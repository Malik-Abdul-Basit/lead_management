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
                                                    echo 'Edit ' . ucwords(str_replace("_", " ", $page));
                                                    $id = htmlentities($_GET['id']);
                                                    $Q = "SELECT * FROM sales_persons WHERE id='{$id}' AND company_id='{$global_company_id}' 
                                                    AND branch_id='{$global_branch_id}' AND deleted_at IS NULL";
                                                    $Qry = mysqli_query($db, $Q);
                                                    $Rows = mysqli_num_rows($Qry);
                                                    if ($Rows != 1) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    } else {
                                                        $Result = mysqli_fetch_object($Qry);
                                                        $first_name = html_entity_decode(stripslashes($Result->first_name));
                                                        $last_name = html_entity_decode(stripslashes($Result->last_name));
                                                        $email = html_entity_decode(stripslashes($Result->email));
                                                        $gender = html_entity_decode(stripslashes($Result->gender));
                                                        $status = html_entity_decode(stripslashes($Result->status));
                                                        $image = getSalesPersonImage($id)['image_path'];
                                                    }
                                                } else {
                                                    if (!hasRight($user_right_title, 'add')) {
                                                        header('Location: ' . $page_not_found_url);
                                                        exit();
                                                    }
                                                    echo 'Add ' . ucwords(str_replace("_", " ", $page));
                                                    $id = 0;
                                                    $first_name = $last_name = $email = '';
                                                    $gender = config('sales_persons.gender.value.male');
                                                    $status = config('sales_persons.status.value.activated');
                                                    $image = '';
                                                }
                                                ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" id="myFORM" name="myFORM" method="post"
                                              enctype="multipart/form-data">
                                            <input type="hidden" class="not-show" name="id" id="id" value="<?php echo $id; ?>"/>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="mb-2">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h3 class="font-size-lg text-dark-75 font-weight-bold">&nbsp;</h3>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="first_name">* First
                                                                                Name:</label>
                                                                            <input tabindex="10" maxlength="50"
                                                                                   id="first_name"
                                                                                   value="<?php echo $first_name; ?>" <?php echo $ApplyMaxLength . $onblur; ?>
                                                                                   placeholder="First Name"/>
                                                                            <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageFirstName"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="last_name"> Last Name:</label>
                                                                            <input tabindex="20" maxlength="50"
                                                                                   id="last_name"
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
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="email">* Email:</label>
                                                                            <input tabindex="30" id="email"
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
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="gender">* Gender:</label>
                                                                            <select tabindex="40"
                                                                                    id="gender" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                                <option selected="selected" value="">
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                foreach (config("sales_persons.gender.title") as $key => $value) {
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
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="status">* Status</label>
                                                                            <select tabindex="50"
                                                                                    id="status" <?php echo $ApplySelect2 . $onblur; ?>>
                                                                                <?php
                                                                                foreach (config('sales_persons.status.title') as $key => $val) {
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
                                                            <div class="col-md-4">
                                                                <div class="row">
                                                                    <div class="col-md-12 text-center mt-2">
                                                                        Minimum Image Size Should Be 400x400
                                                                    </div>
                                                                </div>
                                                                <div id="upload-demo"
                                                                     class="upload-employee-image-preview"></div>
                                                                <input type="file" id="select_file" accept="image/*">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="selectImage()"
                                                                class="btn btn-success font-weight-bold mr-2 float-left">
                                                            <?php echo config('lang.button.title.select_image'); ?>
                                                        </button>
                                                        <button type="button" onclick="saveFORM()"
                                                                class="btn btn-primary font-weight-bold mr-2 float-left">
                                                            <?php echo config('lang.button.title.save'); ?>
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
    <script src="<?php echo $base_url ?>assets/croppie_assets/js/croppie.js"></script>
    <script type="text/javascript">
        $uploadCrop = $('#upload-demo').croppie({
            url: '<?php echo $image; ?>',
            enableExif: true,
            viewport: {
                width: 350,
                height: 350,
                circle: false,
                type: 'canvas',
                //type: 'circle'
            },
            boundary: {
                width: 350,
                height: 350
            }
        });

        $('#select_file').on('change', function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function () {
                    //console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
        });

        function selectImage() {
            document.getElementById("select_file").click();
        }

        function saveFORM() {
            var A = '<?php echo hasRight($user_right_title, 'add') ?>';
            var E = '<?php echo hasRight($user_right_title, 'edit') ?>';

            var genderArray = [<?php echo '"' . implode('","', array_values(config('sales_persons.gender.value'))) . '"' ?>];
            var statusArray = [<?php echo '"' . implode('","', array_values(config('sales_persons.status.value'))) . '"' ?>];

            var id = document.getElementById('id');
            var first_name = document.getElementById('first_name');
            var last_name = document.getElementById('last_name');
            var email = document.getElementById('email');
            var gender = document.getElementById('gender');
            var select2_gender_container = document.querySelector("[aria-labelledby='select2-gender-container']");
            var status = document.getElementById('status');
            var select2_status_container = document.querySelector("[aria-labelledby='select2-status-container']");
            var select_file = document.getElementById("select_file");

            var errorMessageFirstName = document.getElementById('errorMessageFirstName');
            var errorMessageLastName = document.getElementById('errorMessageLastName');
            var errorMessageEmail = document.getElementById('errorMessageEmail');
            var errorMessageGender = document.getElementById('errorMessageGender');
            var errorMessageStatus = document.getElementById('errorMessageStatus');

            first_name.style.borderColor = last_name.style.borderColor = email.style.borderColor = '#E4E6EF';
            select2_gender_container.style.borderColor = select2_status_container.style.borderColor = '#E4E6EF';
            errorMessageFirstName.innerText = errorMessageLastName.innerText = errorMessageEmail.innerText = errorMessageGender.innerText = errorMessageStatus.innerText = "";

            var error = '';
            var toasterType = 'error';

            if (id.value == 0 && A == '') {
                toasterTrigger('warning', 'Sorry! You have no right to add record.');
            } else if (id.value > 0 && E == '') {
                toasterTrigger('warning', 'Sorry! You have no right to update record.');
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
            } else {

                var postData = {
                    "id": id.value,
                    "imageBase64" : '',
                    "first_name": first_name.value.trim(),
                    "last_name": last_name.value.trim(),
                    "email": email.value,
                    "gender": gender.value,
                    "status": status.value,
                    "user_right_title": '<?php echo $user_right_title; ?>',
                };

                if (select_file.value != '') {
                    $uploadCrop.croppie('result', {
                        type: 'canvas',
                        size: 'viewport'
                    }).then(function (imageBase64) {
                        postData.imageBase64 = imageBase64;
                        sendDataToDB(postData);
                    });
                } else {
                    sendDataToDB(postData);
                }

                function sendDataToDB(n){
                    loader(true);
                    $.ajax({
                        type: "POST", url: "ajax/sales_person.php",
                        data: {"postData": n},
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
                                    } else {
                                        loader(false);
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

        <?php
        if (isset($_GET['emp_code']) && is_numeric($_GET['emp_code']) && !empty($_GET['emp_code'])) {
            echo 'getEmployee(' . $_GET['emp_code'] . ')';
        }
        ?>

    </script>
<?php include_once("../includes/endTags.php"); ?>