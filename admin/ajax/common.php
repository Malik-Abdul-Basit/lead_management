<?php
include_once('../../includes/connection.php');

$company_id = $_SESSION['company_id'];
$branch_id = $_SESSION['branch_id'];
$global_employee_id = $_SESSION['employee_id'];
$global_user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['postData'], $_POST['getStates']) && $_POST['getStates'] == true) {
    $object = (object)$_POST['postData'];
    $country_id = $object->country_id;
    $state_id = 0;
    $states = getStates($country_id, $state_id);
    echo json_encode(["code" => 200, "StatesList" => $states]);
}

if (isset($_POST['postData'], $_POST['getCities']) && $_POST['getCities'] == true) {
    $object = (object)$_POST['postData'];

    $state_id = $object->state_id;
    $city_id = 0;
    $cities = getCities($state_id, $city_id);
    echo json_encode(["code" => 200, "CitiesList" => $cities]);
}

if (isset($_POST['postData'], $_POST['getEmployee'], $_POST['R']) && !empty($_POST['R']) && $_POST['getEmployee'] == true) {
    $object = (object)$_POST['postData'];
    $employee_code = $object->code;
    $right_title = $_POST['R'];

    $select = "SELECT *, id AS user_id, id AS employee_id, CONCAT(first_name,' ',last_name) AS full_name, email AS official_email 
    FROM users 
    WHERE employee_code='{$employee_code}' AND company_id='{$company_id}' AND branch_id='{$branch_id}' AND deleted_at IS NULL 
    ORDER BY id ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        if ($result = mysqli_fetch_object($query)) {
            $hasRight = false;
            $code = 405;
            $checkImage = getUserImage($result->user_id);
            $image_path = $checkImage['image_path'];
            $employee_info = ["id" => $result->employee_id, "u_id" => $result->user_id, "full_name" => $result->full_name, "pseudo_name" => $result->pseudo_name, "email" => $result->official_email, "image" => $image_path];

            if ($right_title == 'user') {
                if (hasRight($right_title, 'assign_rights')) {
                    $hasRight = true;
                    $code = 200;
                }
            } else if ($right_title == 'user_image') {
                if (hasRight($right_title, 'add') && $checkImage['default']) {
                    $hasRight = true;
                    $code = 200;
                } else if (hasRight($right_title, 'edit') && !$checkImage['default']) {
                    $hasRight = true;
                    $code = 200;
                }
            }

            echo json_encode(["code" => $code, 'employee_info' => $employee_info, 'hasRight' => $hasRight]);
        }
    } else {
        echo json_encode(["code" => 404, "responseMessage" => 'Employee not found with ' . $employee_code . ' employee code.']);
    }
}

if (isset($_POST['postData'], $_POST['getUserRights']) && $_POST['getUserRights'] == true) {
    $object = (object)$_POST['postData'];
    $employee_id = $object->id;
    $u_id = $object->u_id;
    $branch_id = $object->branch_id;

    $select = "SELECT `status`,`type` FROM `users` WHERE `id`='{$u_id}' AND `deleted_at` IS NULL ORDER BY `id` ASC LIMIT 1";
    $query = mysqli_query($db, $select);
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_object($query);
        $status_html = config('users.status.title.'.$result->status);
        $type_html = config('users.type.title.'.$result->type);
        $html = getUserRightsHTML($u_id, $branch_id);
        echo json_encode(["code" => 200, "status" => $result->status, 'status_html' => $status_html, "type" => $result->type, 'type_html' => $type_html, "html" => $html]);
    }
}


if (isset($_POST['postData'], $_POST['readNotification']) && $_POST['readNotification'] == true) {

    $object = (object)$_POST['postData'];
    $status = config('notifications.status.value.read');

    if (isset($object->id) && !empty($object->id) && is_numeric($object->id) && $object->id > 0) {
        mysqli_query($db, "UPDATE `notifications` SET `status`='{$status}' WHERE `id`='{$object->id}' AND `company_id`='{$company_id}' AND `branch_id`='{$branch_id}'");
        $data = getNotification($global_employee_id);
        echo json_encode(["code" => 200, "data" => $data]);
    }
}

