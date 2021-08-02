<?php
include_once("header/check_login.php");
include_once("../includes/head.php");
include_once("../includes/mobile_menu.php");
$duration_array = config('dashboard.duration.title');
$duration_one_month = config('dashboard.duration.value.one_month');

$date = new DateTime();
$today = $current_date = $date->format("Y-m-d");
$interval = new DateInterval('P1D');
$date->sub($interval);
$prev_day = $date->format("Y-m-d");

$date = new DateTime();
$interval = new DateInterval('P7D');
$date->sub($interval);
$prev_week = $date->format("Y-m-d");

$date = new DateTime();
$interval = new DateInterval('P1M');
$date->sub($interval);
//$subtract_one_month = $date->format("Y-m-d");
//$date = new DateTime($subtract_one_month);
//$date->sub(new DateInterval('P1D'));
$prev_month = $date->format("Y-m-d");


$date = new DateTime();
$interval = new DateInterval('P1Y');
$date->sub($interval);
//$subtract_one_year = $date->format("Y-m-d");
//$date = new DateTime($subtract_one_year);
//$date->sub(new DateInterval('P1D'));
$prev_year = $date->format("Y-m-d");

$duration_value_array = [
        '1d' => [
                'from' => $prev_day,
                'to' => $prev_day,
        ],
        '1w' => [
            'from' => $prev_week,
            'to' => $prev_day,
        ],
        '1m' => [
            'from' => $prev_month,
            'to' => $prev_day,
        ],
        '1y' => [
            'from' => $prev_year,
            'to' => $prev_day,
        ],
];

