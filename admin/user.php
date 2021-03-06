<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
?>
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php include_once("../includes/main_menu.php"); ?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                <?php include_once("../includes/header_menu.php"); ?>
                <!--end::Header-->

                <!--begin::Content-->
                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Breadcrumb-->
                    <?php include_once('../includes/bread_crumb.php'); ?>
                    <!--end::Breadcrumb-->

                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Card-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <?php
                                                if (isset($_GET['id'])) {
                                                    if (!hasRight($user_right_title, 'edit')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . $pageHeading;
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM users WHERE id='{$id}' AND company_id='{$global_company_id}' 
                                                    AND branch_id='{$global_branch_id}' AND deleted_at IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $employee_code = html_entity_decode(stripslashes($Result->employee_code));
                                                        $title = html_entity_decode(stripslashes($Result->title));
                                                        $first_name = html_entity_decode(stripslashes($Result->first_name));
                                                        $last_name = html_entity_decode(stripslashes($Result->last_name));
                                                        $pseudo_name = html_entity_decode(stripslashes($Result->pseudo_name));
                                                        $email = html_entity_decode(stripslashes($Result->email));
                                                        $gender = html_entity_decode(stripslashes($Result->gender));
                                                        $country_id = html_entity_decode(stripslashes($Result->country_id));
                                                        $state_id = html_entity_decode(stripslashes($Result->state_id));
                                                        $city_id = html_entity_decode(stripslashes($Result->city_id));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $type = html_entity_decode(stripslashes($Result->type));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;

                                                    $Q = "SELECT MAX(employee_code)+1 AS employee_code FROM users";
                                                    $Qry = mysqli_query($db, $Q);
                                                    if (mysqli_num_rows($Qry) > 0) {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $employee_code = $Result->employee_code;
                                                    } else {
                                                        $employee_code = '1';
                                                    }
                                                    $id = $state_id = $city_id = 0;
                                                    $country_id = 166;
                                                    $title = $first_name = $last_name = $pseudo_name = $email = '';
                                                    $gender = config('users.gender.value.male');
                                                    $status = config('users.status.value.activated');
                                                    $type = config('users.type.value.supervisor');
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="employee_code">* Employee Code:</label>
                                                                <input tabindex="10" maxlength="20"
                                                                       id="employee_code"
                                                                       value="<?php echo $employee_code; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly . $onblur; ?>
                                                                       placeholder="Employee Code"/>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmployeeCode"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="title">* Title:</label>
                                                                <select tabindex="20"
                                                                        id="title" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <option selected="selected" value="">Select
                                                                    </option>
                                                                    <?php
                                                                    foreach (config("users.title.title") as $key => $value) {
                                                                        $selected = $title == $key ? 'selected="selected"' : '';
                                                                        ?>
                                                                        <option <?php echo $selected; ?>
                                                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageTitle"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="first_name">* First Name:</label>
                                                                <input tabindex="30" maxlength="50" id="first_name"
                                                                       value="<?php echo $first_name; ?>" <?php echo $ApplyMaxLength . $onblur; ?>
                                                                       placeholder="First Name"/>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFirstName"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="last_name"> Last Name:</label>
                                                                <input tabindex="40" maxlength="50" id="last_name"
                                                                       value="<?php echo $last_name; ?>" <?php echo $ApplyMaxLength; ?>
                                                                       placeholder="Last Name"/>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLastName"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="pseudo_name"> Pseudo Name:</label>
                                                                <input tabindex="50" maxlength="50" id="pseudo_name"
                                                                       value="<?php echo $pseudo_name; ?>" <?php echo $ApplyMaxLength; ?>
                                                                       placeholder="Pseudo Name"/>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessagePseudoName"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="email">* Email:</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                                class="input-group-text"><i
                                                                                    class="la la-at"></i></span>
                                                                    </div>
                                                                    <input tabindex="75" id="email"
                                                                           value="<?php echo $email; ?>" <?php echo $ApplyEmailMask . $onblur; ?>
                                                                           placeholder="Email"/>
                                                                </div>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmail"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="gender">* Gender:</label>
                                                                <select tabindex="90"
                                                                        id="gender" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <option selected="selected" value="">Select
                                                                    </option>
                                                                    <?php
                                                                    foreach (config("users.gender.title") as $key => $value) {
                                                                        $selected = $gender == $key ? 'selected="selected"' : '';
                                                                        ?>
                                                                        <option <?php echo $selected; ?>
                                                                                value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGender"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="country_id">* Select Country:</label>
                                                                <select tabindex="100"
                                                                        id="country_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <option selected="selected" value="">Select
                                                                    </option>
                                                                    <?php
                                                                    $select = "SELECT * FROM `countries`";
                                                                    $query = mysqli_query($db, $select);
                                                                    if (mysqli_num_rows($query) > 0) {
                                                                        while ($result = mysqli_fetch_object($query)) {
                                                                            $selected = '';
                                                                            if ($country_id == $result->id) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            ?>
                                                                            <option data-dial_code="<?php echo $result->dial_code; ?>"
                                                                                    data-iso="<?php echo strtolower($result->iso); ?>" <?php echo $selected; ?>
                                                                                    value="<?php echo $result->id; ?>"><?php echo $result->country_name; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCountry"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="state_id">* Select State:</label>
                                                                <select tabindex="110" onchange="getCities(event)"
                                                                        id="state_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <?php
                                                                    if (!empty($country_id)) {
                                                                        echo getStates($country_id, $state_id);
                                                                    } else {
                                                                        echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageState"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="city_id">* Select City:</label>
                                                                <select tabindex="120"
                                                                        id="city_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <?php
                                                                    if (!empty($country_id) && !empty($state_id)) {
                                                                        echo getCities($state_id, $city_id);
                                                                    } else {
                                                                        echo '<option selected="selected" value="">Select
                                                                        </option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCity"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="status">* Status</label>
                                                                <select tabindex="130"
                                                                        id="status" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <?php
                                                                    foreach (config('users.status.title') as $key => $val) {
                                                                        $selected = $status == $key ? 'selected="selected"' : '';
                                                                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageStatus"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="type">* Roles</label>
                                                                <select tabindex="150"
                                                                        id="type" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                    <?php
                                                                    $roles = config('users.type.title');
                                                                    unset($roles[1]);
                                                                    foreach ($roles as $key => $val) {
                                                                        $selected = $type == $key ? 'selected="selected"' : '';
                                                                        echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageType"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2"><?php echo config('lang.button.title.save'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->

                <!--begin::Footer-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Main-->
<?php
include_once("../includes/footer.php");
include_once("../includes/footer_script.php");
?>
    <script>
        function saveFORM() {
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var titleArray = [<?php echo '"' . implode('","', array_values(config('users.title.value'))) . '"' ?>];
            var genderArray = [<?php echo '"' . implode('","', array_values(config('users.gender.value'))) . '"' ?>];
            var statusArray = [<?php echo '"' . implode('","', array_values(config('users.status.value'))) . '"' ?>];
            var typeArray = [<?php echo '"' . implode('","', array_values(config('users.type.value'))) . '"' ?>];

            var id = document.getElementById('id');
            var employee_code = document.getElementById('employee_code');
            var title = document.getElementById('title');
            var select2_title_container = document.querySelector("[aria-labelledby='select2-title-container']");
            var first_name = document.getElementById('first_name');
            var last_name = document.getElementById('last_name');
            var pseudo_name = document.getElementById('pseudo_name');
            var email = document.getElementById('email');
            var gender = document.getElementById('gender');
            var select2_gender_container = document.querySelector("[aria-labelledby='select2-gender-container']");
            var country_id = document.getElementById('country_id');
            var select2_country_id_container = document.querySelector("[aria-labelledby='select2-country_id-container']");
            var state_id = document.getElementById('state_id');
            var select2_state_id_container = document.querySelector("[aria-labelledby='select2-state_id-container']");
            var city_id = document.getElementById('city_id');
            var select2_city_id_container = document.querySelector("[aria-labelledby='select2-city_id-container']");
            var status = document.getElementById('status');
            var select2_status_container = document.querySelector("[aria-labelledby='select2-status-container']");
            var type = document.getElementById('type');
            var select2_type_container = document.querySelector("[aria-labelledby='select2-type-container']");

            var errorMessageEmployeeCode = document.getElementById('errorMessageEmployeeCode');
            var errorMessageTitle = document.getElementById('errorMessageTitle');
            var errorMessageFirstName = document.getElementById('errorMessageFirstName');
            var errorMessageLastName = document.getElementById('errorMessageLastName');
            var errorMessagePseudoName = document.getElementById('errorMessagePseudoName');
            var errorMessageEmail = document.getElementById('errorMessageEmail');
            var errorMessageGender = document.getElementById('errorMessageGender');
            var errorMessageCountry = document.getElementById('errorMessageCountry');
            var errorMessageState = document.getElementById('errorMessageState');
            var errorMessageCity = document.getElementById('errorMessageCity');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var errorMessageType = document.getElementById('errorMessageType');

            employee_code.style.borderColor = select2_title_container.style.borderColor = first_name.style.borderColor = last_name.style.borderColor = pseudo_name.style.borderColor = '#E4E6EF';
            email.style.borderColor = select2_gender_container.style.borderColor = select2_country_id_container.style.borderColor = select2_state_id_container.style.borderColor = select2_city_id_container.style.borderColor = '#E4E6EF';
            select2_status_container.style.borderColor = select2_type_container.style.borderColor = '#E4E6EF';

            errorMessageEmployeeCode.innerText = errorMessageTitle.innerText = errorMessageFirstName.innerText = errorMessageLastName.innerText = errorMessagePseudoName.innerText = errorMessageEmail.innerText = "";
            errorMessageGender.innerText = errorMessageCountry.innerText = errorMessageState.innerText = errorMessageCity.innerText = "";
            errorMessageStatus.innerText = errorMessageType.innerText = "";

            var error = '';
            var toasterType = 'error';

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (employee_code.value == '') {
                employee_code.style.borderColor = '#F00';
                error = "Employee Code field is required.";
                errorMessageEmployeeCode.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(employee_code.value) === true || employee_code.value < 1 || employee_code.value.length > 20) {
                employee_code.style.borderColor = '#F00';
                error = "Invalid Employee Code.";
                errorMessageEmployeeCode.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (title.value == '') {
                select2_title_container.style.borderColor = '#F00';
                error = "Title field is required.";
                errorMessageTitle.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (titleArray.includes(title.value) == false || title.value.length > 5) {
                select2_title_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageTitle.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (first_name.value == '') {
                first_name.style.borderColor = '#F00';
                error = "First Name field is required.";
                errorMessageFirstName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidName(first_name.value)) {
                first_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessageFirstName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (first_name.value.length > 50) {
                first_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessageFirstName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (last_name.value != '' && invalidName(last_name.value)) {
                last_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessageLastName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (last_name.value != '' && last_name.value.length > 50) {
                last_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessageLastName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (pseudo_name.value != '' && invalidName(pseudo_name.value)) {
                pseudo_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessagePseudoName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (pseudo_name.value != '' && pseudo_name.value.length > 50) {
                pseudo_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessagePseudoName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (email.value == '') {
                email.style.borderColor = '#F00';
                error = "Email field is required.";
                errorMessageEmail.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidEmail(email.value)) {
                email.style.borderColor = '#F00';
                error = "Invalid Email Address.";
                errorMessageEmail.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (gender.value == '') {
                select2_gender_container.style.borderColor = '#F00';
                error = "Gender field is required.";
                errorMessageGender.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (genderArray.includes(gender.value) == false || gender.value.length !== 1) {
                select2_gender_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageGender.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (country_id.value == '') {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Country field is required.";
                errorMessageCountry.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(country_id.value) === true || country_id.value <= 0 || country_id.value.length > 10) {
                select2_country_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageCountry.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (state_id.value == '') {
                select2_state_id_container.style.borderColor = '#F00';
                error = "State field is required.";
                errorMessageState.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(state_id.value) === true || state_id.value <= 0 || state_id.value.length > 10) {
                select2_state_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageState.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (city_id.value == '') {
                select2_city_id_container.style.borderColor = '#F00';
                error = "City field is required.";
                errorMessageCity.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(city_id.value) === true || city_id.value <= 0 || city_id.value.length > 10) {
                select2_city_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageCity.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (status.value == '') {
                select2_status_container.style.borderColor = '#F00';
                error = "Status field is required.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (statusArray.includes(status.value) == false || status.value.length !== 1) {
                select2_status_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (type.value == '') {
                select2_type_container.style.borderColor = '#F00';
                error = "Type field is required.";
                errorMessageType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (typeArray.includes(type.value) == false || type.value.length !== 1) {
                select2_type_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "employee_code": employee_code.value.trim(),
                    "title": title.value,
                    "first_name": first_name.value.trim(),
                    "last_name": last_name.value.trim(),
                    "pseudo_name": pseudo_name.value.trim(),
                    "email": email.value,
                    "gender": gender.value,
                    "country_id": country_id.value,
                    "state_id": state_id.value,
                    "city_id": city_id.value,
                    "status": status.value,
                    "type": type.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/user.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                var title = '';
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        document.getElementById(obj.errorField).style.borderColor = '#F00';
                                        document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                        loader(false);
                                        toasterTrigger(toasterType, obj.errorMessage);
                                    }
                                } else if (obj.code === 405 || obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        if (obj.form_reset !== undefined && obj.form_reset) {
                                            document.getElementById("myFORM").reset();
                                            var country_id_container = document.getElementById("select2-country_id-container");
                                            var state_id_container = document.getElementById("select2-state_id-container");
                                            var city_id_container = document.getElementById("select2-city_id-container");
                                            if (country_id_container && state_id_container && city_id_container) {
                                                country_id_container.removeAttribute("title");
                                                state_id_container.removeAttribute("title");
                                                city_id_container.removeAttribute("title");
                                                country_id_container.innerHTML = state_id_container.innerHTML = city_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                country_id.value = 0;
                                                state_id.innerHTML = city_id.innerHTML = '';
                                            }
                                            var status_container = document.getElementById("select2-status-container");
                                            if (status_container) {
                                                status_container.removeAttribute("title");
                                                status_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                status.value = '';
                                            }
                                            var type_container = document.getElementById("select2-type-container");
                                            if (type_container) {
                                                type_container.removeAttribute("title");
                                                type_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                type.value = '';
                                            }
                                            var title_container = document.getElementById("select2-title-container");
                                            if (title_container) {
                                                title_container.removeAttribute("title");
                                                title_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                title.value = '';
                                            }
                                            var gender_container = document.getElementById("select2-gender-container");
                                            if (gender_container) {
                                                gender_container.removeAttribute("title");
                                                gender_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                gender.value = '';
                                            }
                                        }
                                        loader(false);
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
                                    } else {
                                        loader(false);
                                    }
                                }
                            } else {
                                loader(false);
                            }
                        } else {
                            loader(false);
                        }
                    },
                    error: function () {
                        loader(false);
                    }
                });
            }
        }

    </script>
<?php include_once("../includes/endTags.php"); ?>