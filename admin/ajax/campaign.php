<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $date = $object->date;
    $name = $object->name;
    $campaign_type_id = $object->campaign_type_id;
    $source_id = $object->source_id;
    $account_id = $object->account_id;
    $reach = $object->reach;
    $good_responses = $object->good_responses;
    $bad_responses = $object->bad_responses;
    $follow_ups = $object->follow_ups;
    $not_responses = $object->not_responses;
    $type = $object->type;
    $user_right_title = $object->user_right_title;

    $type_array = array_values(config('campaigns.type.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($campaign_type_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'campaign_type_id', 'errorDiv' => 'errorMessageCampaignType', 'errorMessage' => 'Campaign Type field is required.']);
    } else if (!is_numeric($campaign_type_id) || strlen($campaign_type_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'campaign_type_id', 'errorDiv' => 'errorMessageCampaignType', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($source_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Source field is required.']);
    } else if (!is_numeric($source_id) || strlen($source_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($account_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'account_id', 'errorDiv' => 'errorMessageAccount', 'errorMessage' => 'Account field is required.']);
    } else if (!is_numeric($account_id) || strlen($account_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'account_id', 'errorDiv' => 'errorMessageAccount', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($reach)) {
        echo json_encode(['code' => 422, 'errorField' => 'reach', 'errorDiv' => 'errorMessageContact', 'errorMessage' => 'Contacts field is required.']);
    } else if (!is_numeric($reach) || strlen($reach) > 9 || $reach <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'reach', 'errorDiv' => 'errorMessageContact', 'errorMessage' => 'Please type a valid number of Contacts.']);
    } else if ($good_responses == '') {
        echo json_encode(['code' => 422, 'errorField' => 'good_responses', 'errorDiv' => 'errorMessageGoodResponses', 'errorMessage' => 'Good Response field is required.']);
    } else if (!is_numeric($good_responses) || strlen($good_responses) > 9 || $good_responses < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'good_responses', 'errorDiv' => 'errorMessageGoodResponses', 'errorMessage' => 'Please type valid number of Good Responses.']);
    } else if ($bad_responses == '') {
        echo json_encode(['code' => 422, 'errorField' => 'bad_responses', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Bad Response field is required.']);
    } else if (!is_numeric($bad_responses) || strlen($bad_responses) > 9 || $bad_responses < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'bad_responses', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Please type valid number of Bad Responses.']);
    } else if ($follow_ups == '') {
        echo json_encode(['code' => 422, 'errorField' => 'follow_ups', 'errorDiv' => 'errorMessageFollowUps', 'errorMessage' => 'Follow Ups field is required.']);
    } else if (!is_numeric($follow_ups) || strlen($follow_ups) > 9 || $follow_ups < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'follow_ups', 'errorDiv' => 'errorMessageFollowUps', 'errorMessage' => 'Please type valid number of Follow Ups.']);
    } else if ($not_responses == '') {
        echo json_encode(['code' => 422, 'errorField' => 'not_responses', 'errorDiv' => 'errorMessageNotResponses', 'errorMessage' => 'Not Responses field is required.']);
    } else if (!is_numeric($not_responses) || strlen($not_responses) > 9 || $not_responses < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'not_responses', 'errorDiv' => 'errorMessageNotResponses', 'errorMessage' => 'Please type valid number of Not Responses.']);
    } else if (empty($type) || !in_array($type, $type_array)) {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Sorry! some unexpected error.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $date = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date))));

        $continueProcessing = false;
        $message = '';

        $check = mysqli_query($db, "SELECT `id` FROM `campaigns` WHERE `name`='{$name}' AND `date`='{$date}' AND `type`='{$type}' AND `source_id`='{$source_id}' AND `account_id`='{$account_id}' AND `campaign_type_id`='{$campaign_type_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}' ORDER BY `id` ASC LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Campaign already exist.']);
        } else{
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `campaigns` SET `name`='{$name}',`date`='{$date}',`source_id`='{$source_id}',`account_id`='{$account_id}',`campaign_type_id`='{$campaign_type_id}',`reach`='{$reach}',`good_responses`='{$good_responses}',`bad_responses`='{$bad_responses}',`follow_ups`='{$follow_ups}',`not_responses`='{$not_responses}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `type`='{$type}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                $form_reset = false;
            } else{
                $query = "INSERT INTO `campaigns` (`id`, `name`, `date`, `type`, `source_id`, `account_id`, `campaign_type_id`, `reach `, `good_responses`, `bad_responses`, `follow_ups`, `not_responses`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$date}', '{$type}', '{$source_id}', '{$account_id}', '{$campaign_type_id}', '{$reach}', '{$good_responses}', '{$bad_responses}', '{$follow_ups}', '{$not_responses}', '{$company_id}', '{$branch_id}', '{$user_id}')";
                $form_reset = true;
            }

            if (mysqli_query($db, $query)) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => $form_reset]);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.', 'form_reset' => $form_reset]);
            }
        }
    }
}
?>