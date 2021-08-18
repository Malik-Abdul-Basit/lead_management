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
                                                    $condition = '';

                                                    /*if ($global_employee_info->user_type != config('users.type.value.super_admin') && $global_employee_info->user_type != config('users.type.value.admin')) {
                                                        $condition .= " AND `added_by`='{$global_user_id}'";
                                                    }*/
                                                    $condition .= " AND `added_by`='{$global_user_id}'";

                                                    $Q = "SELECT * FROM `tele_marketing_leads` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL " . $condition;
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $sales_person_id = html_entity_decode(stripslashes($Result->sales_person_id));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $business_name = html_entity_decode(stripslashes($Result->business_name));
                                                        $respondent_name = html_entity_decode(stripslashes($Result->respondent_name));
                                                        $email = html_entity_decode(stripslashes($Result->email));
                                                        $dial_code = html_entity_decode(stripslashes($Result->dial_code));
                                                        $contact_no = html_entity_decode(stripslashes($Result->contact_no));
                                                        $iso = html_entity_decode(stripslashes($Result->iso));
                                                        $other_dial_code = html_entity_decode(stripslashes($Result->other_dial_code));
                                                        $other_contact_no = html_entity_decode(stripslashes($Result->other_contact_no));
                                                        $other_iso = html_entity_decode(stripslashes($Result->other_iso));
                                                        $fax = html_entity_decode(stripslashes($Result->fax));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;
                                                    $id = $sales_person_id = 0;
                                                    $date = date('d-m-Y');
                                                    $status = 1;
                                                    $business_name = $respondent_name = $email = $contact_no = $other_contact_no = $fax = '';
                                                    $dial_code = $other_dial_code = '1';
                                                    $iso = $other_iso = 'us';
                                                }
                                                $mobile_no_flag = '<img class="mr-1" src="' . $ct_assets . 'images/flags/' . $iso . '.png">+' . $dial_code;
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-1">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">

                                                                <!-- Date -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="date">
                                                                            * Date:
                                                                            <small>(dd-MM-yyyy)</small>
                                                                        </label>
                                                                        <input tabindex="10" <?php echo $DateInput; ?>
                                                                               id="date" placeholder="Date"
                                                                               value="<?php echo $date; ?>">
                                                                        <span class="e-clear-icon e-clear-icon-hide"
                                                                              aria-label="close"
                                                                              role="button"></span>
                                                                        <div class="error_wrapper">
                                                                    <span class="text-danger"
                                                                          id="errorMessageDate"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Sales Person -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="sales_person_id">* Sales Person:</label>
                                                                        <select tabindex="20"
                                                                                id="sales_person_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                            <option selected="selected" value="0">
                                                                                Select
                                                                            </option>
                                                                            <?php
                                                                            $active = config('sales_persons.status.value.activated');
                                                                            $select = "SELECT id, CONCAT(first_name,' ',last_name,' (',email,')') AS name FROM `sales_persons` WHERE `status`='{$active}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `first_name` ASC";
                                                                            $query = mysqli_query($db, $select);
                                                                            if (mysqli_num_rows($query) > 0) {
                                                                                while ($result = mysqli_fetch_object($query)) {
                                                                                    $selected = '';
                                                                                    if ($sales_person_id == $result->id) {
                                                                                        $selected = 'selected="selected"';
                                                                                    }
                                                                                    ?>
                                                                                    <option <?php echo $selected; ?>
                                                                                            value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <div class="error_wrapper">
                                                                    <span class="text-danger"
                                                                          id="errorMessageSalesPersonId"></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Status -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="status">* Status:</label>
                                                                        <select tabindex="40"
                                                                                id="status" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                            <option value="0">Select</option>
                                                                            <?php
                                                                            foreach (config('tele_marketing_leads.status.title') as $key => $val) {
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

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Business Information :</h3>
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="business_name">Business Name:</label>
                                                                            <input tabindex="50" maxlength="50"
                                                                                   id="business_name"
                                                                                   value="<?php echo $business_name; ?>" <?php echo $ApplyMaxLength; ?>
                                                                                   placeholder="Business Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBusinessName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="respondent_name">Respondent Name:</label>
                                                                            <input tabindex="60" maxlength="50"
                                                                                   id="respondent_name"
                                                                                   value="<?php echo $respondent_name; ?>" <?php echo $ApplyMaxLength; ?>
                                                                                   placeholder="Respondent Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageRespondentName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="email"> Email:</label>
                                                                            <input tabindex="70" id="email"
                                                                                   value="<?php echo $email; ?>" <?php echo $ApplyEmailMask; ?>
                                                                                   placeholder="Email"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmail"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="contact_no"> Contact No:
                                                                                <small>
                                                                                    <a href="javascript:;">Example
                                                                                        300-777
                                                                                        8888</a>
                                                                                </small>
                                                                            </label>
                                                                            <input tabindex="1010" id="dial_code"
                                                                                   class="not-show" type="hidden"
                                                                                   value="<?php echo $dial_code; ?>">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"
                                                                                            id="mobile_no_flag"><?php echo $mobile_no_flag; ?></span>
                                                                                </div>
                                                                                <input tabindex="120" maxlength="12"
                                                                                       id="contact_no"
                                                                                       value="<?php echo $contact_no; ?>" <?php echo $ApplyMobileMask . $onblur; ?>
                                                                                       placeholder="Contact No"/>
                                                                            </div>
                                                                            <input tabindex="1020" id="iso"
                                                                                   class="not-show"
                                                                                   type="hidden"
                                                                                   value="<?php echo $iso; ?>">
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContactNo"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="other_contact_no"> Other Contact No:
                                                                                <small>
                                                                                    <a href="javascript:;">Example
                                                                                        300-777
                                                                                        8888</a>
                                                                                </small>
                                                                            </label>
                                                                            <input tabindex="1060" id="other_dial_code"
                                                                                   class="not-show" type="hidden"
                                                                                   value="<?php echo $other_dial_code; ?>">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"
                                                                                            id="mobile_no_flag"><?php echo $mobile_no_flag; ?></span>
                                                                                </div>
                                                                                <input tabindex="130" maxlength="12"
                                                                                       id="other_contact_no"
                                                                                       value="<?php echo $other_contact_no; ?>" <?php echo $ApplyMobileMask . $onblur; ?>
                                                                                       placeholder="Other Contact No"/>
                                                                            </div>
                                                                            <input tabindex="1070" id="other_iso"
                                                                                   class="not-show"
                                                                                   type="hidden"
                                                                                   value="<?php echo $other_iso; ?>">
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageOtherContactNo"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Fax:
                                                                                <small>
                                                                                    <a href="javascript:;">Example (041)
                                                                                        233-3333</a>
                                                                                </small>
                                                                            </label>

                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend"><span
                                                                                            class="input-group-text"><i
                                                                                                class="fas fa-fax"></i></span>
                                                                                </div>

                                                                                <input tabindex="140" maxlength="14"
                                                                                       id="fax"
                                                                                       value="<?php echo $fax; ?>" <?php echo $ApplyFaxMask; ?>
                                                                                       placeholder="Fax"/>
                                                                            </div>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFax"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="separator separator-dashed my-10"></div>

                                                <div class="mb-3">
                                                    <h3 class="font-size-lg text-dark-75 font-weight-bold mb-10">
                                                        Communication <small>(Messages)</small> :</h3>
                                                    <div class="mb-2">
                                                        <div id="Data_Holder_Parent_Div">
                                                            <div class="row">
                                                                <div class="col-md-1 column text-center">
                                                                    <b>Sr.</b>
                                                                </div>
                                                                <div class="col-md-3 column">
                                                                    <b>Respondent Message</b>
                                                                </div>
                                                                <div class="col-md-4 column">
                                                                    <b>Our Message</b>
                                                                </div>
                                                                <div class="col-md-4 column">
                                                                    <b>Our Note</b>
                                                                </div>
                                                            </div>

                                                            <div id="Data_Holder_Child_Div" class="mt-7 mb-7"
                                                                 style="max-height: 100%">
                                                                <?php
                                                                $i = 1;
                                                                if (!empty($id)) {
                                                                    $query_lead_messages = mysqli_query($db, "SELECT * FROM `tele_marketing_lead_messages` WHERE `lead_id`='{$id}' ORDER BY `id` ASC");
                                                                    if (mysqli_num_rows($query_lead_messages) > 0) {
                                                                        while ($object_lead_messages = mysqli_fetch_object($query_lead_messages)) {
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-md-1 column">
                                                                                    <div class="form-group text-center mt-3">
                                                                                        <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                            <input type="checkbox"
                                                                                                   checked="checked"
                                                                                                   class="lineRepresentativeBox"
                                                                                                   value="<?php echo $i; ?>"
                                                                                                   name="lineRepresentativeBox[]"
                                                                                                   id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                            <b class="float-left mr-2"><?php echo $i; ?>
                                                                                                . </b>
                                                                                            <span class="float-left"></span>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-3 column">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control"
                                                                                          id="respondent_message<?php echo $i; ?>"
                                                                                          placeholder="Respondent Message"><?php echo $object_lead_messages->respondent_message; ?></textarea>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4 column">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control"
                                                                                          id="our_message<?php echo $i; ?>"
                                                                                          placeholder="Our Message"><?php echo $object_lead_messages->our_message; ?></textarea>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4 column">
                                                                                    <div class="form-group">
                                                                                        <textarea class="form-control"
                                                                                          id="our_note<?php echo $i; ?>"
                                                                                          placeholder="Our Note"><?php echo $object_lead_messages->our_note; ?></textarea>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <?php
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                for ($i; $i <= 1; $i++) {
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-md-1 column">
                                                                            <div class="form-group text-center mt-3">
                                                                                <label class="checkbox checkbox-outline checkbox-success d-inline-block">
                                                                                    <input type="checkbox"
                                                                                           class="lineRepresentativeBox"
                                                                                           value="<?php echo $i; ?>"
                                                                                           name="lineRepresentativeBox[]"
                                                                                           id="lineRepresentativeBox<?php echo $i; ?>"/>
                                                                                    <b class="float-left mr-2"><?php echo $i; ?>
                                                                                        . </b>
                                                                                    <span class="float-left"></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3 column">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="respondent_message<?php echo $i; ?>"
                                                                                          placeholder="Respondent Message"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 column">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="our_message<?php echo $i; ?>"
                                                                                          placeholder="Our Message"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 column">
                                                                            <div class="form-group">
                                                                                <textarea class="form-control"
                                                                                          id="our_note<?php echo $i; ?>"
                                                                                          placeholder="Our Note"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                            <input type="hidden" name="r_rows" id="r_rows"
                                                                   value="<?php echo --$i; ?>">
                                                            <button type="button" class="btn btn-success float-right"
                                                                    onclick="addNewRow()"><?php echo config('lang.button.title.add'); ?>
                                                            </button>
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

            var statusArray = [<?php echo '"' . implode('","', array_values(config('tele_marketing_leads.status.value'))) . '"' ?>];

            var id = document.getElementById('id');
            var date = document.getElementById('date');
            var sales_person_id = document.getElementById('sales_person_id');
            var select2_sales_person_id_container = document.querySelector("[aria-labelledby='select2-sales_person_id-container']");
            var status = document.getElementById('status');
            var select2_status_container = document.querySelector("[aria-labelledby='select2-status-container']");

            var business_name = document.getElementById('business_name');
            var respondent_name = document.getElementById('respondent_name');
            var email = document.getElementById('email');
            var dial_code = document.getElementById('dial_code');
            var contact_no = document.getElementById('contact_no');
            var iso = document.getElementById('iso');
            var other_dial_code = document.getElementById('other_dial_code');
            var other_contact_no = document.getElementById('other_contact_no');
            var other_iso = document.getElementById('other_iso');
            var fax = document.getElementById('fax');

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageSalesPersonId = document.getElementById('errorMessageSalesPersonId');
            var errorMessageStatus = document.getElementById('errorMessageStatus');

            var errorMessageBusinessName = document.getElementById('errorMessageBusinessName');
            var errorMessageRespondentName = document.getElementById('errorMessageRespondentName');
            var errorMessageEmail = document.getElementById('errorMessageEmail');

            var errorMessageContactNo = document.getElementById('errorMessageContactNo');
            var errorMessageOtherContactNo = document.getElementById('errorMessageOtherContactNo');
            var errorMessageFax = document.getElementById('errorMessageFax');

            date.style.borderColor = select2_sales_person_id_container.style.borderColor = select2_status_container.style.borderColor = '#E4E6EF';
            business_name.style.borderColor = respondent_name.style.borderColor = email.style.borderColor = contact_no.style.borderColor = other_contact_no.style.borderColor = fax.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageSalesPersonId.innerText = errorMessageStatus.innerText = '';
            errorMessageBusinessName.innerText = errorMessageRespondentName.innerText = errorMessageEmail.innerText = errorMessageContactNo.innerText = errorMessageOtherContactNo.innerText = errorMessageFax.innerText = '';

            var checkedValue = null;
            var continueProcessing = false;
            var data = [];
            var message = 'Please checked at least one Communication.';
            var inputElements = document.getElementsByClassName('lineRepresentativeBox');

            var error = '';
            var toasterType = 'error';


            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
                return false;
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
                return false;
            } else if (date.value == '') {
                date.style.borderColor = '#F00';
                error = "Date field is required.";
                errorMessageDate.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidDate(date.value) || date.value.length !== 10) {
                date.style.borderColor = '#F00';
                error = "Please select a valid date.";
                errorMessageDate.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (sales_person_id.value == '' || sales_person_id.value <= 0) {
                select2_sales_person_id_container.style.borderColor = '#F00';
                error = "Sales Person field is required.";
                errorMessageSalesPersonId.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(sales_person_id.value) === true || sales_person_id.value.length > 10) {
                select2_sales_person_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageSalesPersonId.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (status.value == '' || status.value == 0) {
                select2_status_container.style.borderColor = '#F00';
                error = "Status field is required.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (statusArray.includes(status.value) == false || isNaN(status.value) === true || status.value.length > 3) {
                select2_status_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (business_name.value == '' && respondent_name.value == '' && email.value == '') {
                business_name.style.borderColor = '#F00';
                respondent_name.style.borderColor = '#F00';
                email.style.borderColor = '#F00';
                error = "To save this record please fill the data at least in any of these fields (Business Name,Respondent Name,Email)";
                toasterTrigger(toasterType, error);
                return false;
            } else if (business_name.value != '' && invalidName(business_name.value)) {
                business_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessageBusinessName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (business_name.value != '' && business_name.value.length > 50) {
                business_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessageBusinessName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (respondent_name.value != '' && invalidName(respondent_name.value)) {
                respondent_name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessageRespondentName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (respondent_name.value != '' && respondent_name.value.length > 50) {
                respondent_name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessageRespondentName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (email.value != '' && invalidEmail(email.value)) {
                email.style.borderColor = '#F00';
                error = "Invalid Email Address.";
                errorMessageEmail.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (dial_code.value == '' || isNaN(dial_code.value) === true || dial_code.value <= 0 || dial_code.value.length > 9) {
                contact_no.style.borderColor = '#F00';
                error = "Invalid country dial code.";
                errorMessageContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (contact_no.value != '' && (invalidContactNumber(contact_no.value) || contact_no.value.length !== 12)) {
                contact_no.style.borderColor = '#F00';
                error = "Invalid Contact No.";
                errorMessageContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (iso.value == '' || iso.value.length > 3 || invalidName(iso.value)) {
                contact_no.style.borderColor = '#F00';
                error = "Invalid country iso.";
                errorMessageContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (other_dial_code.value == '' || isNaN(other_dial_code.value) === true || other_dial_code.value <= 0 || other_dial_code.value.length > 9) {
                other_contact_no.style.borderColor = '#F00';
                error = "Invalid country dial code.";
                errorMessageOtherContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (other_contact_no.value != '' && (invalidContactNumber(other_contact_no.value) || other_contact_no.value.length !== 12)) {
                other_contact_no.style.borderColor = '#F00';
                error = "Invalid Other Contact No.";
                errorMessageOtherContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (other_iso.value == '' || other_iso.value.length > 3 || invalidName(other_iso.value)) {
                other_contact_no.style.borderColor = '#F00';
                error = "Invalid country iso.";
                errorMessageOtherContactNo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (fax.value != '' && (invalidContactNumber(fax.value) || fax.value.length != 14)) {
                fax.style.borderColor = '#F00';
                error = "Invalid Fax number.";
                errorMessageFax.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {

                for (var i = 0; inputElements[i]; ++i) {
                    if (inputElements[i].checked) {
                        checkedValue = inputElements[i].value;
                        var respondent_message = document.getElementById('respondent_message' + checkedValue);
                        var our_message = document.getElementById('our_message' + checkedValue);
                        var our_note = document.getElementById('our_note' + checkedValue);

                        if (respondent_message.value == '' && our_message.value == '' && our_note.value == '') {
                            respondent_message.style.borderColor = our_message.style.borderColor = our_note.style.borderColor = '#F00';
                            message = 'To save this record please fill the data at least in any of these fields (Respondent Message,Our Message,Our Note), At line no ' + checkedValue;
                            continueProcessing = false;
                            break;
                        } else if (respondent_message.value != '' && invalidAddress(respondent_message.value)) {
                            respondent_message.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Respondent Message field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else if (our_message.value != '' && invalidAddress(our_message.value)) {
                            our_message.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Our Message field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else if (our_note.value != '' && invalidAddress(our_note.value)) {
                            our_note.style.borderColor = '#F00';
                            message = 'Special Characters are not Allowed in Our Note field, At line no ' + checkedValue;
                            continueProcessing = false;
                        } else {
                            var obj = {};
                            obj = {
                                "respondent_message": respondent_message.value.trim(),
                                "our_message": our_message.value.trim(),
                                "our_note": our_note.value.trim(),
                            }
                            data.push(obj);
                            continueProcessing = true;
                        }
                    }
                }
                if (continueProcessing === false) {
                    toasterTrigger(toasterType, message);
                    return false;
                } else if (continueProcessing === true && data.length > 0) {
                    var postData = {
                        "id": id.value,
                        "date": date.value,
                        "sales_person_id": sales_person_id.value,
                        "status": status.value,
                        "business_name": business_name.value.trim(),
                        "respondent_name": respondent_name.value.trim(),
                        "email": email.value,
                        "dial_code": dial_code.value,
                        "contact_no": contact_no.value,
                        "iso": iso.value,
                        "other_dial_code": other_dial_code.value,
                        "other_contact_no": other_contact_no.value,
                        "other_iso": other_iso.value,
                        "fax": fax.value,
                        "user_right_title": '<?php echo $user_right_title; ?>',
                        "data": data
                    };
                    loader(true);
                    $.ajax({
                        type: "POST", url: "ajax/tele_marketing_lead.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse != '') {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                    if (obj.code === 422) {
                                        if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                            if (obj.errorField == 'sales_person_id') {
                                                select2_sales_person_id_container.style.borderColor = '#F00';
                                            } else if (obj.errorField == 'status') {
                                                select2_status_container.style.borderColor = '#F00';
                                            } else {
                                                document.getElementById(obj.errorField).style.borderColor = '#F00';
                                            }
                                            document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                            loader(false);
                                            toasterTrigger(toasterType, obj.errorMessage);
                                        }
                                    } else if (obj.code === 405 || obj.code === 200) {
                                        if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                            if (obj.form_reset !== undefined && obj.form_reset) {
                                                document.getElementById("myFORM").reset();
                                                var sales_person_id_container = document.getElementById("select2-sales_person_id-container");
                                                var status_container = document.getElementById("select2-status-container");

                                                if (sales_person_id_container) {
                                                    sales_person_id_container.removeAttribute("title");
                                                    sales_person_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    sales_person_id.value = 0;
                                                }
                                                if (status_container) {
                                                    status_container.removeAttribute("title");
                                                    status_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                    status.value = 0;
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
        }

        function addNewRow() {
            var last_row_number = document.getElementById('r_rows');
            var r_rows = last_row_number.value;
            var objDiv = document.getElementById("Data_Holder_Child_Div");
            var innerHTml_c = '';
            r_rows++;
            innerHTml_c += '<div class="row">';
            innerHTml_c += '<div class="col-md-1 column"><div class="form-group text-center mt-3"><label class="checkbox checkbox-outline checkbox-success d-inline-block"><input type="checkbox" class="lineRepresentativeBox" value="' + r_rows + '" name="lineRepresentativeBox[]" id="lineRepresentativeBox' + r_rows + '" checked="checked"><b class="float-left mr-2">' + r_rows + '.</b><span class="float-left"></span></label></div></div>';
            innerHTml_c += '<div class="col-md-3 column"><div class="form-group"><textarea class="form-control" id="respondent_message' + r_rows + '" placeholder="Respondent Message"></textarea></div></div>';
            innerHTml_c += '<div class="col-md-4 column"><div class="form-group"><textarea class="form-control" id="our_message' + r_rows + '" placeholder="Our Message"></textarea></div></div>';
            innerHTml_c += '<div class="col-md-4 column"><div class="form-group"><textarea class="form-control" id="our_note' + r_rows + '" placeholder="Our Note"></textarea></div></div>';
            innerHTml_c += '</div>';
            $("#Data_Holder_Child_Div").append(innerHTml_c);
            objDiv.scrollTop = objDiv.scrollHeight;
            last_row_number.value = r_rows;
        }
    </script>
<?php include_once("../includes/endTags.php"); ?>