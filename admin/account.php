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
                                                $type = config('lang.page_type.title.'.$page);
                                                if (isset($_GET['id'])) {
                                                    if (!hasRight($user_right_title, 'edit')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM `accounts` WHERE `id`='{$id}' AND `type`='{$type}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $name = html_entity_decode(stripslashes($Result->name));
                                                        $source_id = html_entity_decode(stripslashes($Result->source_id));
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = $source_id = 0;
                                                    $name = '';
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <input type="hidden" class="not-show" name="type" id="type" value="<?php echo $type; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="name">* Name:</label>
                                                                            <input tabindex="10" maxlength="50"
                                                                                   id="name"
                                                                                   value="<?php echo $name; ?>" <?php echo $ApplyMaxLength . $onblur; ?>
                                                                                   placeholder="Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="source_id">* Source:</label>
                                                                            <select tabindex="20"
                                                                                    id="source_id" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                                <option selected="selected" value="">
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

            var typeArray = [<?php echo '"' . implode('","', array_values(config('accounts.type.value'))) . '"' ?>];

            var id = document.getElementById('id');
            var name = document.getElementById('name');
            var source_id = document.getElementById('source_id');
            var select2_source_id_container = document.querySelector("[aria-labelledby='select2-source_id-container']");
            var type = document.getElementById('type');

            var errorMessageName = document.getElementById('errorMessageName');
            var errorMessageSource = document.getElementById('errorMessageSource');

            name.style.borderColor = select2_source_id_container.style.borderColor = '#E4E6EF';
            errorMessageName.innerText = errorMessageSource.innerText = "";

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
            } else if (type.value == '' || typeArray.includes(type.value) == false) {
                toasterTrigger(toasterType, 'Sorry! some unexpected error.');
                return false;
            } else {
                loader(true);
                var postData = {
                    "id": id.value,
                    "name": name.value,
                    "source_id": source_id.value,
                    "type": type.value,
                    "user_right_title": '<?php echo $user_right_title; ?>'
                };
                $.ajax({
                    type: "POST", url: "ajax/account.php",
                    data: {'postData': postData},
                    success: function (resPonse) {
                        if (resPonse !== undefined && resPonse != '') {
                            var obj = JSON.parse(resPonse);
                            if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                if (obj.code === 422) {
                                    if (obj.errorField !== undefined && obj.errorField != '' && obj.errorDiv !== undefined && obj.errorDiv != '' && obj.errorMessage !== undefined && obj.errorMessage != '') {
                                        if (obj.errorField == 'source_id') {
                                            select2_source_id_container.style.borderColor = '#F00';
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
                                            var source_id_container = document.getElementById("select2-source_id-container");

                                            if (source_id_container) {
                                                source_id_container.removeAttribute("title");
                                                source_id_container.innerHTML = '<span class="select2-selection__placeholder">Select</span>';
                                                source_id.value = 0;
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