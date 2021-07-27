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

                <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
                    <div class="subheader py-2 py-lg-4  subheader-solid " id="kt_subheader">
                        <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-2">
                                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"> Dashboard </h5>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-header pt-6">
                                            <div class="col-sm-9 my-2 my-md-0"></div>
                                            <div class="col-sm-3 my-2 my-md-0">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="BG_CurrentYear">Year</label>
                                                    <select class="form-control"
                                                            id="BG_CurrentYear"
                                                            onchange="callMonthlyLeadsData()">
                                                        <?php
                                                        for ($y = $starting_year; $y <= $current_year; $y++) {
                                                            $s = ($y == $current_year) ? 'selected="selected"' : '';
                                                            echo '<option value="' . $y . '" ' . $s . '>' . $y . '</option>';
                                                        }
                                                        //$months = array(1 => 'Jan.', 2 => 'Feb.', 3 => 'Mar.', 4 => 'Apr.', 5 => 'May', 6 => 'Jun.', 7 => 'Jul.', 8 => 'Aug.', 9 => 'Sep.', 10 => 'Oct.', 11 => 'Nov.', 12 => 'Dec.');
                                                        //$transposed = array_slice($months, date('n'), 12, true) + array_slice($months, 0, date('n'), true);
                                                        //$last8 = array_reverse(array_slice($transposed, -8, 12, true), true);
                                                        /*foreach ($months as $num => $name) {
                                                            printf('<option value="%u">%s</option>', $num, $name);
                                                        }*/
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column px-2 py-4">
                                            <div class="row" id="firstChartRow">
                                                <div class="col-md-12">
                                                    12 Column
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--begin::Footer Statement-->
                <?php include_once("../includes/footer_statement.php"); ?>
                <!--end::Footer Statement-->
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
    <script type="text/javascript">


    </script>

<?php include_once("../includes/endTags.php"); ?>