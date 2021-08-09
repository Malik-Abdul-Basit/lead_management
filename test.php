<?php include_once('includes/connection.php');

/*echo '<pre>';
print_r(getSalesPersonImage(1));
echo '</pre>';*/

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$added_by = $_SESSION['user_id'];
global $db;

function generateRandomNumber($min, $max)
{
    return rand($min, $max);
}

function generateRespondentDetail()
{
    $index = generateRandomNumber(0, 60);

    $name_array = [
        'Dave Williams',
        'Dan Thomas',
        'Brian Robinson',
        'Ramon Walker',
        'Ethan Scott',
        'Milton Nelson',
        'Alexis Mitchell',
        'Harvey Morgan',
        'Julian Cooper',
        'Liam Howard',
        'Carlos Miller',
        'Aaron Martin',
        'Paul Anderson',
        'Alexis Francis',
        'Johnny Erickson',
        'Charlie Norman',
        'Martin Sherman',
        'Rick Simon',
        'Victor Jones',
        'Jessie Brown',
        'Neil Baker',
        'Nick Adams',
        'Morris Gordon',
        'Clark Holmes',
        'Stefan Saunders',
        'Robin Fisher',
        'Sandy Stewart',
        'Albert Noble',
        'Bruce Leach',
        'Eric Christopher',
        'Mark Lara',
        'Philip Trujillo',
        'Jaime Grant',
        'Shawn Jacobs',
        'Walter Foreman',
        'Fred Dudley',
        'George Potter',
        'Peter Robinson',
        'Smith Connor',
        'Thomas Antonio',
        'Daisy Newton',
        'Stella Daniel',
        'Tracey Guzman',
        'Angela Norris',
        'Lauren Parks',
        'Christina Davis',
        'Katrina Parks',
        'Rose Lucas',
        'Kathie Shelton',
        'Julie Wheeler',
        'Olive Terry',
        'Sophie Holland',
        'Sophia Stanley',
        'Della Perry',
        'Traci White',
        'Michael Gary',
        'David Ronald',
        'Richard Edward',
        'Donald Kenneth',
        'Steven Joshua',
        'Ryan Larry',

    ];
    $n = $name_array[$index];
    $business_name = strtolower(str_replace(' ', ".", $n));

    return [
        'business_name' => $business_name,
        'respondent_name' => $n,
        'email' => $business_name.'@gmail.com',
    ];


}

function generateRandomDate($start_date, $end_date)
{
    $min = strtotime($start_date);
    $max = strtotime($end_date);
    $val = generateRandomNumber($min, $max);
    return date('Y-m-d', $val);
}


