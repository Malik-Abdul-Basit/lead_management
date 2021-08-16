<?php
include_once('../../../includes/connection.php');

$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];

if (isset($_POST['postData']) && !empty($_POST['postData'])) {
    $postData = (object)$_POST['postData'];

    $date_from = $postData->date_from;
    $date_to = $postData->date_to;
    $users = $postData->users;
    $report_type = $postData->report_type;
    $user_right_title = $postData->user_right_title;

    $type_array = array_values(config('daily_progress_details.type.value'));

    if (!hasRight($user_right_title, 'reports')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to view reports.']);
    } else if (empty($date_from)) {
        echo json_encode(['code' => 422, 'errorField' => 'date_from', 'errorDiv' => 'errorMessageDateFrom', 'errorMessage' => 'Date (From) field is required.']);
    } else if (!validDate($date_from) || strlen($date_from) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date_from', 'errorDiv' => 'errorMessageDateFrom', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($date_to)) {
        echo json_encode(['code' => 422, 'errorField' => 'date_to', 'errorDiv' => 'errorMessageDateTo', 'errorMessage' => 'Date (To) field is required.']);
    } else if (!validDate($date_to) || strlen($date_to) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date_to', 'errorDiv' => 'errorMessageDateTo', 'errorMessage' => 'Please select a valid date.']);
    } else if (strtotime($date_to) < strtotime($date_from)) {
        echo json_encode(['code' => 422, 'errorField' => 'date_to', 'errorDiv' => 'errorMessageDateTo', 'errorMessage' => 'Date (To) should be greater than Date (From).']);
    } else if (empty($users) || sizeof($users) == 0 || count($users) == 0) {
        echo json_encode(['code' => 422, 'errorField' => 'user_ids', 'errorDiv' => 'errorMessageUserIds', 'errorMessage' => 'Person field is required.']);
    } else if (empty($report_type) || $report_type == '') {
        echo json_encode(['code' => 422, 'errorField' => 'report_type', 'errorDiv' => 'errorMessageReportType', 'errorMessage' => 'Report Type field is required.']);
    } else if (!is_numeric($report_type) || $report_type < 1) {
        echo json_encode(['code' => 422, 'errorField' => 'report_type', 'errorDiv' => 'errorMessageReportType', 'errorMessage' => 'Please select a valid option of Report Type.']);
    } else if (!in_array($report_type, $type_array) || strlen($report_type) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'report_type', 'errorDiv' => 'errorMessageReportType', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $html = '';
        foreach ($users as $key => $value) {
            $user_name = '';
            $data = '';
            $rangeStart = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date_from))));
            $rangeEnd = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date_to))));
            $query = "SELECT l.*, CONCAT(u.first_name,' ',u.last_name,' (',u.employee_code,')') AS name 
            FROM 
                daily_progress_details AS l
            INNER JOIN 
                users AS u
            ON l.user_id = u.id
            WHERE l.user_id='{$value}' AND l.date BETWEEN '" . $rangeStart . "' and '" . $rangeEnd . "'  AND l.deleted_at IS NULL AND u.deleted_at IS NULL ORDER BY l.date DESC";
            $sql = mysqli_query($db, $query);
            if ($sql && mysqli_num_rows($sql) > 0) {
                $data .= '<table width="100%" class="report_table mb-8">
                <thead>
                    <tr>
                        <th style="width: 90px !important;">Date</th>
                        <th>Calls</th>
                        <th>Follow Up Calls</th>
                        <th>Good Response</th>
                        <th>Bad Response</th>
                        <th>Bad Data</th>
                        <th>Lead Conversion</th>
                        <th>No Answer</th>
                        <th>Voice Mails</th>
                        <th>Emails Sent</th>
                        <th>Response Percentage</th>
                        <th>Lead Percentage</th>
                    </tr>
                </thead>
                <tbody>';
                $t_calls = $t_follow_up = $t_good_response = $t_bad_response = $t_bad_data = 0;
                $t_lead_conversion = $t_no_answer = $t_voice_mails = $t_emails_sent = 0;
                $t_response_percentage = $t_lead_percentage = 0;

                while ($result = mysqli_fetch_object($sql)) {
                    $response_percentage = $lead_percentage = 0;

                    $userFullName = $result->name;

                    $t_calls = round(round($t_calls) + round($result->calls));
                    $t_follow_up = round(round($t_follow_up) + round($result->follow_ups));
                    $t_good_response = round(round($t_good_response) + round($result->good_responses));
                    $t_bad_response = round(round($t_bad_response) + round($result->bad_responses));
                    $t_bad_data = round(round($t_bad_data) + round($result->bad_data));
                    $t_lead_conversion = round(round($t_lead_conversion) + round($result->lead_conversion));
                    $t_no_answer = round(round($t_no_answer) + round($result->no_answers));
                    $t_voice_mails = round(round($t_voice_mails) + round($result->voice_mails));
                    $t_emails_sent = round(round($t_emails_sent) + round($result->emails_sent));

                    if (!empty($result->calls) && !empty($result->good_responses) && $result->calls > 0 && $result->good_responses > 0) {
                        $response_percentage = round(($result->good_responses) / ($result->calls) * (100), 3);
                    }
                    if (!empty($result->calls) && !empty($result->lead_conversion) && $result->calls > 0 && $result->lead_conversion > 0) {
                        $lead_percentage = round(($result->lead_conversion) / ($result->calls) * (100), 3);
                    }

                    if ($report_type == config('daily_progress_details.type.value.day_by_day')) {
                        $data .= '<tr>
                            <td>' . date('d-M-Y', strtotime($result->date)) . '</td>
                            <td>' . $result->calls . '</td>
                            <td>' . $result->follow_ups . '</td>
                            <td>' . $result->good_responses . '</td>
                            <td>' . $result->bad_responses . '</td>
                            <td>' . $result->bad_data . '</td>
                            <td>' . $result->lead_conversion . '</td>
                            <td>' . $result->no_answers . '</td>
                            <td>' . $result->voice_mails . '</td>
                            <td>' . $result->emails_sent . '</td>
                            <td>' . $response_percentage . '%</td>
                            <td>' . $lead_percentage . '%</td>
                        </tr>';
                    }
                }

                if (!empty($t_calls) && !empty($t_good_response) && $t_calls > 0 && $t_good_response > 0) {
                    $t_response_percentage = round(($t_good_response) / ($t_calls) * (100), 3);
                }
                if (!empty($t_calls) && !empty($t_lead_conversion) && $t_calls > 0 && $t_lead_conversion > 0) {
                    $t_lead_percentage = round(($t_lead_conversion) / ($t_calls) * (100), 3);
                }

                $data .= '</tbody>
                <tfoot>
                    <tr>
                        <th> <small><b>
                            ' . date('d-M-Y', strtotime($date_from)) . '
                            <br>To<br>
                            ' . date('d-M-Y', strtotime($date_to)) . '
                         </b></small></th>
                        <th>' . $t_calls . '</th>
                        <th>' . $t_follow_up . '</th>
                        <th>' . $t_good_response . '</th>
                        <th>' . $t_bad_response . '</th>
                        <th>' . $t_bad_data . '</th>
                        <th>' . $t_lead_conversion . '</th>
                        <th>' . $t_no_answer . '</th>
                        <th>' . $t_voice_mails . '</th>
                        <th>' . $t_emails_sent . '</th>
                        <th>' . $t_response_percentage . '%</th>
                        <th>' . $t_lead_percentage . '%</th>
                    </tr>
                </tfoot>
                </table>';
                $user_name = '<div class="report_user_title">' . $userFullName . '</div>';
            }
            $html .= $user_name;
            $html .= $data;
        }
        echo json_encode(['code' => 200, 'html' => $html]);
    }
}
?>