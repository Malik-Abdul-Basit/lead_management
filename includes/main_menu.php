<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto" id="kt_brand">
        <div class="brand-logo-wrapper">
            <a href="<?php echo $admin_url . 'dashboard'; ?>" class="brand-logo">
                <img alt="Logo" src="<?php echo $tm_assets; ?>media/logos/admin_logo_colored.png"/>
            </a>
        </div>
    </div>
    <!--end::Brand-->

    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

        <div id="kt_aside_menu" class="aside-menu"
             data-menu-vertical="1"
             data-menu-scroll="1"
             data-menu-dropdown-timeout="500">
            <ul class="menu-nav">
                <li aria-haspopup="true" class="menu-item">
                    <div class="user-image-portion">
                        <div class="line">
                            <div class="user-image-wrapper" id="kt_quick_user_toggle">
                                <img src="<?php echo getUserImage($global_employee_id)['image_path']; ?>" alt="User Profile Image"/>
                            </div>
                        </div>
                        <div class="line text-center">
                            <span class="label user-active-label mt-6">Active Now</span>
                        </div>
                    </div>
                </li>



                <li aria-haspopup="true" class="menu-item <?php if (in_array($page, array('dashboard'))) {
                    echo 'menu-item-active';
                } ?>">
                    <a href="<?php echo $admin_url . 'dashboard'; ?>" class="menu-link ">
                        <span class="svg-icon menu-icon">
                            <svg viewBox="0 0 512 512">
                                <g>
                                    <path class="light_color" d="M224.69,0H70.81C31.7,0,0,31.7,0,70.81v153.89h224.69V0z"/>
                                    <path class="light_color" d="M512,287.31H287.31V512h153.89c39.11,0,70.81-31.7,70.81-70.81V287.31z"/>
                                    <path class="light_color" d="M224.69,287.31H0v153.89C0,480.3,31.7,512,70.81,512h153.89V287.31z"/>
                                    <path class="dark_color" d="M441.19,0H287.31v224.69H512V70.81C512,31.7,480.3,0,441.19,0"/>
                                    <rect style="fill:none;" width="512" height="512"/>
                                </g>
                            </svg>
                        </span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                <li class="menu-section ">
                    <h4 class="menu-text">Custom</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                <?php
                //include_once('commented_menus.php');


                $sqlM = "SELECT mm.* FROM main_menus AS mm ";
                if($global_employee_info->user_type != config('users.type.value.super_admin')){
                    $sqlM .= " INNER JOIN user_rights AS ur ON mm.id=ur.main_menu_id ";
                }
                $sqlM .= " WHERE mm.status = '";
                $sqlM .= config('main_menus.status.value.active')."'";
                if($global_employee_info->user_type != config('users.type.value.super_admin')){
                    $sqlM .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                }
                $sqlM .= " GROUP BY mm.id ORDER BY mm.sort_by ASC";

                $select_main_menu = mysqli_query($db, $sqlM);
                if (mysqli_num_rows($select_main_menu) > 0) {
                    while ($main_menu = mysqli_fetch_object($select_main_menu)) {
                        $main_menu_class = ($main_menu->id == $main_menu_id) ? 'menu-item-open' : '';
                        ?>
                        <li class="menu-item menu-item-submenu <?php echo $main_menu_class; ?>" aria-haspopup="true"
                            data-menu-toggle="hover" data-id="main-menu-id-<?php echo $main_menu->id; ?>">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="svg-icon menu-icon"><?php echo $main_menu->icon; ?></span>
                                <span class="menu-text"><?php echo $main_menu->name; ?></span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text"><?php echo $main_menu->name; ?></span>
                                        </span>
                                    </li>
                                    <?php
                                    $sqlS = "SELECT sm.* FROM sub_menus AS sm ";
                                    if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                        $sqlS .= " INNER JOIN user_rights AS ur ON sm.id=ur.sub_menu_id ";
                                    }
                                    $sqlS .= " WHERE sm.main_menu_id='{$main_menu->id}' AND sm.status = '";
                                    $sqlS .= config('sub_menus.status.value.active')."'";
                                    if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                        $sqlS .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                                    }
                                    $sqlS .= " GROUP BY sm.id ORDER BY sm.sort_by ASC";
                                    $select_sub_menu = mysqli_query($db, $sqlS);
                                    if (mysqli_num_rows($select_sub_menu) > 0) {
                                        while ($sub_menu = mysqli_fetch_object($select_sub_menu)) {
                                            $sub_menu_class = ($sub_menu->id == $sub_menu_id) ? 'menu-item-open' : '';
                                            ?>
                                            <li class="menu-item menu-item-submenu <?php echo $sub_menu_class; ?>"
                                                aria-haspopup="true"
                                                data-menu-toggle="hover" data-id="sub-menu-id-<?php echo $sub_menu->id; ?>">
                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                    <i class="menu-bullet menu-bullet-line"><span></span></i>
                                                    <span class="menu-text"><?php echo $sub_menu->name; ?></span>
                                                    <i class="menu-arrow"></i>
                                                </a>
                                                <div class="menu-submenu">
                                                    <i class="menu-arrow"></i>
                                                    <ul class="menu-subnav">
                                                        <?php
                                                        $sqlC = "SELECT cm.* FROM child_menus AS cm ";
                                                        if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                                            $sqlC .= " INNER JOIN user_rights AS ur ON cm.id=ur.child_menu_id ";
                                                        }
                                                        $sqlC .= " WHERE cm.sub_menu_id='{$sub_menu->id}' AND cm.status = '";
                                                        $sqlC .= config('child_menus.status.value.active');
                                                        $sqlC .= "' AND cm.menu_link = '";
                                                        $sqlC .= config('child_menus.menu_link.value.display')."'";
                                                        if($global_employee_info->user_type != config('users.type.value.super_admin')){
                                                            $sqlC .= " AND ur.user_id='{$global_user_id}' AND ur.company_id='{$global_company_id}' AND ur.branch_id='{$global_branch_id}' ";
                                                        }
                                                        $sqlC .= " GROUP BY cm.id ORDER BY cm.sort_by ASC";
                                                        $select_child_menu = mysqli_query($db, $sqlC);
                                                        if (mysqli_num_rows($select_child_menu) > 0) {
                                                            while ($child_menu = mysqli_fetch_object($select_child_menu)) {
                                                                ?>
                                                                <li class="menu-item <?php if ($child_menu->id == $child_menu_id) {
                                                                    echo 'menu-item-active';
                                                                } ?>" aria-haspopup="true" data-id="child-menu-id-<?php echo $child_menu->id; ?>">
                                                                    <a href="<?php echo $admin_url . $child_menu->file_name; ?>"
                                                                       class="menu-link ">
                                                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                                        <span class="menu-text"><?php echo $child_menu->display_name; ?></span>
                                                                    </a>
                                                                </li>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>
                        <?php

                    }
                }


                ?>
            </ul>
        </div>
    </div>
    <!--end::Aside Menu-->
</div>
