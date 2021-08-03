<?php include_once('includes/connection.php');

/*echo '<pre>';
print_r(getSalesPersonImage(1));
echo '</pre>';*/

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$added_by = $_SESSION['user_id'];
global $db;

function getRandomNumber($min, $max)
{
    return rand($min, $max);
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

                    $calls = getRandomNumber(35, 48);
                    $follow_ups = getRandomNumber(0, 12);
                    $total_calls = ($calls + $follow_ups);
                    $good_responses = getRandomNumber(0, $total_calls);
                    $remaining_calls = ($total_calls - $good_responses);
                    $bad_responses = getRandomNumber(0, $remaining_calls);
                    $lead_conversion = getRandomNumber(0, 7);
                    $remaining_calls = ($remaining_calls - $bad_responses);
                    $bad_data = getRandomNumber(0, $remaining_calls);
                    $remaining_calls = ($remaining_calls - $bad_data);
                    $no_answers = getRandomNumber(0, $remaining_calls);
                    $remaining_calls = ($remaining_calls - $no_answers);
                    $voice_mails = getRandomNumber(0, $remaining_calls);
                    $emails_sent = getRandomNumber(0, 8);

                    $checkExist = mysqli_query($db, "SELECT `id` FROM `daily_progress_details` WHERE `date`='{$date}' AND `user_id`='{$user_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `deleted_at` IS NULL");
                    if (mysqli_num_rows($checkExist) == 0) {
                        $insert = "INSERT INTO `daily_progress_details`(`id`, `date`, `user_id`, `calls`, `follow_ups`, `good_responses`, `bad_responses`, `bad_data`, `no_answers`, `voice_mails`, `emails_sent`, `lead_conversion`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$user_id}','{$calls}','{$follow_ups}','{$good_responses}','{$bad_responses}','{$bad_data}','{$no_answers}','{$voice_mails}','{$emails_sent}','{$lead_conversion}','{$company_id}','{$branch_id}','{$added_by}')";
                        mysqli_query($db, $insert);
                    }
                }
            }
        }
    }
}