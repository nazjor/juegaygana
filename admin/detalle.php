<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Project Detail | Attex - Responsive Tailwind CSS 3 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc., Tailwind, TailwindCSS, Tailwind CSS 3" name="description">
    <meta content="coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Dropzone Plugin Css -->
    <link href="assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>
</head>

<body>

    <div class="flex wrapper">

        <!-- Sidenav Menu -->
        <div class="app-menu">

            <!-- App Logo -->
            <a href="index.html" class="logo-box">
                <!-- Light Logo -->
                <div class="logo-light">
                    <img src="assets/images/logo.png" class="logo-lg h-[22px]" alt="Light logo">
                    <img src="assets/images/logo-sm.png" class="logo-sm h-[22px]" alt="Small logo">
                </div>

                <!-- Dark Logo -->
                <div class="logo-dark">
                    <img src="assets/images/logo-dark.png" class="logo-lg h-[22px]" alt="Dark logo">
                    <img src="assets/images/logo-sm.png" class="logo-sm h-[22px]" alt="Small logo">
                </div>
            </a>

            <!-- Sidenav Menu Toggle Button -->
            <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5 z-50">
                <span class="sr-only">Menu Toggle Button</span>
                <i class="ri-checkbox-blank-circle-line text-xl"></i>
            </button>

            <!--- Menu -->
            <div class="scrollbar" data-simplebar>
                <ul class="menu" data-fc-type="accordion">
                    <li class="menu-title">Navigation</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-home-4-line"></i>
                            </span>
                            <span class="menu-text"> Dashboard </span>
                            <span class="badge bg-success rounded-full">2</span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="dashboard-analytics.html" class="menu-link">
                                    <span class="menu-text">Analytics</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="index.html" class="menu-link">
                                    <span class="menu-text">Ecommerce</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Apps</li>

                    <li class="menu-item">
                        <a href="apps-calendar.html" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-calendar-event-line"></i>
                            </span>
                            <span class="menu-text"> Calendar </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="apps-chat.html" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-message-3-line"></i>
                            </span>
                            <span class="menu-text"> Chat </span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-mail-line"></i>
                            </span>
                            <span class="menu-text"> Email </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="apps-email-inbox.html" class="menu-link">
                                    <span class="menu-text">Inbox</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="apps-email-read.html" class="menu-link">
                                    <span class="menu-text">Read Email</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-task-line"></i>
                            </span>
                            <span class="menu-text"> Tasks </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="apps-tasks-list.html" class="menu-link">
                                    <span class="menu-text">List</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="apps-tasks-details.html" class="menu-link">
                                    <span class="menu-text">Details</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="apps-kanban.html" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-list-check-3"></i>
                            </span>
                            <span class="menu-text">Kanban Board</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="apps-file-manager.html" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-folder-2-line"></i>
                            </span>
                            <span class="menu-text"> File Manager </span>
                        </a>
                    </li>

                    <li class="menu-title">Custom</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon"><i class="ri-pages-line"></i></span>
                            <span class="menu-text"> Pages </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="pages-starter.html" class="menu-link">
                                    <span class="menu-text">Starter</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-profile.html" class="menu-link">
                                    <span class="menu-text">Profile</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-timeline.html" class="menu-link">
                                    <span class="menu-text">Timeline</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-invoice.html" class="menu-link">
                                    <span class="menu-text">Invoice</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-faqs.html" class="menu-link">
                                    <span class="menu-text">FAQs</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-pricing.html" class="menu-link">
                                    <span class="menu-text">Pricing</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="pages-maintenance.html" class="menu-link">
                                    <span class="menu-text">Maintenance</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-shield-user-line"></i>
                            </span>
                            <span class="menu-text"> Auth Pages </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="auth-login.html" class="menu-link">
                                    <span class="menu-text">Login</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-login-2.html" class="menu-link">
                                    <span class="menu-text">Login 2</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-register.html" class="menu-link">
                                    <span class="menu-text">Register</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-register-2.html" class="menu-link">
                                    <span class="menu-text">Register 2</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-logout.html" class="menu-link">
                                    <span class="menu-text">Logout</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-logout-2.html" class="menu-link">
                                    <span class="menu-text">Logout 2</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-recoverpw.html" class="menu-link">
                                    <span class="menu-text">Recover Password</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-recoverpw-2.html" class="menu-link">
                                    <span class="menu-text">Recover Password 2</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-lock-screen.html" class="menu-link">
                                    <span class="menu-text">Lock Screen</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-lock-screen-2.html" class="menu-link">
                                    <span class="menu-text">Lock Screen 2</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-confirm-mail.html" class="menu-link">
                                    <span class="menu-text">Confirm Mail</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="auth-confirm-mail-2.html" class="menu-link">
                                    <span class="menu-text">Confirm Mail 2</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-error-warning-line"></i>
                            </span>
                            <span class="menu-text"> Error Pages </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="error-404.html" class="menu-link">
                                    <span class="menu-text">Error 404</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="error-404-alt.html" class="menu-link">
                                    <span class="menu-text">Error 404-alt</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="error-500.html" class="menu-link">
                                    <span class="menu-text">Error 500</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-layout-line"></i>
                            </span>
                            <span class="menu-text"> Layout </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="layout-hover-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Hovered Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-icon-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Icon View Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-compact-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Compact Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-mobile-view.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Mobile View Menu</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="layout-hidden.html" target="_blank" class="menu-link">
                                    <span class="menu-text">Hidden Menu</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-title">Components</li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-briefcase-line"></i>
                            </span>
                            <span class="menu-text"> Base UI </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="ui-accordions.html" class="menu-link">
                                    <span class="menu-text">Accordions</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-alerts.html" class="menu-link">
                                    <span class="menu-text">Alerts</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-avatars.html" class="menu-link">
                                    <span class="menu-text">Avatars</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-buttons.html" class="menu-link">
                                    <span class="menu-text">Buttons</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-badges.html" class="menu-link">
                                    <span class="menu-text">Badges</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-breadcrumbs.html" class="menu-link">
                                    <span class="menu-text">Breadcrumb</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-cards.html" class="menu-link">
                                    <span class="menu-text">Cards</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-collapse.html" class="menu-link">
                                    <span class="menu-text">Collapse</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-dismissible.html" class="menu-link">
                                    <span class="menu-text">Dismissible</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-dropdowns.html" class="menu-link">
                                    <span class="menu-text">Dropdowns</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-progress.html" class="menu-link">
                                    <span class="menu-text">Progress</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-skeleton.html" class="menu-link">
                                    <span class="menu-text">Skeleton</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-spinners.html" class="menu-link">
                                    <span class="menu-text">Spinners</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-list-group.html" class="menu-link">
                                    <span class="menu-text">List Group</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-ratio.html" class="menu-link">
                                    <span class="menu-text">Ratio</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tabs.html" class="menu-link">
                                    <span class="menu-text">Tab</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-modals.html" class="menu-link">
                                    <span class="menu-text">Modals</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-offcanvas.html" class="menu-link">
                                    <span class="menu-text">Offcanvas</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-popovers.html" class="menu-link">
                                    <span class="menu-text">Popovers</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-tooltips.html" class="menu-link">
                                    <span class="menu-text">Tooltips</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="ui-typography.html" class="menu-link">
                                    <span class="menu-text">Typography</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-stack-line"></i>
                            </span>
                            <span class="menu-text"> Extended UI </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="extended-swiper.html" class="menu-link">
                                    <span class="menu-text">Swiper</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-nestable.html" class="menu-link">
                                    <span class="menu-text">Nestable List</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-ratings.html" class="menu-link">
                                    <span class="menu-text">Ratings</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-player.html" class="menu-link">
                                    <span class="menu-text">Player</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-scrollbar.html" class="menu-link">
                                    <span class="menu-text">Scrollbar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="extended-tippy-tooltips.html" class="menu-link">
                                    <span class="menu-text">Tippy Tooltip</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-service-line"></i>
                            </span>
                            <span class="menu-text"> Icons </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="icons-remixicons.html" class="menu-link">
                                    <span class="menu-text">Remixicons</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="icons-lucide.html" class="menu-link">
                                    <span class="menu-text">Lucide</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-survey-line"></i>
                            </span>
                            <span class="menu-text"> Forms </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="forms-elements.html" class="menu-link">
                                    <span class="menu-text">Form Elements</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-advanced.html" class="menu-link">
                                    <span class="menu-text">Advanced</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="forms-editor.html" class="menu-link">
                                    <span class="menu-text">Editor</span>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="forms-file-uploads.html" class="menu-link">
                                    <span class="menu-text">File Uploads</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-validation.html" class="menu-link">
                                    <span class="menu-text">Validation</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="forms-layout.html" class="menu-link">
                                    <span class="menu-text">Form Layout</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-table-line"></i>
                            </span>
                            <span class="menu-text"> Tables </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="tables-basic.html" class="menu-link">
                                    <span class="menu-text">Basic Tables</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="tables-datatables.html" class="menu-link">
                                    <span class="menu-text">Data Tables</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-bar-chart-line"></i>
                            </span>
                            <span class="menu-text"> Apex Charts </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="charts-apex-area.html" class="menu-link">
                                    <span class="menu-text">Area</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-bar.html" class="menu-link">
                                    <span class="menu-text">Bar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-bubble.html" class="menu-link">
                                    <span class="menu-text">Bubble</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-candlestick.html" class="menu-link">
                                    <span class="menu-text">Candlestick</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-column.html" class="menu-link">
                                    <span class="menu-text">Column</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-heatmap.html" class="menu-link">
                                    <span class="menu-text">Heatmap</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-line.html" class="menu-link">
                                    <span class="menu-text">Line</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-mixed.html" class="menu-link">
                                    <span class="menu-text">Mixed</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-timeline.html" class="menu-link">
                                    <span class="menu-text">Timeline</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-boxplot.html" class="menu-link">
                                    <span class="menu-text">Boxplot</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-treemap.html" class="menu-link">
                                    <span class="menu-text">Treemap</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-pie.html" class="menu-link">
                                    <span class="menu-text">Pie</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-radar.html" class="menu-link">
                                    <span class="menu-text">Radar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-radialbar.html" class="menu-link">
                                    <span class="menu-text">RadialBar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-scatter.html" class="menu-link">
                                    <span class="menu-text">Scatter</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-polar-area.html" class="menu-link">
                                    <span class="menu-text">Polar Area</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-apex-sparklines.html" class="menu-link">
                                    <span class="menu-text">Sparklines</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-pie-chart-line"></i>
                            </span>
                            <span class="menu-text"> Chartjs </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="charts-chartjs-area.html" class="menu-link">
                                    <span class="menu-text">Area</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-chartjs-bar.html" class="menu-link">
                                    <span class="menu-text">Bar</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-chartjs-line.html" class="menu-link">
                                    <span class="menu-text">Line</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="charts-chartjs-other.html" class="menu-link">
                                    <span class="menu-text">Other</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-treasure-map-line"></i>
                            </span>
                            <span class="menu-text"> Maps </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="maps-vector.html" class="menu-link">
                                    <span class="menu-text">Vector Maps</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="maps-google.html" class="menu-link">
                                    <span class="menu-text">Google Maps</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" data-fc-type="collapse" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-share-line"></i>
                            </span>
                            <span class="menu-text"> Level </span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="sub-menu hidden">
                            <li class="menu-item">
                                <a href="javascript: void(0)" class="menu-link">
                                    <span class="menu-text">Item 1</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="javascript: void(0)" class="menu-link">
                                    <span class="menu-text">Item 2</span>
                                    <span class="badge bg-info rounded-md">New</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu-item">
                        <a href="javascript:void(0)" class="menu-link">
                            <span class="menu-icon">
                                <i class="ri-flag-2-line"></i>
                            </span>
                            <span class="menu-text"> Badge Items </span>
                            <span class="badge bg-danger rounded-md">Hot</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
        <!-- Sidenav Menu End  -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="page-content">

            <!-- Topbar Start -->
            <header class="app-header flex items-center px-4 gap-3.5">

                <!-- App Logo -->
                <a href="index.html" class="logo-box">
                    <!-- Light Logo -->
                    <div class="logo-light">
                        <img src="assets/images/logo.png" class="logo-lg h-[22px]" alt="Light logo">
                        <img src="assets/images/logo-sm.png" class="logo-sm h-[22px]" alt="Small logo">
                    </div>

                    <!-- Dark Logo -->
                    <div class="logo-dark">
                        <img src="assets/images/logo-dark.png" class="logo-lg h-[22px]" alt="Dark logo">
                        <img src="assets/images/logo-sm.png" class="logo-sm h-[22px]" alt="Small logo">
                    </div>
                </a>

                <!-- Sidenav Menu Toggle Button -->
                <button id="button-toggle-menu" class="nav-link p-2">
                    <span class="sr-only">Menu Toggle Button</span>
                    <span class="flex items-center justify-center">
                        <i class="ri-menu-2-fill text-2xl"></i>
                    </span>
                </button>

                <!-- Topbar Search Input -->
                <div class="relative hidden lg:block">

                    <form data-fc-type="dropdown" type="button">
                        <input type="search" class="form-input bg-black/5 border-none ps-8 relative" placeholder="Search...">
                        <span class="ri-search-line text-base z-10 absolute start-2 top-1/2 -translate-y-1/2"></span>
                    </form>

                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 z-50 mt-3.5 transition-all duration-300 bg-white shadow-lg border rounded-lg py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">

                        <!-- item-->
                        <h5 class="flex items-center py-2 px-3 text-sm text-gray-800 dark:text-gray-400 uppercase">Found <b class="text-decoration-underline">08</b> results</h5>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-file-chart-line text-base me-1"></i>
                            <span>Analytics Report</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-lifebuoy-line text-base me-1"></i>
                            <span>How can I help you?</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-user-settings-line text-base me-1"></i>
                            <span>User profile settings</span>
                        </a>

                        <!-- item-->
                        <h6 class="flex items-center py-2 px-3 text-sm text-gray-800 dark:text-gray-400 uppercase">Users</h6>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img class="me-2 rounded-full h-8" src="assets/images/users/avatar-2.jpg" alt="Generic placeholder image">
                            <div class="flex-grow">
                                <h5 class="m-0 fs-14">Erwin Brown</h5>
                                <span class="fs-12 ">UI Designer</span>
                            </div>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img class="me-2 rounded-full h-8" src="assets/images/users/avatar-5.jpg" alt="Generic placeholder image">
                            <div class="flex-grow">
                                <h5 class="m-0 fs-14">Jacob Deo</h5>
                                <span class="fs-12 ">Developer</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Language Dropdown Button -->
                <div class="relative ms-auto">
                    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2 fc-dropdown">
                        <span class="flex items-center gap-2">
                            <img src="assets/images/flags/us.jpg" alt="flag-image" class="h-3">
                            <div class="lg:block hidden">
                                <span>English</span>
                                <i class="ri-arrow-down-s-line"></i>
                            </div>
                        </span>
                    </button>


                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-40 z-50 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg py-2">
                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img src="assets/images/flags/germany.jpg" alt="user-image" class="h-4">
                            <span class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img src="assets/images/flags/italy.jpg" alt="user-image" class="h-4">
                            <span class="align-middle">Italian</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img src="assets/images/flags/spain.jpg" alt="user-image" class="h-4">
                            <span class="align-middle">Spanish</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="flex items-center gap-2.5 py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <img src="assets/images/flags/russia.jpg" alt="user-image" class="h-4">
                            <span class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>

                <!-- Notification Bell Button -->
                <div class="relative lg:flex hidden">
                    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2">
                        <span class="sr-only">View notifications</span>
                        <span class="flex items-center justify-center">
                            <i class="ri-notification-3-line text-2xl"></i>
                            <span class="absolute top-5 end-2.5 w-2 h-2 rounded-full bg-danger"></span>
                        </span>
                    </button>
                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 z-50 transition-all duration-300 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 rounded-lg">

                        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h6 class="text-sm text-gray-500 dark:text-gray-200"> Notification</h6>
                                <a href="javascript: void(0);" class="text-gray-500 dark:text-gray-200 underline">
                                    <small>Clear All</small>
                                </a>
                            </div>
                        </div>

                        <div class="py-4 h-80" data-simplebar>

                            <h5 class="text-xs text-gray-500 dark:text-gray-200 px-4 mb-2">Today</h5>

                            <a href="javascript:void(0);" class="block mb-4">
                                <div class="py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex justify-center items-center h-9 w-9 rounded-full bg text-white bg-primary">
                                                <i class="ri-message-3-line text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow truncate ms-2">
                                            <h5 class="text-sm font-semibold mb-1">Datacorp <small class="font-normal ms-1">1 min ago</small></h5>
                                            <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="block mb-4">
                                <div class="py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex justify-center items-center h-9 w-9 rounded-full bg-info text-white">
                                                <i class="ri-user-add-line text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow truncate ms-2">
                                            <h5 class="text-sm font-semibold mb-1">Admin <small class="font-normal ms-1">1 hr ago</small></h5>
                                            <small class="noti-item-subtitle text-muted">New user registered</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="block mb-4">
                                <div class="py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/users/avatar-2.jpg" class="rounded-full h-9 w-9" alt="">
                                        </div>
                                        <div class="flex-grow truncate ms-2">
                                            <h5 class="text-sm font-semibold mb-1">Cristina Pride <small class="font-normal ms-1">1 day ago</small></h5>
                                            <small class="noti-item-subtitle text-muted">Hi, How are you? What about our next meeting</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <h5 class="text-xs text-gray-500 dark:text-gray-200 px-4 mb-2">Yesterday</h5>

                            <a href="javascript:void(0);" class="block mb-4">
                                <div class="py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="flex justify-center items-center h-9 w-9 rounded-full bg-primary text-white">
                                                <i class="ri-discuss-line text-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow truncate ms-2">
                                            <h5 class="text-sm font-semibold mb-1">Datacorp</h5>
                                            <small class="noti-item-subtitle text-muted">Caleb Flakelar commented on Admin</small>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="javascript:void(0);" class="block">
                                <div class="py-2 px-3 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/users/avatar-4.jpg" class="rounded-full h-9 w-9" alt="">
                                        </div>
                                        <div class="flex-grow truncate ms-2">
                                            <h5 class="text-sm font-semibold mb-1">Karen Robinson</h5>
                                            <small class="noti-item-subtitle text-muted">Wow ! this admin looks good and awesome design</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <a href="javascript:void(0);" class="p-2 border-t border-gray-200 dark:border-gray-700 block text-center text-primary underline font-semibold">
                            View All
                        </a>
                    </div>
                </div>

                <!-- Apps Dropdown -->
                <div class="relative lg:flex hidden">
                    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2">
                        <span class="sr-only">Apps</span>
                        <span class="flex items-center justify-center">
                            <i class="ri-apps-2-line text-2xl"></i>
                        </span>
                    </button>
                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-80 z-50 transition-all duration-300 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                        <div class="grid grid-cols-3 gap-3">
                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/github.png" class="h-6" alt="Github">
                                <span>GitHub</span>
                            </a>

                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/bitbucket.png" class="h-6" alt="bitbucket">
                                <span>Bitbucket</span>
                            </a>

                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/dropbox.png" class="h-6" alt="dropbox">
                                <span>Dropbox</span>
                            </a>

                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/slack.png" class="h-6" alt="slack">
                                <span>Slack</span>
                            </a>

                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/dribbble.png" class="h-6" alt="dribbble">
                                <span>Dribbble</span>
                            </a>

                            <a class="flex flex-col items-center justify-center gap-1.5 py-3 px-6 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300" href="#">
                                <img src="assets/images/brands/behance.png" class="h-6" alt="Behance">
                                <span>Behance</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Theme Setting Button -->
                <div class="flex">
                    <button data-fc-type="offcanvas" data-fc-target="theme-customization" type="button" class="nav-link p-2">
                        <span class="sr-only">Customization</span>
                        <span class="flex items-center justify-center">
                            <i class="ri-settings-3-line text-2xl"></i>
                        </span>
                    </button>
                </div>

                <!-- Light/Dark Toggle Button -->
                <div class="lg:flex hidden">
                    <button id="light-dark-mode" type="button" class="nav-link p-2">
                        <span class="sr-only">Light/Dark Mode</span>
                        <span class="flex items-center justify-center">
                            <i class="ri-moon-line text-2xl block dark:hidden"></i>
                            <i class="ri-sun-line text-2xl hidden dark:block"></i>
                        </span>
                    </button>
                </div>

                <!-- Fullscreen Toggle Button -->
                <div class="md:flex hidden">
                    <button data-toggle="fullscreen" type="button" class="nav-link p-2">
                        <span class="sr-only">Fullscreen Mode</span>
                        <span class="flex items-center justify-center">
                            <i class="ri-fullscreen-line text-2xl"></i>
                        </span>
                    </button>
                </div>

                <!-- Profile Dropdown Button -->
                <div class="relative">
                    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link flex items-center gap-2.5 px-3 bg-black/5 border-x border-black/10">
                        <img src="assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-full h-8">
                        <span class="md:flex flex-col gap-0.5 text-start hidden">
                            <h5 class="text-sm">Tosha Minner</h5>
                            <span class="text-xs">Founder</span>
                        </span>
                    </button>

                    <div class="fc-dropdown fc-dropdown-open:opacity-100 hidden opacity-0 w-44 z-50 transition-all duration-300 bg-white shadow-lg border rounded-lg py-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800">
                        <!-- item-->
                        <h6 class="flex items-center py-2 px-3 text-xs text-gray-800 dark:text-gray-400">Welcome !</h6>

                        <!-- item-->
                        <a href="pages-profile.html" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-account-circle-line text-lg align-middle"></i>
                            <span>My Account</span>
                        </a>

                        <!-- item-->
                        <a href="pages-profile.html" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-settings-4-line text-lg align-middle"></i>
                            <span>Settings</span>
                        </a>

                        <!-- item-->
                        <a href="pages-faqs.html" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-customer-service-2-line text-lg align-middle"></i>
                            <span>Support</span>
                        </a>

                        <!-- item-->
                        <a href="auth-lock-screen.html" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-lock-password-line text-lg align-middle"></i>
                            <span>Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="auth-logout-2.html" class="flex items-center gap-2 py-1.5 px-4 text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
                            <i class="ri-logout-box-line text-lg align-middle"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </header>
            <!-- Topbar End -->

            <main class="p-6">

                <!-- Page Title Start -->
                <div class="flex justify-between items-center mb-6">
                    <h4 class="text-slate-900 dark:text-slate-200 text-lg font-medium">Project Detail</h4>

                    <div class="md:flex hidden items-center gap-2.5 font-semibold">
                        <div class="flex items-center gap-2">
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Attex</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="ri-arrow-right-s-line text-base text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400">Project</a>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="ri-arrow-right-s-line text-base text-slate-400 rtl:rotate-180"></i>
                            <a href="#" class="text-sm font-medium text-slate-700 dark:text-slate-400" aria-current="page">Project Detail</a>
                        </div>
                    </div>
                </div>
                <!-- Page Title End -->

                <div class="grid xl:grid-cols-3 gap-6">

                    <div class="xl:col-span-2">

                        <div class="card mb-6">
                            <div class="p-6">

                                <div class="mb-4">
                                    <input class="form-checkbox rounded text-primary" type="checkbox" id="customckeck1" checked>
                                    <label class="ms-1.5" for="customckeck1">Mark as completed</label>
                                </div>

                                <h4 class="text-base font-medium">Simple Admin Dashboard Template Design</h4>

                                <div class="my-5">
                                    <div class="grid sm:grid-cols-3 gap-3">
                                        <div class="col-span-1">
                                            <p class="text-gray-400">Assigned To</p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <img src="assets/images/users/avatar-2.jpg" alt="" class="h-6 rounded-full">
                                                <div class="">
                                                    <h5 class="font-medium">Jonathan Andrews</h5>
                                                </div>
                                            </div>
                                        </div> <!-- col-end -->

                                        <div class="col-span-1">
                                            <p class="text-gray-400">Project Name</p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <i class="ri-briefcase-line text-success text-lg"></i>
                                                <div class="">
                                                    <h5 class="font-medium">Examron Envirenment</h5>
                                                </div>
                                            </div>
                                        </div> <!-- col-end -->

                                        <div class="col-span-1">
                                            <p class="text-gray-400">Due Date</p>
                                            <div class="flex items-center gap-3 mt-1">
                                                <i class="ri-calendar-todo-line text-success text-lg"></i>
                                                <div class="">
                                                    <h5 class="font-medium">Today 10am</h5>
                                                </div>
                                            </div>
                                        </div> <!-- col-end -->
                                    </div> <!-- grid-end -->
                                </div>

                                <h5 class="mb-1">Overview:</h5>
                                <p class="text-gray-400">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer. Some quick example text to build on the card title and make up the bulk of the card's
                                    content. Some quick example text to build on the card title and make up.</p>

                                <div class="mt-8">
                                    <h5 class="mb-2">Checklists/Sub-tasks</h5>
                                    <div class="mb-1">
                                        <input class="form-checkbox rounded text-primary" type="checkbox" id="customckeck1" checked>
                                        <label class="ms-1.5 text-gray-600" for="customckeck1">Find out the old contract documents</label>
                                    </div>
                                    <div class="mb-1">
                                        <input class="form-checkbox rounded text-primary" type="checkbox" id="customckeck1" checked>
                                        <label class="ms-1.5 text-gray-600" for="customckeck1">Organize meeting sales associates to understand need in detail</label>
                                    </div>
                                    <div class="mb-1">
                                        <input class="form-checkbox rounded text-primary" type="checkbox" id="customckeck1" checked>
                                        <label class="ms-1.5 text-gray-600" for="customckeck1">Make sure to cover every small details</label>
                                    </div>
                                </div>

                            </div>
                        </div> <!-- card-end -->

                        <div class="card">
                            <div class="p-6">

                                <h4 class="text-base">Comments (51)</h4>

                                <div class="mt-7">

                                    <div class="flex gap-3">
                                        <img src="assets/images/users/avatar-3.jpg" alt="" class="h-8 rounded-full">
                                        <div class="w-full">
                                            <h5 class="mb-2">Jeremy Tomlinson
                                                <small class="float-right">5 hours ago</small>
                                            </h5>
                                            <p>Nice work, makes me think of The Money Pit.</p>
                                            <a href="javascript: void(0);" class="block mt-2 font-light"><i class="ri-reply-line"></i> Reply</a>
                                            <!-- chat-end -->

                                            <div class="mt-5">
                                                <div class="flex gap-3">
                                                    <img src="assets/images/users/avatar-4.jpg" alt="" class="h-8 rounded-full">
                                                    <div class="w-full">
                                                        <h5 class="mb-2">Thelma Fridley
                                                            <small class="float-right">3 hours ago</small>
                                                        </h5>
                                                        <p>i'm in the middle of a timelapse animation myself! (Very different though.) Awesome stuff.</p>
                                                        <a href="javascript: void(0);" class="block mt-2 font-light"><i class="ri-reply-line"></i> Reply</a>
                                                    </div>
                                                </div>
                                            </div> <!-- chat-end -->
                                        </div>

                                    </div>

                                    <div class="mt-5">
                                        <div class="flex gap-3">
                                            <img src="assets/images/users/avatar-3.jpg" alt="" class="h-8 rounded-full">
                                            <div class="w-full">
                                                <h5 class="mb-2">Kevin Martinez
                                                    <small class="float-right">1 day ago</small>
                                                </h5>
                                                <p>It would be very nice to have.</p>
                                                <a href="javascript: void(0);" class="block mt-2 font-light"><i class="ri-reply-line"></i> Reply</a>
                                            </div>
                                        </div>
                                    </div> <!-- chat-end -->
                                </div>

                                <div class="text-center mt-3">
                                    <a href="javascript:void(0);" class="text-danger"><i class="ri-loader-2-line me-1"></i> Load more </a>
                                </div> <!-- link-end -->

                                <div class="mt-7 border rounded-md">
                                    <textarea rows="3" class="border-0 w-full focus:outline-0 focus:border-0 focus:ring-0" placeholder="Your comment..."></textarea>
                                    <div class="px-3 py-2 bg-gray-50 flex justify-between items-center">
                                        <div>
                                            <a href="#" class="btn btn-sm px-1 hover:bg-light hover:text-slate-900"><i class="ri-upload-line"></i></a>
                                            <a href="#" class="btn btn-sm px-1 hover:bg-light hover:text-slate-900"><i class="ri-at-line"></i></a>
                                        </div>
                                        <button type="submit" class="btn bg-success text-white py-1">Submit</button>
                                    </div>
                                </div> <!-- textarea-end -->

                            </div>
                        </div> <!-- card-end -->

                    </div> <!-- col-end -->

                    <div class="col-span-1">

                        <div class="card">
                            <div class="p-6">

                                <h5 class="card-title text-base mb-3">Attachments</h5>

                                <form action="/" method="post" class="dropzone mb-5" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>

                                    <div class="dz-message needsclick">
                                        <i class="text-4xl text-muted ri-upload-cloud-line"></i>
                                        <h4 class="mt-4">Drop files here or click to upload.</h4>
                                    </div>
                                </form>

                                <div class="border rounded-md border-gray-200 p-3 mb-2 dark:border-gray-600">
                                    <div class="float-right">
                                        <a href="javascript:void(0);" class="btn btn-link">
                                            <i class="ri-download-line text-lg"></i>
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center justify-center bg-primary/10 text-primary font-semibold rounded-md w-12 h-12">
                                            ZIP
                                        </span>
                                        <div>
                                            <a href="javascript:void(0);" class="font-semibold">Attex-sketch-design.zip</a>
                                            <p>2.3 MB</p>
                                        </div>
                                    </div>
                                </div> <!-- border-end -->

                                <div class="border rounded-md border-gray-200 p-3 mb-2 dark:border-gray-600">
                                    <div class="float-right">
                                        <a href="javascript:void(0);" class="btn btn-link">
                                            <i class="ri-download-line text-lg"></i>
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center justify-center bg-primary/10 text-primary font-semibold rounded-md w-12 h-12">
                                            JPG
                                        </span>
                                        <div>
                                            <a href="javascript:void(0);" class="font-semibold">Dashboard-design.jpg</a>
                                            <p>3.25 MB</p>
                                        </div>
                                    </div>
                                </div> <!-- border-end -->

                                <div class="border rounded-md border-gray-200 p-3 mb-2 dark:border-gray-600">
                                    <div class="float-right">
                                        <a href="javascript:void(0);" class="btn btn-link">
                                            <i class="ri-download-line text-lg"></i>
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center justify-center bg-secondary text-white font-semibold rounded-md w-12 h-12">
                                            .MP4
                                        </span>
                                        <div>
                                            <a href="javascript:void(0);" class="font-semibold">Admin-bug-report.mp4</a>
                                            <p>7.05 MB</p>
                                        </div>
                                    </div>
                                </div> <!-- border-end -->
                            </div>
                        </div> <!-- card-end -->

                    </div> <!-- col-end -->

                </div> <!-- grid-end -->
            </main>

            <!-- Footer Start -->
            <footer class="footer h-16 flex items-center px-6 bg-white shadow dark:bg-gray-800 mt-auto">
                <div class="flex md:justify-between justify-center w-full gap-4">
                    <div>
                        <script>document.write(new Date().getFullYear())</script> © Attex - <a href="https://coderthemes.com/" target="_blank">Coderthemes</a>
                    </div>
                    <div class="md:flex hidden gap-4 item-center md:justify-end">
                        <a href="javascript: void(0);" class="text-sm leading-5 text-zinc-600 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">About</a>
                        <a href="javascript: void(0);" class="text-sm leading-5 text-zinc-600 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Support</a>
                        <a href="javascript: void(0);" class="text-sm leading-5 text-zinc-600 transition hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">Contact Us</a>
                    </div>
                </div>
            </footer>
            <!-- Footer End -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    <!-- Theme Settings Offcanvas -->
    <div>
        <div id="theme-customization" class="fc-offcanvas-open:translate-x-0 hidden translate-x-full rtl:-translate-x-full fixed inset-y-0 end-0 transition-all duration-300 transform max-w-72 w-full z-50 bg-white dark:bg-gray-800" tabindex="-1">
            <div class="h-16 flex items-center text-white bg-primary px-6 gap-3">
                <h5 class="text-base flex-grow">Theme Settings</h5>
                <button type="button" data-fc-dismiss><i class="ri-close-line text-xl"></i></button>
            </div>

            <div class="h-[calc(100vh-128px)]" data-simplebar>
                <div class="p-6">
                    <div class="mb-6">
                        <h5 class="font-semibold text-sm mb-3">Theme</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-mode" id="layout-color-light" value="light">
                                <label class="ms-1.5" for="layout-color-light"> Light </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-mode" id="layout-color-dark" value="dark">
                                <label class="ms-1.5" for="layout-color-dark"> Dark </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h5 class="font-semibold text-sm mb-3">Direction</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="dir" id="direction-ltr" value="ltr">
                                <label class="ms-1.5" for="direction-ltr"> LTR </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="dir" id="direction-rtl" value="rtl">
                                <label class="ms-1.5" for="direction-rtl"> RTL </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 2xl:block hidden">
                        <h5 class="font-semibold text-sm mb-3">Content Width</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-layout-width" id="layout-mode-default" value="default">
                                <label class="ms-1.5" for="layout-mode-default"> Fluid </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-layout-width" id="layout-mode-boxed" value="boxed">
                                <label class="ms-1.5" for="layout-mode-boxed"> Boxed </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h5 class="font-semibold text-sm mb-3">Sidenav View</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-default" value="default">
                                </label>
                                <label class="ms-1.5" for="sidenav-view-default"> Default </label>
                            </div>                       

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-sm" value="sm">
                                <label class="ms-1.5" for="sidenav-view-sm"> Small </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-md" value="md">
                                <label class="ms-1.5" for="sidenav-view-md"> Compact </label>
                            </div>                      

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-mobile" value="mobile">
                                <label class="ms-1.5" for="sidenav-view-mobile"> Mobile </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-hidden" value="hidden">
                                <label class="ms-1.5" for="sidenav-view-hidden"> Hidden </label>
                            </div>
                        
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-hover" value="hover">
                                <label class="ms-1.5" for="sidenav-view-hover"> Hover </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-sidenav-view" id="sidenav-view-hover-active" value="hover-active">
                                <label class="ms-1.5" for="sidenav-view-hover-active"> Hover Active </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h5 class="font-semibold text-sm mb-3">Menu Color</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-menu-color" id="menu-color-light" value="light">
                                <label class="ms-1.5" for="menu-color-light"> Light </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-menu-color" id="menu-color-dark" value="dark">
                                <label class="ms-1.5" for="menu-color-dark"> Dark </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-menu-color" id="menu-color-brand" value="brand">
                                <label class="ms-1.5" for="menu-color-brand"> Brand </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h5 class="font-semibold text-sm mb-3">Topbar Color</h5>
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-topbar-color" id="topbar-color-light" value="light">
                                <label class="ms-1.5" for="topbar-color-light"> Light </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-topbar-color" id="topbar-color-dark" value="dark">
                                <label class="ms-1.5" for="topbar-color-dark"> Dark </label>
                            </div>

                            <div class="flex items-center">
                                <input class="form-switch form-switch-sm" type="checkbox" name="data-topbar-color" id="topbar-color-brand" value="brand">
                                <label class="ms-1.5" for="topbar-color-brand"> Brand </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h5 class="font-semibold text-sm mb-3">Layout Position</h5>

                        <div class="flex btn-radio">
                            <input type="radio" class="form-radio hidden" name="data-layout-position" id="layout-position-fixed" value="fixed">
                            <label class="btn rounded-e-none bg-gray-100 dark:bg-gray-700" for="layout-position-fixed">Fixed</label>
                            <input type="radio" class="form-radio hidden" name="data-layout-position" id="layout-position-scrollable" value="scrollable">
                            <label class="btn rounded-s-none bg-gray-100 dark:bg-gray-700" for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-16 p-4 flex items-center gap-4 border-t border-gray-300 dark:border-gray-600 px-6">
                <button type="button" class="btn bg-primary text-white w-1/2" id="reset-layout">Reset</button>
                <button type="button" class="btn bg-light text-dark dark:text-light dark:bg-opacity-10 w-1/2">Buy Now</button>
            </div>
        </div>
    </div>

    <!-- Plugin Js -->
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/lucide/umd/lucide.min.js"></script>
    <script src="assets/libs/@frostui/tailwindcss/frostui.js"></script>

    <!-- App Js -->
    <script src="assets/js/app.js"></script>

    <!-- Dropzone js -->
    <script src="assets/libs/dropzone/min/dropzone.min.js"></script>

    <!-- init js -->
    <script src="assets/js/pages/component.fileupload.js"></script>

</body>

</html>