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
                    <?php //include_once('../includes/bread_crumb.php'); ?>
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
                                                    $Q = "SELECT * FROM `companies` WHERE `id`='{$id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . $pageHeading;
                                                    $id = 0;
                                                    $name = '';
                                                    $status = '-1';
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="alert alert-custom alert-light-success overflow-hidden"
                                                     role="alert" id="responseMessageWrapper">
                                                    <div class="alert-text font-weight-bold float-left"
                                                         id="responseMessage"></div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-6">

                                                                <div class="form-group">
                                                                    <label for="name">* Name:</label>
                                                                    <input maxlength="50" id="name"
                                                                           value="<?php echo $name; ?>" <?php echo $TAttrs . $onblur; ?>
                                                                           placeholder="Name"/>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageName"></span>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="status">* Company Status:</label>
                                                                    <select id="status" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                        <option selected="selected" value="">Select
                                                                        </option>
                                                                        <?php
                                                                        foreach (config('companies.status.title') as $key => $value) {
                                                                            $selected = '';
                                                                            if ($status == $key) {
                                                                                $selected = 'selected="selected"';
                                                                            }
                                                                            ?>
                                                                            <option <?php echo $selected; ?>
                                                                                    value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                                            <?php
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

            var statusArray = [<?php echo '"'.implode('","', array_values(config('companies.status.value'))).'"' ?>];

            var id = document.getElementById('id');
            var name = document.getElementById('name');
            var status = document.getElementById('status');
            var select2_status_container = document.querySelector("[aria-labelledby='select2-status-container']");

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageStatus = document.getElementById('errorMessageStatus');
            var responseMessageWrapper = document.getElementById('responseMessageWrapper');
            var responseMessage = document.getElementById('responseMessage');

            name.style.borderColor = select2_status_container.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageStatus.innerText = responseMessage.innerText = "";
            responseMessageWrapper.style.display = "none";

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
            } else if (status.value == '') {
                select2_status_container.style.borderColor = '#F00';
                error = "Status field is required.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (statusArray.includes(status.value) == false || status.value.length > 2) {
                select2_status_container.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageStatus.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value.trim(),
                    "status": status.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/company.php",
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
                                    loader(false);
                                    if (obj.responseMessage !== undefined && obj.responseMessage != '') {
                                        if (obj.form_reset !== undefined && obj.form_reset) {
                                            document.getElementById("myFORM").reset();
                                            var status_container = document.getElementById("select2-status-container");
                                            if (status_container) {
                                                status_container.removeAttribute("title");
                                                status_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                status.value = '';
                                            }
                                        }
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
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