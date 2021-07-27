<?php

$get_notification = getNotification($global_employee_id);

$total_notifications = $get_notification['total_notifications'];
$unseen_notifications = $get_notification['unseen_notifications'];
$list_of_notifications = $get_notification['list_of_notifications'];

?>

    <div id="kt_header" class="header header-fixed">
        <!--begin::Container-->
        <!--<div class="container-fluid d-flex align-items-stretch justify-content-between">-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-name text-center">
                        <?php
                        if($page == 'dashboard') {
                            ?>
                            <span class="page-svg-icon-wrapper">
                                <svg x="0px" y="0px" viewBox="0 0 191.82 191.82">
                                    <path class="dark_color" d="M64.18,20v44.18H20V26.53c0-3.6,2.93-6.53,6.53-6.53H64.18"/>
                                    <path class="light_dark" d="M84.18,0H26.53C11.88,0,0,11.88,0,26.53v57.65h84.18V0z"/>
                                    <path class="dark_color" d="M171.82,127.64v37.65c0,3.6-2.93,6.53-6.53,6.53h-37.65v-44.18H171.82"/>
                                    <path class="light_dark" d="M191.82,107.64h-84.18v84.18h57.65c14.65,0,26.53-11.88,26.53-26.53V107.64z"/>
                                    <path class="dark_color" d="M64.18,127.64v44.18H26.53c-3.6,0-6.53-2.93-6.53-6.53v-37.65H64.18"/>
                                    <path class="light_dark" d="M84.18,107.64H0v57.65c0,14.65,11.88,26.53,26.53,26.53h57.65V107.64z"/>
                                    <path class="dark_color" d="M165.29,20c3.6,0,6.53,2.93,6.53,6.53v37.65h-44.18V20H165.29"/>
                                    <path class="dark_color" d="M165.29,0h-57.65v84.18h84.18V26.53C191.82,11.88,179.94,0,165.29,0"/>
                                    <rect style="fill:none;" width="191.82" height="191.82"/>
                                </svg>
                            </span> Dashboard
                            <?php
                        }
                        else {
                            echo '<span class="page-svg-icon-wrapper">'.$page_icon.'</span>';

                            if(array_key_exists($page, config('lang.page_title.title'))){
                                echo config('lang.page_title.title.' . $page);
                            } else{
                                echo ucwords(str_replace("_", " ", $page));
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="topbar">
                <!--begin::Notifications Panel Button-->
                <div class="topbar-item">
                    <div class="btn btn-icon btn-clean btn-lg mr-1" id="kt_quick_panel_toggle">
                        <i class="flaticon2-bell-4 text-primary"></i>
                        <div id="notification-badge-wrapper">
                            <?php
                            if (!empty($unseen_notifications) && is_numeric($unseen_notifications) && $unseen_notifications > 0) {
                                echo '<span class="badge badge-primary notification-badge" id="notification-badge">' . $unseen_notifications . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--end::Notifications Panel Button-->

                <!--begin::User-->
                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                         id="kt_quick_user_toggle">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?php echo $global_employee_info->first_name; ?></span>
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                            <span class="symbol-label font-size-h5 font-weight-bold"><?php echo getInitialsFromString($global_employee_info->first_name, 1); ?></span>
                                        </span>
                    </div>
                </div>
                <!--end::User-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--begin::Notifications Panel-->
    <div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
        <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
            <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-primary flex-grow-1 px-10"
                role="tablist">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_notifications">Notifications</a>
                </li>
            </ul>
            <div class="offcanvas-close mt-n1 pr-5">
                <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
        </div>

        <div class="offcanvas-content px-5">
            <div class="tab-content">
                <div class="tab-pane fade pt-2 active show" id="kt_quick_panel_notifications" role="tabpanel">
                    <div id="notifications_panel">
                        <?php echo $list_of_notifications; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Notifications Panel-->
    <script>
        function readNotification(id) {
            loader(true);
            var postData = {"id": id};
            $.ajax({
                type: "POST", url: "ajax/common.php",
                data: {'postData': postData, 'readNotification': true},
                success: function (resPonse) {
                    if (resPonse !== undefined && resPonse != '') {
                        var obj = JSON.parse(resPonse);
                        if (obj.code === 200 && obj.data !== undefined && obj.data != '') {
                            if (obj.data.unseen_notifications > 0) {
                                document.getElementById('notification-badge-wrapper').innerHTML = '<span class="badge badge-primary notification-badge" id="notification-badge">' + obj.data.unseen_notifications + '</span>';
                            } else {
                                document.getElementById('notification-badge-wrapper').innerHTML = '';
                            }
                            //console.log(obj.data);
                            //document.getElementById('notifications_panel').innerHTML=obj.data.total_notifications;
                            //document.getElementById('notifications_panel').innerHTML=obj.data.unseen_notifications;
                            document.getElementById('notifications_panel').innerHTML = obj.data.list_of_notifications;
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