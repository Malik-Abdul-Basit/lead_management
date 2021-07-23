<?php
include_once('../../includes/connection.php');

$deleted_at = date('Y-m-d H:i:s');
$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['delete_branch'])) {
    if (hasRight('branch', 'delete')) {
        $id = htmlentities($_POST['delete_branch']);
        $query = mysqli_query($db, "SELECT `id` FROM `users` WHERE `branch_id`='{$id}' AND `deleted_at` IS NULL");
        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `branches` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `id`='{$id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => $number_of_record . ' User(s) exist in this Branch.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_shift']) && hasRight('shift', 'delete')) {
    $delete = htmlentities($_POST['delete_shift']);
    $query = mysqli_query($db, "SELECT id FROM employees WHERE shift_id='{$delete}' AND deleted_at IS NULL");
    $number_of_record = mysqli_num_rows($query);
    if ($number_of_record == 0) {
        if (mysqli_query($db, "UPDATE `shifts` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `id`='{$delete}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => 'This shift assigned to ' . $number_of_record . ' Employee(s).']);
    }
}


?>