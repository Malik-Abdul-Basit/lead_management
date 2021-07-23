<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $first_name = trim($object->first_name);
    $last_name = trim($object->last_name);
    $email = $object->email;
    $gender = $object->gender;
    $status = $object->status;
    $imageBase64 = $object->imageBase64;
    $user_right_title = $object->user_right_title;

    $gender_array = array_values(config('sales_persons.gender.value'));
    $status_array = array_values(config('sales_persons.status.value'));

    if ((empty($id) || $id == 0) && (!hasRight($user_right_title, 'add'))) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to add record.']);
    } else if (!empty($id) && is_numeric($id) && $id > 0 && !hasRight($user_right_title, 'edit')) {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to update record.']);
    } else if (empty($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'First Name field is required.']);
    } else if (!validName($first_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (strlen($first_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'first_name', 'errorDiv' => 'errorMessageFirstName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (!empty($last_name) && !validName($last_name)) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Special Characters are not Allowed.']);
    } else if (!empty($last_name) && strlen($last_name) > 50) {
        echo json_encode(['code' => 422, 'errorField' => 'last_name', 'errorDiv' => 'errorMessageLastName', 'errorMessage' => 'Length should not exceed 50.']);
    } else if (empty($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Email field is required.']);
    } else if (!validEmail($email)) {
        echo json_encode(['code' => 422, 'errorField' => 'email', 'errorDiv' => 'errorMessageEmail', 'errorMessage' => 'Invalid Email Address.']);
    } else if (empty($gender)) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Gender field is required.']);
    } else if (!in_array($gender, $gender_array) || strlen($gender) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'gender', 'errorDiv' => 'errorMessageGender', 'errorMessage' => 'Please select a valid option.']);
    } else if ($status == '') {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Status field is required.']);
    } else if (!in_array($status, $status_array) || strlen($status) !== 1) {
        echo json_encode(['code' => 422, 'errorField' => 'status', 'errorDiv' => 'errorMessageStatus', 'errorMessage' => 'Please select a valid option.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];

        $select = "SELECT `id` FROM `sales_persons` WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `email`='{$email}' AND `id`!='{$id}'";
        $query = mysqli_query($db, $select);
        if (mysqli_num_rows($query) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Sales Person already exist.']);
        } else {
            $first_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($first_name))));
            $last_name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($last_name))));

            if (!empty($id) && $id > 0 && hasRight($user_right_title, 'edit')) {
                $update = "UPDATE `sales_persons` SET `first_name`='{$first_name}',`last_name`='{$last_name}',`email`='{$email}',`gender`='{$gender}',`status`='{$status}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                if (mysqli_query($db, $update)) {
                    if (!empty($imageBase64)) {
                        changeSalesPersonImage($id, $imageBase64, $user_right_title);
                    }
                    echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.']);
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                }
            } else if (empty($id) && hasRight($user_right_title, 'add')) {
                $insert = "INSERT INTO `sales_persons`(`id`, `first_name`, `last_name`, `email`, `gender`, `status`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$first_name}', '{$last_name}', '{$email}', '{$gender}', '{$status}', '{$company_id}','{$branch_id}','{$user_id}')";
                if (mysqli_query($db, $insert)) {
                    $id = mysqli_insert_id($db);
                    if (!empty($imageBase64)) {
                        changeSalesPersonImage($id, $imageBase64, $user_right_title);
                    }
                    echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record successfully saved.', 'form_reset' => TRUE]);
                } else {
                    echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                }
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        }
    }
}
?>