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
                        <div class=" container ">

                            <!--begin::Card-->
                            <div class="card card-custom">
                                <div class="card-header flex-wrap py-5">
                                    <div class="card-title">
                                        <h3 class="card-label">
                                            <?php
                                            $type = config('lang.page_type.title.'.$page);
                                            echo ucwords(str_replace("_", " ", $page));
                                            ?>
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <?php
                                        if (hasRight($user_right_title, 'add')) {
                                            echo '<a href="' . $admin_url . $type . '_account" class="btn btn-primary font-weight-bolder">'.config('lang.button.title.new_record').'</a>';
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="mb-7">
                                        <div class="row align-items-center">
                                            <div class="col-lg-12">
                                                <div class="row align-items-center">
                                                    <div class="col-md-4 my-2 my-md-0">
                                                        <div class="input-icon">
                                                            <input type="text" onkeyup="getData()" class="form-control"
                                                                   placeholder="Search..." id="BG_SearchQuery">
                                                            <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 my-2 my-md-0">
                                                        <div class="form-group">
                                                            <label for="BG_SourceFilter">Source</label>
                                                            <select id="BG_SourceFilter"
                                                                    onchange="getData()" <?php echo $ApplySelect2; ?>>
                                                                <option value="-1">All</option>
                                                                <?php
                                                                $select = "SELECT `id`, `name` FROM `sources` WHERE `type`='{$type}' AND `company_id`='{$global_company_id}' AND `branch_id`='{$global_branch_id}' AND `deleted_at` IS NULL ORDER BY `sort_by` ASC";
                                                                $query = mysqli_query($db, $select);
                                                                if (mysqli_num_rows($query) > 0) {
                                                                    while ($result = mysqli_fetch_object($query)) {
                                                                        ?>
                                                                        <option value="<?php echo $result->id; ?>"><?php echo $result->name; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded"
                                         id="dataListingWrapper"></div>
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
        getData();

        function setPageNo(p) {
            document.getElementById('BG_PageNumber').value = p;
            getData();
        }

        function setSort(e) {
            var field = e.target.dataset.field;
            var sort = e.target.dataset.sort;
            var BG_SortColumn = document.getElementById('BG_SortColumn');
            var BG_SortOrder = document.getElementById('BG_SortOrder');

            if (field === undefined) {
                var set_field = 'name';
            } else {
                var set_field = field;
            }
            if (sort === undefined || sort == 'DESC' || sort == 'desc') {
                var set_order = 'ASC';
            } else {
                var set_order = 'DESC';
            }

            if (BG_SortColumn) {
                BG_SortColumn.value = set_field;
            }
            if (BG_SortOrder) {
                BG_SortOrder.value = set_order;
            }
            getData();
        }

        function getData() {
            var BG_SearchQuery = document.getElementById('BG_SearchQuery');
            var BG_PageNumber = document.getElementById('BG_PageNumber');
            var BG_PageSize = document.getElementById('BG_PageSize');
            var BG_SortColumn = document.getElementById('BG_SortColumn');
            var BG_SortOrder = document.getElementById('BG_SortOrder');

            var BG_SourceFilter = document.getElementById('BG_SourceFilter');

            var SearchQuery = '';
            var PageNumber = "1";
            var PageSize = "10";
            var SortColumn = 'name';
            var SortOrder = 'ASC';
            if (BG_SearchQuery && BG_SearchQuery.value != '') {
                SearchQuery = BG_SearchQuery.value;
            }
            if (BG_PageNumber && BG_PageNumber.value != '') {
                PageNumber = BG_PageNumber.value;
            }
            if (BG_PageSize && BG_PageSize.value != '') {
                PageSize = BG_PageSize.value;
            }
            if (BG_SortColumn && BG_SortColumn.value != '') {
                SortColumn = BG_SortColumn.value;
            }
            if (BG_SortOrder && BG_SortOrder.value != '') {
                SortOrder = BG_SortOrder.value;
            }
            var filter = {
                'L': '<?php echo $user_right_title; ?>',
                'T': '<?php echo $type; ?>',
                'SearchQuery': SearchQuery,
                'PageNumber': PageNumber,
                'PageSize': PageSize,
                'Sort': {'SortColumn': SortColumn, 'SortOrder': SortOrder},
                'Filter': [
                    {'field': 'a.source_id', 'value': BG_SourceFilter.value},
                ],
                'Numbering': {
                    'field': 'sr',
                    'title': '#',
                    'text': 'center',
                    'style': 'style="width:40px"',
                    'sort': false
                },
                'Header': [
                    {'field': 'name', 'title': 'Name', 'text': 'left', 'style': 'style="width:250px"', 'sort': true},
                    {
                        'field': 'source_name',
                        'title': 'Source',
                        'text': 'left',
                        'style': 'style="width:250px"',
                        'sort': true
                    },
                ],
                'Actions': {
                    'field': 'actions',
                    'title': 'Actions',
                    'text': 'left',
                    'style': 'style="overflow: visible; position: relative; width:125px"',
                    'sort': false
                },
                "PageSizeStack": ["5", "10", "20", "30", "40", "50"]
            };
            getAllPageData(filter);
        }

        function getAllPageData(filter) {
            loader(true);
            $.ajax({
                type: "POST", url: 'ajax/fetch/accounts.php',
                data: {'filters': filter},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200) {
                            document.getElementById('dataListingWrapper').innerHTML = obj.data;
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

        function entryDelete(id, type) {
            Swal.fire({
                title: 'Are you sure want to delete?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    var D = '<?php echo hasRight($user_right_title, 'delete') ?>';
                    if (D) {
                        loader(true);
                        $.ajax({
                            type: "POST", url: "ajax/delete.php",
                            data: "delete_account=" + id + "&user_right_title=<?php echo $user_right_title; ?>" + "&type=" + type,
                            success: function (resPonse) {
                                if (resPonse !== undefined && resPonse != '') {
                                    var obj = JSON.parse(resPonse);
                                    if (obj.code === 200 || obj.code === 405 || obj.code === 422) {
                                        if (obj.code === 200) {
                                            getData();
                                            Swal.fire({
                                                icon: 'success',
                                                title: obj.responseMessage,
                                                showConfirmButton: false,
                                                timer: 1200
                                            });
                                        } else {
                                            loader(false);
                                        }
                                        toasterTrigger(obj.toasterClass, obj.responseMessage);
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
                    } else {
                        toasterTrigger('error', 'Sorry! You have no right to delete record.');
                    }
                }
            });
        }

    </script>
<?php include_once("../includes/endTags.php"); ?>