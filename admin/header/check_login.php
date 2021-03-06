<?php
include_once('../includes/connection.php');
if (empty($_SESSION['company_id']) || empty($_SESSION['branch_id']) || empty($_SESSION['employee_id']) || empty($_SESSION['user_id'])) {
    header("location:../login");
    exit();
} else {
    $global_company_id = $_SESSION['company_id'];
    $global_branch_id = $_SESSION['branch_id'];
    $global_employee_id = $_SESSION['employee_id'];
    $global_user_id = $_SESSION['user_id'];
    $global_employee_info = getUserInfoFromId($global_user_id);

    date_default_timezone_set($global_employee_info->time_zone);
    global $db, $page, $page_not_found_url;

    $display_global_employee_info = 0;
    if ($display_global_employee_info) {
        echo '<pre>';
        print_r($global_employee_info);
        echo '</pre>';
        exit();
    }

    //check company delete or not $company_delete branch_delete
    if ($global_employee_info->company_status != config('companies.status.value.working') || $global_employee_info->branch_status != config('branches.status.value.working') || $global_employee_info->user_status != config('users.status.value.activated')) {
        $_SESSION['company_id'] = $_SESSION['branch_id'] = $_SESSION['employee_id'] = $_SESSION['user_id'] = '';
        session_destroy();
        header("location:../login");
        exit();
    } else {

        $select_current_page = "SELECT child.id AS child_menu_id, child.display_name AS child_menu_name, child.sub_menu_id, child.user_right_title,
        sub.name AS sub_menu_name, sub.main_menu_id, main.name AS main_menu_name, main.icon,
        child.status AS child_status, sub.status AS sub_status, main.status AS main_status
        FROM
            child_menus AS child
        INNER JOIN
            sub_menus AS sub
            ON child.sub_menu_id = sub.id
        INNER JOIN
            main_menus AS main
            ON sub.main_menu_id = main.id
        WHERE child.file_name='{$page}' ORDER BY child.id ASC LIMIT 1";
        $query_current_page = mysqli_query($db, $select_current_page);
        if (mysqli_num_rows($query_current_page) > 0) {
            $fetch_current_page = mysqli_fetch_object($query_current_page);
            if ($fetch_current_page->child_status == config('child_menus.status.value.active') &&
                $fetch_current_page->sub_status == config('sub_menus.status.value.active') &&
                $fetch_current_page->main_status == config('main_menus.status.value.active')) {
                $child_menu_id = $fetch_current_page->child_menu_id;
                $child_menu_name = $fetch_current_page->child_menu_name;
                $user_right_title = $fetch_current_page->user_right_title;
                $sub_menu_id = $fetch_current_page->sub_menu_id;
                $sub_menu_name = $fetch_current_page->sub_menu_name;
                $main_menu_id = $fetch_current_page->main_menu_id;
                $main_menu_name = $fetch_current_page->main_menu_name;
                $page_icon = $fetch_current_page->icon;

                if (isset($_GET['id'])) {
                    if (!hasRight($user_right_title, 'edit')) {
                        header('Location: ' . $page_not_found_url);
                        exit();
                    }
                } else if ($global_employee_info->user_type != config('users.type.value.super_admin')) {
                    $select_current_page = "SELECT child.id AS child_menu_id, child.display_name AS child_menu_name, child.sub_menu_id, child.user_right_title,
                    sub.name AS sub_menu_name, sub.main_menu_id, main.name AS main_menu_name,
                    child.status AS child_status, sub.status AS sub_status, main.status AS main_status
                    FROM
                        child_menus AS child
                    INNER JOIN
                        sub_menus AS sub
                        ON child.sub_menu_id = sub.id
                    INNER JOIN
                        main_menus AS main
                        ON sub.main_menu_id = main.id
                    INNER JOIN
                        user_rights AS ur
                        ON ur.child_menu_id = child.id
                    WHERE child.file_name='{$page}' AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}'
                    AND ur.branch_id='{$global_branch_id}' GROUP BY child.id ORDER BY child.id ASC LIMIT 1";
                    $query_current_page = mysqli_query($db, $select_current_page);
                    if (mysqli_num_rows($query_current_page) == 0) {
                        header('Location: ' . $page_not_found_url);
                        exit();
                    }
                }
            } else {
                header('Location: ' . $page_not_found_url);
                exit();
            }
        } else {
            if ($page != 'dashboard') {
                header('Location: ' . $page_not_found_url);
                exit();
            }
            $child_menu_id = $child_menu_name = $user_right_title = $sub_menu_id = $sub_menu_name = $main_menu_id = $main_menu_name =  $page_icon = '';
        }
    }
}
$checkLogin = TRUE;

$DateInput = ' type="text" class="DatePicker e-input form-control" onfocus="openCalendar(event)" onclick="openCalendar(event)" maxlength="10" data-format="dd-MM-yyyy" ';//onkeypress="openCalendar(event)"
$TAttrs = ' type="text" class="form-control" onkeypress="formSubmitOnEnter(event)" ';
$NAttrs = ' type="number" class="form-control" onkeypress="formSubmitOnEnter(event)" ';

$AllowNumberOnly = ' type="text" class="form-control apply_max_length" onkeypress="formSubmitOnEnter(event), allowNumberOnly(event)" ';

$ApplyMaxLengthAndTouchSpin = ' type="text" class="form-control apply_touch_spin apply_max_length" onkeypress="formSubmitOnEnter(event)" ';
$ApplyMaxLengthTouchSpinAndNumberOnly = ' type="text" class="form-control apply_touch_spin apply_max_length" onkeypress="formSubmitOnEnter(event), allowNumberOnly(event)" ';
$ApplyMaxLength = ' type="text" class="form-control apply_max_length" onkeypress="formSubmitOnEnter(event)" ';
$ApplyTouchSpin = ' type="text" class="form-control apply_touch_spin" onkeypress="formSubmitOnEnter(event)" ';

$ApplySelect2 = ' class="form-control apply_select2"';
$ApplyEmailMask = ' type="text" class="form-control apply_email_mask" onkeypress="formSubmitOnEnter(event)" ';
$ApplyMobileMask = ' type="text" class="form-control apply_mobile_mask" onkeypress="formSubmitOnEnter(event)" ';
$ApplyFaxMask = ' type="text" class="form-control apply_fax_mask" onkeypress="formSubmitOnEnter(event)" ';
$ApplyCNICMask = ' type="text" class="form-control apply_cnic_mask" onkeypress="formSubmitOnEnter(event)" ';
$ApplyIpAddressMask = ' type="text" class="form-control apply_ip_address_mask" onkeypress="formSubmitOnEnter(event)" ';

$onblur = ' onblur="change_color(this.value, this.id)" ';
$disable = ' type="text" class="form-control form-control-solid" disabled readonly style="cursor: not-allowed" ';






?>