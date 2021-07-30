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
                                <div class="card card-custom box-shadow-none">
                                    <div class="card-header flex-wrap py-5">
                                        <div class="card-title">
                                            <h3 class="card-label">
                                                <?php echo $pageHeading; ?>
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <?php
                                            $type = config('lang.page_type.title.' . $page);
                                            if (hasRight($user_right_title, 'add')) {
                                                echo '<a href="' . $admin_url . $type . '_campaign" class="btn btn-primary font-weight-bolder">' . config('lang.button.title.new_record') . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="card-header flex-wrap border-0 pt-6 pb-6">
                                        <!--begin::Search Form-->
                                        <div class="mb-7 d-block" style="width: 100%">
                                            <div class="row align-items-center">
                                                <div class="col-lg-12 col-xl-12">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2 my-2 my-md-0">
                                                            <div class="form-group">
                                                                <label for="BG_SearchQuery">Search</label>
                                                                <div class="input-icon">
                                                                    <input type="text" onkeyup="getData()"
                                                                           class="form-control"
                                                                           placeholder="Search..."
                                                                           id="BG_SearchQuery">
                                                                    <span><i class="flaticon2-search-1 text-muted"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 my-2 my-md-0">
                                                            <div class="form-group">
                                                                <label for="BG_CampaignTypeFilter">Campaign Type</label>
                                                                <select id="BG_CampaignTypeFilter"
                                                                        onchange="getData()" <?php echo $ApplySelect2; ?>>
                                                                    <option selected="selected" value="-1">
                                                                        All
                                                                    </option>
                                                                    <?php
                                                                    $select = "SELECT ct.id, ct.name FROM campaign_types AS ct INNER JOIN campaigns AS c ON ct.id=c.campaign_type_id WHERE ct.type='{$type}' AND  ct.company_id='{$global_company_id}' AND ct.branch_id='{$global_branch_id}' AND ct.deleted_at IS NULL AND c.type='{$type}' AND  c.company_id='{$global_company_id}' AND c.branch_id='{$global_branch_id}' AND c.deleted_at IS NULL GROUP BY ct.id ORDER BY ct.sort_by ASC";
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

                                                        <div class="col-md-2 my-2 my-md-0">
                                                            <div class="form-group">
                                                                <label for="BG_SourceFilter">Source</label>
                                                                <select id="BG_SourceFilter"
                                                                        onchange="getData(), getAccounts(this.value,'<?php echo $type; ?>')" <?php echo $ApplySelect2; ?>>
                                                                    <option selected="selected" value="-1">
                                                                        All
                                                                    </option>
                                                                    <?php
                                                                    $select = "SELECT s.id, s.name FROM sources AS s INNER JOIN campaigns AS c ON s.id=c.source_id WHERE s.type='{$type}' AND  s.company_id='{$global_company_id}' AND s.branch_id='{$global_branch_id}' AND s.deleted_at IS NULL AND c.type='{$type}' AND  c.company_id='{$global_company_id}' AND c.branch_id='{$global_branch_id}' AND c.deleted_at IS NULL GROUP BY s.id ORDER BY s.sort_by ASC";
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

                                                        <div class="col-md-2 my-2 my-md-0">
                                                            <div class="form-group">
                                                                <label for="BG_AccountFilter">Account</label>
                                                                <select id="BG_AccountFilter"
                                                                        onchange="getData()" <?php echo $ApplySelect2; ?>>
                                                                    <option selected="selected" value="-1">
                                                                        All
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 my-2 my-md-0">
                                                            <div class="form-group row">
                                                                <label for="BG_DateRangeFilter">Select date
                                                                    range</label>
                                                                <div class='input-group' id='daterangepicker'>
                                                                    <input type="text" class="form-control" readonly
                                                                           placeholder="Select date range"/>
                                                                    <input type="hidden" name="rangeStart"
                                                                           id="rangeStart"/>
                                                                    <input type="hidden" name="rangeEnd" id="rangeEnd"/>
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i
                                                                                    class="la la-calendar-check-o"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Search Form-->
                                    </div>

                                    <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded gridListingStyleWrapper"
                                         id="dataListingWrapper">
                                    </div>
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

    getData();

    function setPageNo(p) {
        document.getElementById('BG_PageNumber').value = p;
        getData();
    }

    function getData() {
        var BG_SearchQuery = document.getElementById('BG_SearchQuery');
        var BG_PageNumber = document.getElementById('BG_PageNumber');
        var BG_PageSize = document.getElementById('BG_PageSize');
        var BG_SortColumn = document.getElementById('BG_SortColumn');
        var BG_SortOrder = document.getElementById('BG_SortOrder');

        var BG_CampaignTypeFilter = document.getElementById('BG_CampaignTypeFilter');
        var BG_SourceFilter = document.getElementById('BG_SourceFilter');
        var BG_AccountFilter = document.getElementById('BG_AccountFilter');
        var BG_RangeStart = document.getElementById('rangeStart');
        var BG_RangeEnd = document.getElementById('rangeEnd');

        var SearchQuery = '';
        var PageNumber = "1";
        var PageSize = "10";
        var SortColumn = 'c.date';
        var SortOrder = 'DESC';
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
            'DateRange': {'rangeStart': BG_RangeStart.value, 'rangeEnd': BG_RangeEnd.value},
            'Filter': [
                {'field': 'c.campaign_type_id', 'value': BG_CampaignTypeFilter.value},
                {'field': 'c.source_id', 'value': BG_SourceFilter.value},
                {'field': 'c.account_id', 'value': BG_AccountFilter.value},
            ],
            "PageSizeStack": ["5", "10", "20", "30", "40", "50"]
        };
        getAllPageData(filter);
    }

    function getAllPageData(filter) {
        loader(true);
        $.ajax({
            type: "POST", url: 'ajax/fetch/campaigns.php',
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
                        data: "delete_campaign=" + id + "&user_right_title=<?php echo $user_right_title; ?>" + "&type=" + type,
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

    function getAccounts(id, type) {
        var postData = {"id": id, "type": type, "account_id": 0};
        $.ajax({
            type: "POST", url: "ajax/common.php",
            data: {'postData': postData, 'getAccounts': true},
            success: function (resPonse) {
                if (resPonse !== undefined && resPonse != '') {
                    var obj = JSON.parse(resPonse);
                    if (obj.code !== undefined && obj.code != '' && obj.code === 200 && obj.account_list !== undefined && obj.account_list != '') {
                        document.getElementById('BG_AccountFilter').innerHTML = obj.account_list;
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

</script>
<?php include_once("../includes/endTags.php"); ?>
















