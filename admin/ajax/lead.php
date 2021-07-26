<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {

    $object = (object)$_POST['postData'];
    $id = $object->id;
    $type = $object->type;
    $date = $object->date;
    $sales_person_id = $object->sales_person_id;
    $campaign_id = $object->campaign_id;
    $status = $object->status;

    $business_name = $object->business_name;
    $respondent_name = $object->respondent_name;
    $email = $object->email;

    $dial_code = $object->dial_code;
    $contact_no = $object->contact_no;
    $iso = $object->iso;

    $other_dial_code = $object->other_dial_code;
    $other_contact_no = $object->other_contact_no;
    $other_iso = $object->other_iso;
    $fax = $object->fax;
    $user_right_title = $object->user_right_title;
    $data = $object->data;

    $status_array = array_values(config('leads.status.value'));

    /*echo '<pre>';
    print_r($object);
    echo '<pre>';
    exit();*/

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($date)) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Date field is required.']);
    } else if (!validDate($date) || strlen($date) !== 10) {
        echo json_encode(['code' => 422, 'errorField' => 'date', 'errorDiv' => 'errorMessageDate', 'errorMessage' => 'Please select a valid date.']);
    } else if (empty($sales_person_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'sales_person_id', 'errorDiv' => 'errorMessageSalesPersonId', 'errorMessage' => 'Sales Person field is required.']);
    } else if (!is_numeric($sales_person_id) || strlen($sales_person_id) > 10 || $sales_person_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'sales_person_id', 'errorDiv' => 'errorMessageSalesPersonId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($campaign_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'campaign_id', 'errorDiv' => 'errorMessageCampaignId', 'errorMessage' => 'Campaign field is required.']);
    } else if (!is_numeric($campaign_id) || strlen($campaign_id) > 10 || $campaign_id <= 0) {
        echo json_encode(['code' => 422, 'errorField' => 'campaign_id', 'errorDiv' => 'errorMessageCampaignId', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($status)) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || !is_numeric($status) || strlen($status) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($business_name) && empty($respondent_name) && empty($email)) {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'To save this record please fill the data at least in any of these fields (Business Name,Respondent Name,Email).']);
    } else if (!empty($business_name) && !validName($business_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'business_name', 'errorDiv' => 'errorMessageBusinessName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($business_name) && strlen($business_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'business_name', 'errorDiv' => 'errorMessageBusinessName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($respondent_name) && !validName($respondent_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'respondent_name', 'errorDiv' => 'errorMessageRespondentName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($respondent_name) && strlen($respondent_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'respondent_name', 'errorDiv' => 'errorMessageRespondentName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($email) && !validEmail($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($dial_code) || !is_numeric($dial_code) || strlen($dial_code) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'contact_no', 'errorDiv' => 'errorMessageContactNo', 'errorMessage' => 'Invalid country dial code.']);
    } else if (!empty($contact_no) && (!validMobileNumber($contact_no) || strlen($contact_no) !== 12)) {
        echo json_encode(['code' => 422, 'errorField' => 'contact_no', 'errorDiv' => 'errorMessageContactNo', 'errorMessage' => 'Invalid Contact No.']);
    } else if (empty($iso) || !validName($iso) || strlen($iso) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'contact_no', 'errorDiv' => 'errorMessageContactNo', 'errorMessage' => 'Invalid country iso.']);
    } else if (empty($other_dial_code) || !is_numeric($other_dial_code) || strlen($other_dial_code) > 9) {
        echo json_encode(['code' => 422, 'errorField' => 'other_contact_no', 'errorDiv' => 'errorMessageOtherContactNo', 'errorMessage' => 'Invalid country dial code.']);
    } else if (!empty($other_contact_no) && (!validMobileNumber($other_contact_no) || strlen($other_contact_no) !== 12)) {
        echo json_encode(['code' => 422, 'errorField' => 'other_contact_no', 'errorDiv' => 'errorMessageOtherContactNo', 'errorMessage' => 'Invalid Other Contact No.']);
    } else if (empty($other_iso) || !validName($other_iso) || strlen($other_iso) > 3) {
        echo json_encode(['code' => 422, 'errorField' => 'other_contact_no', 'errorDiv' => 'errorMessageOtherContactNo', 'errorMessage' => 'Invalid country iso.']);
    } else if (!empty($fax) && (!validPhoneNumber($fax) || strlen($fax) !== 14)) {
        echo json_encode(['code' => 422, 'errorField' => 'fax', 'errorDiv' => 'errorMessageFax', 'errorMessage' => 'Invalid Fax number.']);
    } else if (empty($object->data) || sizeof($object->data) < 1) {
        echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => 'Please provide at least one Communication.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $continueProcessing = false;
        $message = '';

        foreach ($object->data as $row => $data) {
            $row++;
            if (empty($data['respondent_message']) && empty($data['our_message']) && empty($data['our_note'])) {
                $message = 'To save this record please fill the data at least in any of these fields (Respondent Message,Our Message,Our Note), At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['respondent_message']) && !validAddress($data['respondent_message'])) {
                $message = 'Special Characters are not Allowed in Respondent Message field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['our_message']) && !validAddress($data['our_message'])) {
                $message = 'Special Characters are not Allowed in Our Message field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else if (!empty($data['our_note']) && !validAddress($data['our_note'])) {
                $message = 'Special Characters are not Allowed in Our Note field, At line no ' . $row;
                $continueProcessing = false;
                break;
            } else {
                $continueProcessing = true;
            }
        }

        if ($continueProcessing === false) {
            echo json_encode(['code' => 405, "toasterClass" => 'error', 'responseMessage' => $message]);
        } else {
            $date = html_entity_decode(stripslashes(date('Y-m-d', strtotime($date))));
            $business_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($business_name))));
            $respondent_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($respondent_name))));

            if (!empty($id) && is_numeric($id) && $id > 0 && hasRight($user_right_title, 'edit')) {

                $added_by = $updated_by = $user_id;
                $created_at = $updated_at = date("Y-m-d H:i:s");

                $old_lead_messages_sql = mysqli_query($db, "SELECT `added_by`, `created_at` FROM `lead_messages` WHERE `lead_id`='{$id}' ORDER BY `id` ASC LIMIT 1");
                if ($old_lead_messages_sql && mysqli_num_rows($old_lead_messages_sql) > 0) {
                    if ($result = mysqli_fetch_object($old_lead_messages_sql)) {
                        $added_by = $result->added_by;
                        $created_at = $result->created_at;
                    }
                    mysqli_query($db, "DELETE FROM `lead_messages` WHERE `lead_id`='{$id}'");
                }

                $update = "UPDATE `leads` SET `date`='{$date}',`sales_person_id`='{$sales_person_id}',`campaign_id`='{$campaign_id}',`status`='{$status}',`business_name`='{$business_name}',`respondent_name`='{$respondent_name}',`email`='{$email}',`dial_code`='{$dial_code}',`contact_no`='{$contact_no}',`iso`='{$iso}',`other_dial_code`='{$other_dial_code}',`other_contact_no`='{$other_contact_no}',`other_iso`='{$other_iso}',`fax`='{$fax}',`updated_by`='{$user_id}' WHERE `id`='{$id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'";
                mysqli_query($db, $update);
                foreach ($object->data as $row => $data) {
                    $insert = "INSERT INTO `lead_messages`(`id`, `lead_id`, `respondent_message`, `our_message`, `our_note`, `company_id`, `branch_id`, `added_by`, `created_at`, `updated_by`, `updated_at`) VALUES (NULL,'{$id}','{$data['respondent_message']}','{$data['our_message']}','{$data['our_note']}','{$company_id}','{$branch_id}','{$added_by}','{$created_at}','{$updated_by}','{$updated_at}')";
                    mysqli_query($db, $insert);
                }
                $code = 200;
                $toasterClass = 'success';
                $responseMessage = 'Record successfully saved.';
                $form_reset = false;
            } else if (empty($id) && is_numeric($id) && hasRight($user_right_title, 'add')) {
                $insert = "INSERT INTO `leads`(`id`, `date`, `sales_person_id`, `campaign_id`, `status`, `type`, `business_name`, `respondent_name`, `email`, `dial_code`, `contact_no`, `iso`, `other_dial_code`, `other_contact_no`, `other_iso`, `fax`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$date}','{$sales_person_id}','{$campaign_id}','{$status}','{$type}','{$business_name}','{$respondent_name}','{$email}','{$dial_code}','{$contact_no}','{$iso}','{$other_dial_code}','{$other_contact_no}','{$other_iso}','{$fax}','{$company_id}','{$branch_id}','{$user_id}')";
                mysqli_query($db, $insert);
                $insert_id = mysqli_insert_id($db);
                foreach ($object->data as $row => $data) {
                    $insert = "INSERT INTO `lead_messages`(`id`, `lead_id`, `respondent_message`, `our_message`, `our_note`, `company_id`, `branch_id`, `added_by`) VALUES (NULL,'{$insert_id}','{$data['respondent_message']}','{$data['our_message']}','{$data['our_note']}','{$company_id}','{$branch_id}','{$user_id}')";
                    mysqli_query($db, $insert);
                }
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
}
?>