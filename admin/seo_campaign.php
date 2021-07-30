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
                                                $type = config('lang.page_type.title.' . $page);
                                                if (isset($_GET['id'])) {
                                                    if (!hasRight($user_right_title, 'edit')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . $pageHeading;
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM `seo_campaigns` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $from = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->from))));
                                                        $to = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->to))));
                                                        $source_id = html_entity_decode(stripslashes($Result->source_id));
                                                        $cost = html_entity_decode(stripslashes($Result->cost));
                                                        $reach = html_entity_decode(stripslashes($Result->reach));
                                                        $clicks = html_entity_decode(stripslashes($Result->clicks));
                                                        $form_submissions = html_entity_decode(stripslashes($Result->form_submissions));
                                                        $calls = html_entity_decode(stripslashes($Result->calls));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;
                                                    $id = $source_id = $cost = $reach = $clicks = $form_submissions = $calls = 0;
                                                    $name = '';
                                                    $from = $to = date('d-m-Y');
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id"
                                                   value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="mb-2">

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="name">* Name:</label>
                                                                    <input tabindex="10" maxlength="50" id="name"
                                                                           value="<?php echo $name; ?>" <?php echo $ApplyMaxLength . $onblur; ?>
                                                                           placeholder="Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageName"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="from">* From:</label>
                                                                    <input tabindex="20" <?php echo $DateInput; ?>
                                                                           id="from" value="<?php echo $from; ?>"
                                                                           placeholder="From">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFrom"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="to">* To:</label>
                                                                    <input tabindex="30" <?php echo $DateInput; ?>
                                                                           id="to" value="<?php echo $to; ?>"
                                                                           placeholder="To">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageTo"></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="source_id">* Source:</label>
                                                                    <select tabindex="40"
                                                                            id="source_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                        <option selected="selected" value="0">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `sources` WHERE `type`='{$type}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($source_id == $result->id) {
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
                                                                              id="errorMessageSource"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="cost">* Cost:</label>
                                                                    <input tabindex="50" maxlength="9"
                                                                           id="cost"
                                                                           value="<?php echo $cost; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly . $onblur; ?>
                                                                           placeholder="Cost"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCost"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="reach">* Reach:</label>
                                                                    <input tabindex="60" maxlength="9"
                                                                           id="reach"
                                                                           value="<?php echo $reach; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly . $onblur; ?>
                                                                           placeholder="Reach"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageReach"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="clicks">* Clicks:</label>
                                                                    <input tabindex="70" maxlength="9"
                                                                           id="clicks"
                                                                           value="<?php echo $clicks; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Clicks"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageClicks"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="form_submissions">Form Submissions:</label>
                                                                    <input tabindex="80" maxlength="9"
                                                                           id="form_submissions"
                                                                           value="<?php echo $form_submissions; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Form Submissions"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFormSubmissions"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="calls">Calls:</label>
                                                                    <input tabindex="90" maxlength="9"
                                                                           id="calls"
                                                                           value="<?php echo $calls; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Calls"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCalls"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                                <!--<div class="separator separator-dashed my-10"></div>-->
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

            var id = document.getElementById('id');
            var name = document.getElementById('name');
            var from = document.getElementById('from');
            var to = document.getElementById('to');
            var source_id = document.getElementById('source_id');
            var select2_source_id_container = document.querySelector("[aria-labelledby='select2-source_id-container']");
            var cost = document.getElementById('cost');
            var reach = document.getElementById('reach');
            var clicks = document.getElementById('clicks');
            var form_submissions = document.getElementById('form_submissions');
            var calls = document.getElementById('calls');

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageFrom = document.getElementById('errorMessageFrom');
            var errorMessageTo = document.getElementById('errorMessageTo');
            var errorMessageSource = document.getElementById('errorMessageSource');
            var errorMessageCost = document.getElementById('errorMessageCost');
            var errorMessageReach = document.getElementById('errorMessageReach');
            var errorMessageClicks = document.getElementById('errorMessageClicks');
            var errorMessageFormSubmissions = document.getElementById('errorMessageFormSubmissions');
            var errorMessageCalls = document.getElementById('errorMessageCalls');

            name.style.borderColor = from.style.borderColor = to.style.borderColor = select2_source_id_container.style.borderColor = '#E4E6EF';
            cost.style.borderColor = reach.style.borderColor = clicks.style.borderColor = form_submissions.style.borderColor = calls.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageFrom.innerText = errorMessageTo.innerText = errorMessageSource.innerText = "";
            errorMessageCost.innerText = errorMessageReach.innerText = errorMessageClicks.innerText = errorMessageFormSubmissions.innerText = errorMessageCalls.innerText = "";

            var error = '';
            var toasterType = 'error';

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
            } else if (name.value == '') {
                name.style.borderColor = '#F00';
                error = "Name field is required.";
                errorMessageName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidName(name.value)) {
                name.style.borderColor = '#F00';
                error = "Special Characters are not Allowed.";
                errorMessageName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (name.value.length > 50) {
                name.style.borderColor = '#F00';
                error = "Length should not exceed 50 characters.";
                errorMessageName.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (from.value == '') {
                from.style.borderColor = '#F00';
                error = "From field is required.";
                errorMessageFrom.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidDate(from.value) || from.value.length !== 10) {
                from.style.borderColor = '#F00';
                error = "Please select a valid date.";
                errorMessageFrom.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (to.value == '') {
                to.style.borderColor = '#F00';
                error = "To field is required.";
                errorMessageTo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidDate(to.value) || to.value.length !== 10) {
                to.style.borderColor = '#F00';
                error = "Please select a valid date.";
                errorMessageTo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (source_id.value == '') {
                select2_source_id_container.style.borderColor = '#F00';
                error = "Source field is required.";
                errorMessageSource.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(source_id.value) === true || source_id.value.length > 10 || source_id.value <= 0) {
                select2_source_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageSource.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (cost.value == '') {
                cost.style.borderColor = '#F00';
                error = "Cost field is required.";
                errorMessageCost.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(cost.value) === true || cost.value.length > 10 || cost.value <= 0) {
                cost.style.borderColor = '#F00';
                error = "Please type a valid Cost value.";
                errorMessageCost.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (reach.value == '') {
                reach.style.borderColor = '#F00';
                error = "Reach field is required.";
                errorMessageReach.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(reach.value) === true || reach.value.length > 10 || reach.value <= 0) {
                reach.style.borderColor = '#F00';
                error = "Please type a valid number of Reach.";
                errorMessageReach.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (clicks.value == '') {
                clicks.style.borderColor = '#F00';
                error = "Clicks field is required.";
                errorMessageClicks.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(clicks.value) === true || clicks.value.length > 10 || clicks.value <= 0) {
                clicks.style.borderColor = '#F00';
                error = "Please type a valid number of Clicks.";
                errorMessageClicks.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (form_submissions.value != '' && (isNaN(form_submissions.value) === true || form_submissions.value.length > 10 || form_submissions.value < 0)) {
                form_submissions.style.borderColor = '#F00';
                error = "Please type valid number of Form Submissions.";
                errorMessageFormSubmissions.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (calls.value != '' && (isNaN(calls.value) === true || calls.value.length > 10 || calls.value < 0)) {
                calls.style.borderColor = '#F00';
                error = "Please type a valid number of Calls.";
                errorMessageCalls.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value,
                    "from": from.value,
                    "to": to.value,
                    "source_id": source_id.value,
                    "cost": cost.value,
                    "reach": reach.value,
                    "clicks": clicks.value,
                    "form_submissions": form_submissions.value,
                    "calls": calls.value,
                    "user_right_title": '<?php echo $user_right_title; ?>',
                };
                $.ajax({
                    type: "POST", url: "ajax/seo_campaign.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        document.getElementById(obj.errorField).style.borderColor = '#F00';
                                        document.getElementById(obj.errorDiv).innerText = obj.errorMessage;
                                        loader(false);
                                        toasterTrigger(toasterType, obj.errorMessage);
                                    } else {
                                        loader(false);
                                    }
                                } else if (obj.code === 405 || obj.code === 200) {
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        if (obj.form_reset !== undefined && obj.form_reset) {
                                            document.getElementById("myFORM").reset();
                                            var source_id_container = document.getElementById("select2-source_id-container");
                                            if (source_id_container) {
                                                source_id_container.removeAttribute("title");
                                                source_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                source_id.value = '0';
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