if (isset($_GET['n']) && !empty($_GET['n'])) {
    $get = $_GET['n'];
    if ($get == "add_db_progress") {

        $user_array = array(6, 7, 8);
        foreach ($user_array as $user_id) {
            $start = '2021-01-01';
            $end = '2021-01-31';
            $start_date = new DateTime($start);
            $end = new DateTime($end);
            $end = $end->modify('+1 day');
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($start_date, $interval, $end);
            foreach ($daterange as $d) {
                $date = $d->format("Y-m-d");
                if (date('D', strtotime($date)) != 'Sat' && date('D', strtotime($date)) != 'Sun') {

                    $calls = generateRandomNumber(35, 48);
                    $follow_ups = generateRandomNumber(0, 12);
                    $total_calls = ($calls + $follow_ups);
                    $good_responses = generateRandomNumber(0, $total_calls);
                    $remaining_calls = ($total_calls - $good_responses);
                    $bad_responses = generateRandomNumber(0, $remaining_calls);
                    $lead_conversion = generateRandomNumber(0, 7);
                    $remaining_calls = ($remaining_calls - $bad_responses);
                    $bad_data = generateRandomNumber(0, $remaining_calls);
                    $remaining_calls = ($remaining_calls - $bad_data);
                    $no_answers = generateRandomNumber(0, $remaining_calls);
                    $remaining_calls = ($remaining_calls - $no_answers);
                    $voice_mails = generateRandomNumber(0, $remaining_calls);
                    $emails_sent = generateRandomNumber(0, 8);

                    $checkExist = mysqli_query($db, "SELECT `id` FROM `daily_progress_details` WHERE `date`='{$date}' AND `user_id`='{$user_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL");
                    if (mysqli_num_rows($checkExist) == 0) {
                        $insert = "INSERT INTO `daily_progress_details`(`id`, `date`, `user_id`, `calls`, `follow_ups`, `good_responses`, `bad_responses`, `bad_data`, `no_answers`, `voice_mails`, `emails_sent`, `lead_conversion`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$user_id}','{$calls}','{$follow_ups}','{$good_responses}','{$bad_responses}','{$bad_data}','{$no_answers}','{$voice_mails}','{$emails_sent}','{$lead_conversion}','{$company_id}','{$branch_id}','{$added_by}')";
                        mysqli_query($db, $insert);
                    }
                }
            }
        }
    }
    else if ($get == "add_seo_campaign") {
        $source_id = '1';
        $start = '2021-01-01';
        $end = '2021-08-10';
        $start_date = new DateTime($start);
        $end = new DateTime($end);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P10D');
        $daterange = new DatePeriod($start_date, $interval, $end);
        foreach ($daterange as $d) {
            $from = $d->format("Y-m-d");
            $e = $d->modify('+9 day');
            $to = $e->format("Y-m-d");
            $name = 'Campaign';

            $cost = generateRandomNumber(50, 250);
            $reach = generateRandomNumber(35, 48);
            $clicks = generateRandomNumber(0, $reach);
            $remaining_calls = ($reach - $clicks);
            $form_submissions = generateRandomNumber(0, $remaining_calls);
            $remaining_calls = ($remaining_calls - $form_submissions);
            $calls = generateRandomNumber(0, $remaining_calls);

            $check = mysqli_query($db, "SELECT `id` FROM `seo_campaigns` WHERE `name`='{$name}' AND `from`='{$from}' AND `to`='{$to}' AND `source_id`='{$source_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' ORDER BY `id` ASC LIMIT 1");
            if ($check && mysqli_num_rows($check) == 0) {
                $query = "INSERT INTO `seo_campaigns` (`id`, `name`, `from`, `to`, `source_id`, `cost`, `reach`, `clicks`, `form_submissions`, `calls`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$from}', '{$to}', '{$source_id}', '{$cost}', '{$reach}', '{$clicks}', '{$form_submissions}', '{$calls}', '{$company_id}', '{$branch_id}', '{$added_by}')";
                mysqli_query($db, $query);
            }
        }
    }
    else if ($get == "add_smm_campaign" || $get == "add_em_campaign") {
        if($get == "add_smm_campaign"){
            $type = 'smm';
            $source_id = '3';
            $account_id = generateRandomNumber(1, 10);
            $campaign_type_id = '1';
        } else{
            $type = 'em';
            $source_id = '4';
            $account_id = generateRandomNumber(11, 13);
            $campaign_type_id = '2';
        }

        $start = '2021-01-01';
        $end = '2021-01-31';
        $start_date = new DateTime($start);
        $end = new DateTime($end);
        $end = $end->modify('+1 day');
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($start_date, $interval, $end);
        foreach ($daterange as $d) {
            $date = $d->format("Y-m-d");
            if (date('D', strtotime($date)) != 'Sat' && date('D', strtotime($date)) != 'Sun') {
                $sec = date('d-m-Y h:i:sa', strtotime($date));
                $name = 'Name ('.$sec.') '.$type;

                $reach = generateRandomNumber(35, 48);
                $follow_ups = generateRandomNumber(0, 12);
                $total_calls = ($reach + $follow_ups);
                $good_responses = generateRandomNumber(0, $total_calls);
                $remaining_calls = ($total_calls - $good_responses);
                $bad_responses = generateRandomNumber(0, $remaining_calls);
                $remaining_calls = ($remaining_calls - $bad_responses);
                $not_responses = generateRandomNumber(0, $remaining_calls);

                $check = mysqli_query($db, "SELECT `id` FROM `campaigns` WHERE `name`='{$name}' AND `date`='{$date}' AND `type`='{$type}' AND `source_id`='{$source_id}' AND `account_id`='{$account_id}' AND `campaign_type_id`='{$campaign_type_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' ORDER BY `id` ASC LIMIT 1");
                if ($check && mysqli_num_rows($check) == 0) {
                    $query = "INSERT INTO `campaigns` (`id`, `name`, `date`, `type`, `source_id`, `account_id`, `campaign_type_id`, `reach`, `good_responses`, `bad_responses`, `follow_ups`, `not_responses`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$date}', '{$type}', '{$source_id}', '{$account_id}', '{$campaign_type_id}', '{$reach}', '{$good_responses}', '{$bad_responses}', '{$follow_ups}', '{$not_responses}', '{$company_id}', '{$branch_id}', '{$added_by}')";
                    mysqli_query($db, $query);
                }
            }
        }
    }
    else if ($get == "add_seo_leads"){

        $from = '2021-08-01';
        $to = '2021-08-10';

        $get = mysqli_query($db, "SELECT `id`,`from`,`to`,`source_id`,`reach` FROM `seo_campaigns` WHERE `from` BETWEEN '{$from}' AND '{$to}'");
        if ($get && mysqli_num_rows($get) > 0) {
            while ($object = mysqli_fetch_object($get)) {
                $campaign_id = $object->id;
                $reach = ($object->reach - 27);
                $from = $object->from;
                $to = $object->to;
                $source_id = $object->source_id;
                $number_of_leads = generateRandomNumber(0, $reach);
                if($number_of_leads > 0){
                    for ($x = 1; $x <= $number_of_leads; $x++) {
                        $sales_person_id = ($x % 2 == 0) ? 1 : 2;
                        $status = generateRandomNumber(1, 13);
                        $date = generateRandomDate($from, $to);
                        $respondent_detail = generateRespondentDetail();
                        $business_name = $respondent_detail['business_name'];
                        $respondent_name = $respondent_detail['respondent_name'];
                        $email = $respondent_detail['email'];
                        $insert = "INSERT INTO `seo_leads`(`id`, `date`, `sales_person_id`, `source_id`, `campaign_id`, `status`, `business_name`, `respondent_name`, `email`, `dial_code`, `contact_no`, `iso`, `other_dial_code`, `other_contact_no`, `other_iso`, `fax`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$sales_person_id}','{$source_id}','{$campaign_id}','{$status}','{$business_name}','{$respondent_name}','{$email}','1','','us','1','','us','','{$company_id}','{$branch_id}','{$added_by}')";
                        mysqli_query($db, $insert);
                    }
                }
            }
        }

    }
    else if ($get == "add_smm_lead" || $get == "add_em_lead"){
        if($get == "add_smm_lead"){
            $type = 'smm';
        } else{
            $type = 'em';
        }

        $from = '2021-08-01';
        $to = '2021-08-10';

        $get = mysqli_query($db, "SELECT `id`,`date`,`reach` FROM `campaigns` WHERE `type`='{$type}' AND `date` BETWEEN '{$from}' AND '{$to}'");
        if ($get && mysqli_num_rows($get) > 0) {
            while ($object = mysqli_fetch_object($get)) {
                $campaign_id = $object->id;
                $reach = ($object->reach - 27);
                $from = $object->date;
                $to = date('Y-m-d', strtotime($from . " +15 days"));
                $number_of_leads = generateRandomNumber(0, $reach);
                if($number_of_leads > 0){
                    for ($x = 1; $x <= $number_of_leads; $x++) {
                        $sales_person_id = ($x % 2 == 0) ? 1 : 2;
                        $status = generateRandomNumber(1, 13);
                        $date = generateRandomDate($from, $to);
                        $respondent_detail = generateRespondentDetail();
                        $business_name = $respondent_detail['business_name'];
                        $respondent_name = $respondent_detail['respondent_name'];
                        $email = $respondent_detail['email'];
                        $insert = "INSERT INTO `leads`(`id`, `date`, `sales_person_id`, `campaign_id`, `status`, `type`, `business_name`, `respondent_name`, `email`, `dial_code`, `contact_no`, `iso`, `other_dial_code`, `other_contact_no`, `other_iso`, `fax`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$sales_person_id}','{$campaign_id}','{$status}','{$type}','{$business_name}','{$respondent_name}','{$email}','1','','us','1','','us','','{$company_id}','{$branch_id}','{$added_by}')";
                        mysqli_query($db, $insert);
                    }
                }
            }
        }

    }
}