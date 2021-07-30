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
                                                    $Q = "SELECT * FROM `campaigns` WHERE `id`='{$id}' AND `type`='{$type}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $date = html_entity_decode(stripslashes(date('d-m-Y', strtotime($Result->date))));
                                                        $source_id = html_entity_decode(stripslashes($Result->source_id));
                                                        $account_id = html_entity_decode(stripslashes($Result->account_id));
                                                        $campaign_type_id = html_entity_decode(stripslashes($Result->campaign_type_id));
                                                        $reach = html_entity_decode(stripslashes($Result->reach));
                                                        $good_responses = html_entity_decode(stripslashes($Result->good_responses));
                                                        $bad_responses = html_entity_decode(stripslashes($Result->bad_responses));
                                                        $follow_ups = html_entity_decode(stripslashes($Result->follow_ups));
                                                        $not_responses = html_entity_decode(stripslashes($Result->not_responses));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;
                                                    $id = $source_id = $account_id = $campaign_type_id = $reach = $good_responses = $bad_responses = $follow_ups = $not_responses = 0;
                                                    $name = '';
                                                    $date = date('d-m-Y');
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id"
                                                   value="<?php echo $id; ?>"/>
                                            <input type="hidden" class="not-show" name="type" id="type"
                                                   value="<?php echo $type; ?>"/>
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
                                                                    <label for="campaign_type_id">* Campaign
                                                                        Type:</label>
                                                                    <select tabindex="30"
                                                                            id="campaign_type_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                        <option selected="selected" value="0">
                                                                            Select
                                                                        </option>
                                                                        <?php
                                                                        $select = "SELECT `id`,`name` FROM `campaign_types` WHERE `type`='{$type}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                $selected = '';
                                                                                if ($campaign_type_id == $result->id) {
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
                                                                              id="errorMessageCampaignType"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="source_id">* Source:</label>
                                                                    <select onchange="getAccounts(this.value,'<?php echo $type; ?>')"
                                                                            tabindex="40"
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
                                                                    <label for="account_id">* Account:</label>
                                                                    <select tabindex="50"
                                                                            id="account_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                        <?php
                                                                        if (!empty($source_id)) {
                                                                            echo getAccounts($source_id, $type, $account_id);
                                                                        } else {
                                                                            echo '<option selected="selected" value="0">Select
                                                                        </option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageAccount"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="reach">* Contacts:</label>
                                                                    <input tabindex="60" maxlength="9"
                                                                           id="reach"
                                                                           value="<?php echo $reach; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly . $onblur; ?>
                                                                           placeholder="Contacts"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageContact"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="good_responses">Good Responses:</label>
                                                                    <input tabindex="70" maxlength="9"
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
                                                                    <input tabindex="80" maxlength="9"
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
                                                                    <label for="follow_ups">Follow Ups:</label>
                                                                    <input tabindex="90" maxlength="9"
                                                                           id="follow_ups"
                                                                           value="<?php echo $follow_ups; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Follow Ups"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFollowUps"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="not_responses">Not Responses:</label>
                                                                    <input tabindex="100" maxlength="9"
                                                                           id="not_responses"
                                                                           value="<?php echo $not_responses; ?>" <?php echo $ApplyMaxLengthTouchSpinAndNumberOnly; ?>
                                                                           placeholder="Not Responses"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageNotResponses"></span>
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

            var typeArray = [<?php echo '"' . implode('","', array_values(config('campaigns.type.value'))) . '"' ?>];

            var id = document.getElementById('id');
            var date = document.getElementById('date');
            var name = document.getElementById('name');
            var campaign_type_id = document.getElementById('campaign_type_id');
            var select2_campaign_type_id_container = document.querySelector("[aria-labelledby='select2-campaign_type_id-container']");
            var source_id = document.getElementById('source_id');
            var select2_source_id_container = document.querySelector("[aria-labelledby='select2-source_id-container']");
            var account_id = document.getElementById('account_id');
            var select2_account_id_container = document.querySelector("[aria-labelledby='select2-account_id-container']");
            var reach = document.getElementById('reach');
            var good_responses = document.getElementById('good_responses');
            var bad_responses = document.getElementById('bad_responses');
            var follow_ups = document.getElementById('follow_ups');
            var not_responses = document.getElementById('not_responses');
            var type = document.getElementById('type');

            var errorMessageDate = document.getElementById('errorMessageDate');
            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageCampaignType = document.getElementById('errorMessageCampaignType');
            var errorMessageSource = document.getElementById('errorMessageSource');
            var errorMessageAccount = document.getElementById('errorMessageAccount');
            var errorMessageContact = document.getElementById('errorMessageContact');
            var errorMessageGoodResponses = document.getElementById('errorMessageGoodResponses');
            var errorMessageBadResponses = document.getElementById('errorMessageBadResponses');
            var errorMessageFollowUps = document.getElementById('errorMessageFollowUps');
            var errorMessageNotResponses = document.getElementById('errorMessageNotResponses');

            date.style.borderColor = name.style.borderColor = select2_campaign_type_id_container.style.borderColor = select2_source_id_container.style.borderColor = select2_account_id_container.style.borderColor = '#E4E6EF';
            reach.style.borderColor = good_responses.style.borderColor = bad_responses.style.borderColor = follow_ups.style.borderColor = not_responses.style.borderColor = '#E4E6EF';
            errorMessageDate.innerText = errorMessageName.innerText = errorMessageCampaignType.innerText = errorMessageSource.innerText = errorMessageAccount.innerText = "";
            errorMessageContact.innerText = errorMessageGoodResponses.innerText = errorMessageBadResponses.innerText = errorMessageFollowUps.innerText = errorMessageNotResponses.innerText = "";

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
            } else if (campaign_type_id.value == '') {
                select2_campaign_type_id_container.style.borderColor = '#F00';
                error = "Campaign Type field is required.";
                errorMessageCampaignType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(campaign_type_id.value) === true || campaign_type_id.value.length > 10 || campaign_type_id.value <= 0) {
                select2_campaign_type_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageCampaignType.innerText = error;
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
            } else if (account_id.value == '') {
                select2_account_id_container.style.borderColor = '#F00';
                error = "Account field is required.";
                errorMessageAccount.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(account_id.value) === true || account_id.value.length > 10 || account_id.value <= 0) {
                select2_account_id_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageAccount.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (reach.value == '') {
                reach.style.borderColor = '#F00';
                error = "Contacts field is required.";
                errorMessageContact.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(reach.value) === true || reach.value.length > 10 || reach.value <= 0) {
                reach.style.borderColor = '#F00';
                error = "Please type a valid number of Contacts.";
                errorMessageContact.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (good_responses.value != '' && (isNaN(good_responses.value) === true || good_responses.value.length > 10 || good_responses.value < 0)) {
                good_responses.style.borderColor = '#F00';
                error = "Please type valid number of Good Responses.";
                errorMessageGoodResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (bad_responses.value != '' && (isNaN(bad_responses.value) === true || bad_responses.value.length > 10 || bad_responses.value < 0)) {
                good_responses.style.borderColor = '#F00';
                error = "Please type valid number of Bad Responses.";
                errorMessageBadResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (follow_ups.value != '' && (isNaN(follow_ups.value) === true || follow_ups.value.length > 10 || follow_ups.value < 0)) {
                follow_ups.style.borderColor = '#F00';
                error = "Please type valid number of Follow Ups.";
                errorMessageFollowUps.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (not_responses.value != '' && (isNaN(not_responses.value) === true || not_responses.value.length > 10 || not_responses.value < 0)) {
                not_responses.style.borderColor = '#F00';
                error = "Please type valid number of Not Responses.";
                errorMessageNotResponses.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (type.value == '' || typeArray.includes(type.value) == false) {
                toasterTrigger(toasterType, 'Sorry! some unexpected error.');
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "date": date.value,
                    "name": name.value,
                    "campaign_type_id": campaign_type_id.value,
                    "source_id": source_id.value,
                    "account_id": account_id.value,
                    "reach": reach.value,
                    "good_responses": good_responses.value,
                    "bad_responses": bad_responses.value,
                    "follow_ups": follow_ups.value,
                    "not_responses": not_responses.value,
                    "type": type.value,
                    "user_right_title": '<?php echo $user_right_title; ?>',
                };
                $.ajax({
                    type: "POST", url: "ajax/campaign.php",
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
                                            document.getElementById('account_id').innerHTML = '<option selected="selected" value="0">Select</option>';

                                            var campaign_type_id_container = document.getElementById("select2-campaign_type_id-container");
                                            if (campaign_type_id_container) {
                                                campaign_type_id_container.removeAttribute("title");
                                                campaign_type_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                campaign_type_id.value = '0';
                                            }
                                            var source_id_container = document.getElementById("select2-source_id-container");
                                            if (source_id_container) {
                                                source_id_container.removeAttribute("title");
                                                source_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                source_id.value = '0';
                                            }
                                            var account_id_container = document.getElementById("select2-account_id-container");
                                            if (account_id_container) {
                                                account_id_container.removeAttribute("title");
                                                account_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                account_id.value = '0';
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