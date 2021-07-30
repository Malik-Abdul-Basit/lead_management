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

                                <div class="col-md-4">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-body progress-card d-flex flex-column pt-8 pr-5 pb-5 pl-5">
                                            <div class="line">
                                                <h2 class="bd-heading"> Business Development </h2>
                                            </div>
                                            <div class="line mt-6">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="bd_progress" class="PieChartWrapper">
                                                            <span class="percent"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Calls</p>
                                                        <h1>267</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1>21</h1>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-body progress-card d-flex flex-column pt-8 pr-5 pb-5 pl-5">
                                            <div class="line">
                                                <h2 class="seo-heading"> Search Engine Optimization </h2>
                                            </div>
                                            <div class="line mt-6">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="seo_progress" class="PieChartWrapper">
                                                            <span class="percent"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>Submissions</p>
                                                        <h1>267</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1>21</h1>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-body progress-card d-flex flex-column pt-8 pr-5 pb-5 pl-5">
                                            <div class="line">
                                                <h2 class="smm-heading"> Social Media Marketing </h2>
                                            </div>
                                            <div class="line mt-6">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="smm_progress" class="PieChartWrapper">
                                                            <span class="percent"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Reached</p>
                                                        <h1>267</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1>21</h1>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-body progress-card d-flex flex-column pt-8 pr-5 pb-5 pl-5">
                                            <div class="line">
                                                <h2 class="em-heading"> Email Marketing </h2>
                                            </div>
                                            <div class="line mt-6">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="em_progress" class="PieChartWrapper">
                                                            <span class="percent"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Reached</p>
                                                        <h1>267</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1>21</h1>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-custom card-stretch gutter-b">
                                        <div class="card-body progress-card d-flex flex-column pt-8 pr-5 pb-5 pl-5">
                                            <div class="line">
                                                <h2> Medcare MSO </h2>
                                            </div>
                                            <div class="line mt-6">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div id="medcare_progress" class="PieChartWrapper">
                                                            <span class="percent"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Reached</p>
                                                        <h1>267</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1>21</h1>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-row mb-3">

                                <div class="col-md-6 Card-Stretch-Wrapper BD-Overview-Wrapper">
                                    <h1>Business Development</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-3">
                                            <h2>card-body</h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 Card-Stretch-Wrapper SEO-Overview-Wrapper">
                                    <h1>Search Engine Optimization</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-3">
                                            <h2>card-body</h2>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-row mb-3">

                                <div class="col-md-6 Card-Stretch-Wrapper SMM-Overview-Wrapper">
                                    <h1>Social Media Marketing</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">
                                            <h2>card-body</h2>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 Card-Stretch-Wrapper EM-Overview-Wrapper">
                                    <h1>Email Marketing</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">
                                            <h2>card-body</h2>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-row mb-3">

                                <div class="col-md-6 Card-Stretch-Wrapper MSO-Overview-Wrapper">
                                    <h1>Medcare MSO</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">
                                            <h2>card-body</h2>
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

        getAllPageData();

        function getAllPageData(){
            getStatistics();
        }

        function getStatistics(){
            loader(true);
            setStatistics();
        }

        function setStatistics(){
            var easing = 'easeOutElastic';
            var delay = 300;
            var scaleColor = false;
            var scaleLength = 5;
            var trackWidth = 10;
            var lineWidth = 14;
            var lineCap = 'butt' /*'round'*/;
            var size = 95;
            var rotate = 0;
            var animate = {
                duration: 1000,
                enabled: true
            };

            document.addEventListener('DOMContentLoaded', function() {

                var element = document.getElementById('bd_progress');
                var rate = "46.22"
                element.setAttribute('data-percent', rate);
                window.chart = new EasyPieChart(element, {
                    barColor: '#0155e6',
                    trackColor: '#97c6ff',
                    easing: easing,
                    delay: delay,
                    scaleColor: scaleColor,
                    scaleLength: scaleLength,
                    trackWidth: trackWidth,
                    lineWidth: lineWidth,
                    lineCap: lineCap,
                    size: size,
                    rotate: rotate,
                    animate: animate,
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = rate;
                    }
                });

                var element = document.getElementById('seo_progress');
                rate = "59.05"
                element.setAttribute('data-percent', rate);
                window.chart = new EasyPieChart(element, {
                    barColor: '#04cbfe',
                    trackColor: '#a4f2ff',
                    easing: easing,
                    delay: delay,
                    scaleColor: scaleColor,
                    scaleLength: scaleLength,
                    trackWidth: trackWidth,
                    lineWidth: lineWidth,
                    lineCap: lineCap,
                    size: size,
                    rotate: rotate,
                    animate: animate,
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = rate;
                    }
                });

                var element = document.getElementById('smm_progress');
                var rate = "12.95"
                element.setAttribute('data-percent', rate);
                window.chart = new EasyPieChart(element, {
                    barColor: '#47c997',
                    trackColor: '#9bf9d1',
                    easing: easing,
                    delay: delay,
                    scaleColor: scaleColor,
                    scaleLength: scaleLength,
                    trackWidth: trackWidth,
                    lineWidth: lineWidth,
                    lineCap: lineCap,
                    size: size,
                    rotate: rotate,
                    animate: animate,
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = rate;
                    }
                });

                var element = document.getElementById('em_progress');
                var rate = "46.45"
                element.setAttribute('data-percent', rate);
                window.chart = new EasyPieChart(element, {
                    barColor: '#0078ba',
                    trackColor: '#5fd6ff',
                    easing: easing,
                    delay: delay,
                    scaleColor: scaleColor,
                    scaleLength: scaleLength,
                    trackWidth: trackWidth,
                    lineWidth: lineWidth,
                    lineCap: lineCap,
                    size: size,
                    rotate: rotate,
                    animate: animate,
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = rate;
                    }
                });

                var element = document.getElementById('medcare_progress');
                var rate = "65.83"
                element.setAttribute('data-percent', rate);
                window.chart = new EasyPieChart(element, {
                    barColor: '#8bc443',
                    trackColor: '#c1ed7c',
                    easing: easing,
                    delay: delay,
                    scaleColor: scaleColor,
                    scaleLength: scaleLength,
                    trackWidth: trackWidth,
                    lineWidth: lineWidth,
                    lineCap: lineCap,
                    size: size,
                    rotate: rotate,
                    animate: animate,
                    onStep: function(from, to, percent) {
                        this.el.children[0].innerHTML = rate;
                    }
                });
            });

            loader(false);
        }

    </script>

<?php include_once("../includes/endTags.php"); ?>