/*echo '<pre>';
print_r($duration_value_array);
echo '</pre>';
exit();*/

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
                                                        <h1 id="bd_reach">0</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1 id="bd_lead">0</h1>
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
                                                        <h1 id="smm_reach">0</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1 id="smm_lead">0</h1>
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
                                                        <h1 id="em_reach">0</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1 id="em_lead">0</h1>
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
                                                        <h1 id="seo_reach">0</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1 id="seo_lead">0</h1>
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
                                                        <h1 id="medcare_reach">0</h1>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <p>No Of Leads</p>
                                                        <h1 id="medcare_lead">0</h1>
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
                                            <div class="duration_buttons_wrapper">
                                                <ul>
                                                    <?php
                                                    foreach ($duration_array as $duration_key => $duration_value){
                                                        $classes = ($duration_key == $duration_one_month) ? ' class="active BD_duration_button" ' : ' class="BD_duration_button" ';
                                                        ?>
                                                            <li>
                                                                <button data-from="<?php echo $duration_value_array[$duration_key]['from']; ?>"
                                                                        data-to="<?php echo $duration_value_array[$duration_key]['to']; ?>"
                                                                        data-value="<?php echo $duration_key; ?>"
                                                                        title="<?php echo $duration_value; ?>" <?php echo $classes; ?>
                                                                        onclick="callForBDData(this)"
                                                                >
                                                                    <?php echo strtoupper($duration_key); ?>
                                                                </button>
                                                            </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="Chart_Wrapper" id="BD_Chart_Wrapper"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 Card-Stretch-Wrapper SMM-Overview-Wrapper">
                                    <h1>Social Media Marketing</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">
                                            <div class="duration_buttons_wrapper">
                                                <ul>
                                                    <?php
                                                    foreach ($duration_array as $duration_key => $duration_value){
                                                        $classes = ($duration_key == $duration_one_month) ? ' class="active SMM_duration_button" ' : ' class="SMM_duration_button" ';
                                                        ?>
                                                        <li>
                                                            <button data-from="<?php echo $duration_value_array[$duration_key]['from']; ?>" data-to="<?php echo $duration_value_array[$duration_key]['to']; ?>" data-value="<?php echo $duration_key; ?>" title="<?php echo $duration_value; ?>" <?php echo $classes; ?>>
                                                                <?php echo strtoupper($duration_key); ?>
                                                            </button>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="Chart_Wrapper" id="SMM_Chart_Wrapper"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-row mb-3">

                                <div class="col-md-6 Card-Stretch-Wrapper EM-Overview-Wrapper">
                                    <h1>Email Marketing</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">
                                            <div class="duration_buttons_wrapper">
                                                <ul>
                                                    <?php
                                                    foreach ($duration_array as $duration_key => $duration_value){
                                                        $classes = ($duration_key == $duration_one_month) ? ' class="active EM_duration_button" ' : ' class="EM_duration_button" ';
                                                        ?>
                                                        <li>
                                                            <button data-from="<?php echo $duration_value_array[$duration_key]['from']; ?>" data-to="<?php echo $duration_value_array[$duration_key]['to']; ?>" data-value="<?php echo $duration_key; ?>" title="<?php echo $duration_value; ?>" <?php echo $classes; ?>>
                                                                <?php echo strtoupper($duration_key); ?>
                                                            </button>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="Chart_Wrapper" id="EM_Chart_Wrapper"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 Card-Stretch-Wrapper SEO-Overview-Wrapper">
                                    <h1>Search Engine Optimization</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-3">
                                            <div class="duration_buttons_wrapper">
                                                <ul>
                                                    <?php
                                                    foreach ($duration_array as $duration_key => $duration_value){
                                                        $classes = ($duration_key == $duration_one_month) ? ' class="active SEO_duration_button" ' : ' class="SEO_duration_button" ';
                                                        ?>
                                                        <li>
                                                            <button data-from="<?php echo $duration_value_array[$duration_key]['from']; ?>" data-to="<?php echo $duration_value_array[$duration_key]['to']; ?>" data-value="<?php echo $duration_key; ?>" title="<?php echo $duration_value; ?>" <?php echo $classes; ?>>
                                                                <?php echo strtoupper($duration_key); ?>
                                                            </button>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                            <div class="Chart_Wrapper" id="SEO_Chart_Wrapper"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--<div class="d-flex flex-row mb-3">

                                <div class="col-md-6 Card-Stretch-Wrapper MSO-Overview-Wrapper">
                                    <h1>Medcare MSO</h1>
                                    <div class="card card-custom card-stretch">
                                        <div class="card-body px-5">

                                        </div>
                                    </div>
                                </div>

                            </div>-->





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
            var BG_CurrentDate = '<?php echo $today;?>';
            var BG_PreviousDay = '<?php echo $prev_day;?>';
            var BG_PreviousMonth = '<?php echo $prev_month;?>';
            var BG_PreviousYear = '<?php echo $prev_year;?>';

            var filter = {
                'CurrentDate': BG_CurrentDate,
                'PreviousDay': BG_PreviousDay,
                'PreviousMonth': BG_PreviousMonth,
                'PreviousYear': BG_PreviousYear,
            };
            getStatistics(filter);
        }

        function getStatistics(filter){
            loader(true);
            $.ajax({
                type: "POST", url: "ajax/dashboard.php",
                data: {'getStatistics': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var response = JSON.parse(resPonse);
                        if (response.code === 200) {
                            setStatistics(response.data);
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

        function setStatistics(data){

            var easing = 'easeOutElastic';
            var delay = 300;
            var scaleColor = false;
            var scaleLength = 5;
            var trackWidth = 10;
            var lineWidth = 14;
            var lineCap = 'butt'; /*'round'*/
            var size = 95;
            var rotate = 0;
            var animate = {
                duration: 1000,
                enabled: true
            };

            document.getElementById('bd_reach').innerText = data.bd_reach;
            document.getElementById('bd_lead').innerText = data.bd_leads;
            var element = document.getElementById('bd_progress');
            element.setAttribute('data-percent', data.bd_rate);
            new EasyPieChart(element, {
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
                    this.el.children[0].innerHTML = data.bd_rate;
                }
            });

            document.getElementById('smm_reach').innerText = data.smm_reach;
            document.getElementById('smm_lead').innerText = data.smm_leads;
            var element = document.getElementById('smm_progress');
            element.setAttribute('data-percent', data.smm_rate);
            new EasyPieChart(element, {
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
                    this.el.children[0].innerHTML = data.smm_rate;
                }
            });

            document.getElementById('em_reach').innerText = data.em_reach;
            document.getElementById('em_lead').innerText = data.em_leads;
            var element = document.getElementById('em_progress');
            element.setAttribute('data-percent', data.em_rate);
            new EasyPieChart(element, {
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
                    this.el.children[0].innerHTML = data.em_rate;
                }
            });

            document.getElementById('seo_reach').innerText = data.seo_reach;
            document.getElementById('seo_lead').innerText = data.seo_leads;
            var element = document.getElementById('seo_progress');
            element.setAttribute('data-percent', data.seo_rate);
            new EasyPieChart(element, {
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
                    this.el.children[0].innerHTML = data.seo_rate;
                }
            });

            document.getElementById('medcare_reach').innerText = data.total_reach;
            document.getElementById('medcare_lead').innerText = data.total_leads;
            var element = document.getElementById('medcare_progress');
            element.setAttribute('data-percent', data.total_rate);
            new EasyPieChart(element, {
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
                    this.el.children[0].innerHTML = data.total_rate;
                }
            });

            loader(false);
        }

        function callForBDData(e){
            removeAllClasses(e);
        }

        Highcharts.chart('BD_Chart_Wrapper', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Business Development Chart'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun',
                    'Jul',
                    'Aug',
                    'Sep',
                    'Oct',
                    'Nov',
                    'Dec'
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Calls',
                data: [49, 71, 106, 129, 144, 176, 135, 148, 216, 194, 95, 54]

            }, {
                name: 'Good Responses',
                data: [83, 78, 98, 93, 106, 84, 105, 104, 91, 83, 106, 92]

            }, {
                name: 'Bad Responses',
                data: [48, 38, 39, 41, 47, 48, 59, 59, 52, 65, 59, 51]

            }, {
                name: 'Follow Ups',
                data: [42, 33, 34, 39, 52, 75, 57, 60, 47, 39, 46, 51]

            }, {
                name: 'Leads',
                data: [42, 33, 34, 39, 52, 75, 57, 60, 47, 39, 46, 51]

            }]
        });

        Highcharts.chart('SEO_Chart_Wrapper', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Search Engine Optimization Chart'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Reach', 'Clicks', 'Form Submissions', 'Calls', 'Leads'],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -40,
                y: 80,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'One Month Record',
                data: [50, 68, 90, 107, 30]
            },]
        });

        Highcharts.chart('SMM_Chart_Wrapper', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Social Media Marketing Chart'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },

            "series": [
                {
                    "name": " ",
                    "colorByPoint": true,
                    "data": [
                        {
                            "name": "Reach",
                            "y": 62
                        },
                        {
                            "name": "Good Responses",
                            "y": 10
                        },
                        {
                            "name": "Bad Responses",
                            "y": 7
                        },
                        {
                            "name": "Follow Ups",
                            "y": 5
                        },
                        {
                            "name": "No Response",
                            "y": 12
                        },
                        {
                            "name": "Leads",
                            "y": 4
                        }
                    ]
                }
            ]
        });

        Highcharts.chart('EM_Chart_Wrapper', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Email Marketing Chart'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: ''
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },

            "series": [
                {
                    "name": " ",
                    "colorByPoint": true,
                    "data": [
                        {
                            "name": "Reach",
                            "y": 62
                        },
                        {
                            "name": "Good Responses",
                            "y": 10
                        },
                        {
                            "name": "Bad Responses",
                            "y": 7
                        },
                        {
                            "name": "Follow Ups",
                            "y": 5
                        },
                        {
                            "name": "No Response",
                            "y": 12
                        },
                        {
                            "name": "Leads",
                            "y": 4
                        }
                    ]
                }
            ]
        });


    </script>

<?php include_once("../includes/endTags.php"); ?>