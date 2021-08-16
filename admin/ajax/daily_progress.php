<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $date = $object->date;
    $calls = $object->calls;
    $follow_up = $object->follow_ups;
    $good_response = $object->good_responses;
    $bad_response = $object->bad_responses;
    $bad_data = $object->bad_data;
    $no_answer = $object->no_answers;
    $voice_mails = $object->voice_mails;
    $emails_sent = $object->emails_sent;
    $lead_conversion = $object->lead_conversion;
    $user_right_title = $object->user_right_title;

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($calls)) {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Calls field is required.']);
    } else if (!is_numeric($calls) || strlen($calls) > 9 || $calls < 1) {
        echo json_encode(['code' => 422, 'errorField' => 'calls', 'errorDiv' => 'errorMessageCalls', 'errorMessage' => 'Please type a valid number of Calls.']);
    } else if ($follow_up == '') {
        echo json_encode(['code' => 422, 'errorField' => 'follow_ups', 'errorDiv' => 'errorMessageFollowUps', 'errorMessage' => 'Follow Ups field is required.']);
    } else if (!is_numeric($follow_up) || strlen($follow_up) > 9 || $follow_up < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'follow_ups', 'errorDiv' => 'errorMessageFollowUps', 'errorMessage' => 'Please type valid number of Follow Ups.']);
    } else if ($good_response == '') {
        echo json_encode(['code' => 422, 'errorField' => 'good_responses', 'errorDiv' => 'errorMessageGoodResponses', 'errorMessage' => 'Good Responses field is required.']);
    } else if (!is_numeric($good_response) || strlen($good_response) > 9 || $good_response < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'good_responses', 'errorDiv' => 'errorMessageGoodResponses', 'errorMessage' => 'Please type valid number of Good Responses.']);
    } else if ($bad_response == '') {
        echo json_encode(['code' => 422, 'errorField' => 'bad_responses', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Bad Responses field is required.']);
    } else if (!is_numeric($bad_response) || strlen($bad_response) > 9 || $bad_response < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'bad_responses', 'errorDiv' => 'errorMessageBadResponses', 'errorMessage' => 'Please type valid number of Bad Responses.']);
    } else if ($bad_data == '') {
        echo json_encode(['code' => 422, 'errorField' => 'bad_data', 'errorDiv' => 'errorMessageBadData', 'errorMessage' => 'Bad Data field is required.']);
    } else if (!is_numeric($bad_data) || strlen($bad_data) > 9 || $bad_data < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'bad_data', 'errorDiv' => 'errorMessageBadData', 'errorMessage' => 'Please type valid number of Bad Data.']);
    } else if ($no_answer == '') {
        echo json_encode(['code' => 422, 'errorField' => 'no_answers', 'errorDiv' => 'errorMessageNoAnswers', 'errorMessage' => 'No Answers field is required.']);
    } else if (!is_numeric($no_answer) || strlen($no_answer) > 9 || $no_answer < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'no_answers', 'errorDiv' => 'errorMessageNoAnswers', 'errorMessage' => 'Please type valid number of No Answers.']);
    } else if ($voice_mails == '') {
        echo json_encode(['code' => 422, 'errorField' => 'voice_mails', 'errorDiv' => 'errorMessageVoiceMails', 'errorMessage' => 'Voice Mails field is required.']);
    } else if (!is_numeric($voice_mails) || strlen($voice_mails) > 9 || $voice_mails < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'voice_mails', 'errorDiv' => 'errorMessageVoiceMails', 'errorMessage' => 'Please type valid number of Voice Mails.']);
    } else if ($emails_sent == '') {
        echo json_encode(['code' => 422, 'errorField' => 'emails_sent', 'errorDiv' => 'errorMessageEmailsSent', 'errorMessage' => 'Emails Sent field is required.']);
    } else if (!is_numeric($emails_sent) || strlen($emails_sent) > 9 || $emails_sent < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'emails_sent', 'errorDiv' => 'errorMessageEmailsSent', 'errorMessage' => 'Please type valid number of Emails Sent.']);
    } else if ($lead_conversion == '') {
        echo json_encode(['code' => 422, 'errorField' => 'lead_conversion', 'errorDiv' => 'errorMessageLeadConversion', 'errorMessage' => 'Lead Conversion field is required.']);
    } else if (!is_numeric($lead_conversion) || strlen($lead_conversion) > 9 || $lead_conversion < 0) {
        echo json_encode(['code' => 422, 'errorField' => 'lead_conversion', 'errorDiv' => 'errorMessageLeadConversion', 'errorMessage' => 'Please type valid number of Lead Conversion.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $date = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date))));

        $continueProcessing = false;
        $message = '';

        $check = mysqli_query($db, "SELECT `id` FROM `daily_progress_details` WHERE `date`='{$date}' AND `user_id`='{$user_id}' AND `id`!='{$id}' ORDER BY `id` ASC LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            $code = 405;
            $toasterClass = 'error';
            $responseMessage = 'Record already exist of this date.';
            $form_reset = false;
        } else if (!empty($id) && is_numeric($id) && $id > 0 && hasRight($user_right_title, 'edit')) {

            $update = "UPDATE `daily_progress_details` SET `date`='{$date}',`calls`='{$calls}',`follow_ups`='{$follow_up}',`good_responses`='{$good_response}',`bad_responses`='{$bad_response}',`bad_data`='{$bad_data}',`no_answers`='{$no_answer}',`voice_mails`='{$voice_mails}',`emails_sent`='{$emails_sent}',`lead_conversion`='{$lead_conversion}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `user_id`='{$user_id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
            mysqli_query($db, $update);
            $code = 200;
            $toasterClass = 'success';
            $responseMessage = 'Record successfully saved.';
            $form_reset = false;
        } else if (empty($id) && is_numeric($id) && hasRight($user_right_title, 'add')) {
            $insert = "INSERT INTO `daily_progress_details` (`id`, `date`, `user_id`, `calls`, `follow_ups`, `good_responses`, `bad_responses`, `bad_data`, `no_answers`, `voice_mails`, `emails_sent`, `lead_conversion`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$date}', '{$user_id}', '{$calls}', '{$follow_up}', '{$good_response}', '{$bad_response}', '{$bad_data}', '{$no_answer}', '{$voice_mails}', '{$emails_sent}', '{$lead_conversion}', '{$company_id}', '{$branch_id}', '{$user_id}')";
            mysqli_query($db, $insert);
            $code = 200;
            $toasterClass = 'success';
            $responseMessage = 'Record successfully insert.';
            $form_reset = true;
        } else {
            $code = 405;
            $toasterClass = 'warning';
            $responseMessage = 'Sorry! You have no right to this action.';
            $form_reset = true;
        }
        echo json_encode(['code' => $code, "toasterClass" => $toasterClass, "responseMessage" => $responseMessage, 'form_reset' => $form_reset]);

    }
}
?>