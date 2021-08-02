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

    foreach ($type_array as $type) {
        if ($type == config('lang.type.value.search_engine_optimization')) {
            $checkExist = mysqli_query($db, "SELECT SUM(`reach`) AS `total_reach` FROM `seo_campaigns` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL AND (`from` BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}' || `to` BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}') ORDER BY `from` DESC");
            if (mysqli_num_rows($checkExist) > 0) {
                if ($result = mysqli_fetch_object($checkExist)) {
                    if (!empty($result->total_reach)) {
                        $seo_reach = $result->total_reach;
                        $checkLeads = mysqli_query($db, "SELECT COUNT(l.id) AS total_leads FROM seo_leads AS l INNER JOIN seo_campaigns AS c ON c.id=l.campaign_id WHERE c.company_id='{$company_id}' AND c.branch_id='{$branch_id}' AND c.deleted_at IS NULL AND (c.from BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}' || c.to BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}') AND l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL ORDER BY c.from DESC");
                        if (mysqli_num_rows($checkLeads) > 0) {
                            if ($res = mysqli_fetch_object($checkLeads)) {
                                if (!empty($res->total_leads)) {
                                    $seo_leads = $res->total_leads;
                                    $seo_rate = round(($seo_leads / $seo_reach) * 100,2);
                                }
                            }
                        }
                    }
                }
            }
        } else if (in_array($type, array_values(config('campaigns.type.value')))) {
            $reach = $leads = $rate = 0;
            $checkExist = mysqli_query($db, "SELECT SUM(`reach`) AS `total_reach` FROM `campaigns` WHERE `type`='{$type}' AND `date` BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL ORDER BY `date` DESC");
            if (mysqli_num_rows($checkExist) > 0) {
                if ($result = mysqli_fetch_object($checkExist)) {
                    if (!empty($result->total_reach)) {
                        $reach = $result->total_reach;
                        $checkLeads = mysqli_query($db, "SELECT COUNT(l.id) AS total_leads FROM leads AS l INNER JOIN campaigns AS c ON c.id=l.campaign_id WHERE c.type='{$type}' AND c.date BETWEEN '{$object->PreviousMonth}' AND '{$object->PreviousDay}' AND c.company_id='{$company_id}' AND c.branch_id='{$branch_id}' AND c.deleted_at IS NULL AND l.type='{$type}' AND l.company_id='{$company_id}' AND l.branch_id='{$branch_id}' AND l.deleted_at IS NULL ORDER BY c.date DESC");
                        if (mysqli_num_rows($checkLeads) > 0) {
                            if ($res = mysqli_fetch_object($checkLeads)) {
                                if (!empty($res->total_leads)) {
                                    $leads = $res->total_leads;
                                    $rate = round(($leads / $reach) * 100,2);
                                }
                            }
                        }
                    }
                }
            }

            if ($type == config('campaigns.type.value.social_media_marketing')) {
                $smm_reach=$reach;
                $smm_leads=$leads;
                $smm_rate=$rate;
            } else {
                $em_reach=$reach;
                $em_leads=$leads;
                $em_rate=$rate;
            }
        }
    }

    $total_reach = $total_leads = $total_rate = 0;

    $total_reach = $seo_reach+$smm_reach+$em_reach+$bd_reach;
    $total_leads = $seo_leads+$smm_leads+$em_leads+$bd_leads;
    $total_rate = round($seo_rate+$smm_rate+$em_rate+$bd_rate,2);

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

/*
$today     = new DateTime();
$begin     = $today->sub(new DateInterval('P30D'));
$end       = new DateTime();
$end       = $end->modify('+1 day');
$interval  = new DateInterval('P1D');
$daterange = new DatePeriod($begin, $interval, $end);
foreach ($daterange as $date) {
    $d[] = $date->format("Y-m-d");
}
echo '<pre>';
print_r($d);
echo '</pre>';

exit();*/

?>