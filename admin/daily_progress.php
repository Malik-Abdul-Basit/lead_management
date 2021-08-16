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
                                                        $condition .= " AND `user_id`='{$global_user_id}'";
                                                    }*/
                                                    $condition .= " AND `user_id`='{$global_user_id}'";

                                                    $Q = "SELECT * FROM `daily_progress_details` WHERE `id`='{$id}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL " . $condition;
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));

                                                        $calls = html_entity_decode(stripslashes($Result->calls));
                                                        $follow_ups = html_entity_decode(stripslashes($Result->follow_ups));
                                                        $good_responses = html_entity_decode(stripslashes($Result->good_responses));
                                                        $bad_responses = html_entity_decode(stripslashes($Result->bad_responses));
                                                        $bad_data = html_entity_decode(stripslashes($Result->bad_data));
                                                        $no_answers = html_entity_decode(stripslashes($Result->no_answers));
                                                        $voice_mails = html_entity_decode(stripslashes($Result->voice_mails));
                                                        $emails_sent = html_entity_decode(stripslashes($Result->emails_sent));
                                                        $lead_conversion = html_entity_decode(stripslashes($Result->lead_conversion));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;
                                                    $date = date('d-m-Y');
                                                    $id = $calls = $follow_ups = $good_responses = $bad_responses = $bad_data = $no_answers = $voice_mails = $emails_sent = $lead_conversion = 0;
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
                                                                    <label for="date">* Date:</label>
                                                                    <input tabindex="10" <?php echo $DateInput; ?>
                                                                           id="date" value="<?php echo $date; ?>"
                                                                           placeholder="Date">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close" role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDate"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="calls">* Calls:</label>
                                                                    <input tabindex="20" maxlength="9"
                                                                           id="calls"
                                                                           value="<?php echo $calls; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly . $onblur; ?>
                                                                           placeholder="Calls"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageCalls"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                <label for="follow_ups">Follow Ups:</label>
                                                                <input tabindex="30" maxlength="9"
                                                                       id="follow_ups"
                                                                       value="<?php echo $follow_ups; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                       placeholder="Follow Ups"/>
                                                                <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFollowUps"></span>
                                                                </div>
                                                            </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="good_responses">Good Responses:</label>
                                                                    <input tabindex="40" maxlength="9"
                                                                           id="good_responses"
                                                                           value="<?php echo $good_responses; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Good Responses"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageGoodResponses"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bad_responses">Bad Responses:</label>
                                                                    <input tabindex="50" maxlength="9"
                                                                           id="bad_responses"
                                                                           value="<?php echo $bad_responses; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Bad Responses"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBadResponses"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="bad_data">Bad Data:</label>
                                                                    <input tabindex="60" maxlength="9"
                                                                           id="bad_data"
                                                                           value="<?php echo $bad_data; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Bad Data"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageBadData"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="no_answers">No Answers:</label>
                                                                    <input tabindex="70" maxlength="9"
                                                                           id="no_answers"
                                                                           value="<?php echo $no_answers; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="No Answers"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageNoAnswers"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="voice_mails">Voice Mails:</label>
                                                                    <input tabindex="80" maxlength="9"
                                                                           id="voice_mails"
                                                                           value="<?php echo $voice_mails; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Voice Mails"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageVoiceMails"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="emails_sent">Emails Sent:</label>
                                                                    <input tabindex="90" maxlength="9"
                                                                           id="emails_sent"
                                                                           value="<?php echo $emails_sent; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Emails Sent"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageEmailsSent"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="lead_conversion">Lead Conversion:</label>
                                                                    <input tabindex="100" maxlength="9"
                                                                           id="lead_conversion"
                                                                           value="<?php echo $lead_conversion; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Lead Conversion"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageLeadConversion"></span>
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
            var date = document.getElementById('date');

            var calls = document.getElementById('calls');
            var follow_ups = document.getElementById('follow_ups');
            var good_responses = document.getElementById('good_responses');
            var bad_responses = document.getElementById('bad_responses');
            var bad_data = document.getElementById('bad_data');
            var no_answers = document.getElementById('no_answers');
            var voice_mails = document.getElementById('voice_mails');
            var emails_sent = document.getElementById('emails_sent');
            var lead_conversion = document.getElementById('lead_conversion');

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageCalls = document.getElementById('errorMessageCalls');
            var errorMessageFollowUps = document.getElementById('errorMessageFollowUps');
            var errorMessageGoodResponses = document.getElementById('errorMessageGoodResponses');
            var errorMessageBadResponses = document.getElementById('errorMessageBadResponses');
            var errorMessageBadData = document.getElementById('errorMessageBadData');
            var errorMessageNoAnswers = document.getElementById('errorMessageNoAnswers');
            var errorMessageVoiceMails = document.getElementById('errorMessageVoiceMails');
            var errorMessageEmailsSent = document.getElementById('errorMessageEmailsSent');
            var errorMessageLeadConversion = document.getElementById('errorMessageLeadConversion');

            date.style.borderColor = calls.style.borderColor = follow_ups.style.borderColor = good_responses.style.borderColor = bad_responses.style.borderColor = '#E4E6EF';
            bad_data.style.borderColor = no_answers.style.borderColor = voice_mails.style.borderColor = emails_sent.style.borderColor = lead_conversion.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageCalls.innerText = errorMessageFollowUps.innerText = errorMessageGoodResponses.innerText = errorMessageBadResponses.innerText = "";
            errorMessageBadData.innerText = errorMessageNoAnswers.innerText = errorMessageVoiceMails.innerText = errorMessageEmailsSent.innerText = errorMessageLeadConversion.innerText = "";

            var error = '';
            var toasterType = 'error';

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
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
            } else if (calls.value == '') {
                calls.style.borderColor = '#F00';
                error = "Calls field is required.";
                errorMessageCalls.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(calls.value) === true || calls.value.length > 10 || calls.value <= 0) {
                calls.style.borderColor = '#F00';
                error = "Please type a valid number of Calls.";
                errorMessageCalls.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (follow_ups.value == '') {
                follow_ups.style.borderColor = '#F00';
                error = "Follow Ups field is required.";
                errorMessageFollowUps.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (follow_ups.value != '' && (isNaN(follow_ups.value) === true || follow_ups.value.length > 10 || follow_ups.value < 0)) {
                follow_ups.style.borderColor = '#F00';
                error = "Please type valid number of Follow Ups.";
                errorMessageFollowUps.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (good_responses.value == '') {
                good_responses.style.borderColor = '#F00';
                error = "Good Responses field is required.";
                errorMessageGoodResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (good_responses.value != '' && (isNaN(good_responses.value) === true || good_responses.value.length > 10 || good_responses.value < 0)) {
                good_responses.style.borderColor = '#F00';
                error = "Please type valid number of Good Responses.";
                errorMessageGoodResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (bad_responses.value == '') {
                bad_responses.style.borderColor = '#F00';
                error = "Bad Responses field is required.";
                errorMessageBadResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (bad_responses.value != '' && (isNaN(bad_responses.value) === true || bad_responses.value.length > 10 || bad_responses.value < 0)) {
                bad_responses.style.borderColor = '#F00';
                error = "Please type valid number of Bad Responses.";
                errorMessageBadResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (bad_data.value == '') {
                bad_data.style.borderColor = '#F00';
                error = "Bad Data field is required.";
                errorMessageBadData.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (bad_data.value != '' && (isNaN(bad_data.value) === true || bad_data.value.length > 10 || bad_data.value < 0)) {
                bad_data.style.borderColor = '#F00';
                error = "Please type valid number of Bad Data.";
                errorMessageBadData.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (no_answers.value == '') {
                no_answers.style.borderColor = '#F00';
                error = "No Answers field is required.";
                errorMessageNoAnswers.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (no_answers.value != '' && (isNaN(no_answers.value) === true || no_answers.value.length > 10 || no_answers.value < 0)) {
                no_answers.style.borderColor = '#F00';
                error = "Please type valid number of No Answers.";
                errorMessageNoAnswers.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (voice_mails.value == '') {
                voice_mails.style.borderColor = '#F00';
                error = "Voice Mails field is required.";
                errorMessageVoiceMails.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (voice_mails.value != '' && (isNaN(voice_mails.value) === true || voice_mails.value.length > 10 || voice_mails.value < 0)) {
                voice_mails.style.borderColor = '#F00';
                error = "Please type valid number of Voice Mails.";
                errorMessageVoiceMails.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (emails_sent.value == '') {
                emails_sent.style.borderColor = '#F00';
                error = "Emails Sent field is required.";
                errorMessageEmailsSent.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (emails_sent.value != '' && (isNaN(emails_sent.value) === true || emails_sent.value.length > 10 || emails_sent.value < 0)) {
                emails_sent.style.borderColor = '#F00';
                error = "Please type valid number of Emails Sent.";
                errorMessageEmailsSent.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (lead_conversion.value == '') {
                lead_conversion.style.borderColor = '#F00';
                error = "Lead Conversion field is required.";
                errorMessageLeadConversion.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (lead_conversion.value != '' && (isNaN(lead_conversion.value) === true || lead_conversion.value.length > 10 || lead_conversion.value < 0)) {
                lead_conversion.style.borderColor = '#F00';
                error = "Please type valid number of Lead Conversion.";
                errorMessageLeadConversion.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "date": date.value,
                    "calls": calls.value,
                    "follow_ups": follow_ups.value,
                    "good_responses": good_responses.value,
                    "bad_responses": bad_responses.value,
                    "bad_data": bad_data.value,
                    "no_answers": no_answers.value,
                    "voice_mails": voice_mails.value,
                    "emails_sent": emails_sent.value,
                    "lead_conversion": lead_conversion.value,
                    "user_right_title": '<?php echo $user_right_title; ?>',
                };
                $.ajax({
                    type: "POST", url: "ajax/daily_progress.php",
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

        function getAccounts(id, type) {
            if (id > 0) {
                loader(true);
                var postData = {"id": id, "type": type, "account_id": 0};
                $.ajax({
                    type: "POST", url: "ajax/common.php",
                    data: {'postData': postData, 'getAccounts': true},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code !== undefined && obj.code != '' && obj.code === 200 && obj.account_list !== undefined && obj.account_list != '' ) {
                                document.getElementById('account_id').innerHTML=obj.account_list;
                                loader(false);
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