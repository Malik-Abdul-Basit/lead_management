<?php
include_once('../../includes/connection.php');

if (isset($_POST['postData'])) {
    $object = (object)$_POST['postData'];

    $id = $object->id;
    $name = $object->name;
    $source_id = $object->source_id;
    $type = $object->type;
    $user_right_title = $object->user_right_title;

    $type_array = array_values(config('accounts.type.value'));

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
    } else if (empty($source_id)) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Source field is required.']);
    } else if (!is_numeric($source_id) || strlen($source_id) > 10) {
        echo json_encode(['code' => 422, 'errorField' => 'source_id', 'errorDiv' => 'errorMessageSource', 'errorMessage' => 'Please select a valid option.']);
    } else if (empty($type) || !in_array($type, $type_array)) {
        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Sorry! some unexpected error.']);
    } else {
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $user_id = $_SESSION['user_id'];
        $name = $db->real_escape_string(html_entity_decode(stripslashes(strip_tags($name))));

        $checkExist = mysqli_query($db, "SELECT `id` FROM `accounts` WHERE `name`='{$name}' AND `source_id`='{$source_id}' AND `type`='{$type}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`!='{$id}' AND `deleted_at` IS NULL");
        if (mysqli_num_rows($checkExist) > 0) {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'This Account already exist.']);
        } else {
            if (!empty($id) && $id > 0) {
                $query = "UPDATE `accounts` SET `name`='{$name}',`source_id`='{$source_id}',`updated_by`='{$user_id}' WHERE `company_id`='{$company_id}' AND `branch_id`='{$branch_id}' AND `id`='{$id}'";
                $form_reset = false;
            } else {
                $query = "INSERT INTO `accounts`(`id`, `name`, `type`, `source_id`, `company_id`, `branch_id`, `added_by`) VALUES (NULL, '{$name}', '{$type}', '{$source_id}', '{$company_id}', '{$branch_id}', '{$user_id}')";
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