if (isset($_POST['postData'], $_POST['resetPassword']) && $_POST['resetPassword'] == true) {

    $object = (object)$_POST['postData'];
    $oldPassword = $object->old_password;
    $newPassword = $object->new_password;
    $confirmPassword = $object->confirm_password;

    if (empty($oldPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'old_password', 'errorDiv' => 'errorMessageOldPassword', 'errorMessage' => 'Old Password field is required.']);
    } else if (empty($newPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'New Password field is required.']);
    } else if (strlen($newPassword) <= 8) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Password should be more than 8 characters.']);
    } else if (lowerCaseExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one lowercase character. (a-z)']);
    } else if (uppercaseExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one uppercase character. (A-Z)']);
    } else if (numberExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Please enter at least one digit character. (0-9)']);
    } else if (specialCharactersExist($newPassword) === false) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Password should contain at least one special character. (!@#$%^&*)']);
    } else if ($oldPassword == $newPassword) {
        echo json_encode(['code' => 422, 'errorField' => 'new_password', 'errorDiv' => 'errorMessageNewPassword', 'errorMessage' => 'Your New Password should be different from the previous One.']);
    } else if (empty($confirmPassword)) {
        echo json_encode(['code' => 422, 'errorField' => 'confirm_password', 'errorDiv' => 'errorMessageConfirmPassword', 'errorMessage' => 'Confirm Password field is required.']);
    } else if ($confirmPassword != $newPassword) {
        echo json_encode(['code' => 422, 'errorField' => 'confirm_password', 'errorDiv' => 'errorMessageConfirmPassword', 'errorMessage' => 'Password mismatch.']);
    } else {
        $old_password = md5($oldPassword);
        $password = md5($newPassword);
        $confirm_password = md5($confirmPassword);

        if (isset($object->old_password, $object->new_password, $object->confirm_password) && !empty($object->old_password) && !empty($object->new_password) && !empty($object->confirm_password)) {
            $select = mysqli_query($db, "SELECT u.id, u.email, e.company_id, e.branch_id, CONCAT(eb.first_name,' ',eb.last_name) AS user_name FROM users AS u INNER JOIN employees AS e ON e.id=u.employee_id INNER JOIN employee_basic_infos AS eb ON e.id=eb.employee_id WHERE u.id='{$global_user_id}' AND u.employee_id='{$global_employee_id}' AND u.password='{$old_password}' AND e.company_id='{$company_id}' AND e.branch_id='{$branch_id}' ORDER BY u.id ASC LIMIT 1");
            if (mysqli_num_rows($select) > 0) {
                if ($result = mysqli_fetch_object($select)) {
                    $id = $result->id;
                    $email = $result->email;
                    $user_name = $result->user_name;
                    if (mysqli_query($db, "UPDATE `users` SET `password`='{$password}' WHERE `id`='{$id}'")) {
                        $notification_type = config("notifications.type.value.password_reset");
                        $notification_status = config("notifications.status.value.pending");
                        $notification_body = getNotificationBody($notification_type);
                        insertNotification($notification_type, $global_employee_id, $global_employee_id, $id, $notification_body['message'], '', $notification_status, $company_id, $branch_id, $id);
                        $mail_body = getMailBody($notification_type, ['{mailToName}' => $user_name, '{mailTo}' => $email, '{newPassword}' => $newPassword]);
                        $parameters = [
                            'subject' => $notification_type,
                            'data' => [
                                'email_body' => $mail_body['html'],
                                'message' => $mail_body['message'],
                            ],
                            'mailTo' => [
                                'email' => $email,
                                'name' => $user_name,
                            ],
                        ];
                        sendEmail($parameters);
                        echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Password successfully changed.']);
                    } else {
                        echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
                    }
                }
            } else {
                echo json_encode(['code' => 422, 'errorField' => 'old_password', 'errorDiv' => 'errorMessageOldPassword', 'errorMessage' => 'Old Password is incorrect.']);
            }
        }
    }
}

?>