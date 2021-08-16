<?php
include_once('../../includes/connection.php');

$deleted_at = date('Y-m-d H:i:s');
$global_company_id = $_SESSION['company_id'];
$global_branch_id = $_SESSION['branch_id'];
$global_user_id = $_SESSION['user_id'];
global $db;

if (isset($_POST['delete_branch'], $_POST['user_right_title'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
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

if (isset($_POST['delete_source'], $_POST['user_right_title'], $_POST['type']) && !empty($_POST['delete_source']) && !empty($_POST['user_right_title']) && !empty($_POST['type']) && is_numeric($_POST['delete_source'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_source']);

        if($_POST['type'] == config('sources.type.value.search_engine_optimization')){
            $query = mysqli_query($db, "SELECT `id` FROM `seo_campaigns` WHERE `source_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        } else{
            $query = mysqli_query($db, "SELECT `id` FROM `campaigns` WHERE `source_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        }

        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `sources` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `type`='{$_POST['type']}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => ' Record already in used.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_account'], $_POST['user_right_title'], $_POST['type']) && !empty($_POST['delete_account']) && !empty($_POST['user_right_title']) && !empty($_POST['type']) && is_numeric($_POST['delete_account'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_account']);
        $query = mysqli_query($db, "SELECT `id` FROM `campaigns` WHERE `account_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `accounts` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `type`='{$_POST['type']}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => ' Record already in used.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_campaign_type'], $_POST['user_right_title'], $_POST['type']) && !empty($_POST['delete_campaign_type']) && !empty($_POST['user_right_title']) && !empty($_POST['type']) && is_numeric($_POST['delete_campaign_type'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_campaign_type']);
        $query = mysqli_query($db, "SELECT `id` FROM `campaigns` WHERE `campaign_type_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `campaign_types` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `type`='{$_POST['type']}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => ' Record already in used.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_seo_campaign'], $_POST['user_right_title']) && !empty($_POST['delete_seo_campaign']) && !empty($_POST['user_right_title']) && is_numeric($_POST['delete_seo_campaign'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_seo_campaign']);
        $query = mysqli_query($db, "SELECT `id` FROM `seo_leads` WHERE `campaign_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `seo_campaigns` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => ' Record already in used.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_campaign'], $_POST['user_right_title'], $_POST['type']) && !empty($_POST['delete_campaign']) && !empty($_POST['user_right_title']) && !empty($_POST['type']) && is_numeric($_POST['delete_campaign'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_campaign']);
        $query = mysqli_query($db, "SELECT `id` FROM `leads` WHERE `campaign_id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}' AND `deleted_at` IS NULL");
        $number_of_record = mysqli_num_rows($query);
        if ($number_of_record == 0) {
            if (mysqli_query($db, "UPDATE `campaigns` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `type`='{$_POST['type']}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
                echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
            } else {
                echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
            }
        } else {
            echo json_encode(["code" => 422, "toasterClass" => 'warning', "responseMessage" => ' Record already in used.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_seo_lead'], $_POST['user_right_title']) && !empty($_POST['delete_seo_lead']) && !empty($_POST['user_right_title']) && is_numeric($_POST['delete_seo_lead'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_seo_lead']);
        if (mysqli_query($db, "UPDATE `seo_leads` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_lead'], $_POST['user_right_title'], $_POST['type']) && !empty($_POST['delete_lead']) && !empty($_POST['user_right_title']) && !empty($_POST['type']) && is_numeric($_POST['delete_lead'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {
        $id = htmlentities($_POST['delete_lead']);
        if (mysqli_query($db, "UPDATE `leads` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `type`='{$_POST['type']}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'")) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }
    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}

if (isset($_POST['delete_daily_progress'], $_POST['user_right_title']) && !empty($_POST['delete_daily_progress']) && !empty($_POST['user_right_title']) && is_numeric($_POST['delete_daily_progress'])) {
    if (hasRight($_POST['user_right_title'], 'delete')) {

        $condition='';
        $employee_info = getUserInfoFromId($global_user_id);
        if ($employee_info->user_type != config('users.type.value.super_admin') && $employee_info->user_type != config('users.type.value.admin')) {
            $condition .= " AND `user_id`='{$global_user_id}'";
        }

        $id = htmlentities($_POST['delete_daily_progress']);
        if (mysqli_query($db, "UPDATE `daily_progress_details` SET `deleted_by`='{$global_user_id}', `deleted_at`='{$deleted_at}' WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_company_id}'".$condition)) {
            echo json_encode(["code" => 200, "toasterClass" => 'success', "responseMessage" => 'Record has been deleted.']);
        } else {
            echo json_encode(["code" => 405, "toasterClass" => 'error', "responseMessage" => 'Unexpected error.']);
        }

    } else {
        echo json_encode(["code" => 405, "toasterClass" => 'warning', "responseMessage" => 'Sorry! You have no right to delete record.']);
    }
}


?>