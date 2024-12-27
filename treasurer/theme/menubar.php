<div class="mdk-drawer js-mdk-drawer" id="default-drawer">
            <div class="mdk-drawer__content">
                <div class="mdk-drawer__inner" data-simplebar data-simplebar-force-enabled="true">
                    <nav class="drawer  drawer--custom"><!-- ilisdan lang ang drawer--custom to drawer--dark para erase sa custom color -->
                        <div class="drawer-spacer">
                            <div class="media align-items-center">
                                <a href="#" class="drawer-brand-circle mr-2">CF</a>
                                <!-- <a href="#" class="nav-link dropdown-toggle dropdown-clear-caret text-success" data-toggle="sidebar" data-target="#user-drawer"><img src="https://img.freepik.com/premium-photo/cute-monster-with-long-tongue_985323-14030.jpg" class="img-fluid rounded-circle ml-1" width="35"
                                            alt=""></a> -->
                                <div class="media-body">
                                    <a href="#" data-toggle="sidebar" data-target="#user-drawer" class="h6 m-0 text-link">&nbsp; <?=strtoupper($_SESSION['CMS_treasurer_fname'] . ' ' .$_SESSION['CMS_treasurer_lname'])?></a>
                                    <a href="#" class="nav-link dropdown-toggle dropdown-clear-caret text-info">
                                        <?=strtoupper($_SESSION['CMS_treasurer_role'])?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- HEADING -->
                        <div class="py-2 drawer-heading">
                            Dashboards
                        </div>
                        <!-- DASHBOARDS MENU -->
                        <ul class="drawer-menu" id="dasboardMenu" data-children=".drawer-submenu">
                            <li class="drawer-menu-item <?php echo ($p==1) ? 'active' : ''; ?>">
                                <a href="../treasurer/?p=1">
                                    <i class="material-icons">poll</i>
                                    <span class="drawer-menu-text"> Dashboard</span>
                                </a>
                            </li>
                            <li class="drawer-menu-item <?php echo ($p==2) ? 'active' : ''; ?>">
                                <a href="../treasurer/?p=2">
                                    <i class="material-icons">people_outline</i>
                                    <span class="drawer-menu-text"> Member</span>
                                </a>
                            </li>
                            <li class="drawer-menu-item <?php echo ($p==3) ? 'active' : ''; ?>">
                                <a href="../treasurer/?p=3">
                                    <i class="material-icons">content_paste</i>
                                    <span class="drawer-menu-text"> Death Record</span>
                                </a>
                            </li>
                            <li class="drawer-menu-item <?php echo ($p==4) ? 'active' : ''; ?>">
                                <a href="../treasurer/?p=4">
                                    <i class="material-icons">pie_chart</i>
                                    <span class="drawer-menu-text"> Report</span>
                                </a>
                            </li>

                            <li hidden class="drawer-menu-item dropdown notifications" id="navbarNotifications">
                                <a href="#" class="nav-link dropdown-toggle notifications--active" data-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons align-middle">notifications</i>
                                    <span class="drawer-menu-text"> Notification</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown" id="notificationsDropdown">
                                    <ul class="nav nav-tabs-notifications" id="notifications-ul" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="notifications-tab" data-toggle="tab" href="#notifications" role="tab" aria-controls="notifications" aria-selected="true">Notifications</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="notifications-tabs">
                                        <div class="tab-pane fade show active" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <div class="w-100">
                                                        <a href="#">john</a> received a new quote</div>
                                                    <div class="w-100 text-muted">4 secs ago</div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="w-100">
                                                        <a href="#">karen</a> received a new quote</div>
                                                    <div class="w-100 text-muted">25 mins ago</div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="w-100">
                                                        <a href="#">jim</a> received a new quote</div>
                                                    <div class="w-100 text-muted">7 hrs ago</div>
                                                </li>
                                                <li class="list-group-item text-right">
                                                    <a href="#">
                                                        <span class="align-middle">View All</span>
                                                        <i class="material-icons md-18 align-middle">arrow_forward</i>
                                                  </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- // END drawer -->

        <!-- drawer -->
        <div class="mdk-drawer js-mdk-drawer" id="user-drawer" data-position="right" data-align="end">
            <div class="mdk-drawer__content">
                <div class="mdk-drawer__inner" data-simplebar data-simplebar-force-enabled="true">
                    <nav class="drawer drawer--light">
                        <div class="drawer-spacer drawer-spacer-border">
                            <div class="media align-items-center">
                                <a href="#" class="drawer-brand-circle mr-2">CF</a>
                                <div class="media-body">
                                    <a href="#" class="h5 m-0"><?=strtoupper($_SESSION['CMS_treasurer_fname'] . ' ' .$_SESSION['CMS_treasurer_lname'])?></a>
                                    <div><?=strtoupper($_SESSION['CMS_treasurer_role'])?></div>
                                </div>
                            </div>
                        </div>
                        <div class="drawer-spacer bg-body-bg">
                            <div class="d-flex justify-content-between mb-2">
                                <p class="h6 text-gray m-0"><i class="material-icons align-middle md-18 text-primary">account_balance_wallet</i> Balance</p>
                                <span>₱<?=number_format($balance,2)?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p class="h6 text-gray m-0"><i class="material-icons align-middle md-18 text-primary">contacts</i> Contribution</p>
                                <span>₱<?=number_format($contribution,2)?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p class="h6 text-gray m-0">&nbsp;<i class="md-18 text-primary">₱</i>&nbsp;&nbsp;&nbsp;To Be Collected</p>
                                <span>₱<?=number_format($collectible,2)?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p class="h6 text-gray m-0"><i class="material-icons align-middle md-18 text-primary">supervisor_account</i> Member</p>
                                <span><?=$totalmembers?></span>
                            </div>
                        </div>
                        <!-- MENU -->
                        <ul class="drawer-menu" id="userMenu" data-children=".drawer-submenu">
                            <li class="drawer-menu-item">
                                <a href="../treasurer/?p=account">
                                    <i class="material-icons">lock</i>
                                    <span class="drawer-menu-text"> Account</span>
                                </a>
                            </li>
                            <li class="drawer-menu-item">
                                <a href="../treasurer/?p=logout">
                                    <i class="material-icons">exit_to_app</i>
                                    <span class="drawer-menu-text"> Logout</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- // END drawer -->