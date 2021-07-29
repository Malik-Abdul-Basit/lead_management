<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];

if (isset($_POST['filters']) && !empty($_POST['filters'])) {
    $filters = (object)$_POST['filters'];

    $pageNo = 1;
    $perPage = 10;
    $sortColumn = 'l.date';
    $sortOrder = 'DESC';
    $condition = " WHERE l.company_id='{$global_company_id}' AND l.branch_id='{$global_branch_id}' AND l.deleted_at IS NULL AND s.type='{$filters->T}' AND s.company_id='{$global_company_id}' AND s.branch_id='{$global_branch_id}' AND s.deleted_at IS NULL ";
    if (isset($filters->SearchQuery) && !empty($filters->SearchQuery) && strlen($filters->SearchQuery) > 0) {
        $condition .= " AND (l.business_name LIKE '%{$filters->SearchQuery}%' OR l.respondent_name LIKE '%{$filters->SearchQuery}%' OR l.email LIKE '%{$filters->SearchQuery}%' OR l.contact_no LIKE '%{$filters->SearchQuery}%' OR l.other_contact_no LIKE '%{$filters->SearchQuery}%') ";
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

    /*$employee_info = getEmployeeInfoFromId($global_user_id);
    if ($employee_info->user_type != config('users.type.value.super_admin') && $employee_info->user_type != config('users.type.value.admin') ) {
        $condition .= " AND l.user_id='{$global_user_id}'";
    }*/

    $total = 0;
    $data = '';
    $sql = mysqli_query($db, "SELECT count(l.id) AS total FROM seo_leads AS l INNER JOIN sales_persons AS sp ON sp.id=l.sales_person_id INNER JOIN sources AS s ON s.id=l.source_id LEFT JOIN seo_campaigns AS c ON s.id=l.campaign_id " . $condition . " GROUP BY l.id ");
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
            $h_col = '<div class="col-md-2"><b>Campaign</b></div><div class="col-md-2"><b>Action</b></div>';
            $right = true;
        } else {
            $h_col = '<div class="col-md-4"><b>Campaign</b></div>';
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
                                <div class="col-md-2"><b>Sales Person</b></div>
                                <div class="col-md-2"><b>Source</b></div>
                                <div class="col-md-2"><b>Date</b></div>
                                <div class="col-md-2"><b>Status</b></div>' . $h_col . '
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
        $select = "SELECT l.*, CONCAT('+',l.dial_code,' ',l.contact_no) AS contact_number, 
        CONCAT('+',l.other_dial_code,' ',l.other_contact_no) AS other_contact_number,
        CONCAT(sp.first_name,' ',sp.last_name) AS full_name, sp.email AS sales_person_email,
        s.name AS source_name, c.name AS campaign_name, c.from, c.to
        FROM 
            seo_leads AS l 
        INNER JOIN 
            sales_persons AS sp 
            ON sp.id=l.sales_person_id 
        INNER JOIN 
            sources AS s 
            ON s.id=l.source_id 
        LEFT JOIN 
            seo_campaigns AS c 
            ON s.id=l.campaign_id " . $condition . " GROUP BY l.id " . $sort . $number_of_record;

        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            $row_number = 0;
            while ($result = mysqli_fetch_object($query)) {
                $row_number++;
                $evenOrOdd = ($row_number % 2) == 1 ? 'odd' : 'even';

                $status = config('seo_leads.status.title.' . $result->status);

                if(!empty($result->from) && !empty($result->to)){
                    $campaign_duration = date('d-M-Y', strtotime($result->from)). ' To ' .date('d-M-Y', strtotime($result->to));
                } else{
                    $campaign_duration = '';
                }

                if (!empty($result->business_name)) {
                    $company_initial = getInitialsFromString($result->business_name, 1);
                } elseif (!empty($result->respondent_name)) {
                    $company_initial = getInitialsFromString($result->respondent_name, 1);
                } elseif (!empty($result->email)) {
                    $company_initial = getInitialsFromString($result->email, 1);
                }

                $checkImage = getSalesPersonImage($result->sales_person_id);
                $image_path = $checkImage['image_path'];
                $img = $checkImage['img'];
                $default_image = $checkImage['default'];

                $contact_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $result->iso . '.png">';
                $other_contact_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $result->other_iso . '.png">';

                $contact_no = !empty($result->contact_no) ? $contact_no_flag . $result->contact_number : 'None';
                $other_contact_no = !empty($result->other_contact_no) ? $other_contact_no_flag . $result->other_contact_number : 'None';

                $fax = !empty($result->fax) ? $result->fax : 'None';

                $data .= '<tr style="left:0" data-row="' . $row_number . '" class="datatable-row  datatable-row-' . $evenOrOdd . '"><td>';
                $data .= '<div class="collapse-card-outer-wrapper">
                    <div class="collapse-card">
                        <div class="card-pane success">
                            <div class="row">
                                <div class="col-md-2 text-vertical-align-center">
                                    <div class="flex-grow-0">
                                        <span>' . $result->full_name . '</span>
                                        <br>
                                        <small>' . $result->sales_person_email . '</small>
                                    </div>
                                </div>
                                <div class="col-md-2 text-vertical-align-center">' . $result->source_name . '</div>
                                <div class="col-md-2 text-vertical-align-center">' . date('d-M-Y', strtotime($result->date)) . '</div>
                                <div class="col-md-2 text-vertical-align-center">' . $status . '</div>';
                if ($right) {
                    $data .= '<div class="col-md-2 text-vertical-align-center">
                                    <div class="flex-grow-0">
                                        <span>' . $result->campaign_name . '</span>
                                        <br>
                                        <small>' . $campaign_duration . '</small>
                                    </div>
                                </div>';

                    $data .= '<div class="col-md-2 text-vertical-align-center">';
                    if (hasRight($filters->L, 'edit')) {
                        $data .= '<a href="' . $admin_url . $filters->T . '_lead?id=' . $result->id . '" class="btn btn-sm btn-light-primary font-weight-bolder text-uppercase mr-2" style="font-size: 10px" title="Edit">
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
                    $data .= '<div class="col-md-4 text-vertical-align-center">
                                    <div class="flex-grow-0">
                                        <span>' . $result->campaign_name . '</span>
                                        <br>
                                        <small>' . $campaign_duration . '</small>
                                    </div>
                                </div>';
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
                                <div class="card-section-body p-0">';
                $data .= '<div class="lead-card-details px-6 py-4">
                    <div class="card-section-title mb-6">Business Information</div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="small">Business Name</div>
                            <span>' . $result->business_name . '</span>
                        </div>
                        <div class="col-md-3">
                            <div class="small">Respondent</div>
                            <span>' . $result->respondent_name . '</span>
                        </div>
                        <div class="col-md-3">
                            <div class="small">Email</div>
                            <span>' . $result->email . '</span>
                        </div>
                        <div class="col-md-3">
                            <div class="small">Contact</div>
                            <span> Contact No: ' . $contact_no . '</span><br>
                            <small> Other Contact No: ' . $other_contact_no . '<br>Fax: ' . $fax . '</small>
                        </div>  
                    </div>
                    <div class="card-section-title mt-6 mb-2">Communication Detail</div>
                </div>
                <div class="bg-white px-6 py-4">
                    <div class="card-section-title text-center pt-3 pr-3 pb-1 pl-3 mt-2 mr-2 mb-8 ml-2">
                        <h5>' . $result->business_name . '</h5>
                        <p>' . $result->email . '</p>
                    </div>';
                $query_lead_messages = mysqli_query($db, "SELECT * FROM `seo_lead_messages` WHERE `lead_id`='{$result->id}'");
                if (mysqli_num_rows($query_lead_messages) > 0) {
                    while ($object_lead_messages = mysqli_fetch_object($query_lead_messages)) {
                        $data .= '<div class="row mt-5 mb-5"><div class="col-md-12 column"><div class="messages">';
                        if (!empty($object_lead_messages->respondent_message)) {
                            $data .= '<div class="d-flex flex-column mb-3 align-items-start">
                                <div class="d-flex align-items-center">
                                    <span class="symbol rounded-circle symbol-lg-35 symbol-25 symbol-light-success mr-2">
                                        <span class="symbol-label rounded-circle font-size-h5 font-weight-bold">' . $company_initial . '</span>
                                    </span>
                                </div>
                                <div class="mt-2 rounded p-5 bg-light-success text-dark-50 font-weight-bold font-size-lg text-left max-w-75Per">' . $object_lead_messages->respondent_message . '</div>
                            </div>';
                        }
                        if (!empty($object_lead_messages->our_message)) {
                            $data .= '<div class="d-flex flex-column mb-5 align-items-end">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-40 ml-3">
                                        <img alt="Pic" src="' . $image_path . '">
                                    </div>
                                </div>
                                <div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-left max-w-75Per">' . $object_lead_messages->our_message . '</div>
                            </div>';
                        }
                        if (!empty($object_lead_messages->our_note)) {
                            $data .= '<div class="d-flex flex-column mb-5 align-items-end">
                                <div class="mt-2 rounded p-5 bg-light-warning text-dark-50 font-weight-bold font-size-lg text-left max-w-75Per">' . $object_lead_messages->our_note . '</div>
                            </div>';
                        }

                        $data .= '</div></div></div>';
                    }
                }

                $data .= '
                           </div></div></div>
                        </div>
                        <div class="card-footer-info">
                            <div class="d-block float-left overflow-hidden">
                                &nbsp;
                            </div>
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