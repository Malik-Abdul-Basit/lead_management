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
                                                <?php echo ucwords(str_replace("_", " ", $page)); ?>
                                            </h3>
                                        </div>
                                        <!--begin::Form-->
                                        <form class="form" style="overflow:visible" id="myFORM" name="myFORM"
                                              method="post"
                                              enctype="multipart/form-data">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div class="row">
                                                            <?php
                                                            $date_from = $date_to = date('d-m-Y');
                                                            ?>

                                                            <!-- Date From -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="date_from">
                                                                        * Date :
                                                                        <small> (From) (dd-MM-yyyy)</small>
                                                                    </label>
                                                                    <input tabindex="10" <?php echo $DateInput; ?>
                                                                           id="date_from"
                                                                           placeholder="Date From"
                                                                           value="<?php echo $date_from; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close"
                                                                          role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDateFrom"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Date To -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="date_to">
                                                                        * Date:
                                                                        <small> (To) (dd-MM-yyyy)</small>
                                                                    </label>
                                                                    <input tabindex="20" <?php echo $DateInput; ?>
                                                                           id="date_to" placeholder="Date To"
                                                                           value="<?php echo $date_to; ?>">
                                                                    <span class="e-clear-icon e-clear-icon-hide"
                                                                          aria-label="close"
                                                                          role="button"></span>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageDateTo"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Person -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="user_ids"> * Person:</label>
                                                                    <select <?php echo $onblur; ?>
                                                                            tabindex="30"
                                                                            class="form-control selectpicker"
                                                                            multiple data-actions-box="true"
                                                                            id="user_ids">
                                                                        <?php
                                                                        $select = "SELECT u.id, CONCAT(u.first_name,' ',u.last_name,' (',u.employee_code,')') AS name FROM users AS u INNER JOIN daily_progress_details AS l ON u.id=l.user_id WHERE u.company_id='{$global_company_id}' AND u.branch_id='{$global_branch_id}' AND u.deleted_at IS NULL AND l.company_id='{$global_company_id}' AND l.branch_id='{$global_branch_id}' AND l.deleted_at IS NULL GROUP BY u.id ORDER BY u.employee_code ASC";
                                                                        $query = mysqli_query($db, $select);
                                                                        if (mysqli_num_rows($query) > 0) {
                                                                            while ($result = mysqli_fetch_object($query)) {
                                                                                echo '<option value="' . $result->id . '">' . $result->name . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageUserIds"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Report Type -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="report_type"> * Report
                                                                        Type:</label>
                                                                    <select class="form-control"
                                                                            id="report_type" tabindex="40">
                                                                        <?php
                                                                        foreach (config('daily_progress_details.type.title') as $key => $val) {
                                                                            $selected = config('daily_progress_details.type.value.day_by_day') == $key ? ' selected="selected" ' : '';
                                                                            echo '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                    <div class="error_wrapper">
                                                                        <span class="text-danger"
                                                                              id="errorMessageReportType"></span>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <button type="button" onclick="getReport()"
                                                                class="btn btn-primary font-weight-bold mr-2 float-right"><?php echo config('lang.button.title.get_report'); ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer pt-9 pr-5 pb-5 pl-5">
                                                <div class="row">
                                                    <div class="col-lg-12" id="resultBody">

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

        function getReport() {

            var resultBody = document.getElementById('resultBody');
            resultBody.innerHTML='';

            var R = '<?php echo hasRight($user_right_title, 'reports') ?>';
            var typeArray = [<?php echo '"' . implode('","', array_values(config('daily_progress_details.type.value'))) . '"' ?>];

            var date_from = document.getElementById('date_from');
            var date_to = document.getElementById('date_to');
            var user_ids = document.getElementById('user_ids')
            var users = $('#user_ids').val();
            var report_type = document.getElementById('report_type');

            var errorMessageDateFrom = document.getElementById('errorMessageDateFrom');
            var errorMessageDateTo = document.getElementById('errorMessageDateTo');
            var errorMessageUserIds = document.getElementById('errorMessageUserIds');
            var errorMessageReportType = document.getElementById('errorMessageReportType');

            date_from.style.borderColor = date_to.style.borderColor = user_ids.style.borderColor = report_type.style.borderColor = '#E4E6EF';
            errorMessageDateFrom.innerText = errorMessageDateTo.innerText = errorMessageUserIds.innerText = errorMessageReportType.innerText = '';

            var error = '';
            var toasterType = 'error';

            if (R == '') {
                toasterTrigger(toasterType, 'Sorry! You have no right to view reports.');
                return false;
            } else if (date_from.value == '') {
                date_from.style.borderColor = '#F00';
                error = "Date (From) field is required.";
                errorMessageDateFrom.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidDate(date_from.value) || date_from.value.length !== 10) {
                date_from.style.borderColor = '#F00';
                error = "Please select a valid date.";
                errorMessageDateFrom.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (date_to.value == '') {
                date_to.style.borderColor = '#F00';
                error = "Date (To) field is required.";
                errorMessageDateTo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (invalidDate(date_to.value) || date_to.value.length !== 10) {
                date_to.style.borderColor = '#F00';
                error = "Please select a valid date.";
                errorMessageDateTo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (date_to.value < date_from.value) {
                date_to.style.borderColor = '#F00';
                error = 'Date (To) should be greater than Date (From)';
                errorMessageDateTo.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (users == '') {
                user_ids.style.borderColor = '#F00';
                error = "Person field is required.";
                errorMessageUserIds.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (report_type.value == '') {
                report_type.style.borderColor = '#F00';
                error = "Report Type field is required.";
                errorMessageReportType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (isNaN(report_type.value) === true || report_type.value < 1) {
                report_type.style.borderColor = '#F00';
                error = "Please select a valid option of Report Type.";
                errorMessageReportType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else if (typeArray.includes(report_type.value) == false || report_type.value.length !== 1) {
                report_type.style.borderColor = '#F00';
                error = "Please select a valid option.";
                errorMessageReportType.innerText = error;
                toasterTrigger(toasterType, error);
                return false;
            } else {
                var continueProcessing = true;
                if (continueProcessing === true) {
                    var postData = {
                        "date_from": date_from.value,
                        "date_to": date_to.value,
                        "users": users,
                        "report_type": report_type.value,
                        "user_right_title": '<?php echo $user_right_title; ?>'
                    };
                    loader(true);
                    $.ajax({
                        type: "POST", url: "ajax/fetch/daily_progress_reports.php",
                        data: {"postData": postData},
                        success: function (resPonse) {
                            if (resPonse !== undefined && resPonse !== '' && resPonse !== null) {
                                var obj = JSON.parse(resPonse);
                                if (obj.code === 200 && obj.html !== undefined && obj.html !== '' && obj.html !== null) {
                                    resultBody.innerHTML=obj.html;
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
        }

    </script>
<?php include_once("../includes/endTags.php"); ?>