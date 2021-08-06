<?php
include_once('../../includes/connection.php');

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['getStatistics'])) {
    $data = [];
    $object = (object)$_POST['getStatistics'];
    $type_array = array_values(config('lang.type.value'));

    $seo_reach = $seo_leads = $seo_rate = $smm_reach = $smm_leads = $smm_rate = $em_reach = $em_leads = $em_rate = $bd_reach = $bd_leads = $bd_rate = 0;

    if (!empty($object) && !empty($object->from) && strlen($object->from) === 10 && !empty($object->to) && strlen($object->to) === 10 && $object->from <= $object->to) {

        foreach ($type_array as $type) {
            if ($type == config('lang.type.value.search_engine_optimization')) {
                $checkExist = mysqli_query($db, "SELECT SUM(`reach`) AS `total_reach` FROM `seo_campaigns` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL AND (`from` BETWEEN '{$object->from}' AND '{$object->to}' || `to` BETWEEN '{$object->from}' AND '{$object->to}') ORDER BY `from` DESC");
                if (mysqli_num_rows($checkExist) > 0) {
                    if ($result = mysqli_fetch_object($checkExist)) {
                        if (!empty($result->total_reach)) {
                            $seo_reach = $result->total_reach;
                            $checkLeads = mysqli_query($db, "SELECT COUNT(l.id) AS total_leads FROM seo_leads AS l INNER JOIN seo_campaigns AS c ON c.id=l.campaign_id WHERE c.company_id='{$company_id}' AND c.branch_id='{$branch_id}' AND c.deleted_at IS NULL AND (c.from BETWEEN '{$object->from}' AND '{$object->to}' || c.to BETWEEN '{$object->from}' AND '{$object->to}') AND l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL ORDER BY c.from DESC");
                            if (mysqli_num_rows($checkLeads) > 0) {
                                if ($res = mysqli_fetch_object($checkLeads)) {
                                    if (!empty($res->total_leads)) {
                                        $seo_leads = $res->total_leads;
                                        $seo_rate = round(($seo_leads / $seo_reach) * 100, 2);
                                    }
                                }
                            }
                        }
                    }
                }
            } else if (in_array($type, array_values(config('campaigns.type.value')))) {
                $reach = $leads = $rate = 0;
                $checkExist = mysqli_query($db, "SELECT SUM(`reach`) AS `total_reach` FROM `campaigns` WHERE `type`='{$type}' AND `date` BETWEEN '{$object->from}' AND '{$object->to}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `date` DESC");
                if (mysqli_num_rows($checkExist) > 0) {
                    if ($result = mysqli_fetch_object($checkExist)) {
                        if (!empty($result->total_reach)) {
                            $reach = $result->total_reach;
                            $checkLeads = mysqli_query($db, "SELECT COUNT(l.id) AS total_leads FROM leads AS l INNER JOIN campaigns AS c ON c.id=l.campaign_id WHERE c.type='{$type}' AND c.date BETWEEN '{$object->from}' AND '{$object->to}' AND c.company_id='{$company_id}' AND c.branch_id='{$branch_id}' AND c.deleted_at IS NULL AND l.type='{$type}' AND l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL ORDER BY c.date DESC");
                            if (mysqli_num_rows($checkLeads) > 0) {
                                if ($res = mysqli_fetch_object($checkLeads)) {
                                    if (!empty($res->total_leads)) {
                                        $leads = $res->total_leads;
                                        $rate = round(($leads / $reach) * 100, 2);
                                    }
                                }
                            }
                        }
                    }
                }

                if ($type == config('campaigns.type.value.social_media_marketing')) {
                    $smm_reach = $reach;
                    $smm_leads = $leads;
                    $smm_rate = $rate;
                } else {
                    $em_reach = $reach;
                    $em_leads = $leads;
                    $em_rate = $rate;
                }
            }
        }

        $checkExist = mysqli_query($db, "SELECT
                SUM(`calls`) AS `total_reach`,
                SUM(`lead_conversion`) AS `total_leads`
                FROM 
                    `daily_progress_details` 
                WHERE
                `company_id`='{$company_id}' AND
                `branch_id`='{$branch_id}' AND
                `deleted_at` IS NULL AND
                `date` BETWEEN '{$object->from}' AND '{$object->to}' ORDER BY `date` ASC");
        if (mysqli_num_rows($checkExist) > 0) {
            if ($result = mysqli_fetch_object($checkExist)) {
                if (!empty($result->total_reach)) {
                    $bd_reach = $result->total_reach;
                    if (!empty($result->total_leads)) {
                        $bd_leads = $result->total_leads;
                        $bd_rate = round(($bd_leads / $bd_reach) * 100, 2);
                    }
                }
            }
        }

    }

    $total_reach = $seo_reach + $smm_reach + $em_reach + $bd_reach;
    $total_leads = $seo_leads + $smm_leads + $em_leads + $bd_leads;
    $total_rate = round($seo_rate + $smm_rate + $em_rate + $bd_rate, 2);

    $data = [
        "seo_reach" => $seo_reach,
        "seo_leads" => $seo_leads,
        "seo_rate" => $seo_rate,

        "smm_reach" => $smm_reach,
        "smm_leads" => $smm_leads,
        "smm_rate" => $smm_rate,

        "em_reach" => $em_reach,
        "em_leads" => $em_leads,
        "em_rate" => $em_rate,

        "bd_reach" => $bd_reach,
        "bd_leads" => $bd_leads,
        "bd_rate" => $bd_rate,

        "total_reach" => $total_reach,
        "total_leads" => $total_leads,
        "total_rate" => $total_rate
    ];

    echo json_encode(["code" => 200, "data" => $data]);
}

if (isset($_POST['getBDData'])) {
    $data = $result_array = [];
    $code = 420;
    $object = (object)$_POST['getBDData'];
    $duration_array = array_values(config('dashboard.duration.value'));

    if (!empty($object) && !empty($object->duration_type) && in_array($object->duration_type, $duration_array) && !empty($object->from) && strlen($object->from) === 10 && !empty($object->to) && strlen($object->to) === 10 && $object->from <= $object->to) {
        if ($object->duration_type == config('dashboard.duration.value.one_year')) {

            $category = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            $checkExist = mysqli_query($db, "SELECT 
                `date`,
                SUM(`calls`) AS `total_calls`,
                SUM(`follow_ups`) AS `total_follow_ups`,
                SUM(`good_responses`) AS `total_good_responses`,
                SUM(`bad_responses`) AS `total_bad_responses`,
                SUM(`lead_conversion`) AS `total_lead_conversion`
                FROM 
                    `daily_progress_details` 
                WHERE
                `company_id`='{$company_id}' AND
                `branch_id`='{$branch_id}' AND
                `deleted_at` IS NULL AND
                `date` BETWEEN '{$object->from}' AND '{$object->to}' GROUP BY MONTH(`date`) ORDER BY `date` ASC");
            if (mysqli_num_rows($checkExist) > 0) {
                $code = 200;
                while ($result = mysqli_fetch_object($checkExist)) {
                    $date = new DateTime($result->date);
                    $formated_date = $date->format("M");

                    $result_array[$formated_date]['calls'] = $result->total_calls;
                    $result_array[$formated_date]['follow_ups'] = $result->total_follow_ups;
                    $result_array[$formated_date]['good_responses'] = $result->total_good_responses;
                    $result_array[$formated_date]['bad_responses'] = $result->total_bad_responses;
                    $result_array[$formated_date]['lead_conversion'] = $result->total_lead_conversion;
                }
            }

            foreach ($category as $month_name) {
                if (!empty($result_array) && count($result_array) > 0 && sizeof($result_array) > 0 && array_key_exists($month_name, $result_array)) {
                    $calls[] = (int)$result_array[$month_name]['calls'];
                    $follow_ups[] = (int)$result_array[$month_name]['follow_ups'];
                    $good_responses[] = (int)$result_array[$month_name]['good_responses'];
                    $bad_responses[] = (int)$result_array[$month_name]['bad_responses'];
                    $lead_conversion[] = (int)$result_array[$month_name]['lead_conversion'];
                } else {
                    $calls[] = $follow_ups[] = $good_responses[] = $bad_responses[] = $lead_conversion[] = 0;
                }
            }

        } else {

            $checkExist = mysqli_query($db, "SELECT 
                `date`,
                SUM(`calls`) AS `total_calls`,
                SUM(`follow_ups`) AS `total_follow_ups`,
                SUM(`good_responses`) AS `total_good_responses`,
                SUM(`bad_responses`) AS `total_bad_responses`,
                SUM(`lead_conversion`) AS `total_lead_conversion`
                FROM 
                    `daily_progress_details` 
                WHERE
                `company_id`='{$company_id}' AND
                `branch_id`='{$branch_id}' AND
                `deleted_at` IS NULL AND
                `date` BETWEEN '{$object->from}' AND '{$object->to}' GROUP BY `date` ORDER BY `date` ASC");
            if (mysqli_num_rows($checkExist) > 0) {
                $code = 200;
                while ($result = mysqli_fetch_object($checkExist)) {
                    $result_array[$result->date]['calls'] = $result->total_calls;
                    $result_array[$result->date]['follow_ups'] = $result->total_follow_ups;
                    $result_array[$result->date]['good_responses'] = $result->total_good_responses;
                    $result_array[$result->date]['bad_responses'] = $result->total_bad_responses;
                    $result_array[$result->date]['lead_conversion'] = $result->total_lead_conversion;
                }
            }

            $calls = $follow_ups = $good_responses = $bad_responses = $lead_conversion = [];

            $start_date = new DateTime($object->from);
            $end = new DateTime($object->to);
            $end = $end->modify('+1 day');
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($start_date, $interval, $end);
            foreach ($daterange as $date) {
                $category[] = $date->format("d-m-Y");
                $formated_date = $date->format("Y-m-d");
                if (!empty($result_array) && count($result_array) > 0 && sizeof($result_array) > 0 && array_key_exists($formated_date, $result_array)) {
                    $calls[] = (int)$result_array[$formated_date]['calls'];
                    $follow_ups[] = (int)$result_array[$formated_date]['follow_ups'];
                    $good_responses[] = (int)$result_array[$formated_date]['good_responses'];
                    $bad_responses[] = (int)$result_array[$formated_date]['bad_responses'];
                    $lead_conversion[] = (int)$result_array[$formated_date]['lead_conversion'];
                } else {
                    $calls[] = $follow_ups[] = $good_responses[] = $bad_responses[] = $lead_conversion[] = 0;
                }
            }
        }
    }

    echo json_encode([
        "code" => $code,
        "data" => [
            'category' => $category,
            'calls' => $calls,
            'follow_ups' => $follow_ups,
            'good_responses' => $good_responses,
            'bad_responses' => $bad_responses,
            'lead_conversion' => $lead_conversion,
            'result_array' => $result_array
        ]
    ]);
}

if (isset($_POST['postData'], $_POST['getAccounts']) && $_POST['getAccounts'] == true) {
    $object = (object)$_POST['postData'];

    if (!empty($object) && !empty($object->id) && $object->id > 0 && is_numeric($object->id) && !empty($object->type) && in_array($object->type, array_values(config('accounts.type.value')))) {
        $id = $object->id;
        $type = $object->type;

        $number_of_display = 4;
        $inner_items='';

        $account_list = '<ul>';
        $account_list .= '<li>
            <div class="sales_person_info_wrapper">
                <a class="' . $type . '_account_id active" data-id="-1" onclick="removeAllClasses(this), callForMarketingData(\'' . $type . '\')">
                    <div>
                        <img src="' . $base_url . 'storage/accounts/sales_person.png" alt="account-image">
                    </div>
                    <span>All</span>
                </a>
            </div>
        </li>';
        $select = "SELECT `id`, `name` FROM `accounts` WHERE `type`='{$type}' AND `source_id`='{$id}' AND `deleted_at` IS NULL ORDER BY `name` ASC";
        $query = mysqli_query($db, $select);
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $i=0;
            while ($result = mysqli_fetch_object($query)) {
                $i++;
                if ($num_rows > $number_of_display && $i >= $number_of_display) {
                    $inner_items .= '<a class="' . $type . '_account_id" data-id="' . $result->id . '" onclick="removeAllClasses(this), callForMarketingData(\'' . $type . '\')">
                        <div>
                            <img src="' . $base_url . 'storage/accounts/sales_person.png" alt="account-image">
                        </div>' . $result->name . '
                    </a>';

                } else {
                    $account_list .= '<li>
                        <div class="sales_person_info_wrapper">
                            <a class="' . $type . '_account_id" data-id="' . $result->id . '" onclick="removeAllClasses(this), callForMarketingData(\'' . $type . '\')">
                                <div>
                                    <img src="' . $base_url . 'storage/accounts/sales_person.png" alt="account-image">
                                </div>
                                <span>' . $result->name . '</span>
                            </a>
                        </div>
                    </li>';
                }
            }
            if ($num_rows > $number_of_display) {
                $account_list .= '<li>
                        <div class="sales_person_info_wrapper">
                            <a class="' . $type . '_account_id dropdown-toggle" role="button" id="'.$type.'otherAccountsList" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div>
                                    <span>+ '.(($num_rows+1)-($number_of_display)).'</span>
                                    <img src="' . $base_url . 'storage/accounts/sales_person_plane.png" alt="account-image">
                                </div>
                                <span>More</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="'.$type.'otherAccountsList">'.$inner_items.'</div>
                        </div>
                    </li>';
            }
        }
        $account_list .= '</ul>';
        echo json_encode(["code" => 200, "account_list" => $account_list]);
    }
}

?>