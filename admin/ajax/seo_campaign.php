<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $name = $object->name;
    $from = $object->from;
    $to = $object->to;
    $source_id = $object->source_id;
    $cost = $object->cost;
    $reach = $object->reach;
    $clicks = $object->clicks;
    $form_submissions = $object->form_submissions;
    $calls = $object->calls;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Name field is required.']);
    } else if (!validName($name)) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'name', 'errorDiv' => 'errorMessageName', 'errorMessage' => 'Length should not exceed 50 characters.']);
    } else if (empty($from)) {
        echo json_encode(['code' => 422, 'errorField' => 'from', 'errorDiv' => 'errorMessageFrom', 'errorMessage' => 'From field is required.']);
    } else if (!validDate($from) || strlen($from) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'from', 'errorDiv' => 'errorMessageFrom', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($to)) {
        echo json_encode(['code' => 422, 'errorField' => 'to', 'errorDiv' => 'errorMessageTo', 'errorMessage' => 'To field is required.']);
    } else if (!validDate($to) || strlen($to) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'to', 'errorDiv' => 'errorMessageTo', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($source_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Source field is required.']);
    } else if (!is_numeric($source_id) || strlen($source_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($cost)) {
        echo json_encode(['code' => 422, 'errorField' => 'cost', 'errorDiv' => 'errorMessageCost', 'errorMessage' => 'Cost field is required.']);
    } else if (!is_numeric($cost) || strlen($cost) > 9 || $cost <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'cost', 'errorDiv' => 'errorMessageCost', 'errorMessage' => 'Please type a valid Cost value.']);
    } else if (empty($reach)) {
        echo json_encode(['code' => 422, 'errorField' => 'reach', 'errorDiv' => 'errorMessageContact', 'errorMessage' => 'Reach field is required.']);
    } else if (!is_numeric($reach) || strlen($reach) > 9 || $reach <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'reach', 'errorDiv' => 'errorMessageContact', 'errorMessage' => 'Please type a valid number of Reach.']);
    } else if (empty($clicks)) {
        echo json_encode(['code' => 422, 'errorField' => 'clicks', 'errorDiv' => 'errorMessageClicks', 'errorMessage' => 'Clicks field is required.']);
    } else if (!is_numeric($clicks) || strlen($clicks) > 9 || $clicks <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'clicks', 'errorDiv' => 'errorMessageClicks', 'errorMessage' => 'Please type a valid number of Clicks.']);
    } else if ($form_submissions == '') {
        echo json_encode(['code' => 422, 'errorField' => 'form_submissions', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Bad Response field is required.']);
    } else if (!is_numeric($form_submissions) || strlen($form_submissions) > 9 || $form_submissions < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'form_submissions', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Please type valid number of Bad Responses.']);
    } else if ($calls == '') {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Calls field is required.']);
    } else if (!is_numeric($calls) || strlen($calls) > 9 || $calls < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Please type a valid number of Calls.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));
        $from = html_entity_decode(stripslashes(date('Y-m-d', strtotime($from))));
        $to = html_entity_decode(stripslashes(date('Y-m-d', strtotime($to))));

        $check = mysqli_query($db, "SELECT `id` FROM `seo_campaigns` WHERE `name`='{$name}' AND `from`='{$from}' AND `to`='{$to}' AND `source_id`='{$source_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}' ORDER BY `id` ASC LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Campaign already exist.']);
        } else{
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `seo_campaigns` SET `name`='{$name}',`from`='{$from}',`to`='{$to}',`source_id`='{$source_id}',`cost`='{$cost}',`reach`='{$reach}',`clicks`='{$clicks}',`form_submissions`='{$form_submissions}',`calls`='{$calls}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                $form_reset = false;
            } else{
                $query = "INSERT INTO `seo_campaigns` (`id`, `name`, `from`, `to`, `source_id`, `cost`, `reach`, `clicks`, `form_submissions`, `calls`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$from}', '{$to}', '{$source_id}', '{$cost}', '{$reach}', '{$clicks}', '{$form_submissions}', '{$calls}', '{$company_id}', '{$branch_id}', '{$user_id}')";
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