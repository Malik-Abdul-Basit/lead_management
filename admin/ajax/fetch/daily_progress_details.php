<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];
$global_user_id = $_SESSION['user_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'l.date';
    $sortOrder = 'DESC';
    $condition = " WHERE u.company_id='{$global_company_id}' AND u.branch_id='{$global_branch_id}' AND u.deleted_at IS NULL AND l.company_id='{$global_company_id}' AND l.branch_id='{$global_branch_id}' AND l.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (l.calls LIKE '%{$filters->SearchQuery}%' OR CONCAT(u.first_name,' ',u.last_name) LIKE '%{$filters->SearchQuery}%' OR u.pseudo_name LIKE '%{$filters->SearchQuery}%' OR u.email LIKE '%{$filters->SearchQuery}%' OR u.employee_code LIKE '%{$filters->SearchQuery}%') ";
    }

    if (!empty($filters->Filter) && isset($filters->Filter) && count($filters->Filter) > 0) {
        $queryFilter = (object)$filters->Filter;
        foreach ($queryFilter as $filterRow) {
            $filterCol = $filterRow['field'];
            $filterVal = $filterRow['value'];
            if ($filterVal != '' && $filterVal != '-1') {
                $condition .= " AND " . $filterCol . " = '" . $filterVal . "'";
            }
        }
    }

    if (isset($filters->DateRange) && !empty($filters->DateRange) && sizeof($filters->DateRange) > 0) {
        $range_object = (object)$filters->DateRange;
        if (!empty($range_object->rangeStart)) {
            $rangeStart = $range_object->rangeStart;
            $rangeEnd = !empty($range_object->rangeEnd) ? $range_object->rangeEnd : date('Y-m-d');
            $condition .= " AND l.date BETWEEN '" . $rangeStart . "' and '" . $rangeEnd . "'";
        }
    }

    $employee_info = getUserInfoFromId($global_user_id);

    if ($employee_info->user_type != config('users.type.value.super_admin') && $employee_info->user_type != config('users.type.value.admin')) {
        $condition .= " AND l.user_id='{$global_user_id}'";
    }

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(l.id) AS total FROM daily_progress_details AS l INNER JOIN users AS u ON l.user_id=u.id " . $condition);
    if (mysqli_num_rows($sql) > 0) {
        $result = mysqli_fetch_object($sql);
        $total = $result->total;
    }

    if (isset($filters->Sort) && !empty($filters->Sort) && sizeof($filters->Sort) > 0) {
        $sort_object = (object)$filters->Sort;
        if (!empty($sort_object->SortColumn)) {
            $sortColumn = $sort_object->SortColumn;
        }
        if (!empty($sort_object->SortOrder)) {
            $sortOrder = $sort_object->SortOrder;
        }
    }

    if (isset($filters->L)) {
        if (hasRight($filters->L, 'edit') || hasRight($filters->L, 'delete')) {
            $h_col = '<div class="col-md-4"><b>Person</b></div><div class="col-md-4"><b>Email</b></div><div class="col-md-2"><b>Action</b></div>';
            $right = true;
        } else {
            $h_col = '<div class="col-md-5"><b>Person</b></div><div class="col-md-5"><b>Email</b></div>';
            $right = false;
        }
    }

    $data .= '<table class="datatable-table d-block" style="overflow:visible">
        <thead class="datatable-head">
            <tr style="left:0" class="datatable-row">
                <th>
                    <div class="collapse-card-outer-wrapper">
                        <div class="table-header">
                            <div class="row">
                                <div class="col-md-2"><b>Date</b></div>' . $h_col . '
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody class="datatable-body">';
    $not_found = '<tr style="left:0" data-row="1" class="datatable-row datatable-row-odd"><td class="datatable-cell-center datatable-cell"><div class="card card-custom gutter-b"><div class="card-body">Record Not Found.</div></div></td></tr></tbody></table>';

    if ($total > 0) {
        if (isset($filters->PageNumber) && !empty($filters->PageNumber) && strlen($filters->PageNumber) > 0) {
            $pageNo = $filters->PageNumber;
        }
        if (isset($filters->PageSize) && !empty($filters->PageSize) && strlen($filters->PageSize) > 0) {
            $perPage = $filters->PageSize;
        }

        $offset = round(round($pageNo) * round($perPage)) - round($perPage);
        $sort = " ORDER BY " . $sortColumn . " " . $sortOrder;
        if ($total <= $offset) {
            $number_of_record = " LIMIT 0, " . $total;
            $pageNo = 1;
        } else {
            $number_of_record = " LIMIT " . $offset . ", " . $perPage;
        }
        $select = "SELECT l.*,
        CONCAT(u.first_name,' ',u.last_name) AS full_name,
        u.employee_code, u.email AS user_email, u.pseudo_name
        FROM
            daily_progress_details AS l
        INNER JOIN
            users AS u 
            ON l.user_id=u.id " . $condition . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_object($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td>';
                $data .= '<div class="collapse-card-outer-wrapper">
                    <div class="collapse-card">
                        <div class="card-pane success">
                            <div class="row">
                                <div class="col-md-2 text-vertical-align-center">' . date('d-M-Y', strtotime($result->date)) . '</div>';
                if ($right) {
                    $data .= '<div class="col-md-4 text-vertical-align-center">
                        <div class="flex-grow-0">
                            <span>' . $result->full_name . '</span><br>
                            <small>' . $result->pseudo_name . '</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-vertical-align-center">' . $result->user_email . '</div>';

                    $data .= '<div class="col-md-2 text-vertical-align-center">';
                    if (hasRight($filters->L, 'edit')) {
                        $data .= '<a href="' . $admin_url . 'daily_progress?id=' . $result->id . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px" title="Edit">
                                        <span class="navi-icon"><i class="flaticon2-pen" style="font-size: 12px"></i></span> Edit
                                    </a>';
                    }
                    if (hasRight($filters->L, 'delete')) {
                        $data .= '<button type="button" onclick="entryDelete(' . $result->id . ')" class="btn btn-sm btn-danger font-weight-bolder text-uppercase" style="font-size: 10px" title="Delete">
                                        <span class="navi-icon"><i class="flaticon-delete" style="font-size: 12px"></i></span> Delete
                                    </button>';
                    }
                    $data .= '</div>';
                } else {
                    $data .= '<div class="col-md-5 text-vertical-align-center">
                                    <div class="flex-grow-0">
                                        <span>' . $result->full_name . '</span>
                                        <br>
                                        <small>' . $result->pseudo_name . '</small>
                                    </div>
                                </div>
                                <div class="col-md-5 text-vertical-align-center">' . $result->user_email . '</div>';
                }

                $data .= '</div>
                            <a aria-controls="collapse_' . $result->id . '" href="#collapse_' . $result->id . '"
                            aria-expanded="true" data-open="true"
                            data-toggle="collapse"
                            role="button"
                            class="card-collapse collapsed">
                                <i id="target_' . $result->id . '" data-open="false"
                                class="fas fa-chevron-up"></i>
                            </a>
                        </div>
                        <div id="collapse_' . $result->id . '" class="collapse">
                            <div class="card-section">
                                <div class="card-section-body p-0">
                                    <div class="lead-card-details px-6 py-4">
                                        <div class="card-section-title mb-6">Work Report</div>
                                        
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <div class="small">Number of Calls</div>
                                                <span>' . $result->calls . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">Number of Follow Up Calls</div>
                                                <span>' . $result->follow_ups . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">Good Response</div>
                                                <span>' . $result->good_responses . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">Bad Response</div>
                                                <span>' . $result->bad_responses . '</span><br>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-2">
                                            <div class="col-md-3">
                                                <div class="small">Bad Data</div>
                                                <span>' . $result->bad_data . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">Lead Conversion</div>
                                                <span>' . $result->lead_conversion . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">No Answer</div>
                                                <span>' . $result->no_answers . '</span><br>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="small">Voice Mails & Emails Sent</div>
                                                <small>
                                                    Voice Mails: ' . $result->voice_mails . '
                                                    <br>
                                                    Emails Sen: ' . $result->emails_sent . '
                                                </small>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-info">
                            <div class="d-block float-left overflow-hidden">&nbsp;</div>
                        </div>
                    </div>
                </div>';
                $data .= '</td></tr>';
            }
            $data .= '<input type="hidden" id="BG_SortColumn" value="' . $sortColumn . '"><input type="hidden" id="BG_SortOrder" value="' . $sortOrder . '"></tbody></table>';
            $data .= getPaginationNumbering($pageNo, $perPage, $total, $filters->PageSizeStack);
        } else {
            $data .= $not_found;
        }
    } else {
        $data .= $not_found;
    }

    echo json_encode(['code' => 200, 'data' => $data]);
}
?>