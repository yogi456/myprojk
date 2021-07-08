<template>
    <aside class="app-sidebar pos-rel" v-bind:class="[{ 'menu-win-show': openSidebarWindow }, { 'open-sub-menu': parmanentSubMenuWindow }]">
        <nav class="side-navbar shrink d-flex">
            <div class="side-navbar-wrapper">
                <div class="sidenav-header d-flex align-items-center justify-content-center">
                    <div class="sidenav-header-inner text-center w-100">
                        <a href="/" class="ml-5 p-0 d-inline">
                            <img v-bind:src="siteUrl + '/images/logo1.png'" alt="person" class="img-fluid rounded-circle" />
                        </a>
                    </div>
                </div>
                <div class="main-menu">
                    <ul id="side-main-menu" class="side-menu list-unstyled">
                        <li class="conversation-menu">
                            <a class="side-menu-icon" href="javascript:void(0)" data-list="Conversation">
                                <i class="fa fa-comments-o" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="channel-menu">
                            <a class="side-menu-icon" href="javascript:void(0)" data-list="Channel">
                                <i class="fa fa-comments-o" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="contact-menu">
                            <a class="side-menu-icon" href="javascript:void(0)" data-list="Sales">
                                <i class="fa fa-ticket" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="report-menu">
                            <a vhref="javascript:void(0)" class="side-menu-icon" data-list="Report">
                                <i class="fa fa-comments-o"></i>
                            </a>
                        </li>

                        <li class="mt-auto" v-show="currentUser.id == 1">
                            <a class="side-menu-icon px-3" v-bind:href="siteUrl + 'admin-sms'" data-list="blank">
                                <img class="img-fluid" v-bind:src="siteUrl + 'images/sms-bubble.png'" />
                            </a>
                        </li>

                        <li v-bind:class="{ 'mt-auto': currentUser.id != 1 }">
                            <a class="side-menu-icon" href="javascript:void(0)" data-list="System">
                                <i class="fa fa-cog" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="mb-5">
                            <a href="javascript:void(0)" class="side-menu-icon" data-list="Addon">
                                <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-window">
                <div class="sidebar-window-inner">
                    <div v-show="sideWin.Conversation" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">Conversation Center</h2>
                        <ul class="list-unstyled" data-list="Conversation">
                            <li>
                                <a v-bind:href="siteUrl + 'conversation-hub'" class="sm-link">
                                    <span class="sm-link-text">Inbox</span>
                                </a>
                            </li>
                            <li v-if="isPermission('bots')">
                                <a v-bind:href="siteUrl + 'bots'" class="sm-link">
                                    <span class="sm-link-text">Bots</span>
                                </a>
                            </li>
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl + 'collaboration'">
                                    <span class="sm-link-text">Team Messaging</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div v-show="sideWin.Channel" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">Conversation Tools</h2>
                        <ul class="list-unstyled" data-list="Channel">
                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Marketing</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('playbooks_view', 'playbook?sub=sms')" v-if="isPermission('playbooks_view')">
                                            <span class="sm-link-text">Playbooks SMS</span>
                                        </a>
                                        <!-- <a class="dropdown-item sm-link" v-bind:href="addLink('playbooks_view', 'playbook?sub=email')" v-if="isPermission('playbooks_view')">
                                            <span class="sm-link-text">Playbooks Email</span>
                                        </a> -->
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('playbooks_view', 'playbook?sub=facebook')" v-if="isPermission('playbooks_view')">
                                            <span class="sm-link-text">Facebook Ads</span>
                                        </a>
                                        <a class="sm-link" v-bind:href="addLink('chat_settings', 'triggers')" v-if="isPermission('chat_settings')">
                                            <span class="sm-link-text">Forms</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Sales</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <ul class="dropdown-ul">
                                            <li class="list-item" v-if="isPermission('playbooks_view')">
                                                <a class="sm-link" v-bind:href="addLink('playbooks_view', 'playbook?sub=email')">
                                                    <span class="sm-link-text">Playbooks Email</span>
                                                </a>
                                            </li>
                                            <li class="list-item">
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                                        <span class="sm-link-text">Scheduling</span>
                                                    </button>
                                                    <div class="dropdown-menu pos-stt">
                                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'appointments?sub=calendar'">
                                                            <span class="sm-link-text">Calendar</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'appointments?sub=type'">
                                                            <span class="sm-link-text">Event Type</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'appointments?sub=events'">
                                                            <span class="sm-link-text">Events</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'appointments?sub=tasks'">
                                                            <span class="sm-link-text">Tasks</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Support</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="sm-link" v-bind:href="siteUrl + 'ticket'">
                                            <span class="sm-link-text">Tickets</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'knowledgebase?sub=documents'">
                                            <span class="sm-link-text">Documents</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="side-menu-group text-left" v-show="sideWin.Sales">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">CRM</h2>
                        <ul class="list-unstyled" data-list="Sales">
                            <li v-if="isPermission('contacts_view')">
                                <a class="sm-link" v-bind:href="siteUrl + 'contact'">
                                    <span class="sm-link-text">Contacts</span>
                                </a>
                            </li>
                            <li v-if="isPermission('companies_view')">
                                <a class="sm-link" v-bind:href="siteUrl + 'companies'">
                                    <span class="sm-link-text">Companies</span>
                                </a>
                            </li>
                            <li v-if="isPermission('deal_view')">
                                <a class="sm-link" v-bind:href="siteUrl + 'deals'">
                                    <span class="sm-link-text">Deals</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="side-menu-group text-left" v-show="sideWin.Report">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">Reports</h2>
                        <ul class="list-unstyled" data-list="Report">
                            <li v-if="isPermission('reports_access')">
                                <a class="sm-link" v-bind:href="siteUrl + 'reports?sub=features'">
                                    <span class="sm-link-text">Ngagge Metrics</span>
                                </a>
                            </li>
                            <li v-if="isPermission('trend_alerts_access')">
                                <a class="sm-link" v-bind:href="siteUrl + 'reports?sub=trend_alerts'">
                                    <span class="sm-link-text">Trend Alerts</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="side-menu-group text-left" v-show="sideWin.System">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">Settings</h2>
                        <ul class="list-unstyled" data-list="System">
                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Company</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=profile'" v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Profile</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=departments'" v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Departments</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=websites'" v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Websites</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=prod_serv'">
                                            <span class="sm-link-text">Product/Service</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=role_permission'" v-if="isPermission('company_roles_and_permissions_setup')">
                                            <span class="sm-link-text">Roles & Permissions</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'company?sub=teammates'" v-if="isPermission('company_teammates_invite_edit_and_delete')">
                                            <span class="sm-link-text">Teammates</span>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Conversation Center</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <ul class="dropdown-ul">
                                            <li class="list-item" v-if="isPermission('chat_settings')">
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" v-bind:class="{ disabled: !manageDisabled('chat_settings') }">
                                                        <span class="sm-link-text">Chat</span>
                                                    </button>
                                                    <div class="dropdown-menu pos-stt">
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'code')">
                                                            <span class="sm-link-text">Code</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'button-design')">
                                                            <span class="sm-link-text">Design</span>
                                                        </a>
                                                        <a v-bind:href="addLink('chat_settings', 'chat-scheduling')" class="dropdown-item sm-link">
                                                            <span class="sm-link-text">Business Hours</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'scripts')">
                                                            <span class="sm-link-text">Scripts</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'banned-visitor')">
                                                            <span class="sm-link-text">Banned Visitors</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-item" v-if="isPermission('email_settings')">
                                                <div class="dropdown">
                                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown" v-bind:class="{ disabled: !manageDisabled('email_settings') }">
                                                        <span class="sm-link-text">Email</span>
                                                    </button>
                                                    <div class="dropdown-menu pos-stt">
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=address_selection')">
                                                            <span class="sm-link-text">Address Selection</span>
                                                        </a>
                                                        <a v-if="false" class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=auto_response')">
                                                            <span class="sm-link-text">Auto Response</span>
                                                        </a>
                                                        <a v-if="false" class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=shared')">
                                                            <span class="sm-link-text">Forward Email</span>
                                                        </a>
                                                        <a class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=transfer')">
                                                            <span class="sm-link-text">Transfer</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="list-item" v-if="isPermission('facebook_messenger_settings')">
                                                <a class="sm-link" v-bind:href="addLink('facebook_messenger_settings', 'facebook?sub=messenger')">
                                                    <span class="sm-link-text text-dgray">Messenger</span>
                                                </a>
                                            </li>
                                            <li class="list-item" v-if="isPermission('routing_set_up')">
                                                <a class="sm-link" v-bind:href="addLink('routing_set_up', 'routing')">
                                                    <span class="sm-link-text">Routing</span>
                                                </a>
                                            </li>
                                            <li class="list-item" v-if="isPermission('monitoring_access')">
                                                <a class="sm-link" v-bind:href="addLink('monitoring_access', 'visitor')">
                                                    <span class="sm-link-text">Monitoring</span>
                                                </a>
                                            </li>
                                            <li class="list-item" v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                                <a class="sm-link" v-bind:href="addLink('chat_settings', 'shortcuts')">
                                                    <span class="sm-link-text">Shortcuts</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>

                            <li class="list-item" v-if="isPermission('knowledgebase_website_help_center_setup')">
                                <a class="sm-link" v-bind:href="siteUrl + 'knowledgebase?sub=whc'">
                                    <span class="sm-link-text text-dgray">Website Help Center</span>
                                </a>
                            </li>

                            <li class="list-item">
                                <a class="sm-link" v-bind:href="siteUrl + 'notifications'">
                                    <span class="sm-link-text text-dgray">Notifications</span>
                                </a>
                            </li>

                            <li class="list-item">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Security</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'settings?sub=login'">
                                            <span class="sm-link-text">Two Factor Authentication</span>
                                        </a>

                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl + 'settings?sub=data'">
                                            <span class="sm-link-text">Data</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- <li class="list-item">
                                <a class="sm-link" v-bind:href="siteUrl + 'features'">
                                    <span class="sm-link-text text-dgray">Feature Display</span>
                                </a>
                            </li> -->
                            <li class="list-item">
                                <a class="sm-link" v-bind:href="siteUrl + 'integrations'">
                                    <span class="sm-link-text text-dgray">Integrations</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="side-menu-group text-left" v-show="sideWin.Addon">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap">Optional Services</h2>
                        <ul class="list-unstyled" data-list="Addon">
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl + 'addons?sub=featured'">
                                    <span class="sm-link-text">Services</span>
                                </a>
                            </li>
                            <li v-if="isPermission('my_add_ons_access')">
                                <a class="sm-link" v-bind:href="siteUrl + 'addons?sub=myaddon'">
                                    <span class="sm-link-text">My Services</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </aside>
</template>
<script>
import { site_root } from "../../Utitlity.js";
export default {
    name: "default-Subscriber-Sidebar",
    data() {
        return {
            siteUrl: site_root,
            userRolePermissions: [],
            modalTitle: "",
            btnmodalText: "",
            currentUser: {},
            openSidebarWindow: false,
            sideWinSystem: false,
            sideWinSupport: false,
            sideWinCollaboration: false,
            sideWinConversation: false,
            sideWinMarketing: false,
            sideWinSales: false,
            sideWin: [
                {
                    Conversation: false,
                    Channel: false,
                    Marketing: false,
                    Sales: false,
                    Support: false,
                    Collaboration: false,
                    Report: false,
                    System: false,
                    Addon: false,
                },
            ],
            sideWinSubSection: [],
            parmanentSubMenuWindow: false,
            features: {},
        };
    },
    computed: {},
    components: {},
    watch: {
        openSidebarWindow: function(newValue) {
            if (!newValue) {
                this.resetFooterButtonWidth();
            } else {
            }
        },
    },
    methods: {
        getFeatures() {
            const thisObj = this;
            axios
                .post(thisObj.siteUrl + "get-subscriber-features")
                .then(function(response) {
                    if (response.data != "500") {
                        thisObj.features = {};
                        thisObj.features = response.data;
                    }
                })
                .catch(function(error) {
                    console.error(error.message);
                });
        },
        getUserRolePermissions: function() {
            const thisObj = this;
            axios
                .get(thisObj.siteUrl + "get-user-role-permission")
                .then(function(response) {
                    if (response.data && response.data.status == "success") thisObj.userRolePermissions = response.data.userRolePermissions;
                })
                .catch(function(error) {
                    console.error(error.message);
                });
        },
        addLink(permission_key, link_url) {
            const thisObj = this;
            let return_value = "javascript:void(0);";
            $.each(thisObj.userRolePermissions, function(role_permission_key, role_permission_value) {
                if (role_permission_value.permission_slug == permission_key && role_permission_value.status == true) return_value = thisObj.siteUrl + link_url;
            });
            return return_value;
        },
        manageDisabled(permission_key) {
            const thisObj = this;
            let return_value = true;
            $.each(thisObj.userRolePermissions, function(role_permission_key, role_permission_value) {
                if (role_permission_value.permission_slug == permission_key) return_value = role_permission_value.status;
            });
            return return_value;
        },
        isPermission(permission_key) {
            const thisObj = this;
            let return_value = false;
            $.each(thisObj.userRolePermissions, function(role_permission_key, role_permission_value) {
                if (role_permission_value.permission_slug == permission_key) return_value = role_permission_value.status;
            });
            return return_value;
        },
        makeAllSubMenuHide: function() {
            var thisObject = this;
            for (var obj in thisObject.sideWin) {
                if (thisObject.sideWin.hasOwnProperty(obj)) {
                    for (var prop in thisObject.sideWin[obj]) {
                        thisObject.sideWin[prop] = false;
                    }
                }
            }
            thisObject.$forceUpdate();
        },

        activeLeftMenuLink: function() {
            var thisObject = this;
            ///thisObject.loadProductWiseMenuData();
            var current = location;
            var currentUrlString = String(current).split("/");
            var urlLast = currentUrlString[currentUrlString.length - 1];
            setTimeout(function() {
                $("#side-main-menu a").each(function() {
                    if ($(this).attr("href") == current || $(this).attr("href") + "#" == current) {
                    }
                });
                $(".app-sidebar a").each(function(ev) {
                    var innThisObj = $(this);
                    setTimeout(function() {
                        if (innThisObj.attr("href") == current || innThisObj.attr("href") + "#" == current) {
                            var obj = $("#side-main-menu a[data-list=" + innThisObj.parents("ul").data("list") + "]");
                            innThisObj.addClass("active");
                            innThisObj.parent(".dropdown-menu").addClass("aside-dd-show");
                            obj.parent("li").addClass("active-page");
                            thisObject.sideWin[innThisObj.parents("ul").data("list")] = true;
                            return 0;
                        }
                    }, 50);
                });
                if (urlLast[urlLast.length - 1] == "#") {
                    urlLast = urlLast.slice(0, -1);
                }
            }, 1500);
        },

        consoleWindowViewChange: function(winCount) {
            jQuery("#consoleWinSlider").slick("destroy");
            var defaultDetailWidth = 321;
            if (winCount == "1") {
                defaultDetailWidth = 356;
            }
            setTimeout(function() {
                jQuery("#consoleWinSlider").slick({
                    infinite: false,
                    draggable: false,
                    slidesToShow: winCount,
                    slidesToScroll: 1,
                    prevArrow: $(".btn-console-slider-prev"),
                    nextArrow: $(".btn-console-slider-next"),
                });
                $(".chat-window-part").css({
                    "flex-basis": "calc(100% - " + defaultDetailWidth + "px)",
                });
                $(".chat-detail-part").css({
                    "flex-basis": "calc(" + (defaultDetailWidth - 6) + "px)",
                });
            }, 1);
        },
        resetFooterButtonWidth: function() {
            var current = location;
            var currentUrlString = String(current).split("/");
            var urlLast = currentUrlString[currentUrlString.length - 1];
            if (urlLast == "playbook") {
                setTimeout(function() {
                    $(".footer-action-wrapper").css({
                        "max-width": $(window).width() - $(".app-sidebar").width(),
                        left: "auto",
                        right: "0",
                    });
                }, 500);
            }
        },
    },
    mounted: function() {
        var thisObject = this;
        thisObject.activeLeftMenuLink();
        thisObject.getFeatures();
        thisObject.getUserRolePermissions();

        //            $('#side-main-menu').on('click', 'li.active-page > a', function () {
        //                $('#side-main-menu li').removeClass('active-page');
        //                $(this).parents('li').addClass('active-page');
        //                if ($(this).data('list') != 'blank') {
        //                    thisObject.parmanentSubMenuWindow = true;
        //                } else {
        //                    thisObject.parmanentSubMenuWindow = false;
        //                }
        //                thisObject.makeAllSubMenuHide();
        //                thisObject.sideWin[$(this).attr('data-list')] = true;
        //            });

        $("body").on("click", ".btn-op-sub-menu", function() {
            //console.log('==>' + $("li.active-page > a").attr("data-list"));
            if ($(".app-sidebar").hasClass("open-sub-menu")) {
                thisObject.makeAllSubMenuHide();
                thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = false;
                $("body").removeClass("side-menu-open");
            } else {
                if ($("li.active-page > a").data("list") != "blank") {
                    thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = true;
                    $("body").addClass("side-menu-open");
                } else {
                    thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = false;
                    $("body").removeClass("side-menu-open");
                }
                thisObject.makeAllSubMenuHide();
                thisObject.sideWin[$("li.active-page > a").attr("data-list")] = true;
            }
        });
        $(".side-menu-icon").mouseenter(function() {
            //// alert("TEST ENTER");
            if ($(this).attr("data-list") != "blank") {
                thisObject.openSidebarWindow = true;
                thisObject.makeAllSubMenuHide();
                thisObject.sideWin[$(this).attr("data-list")] = true;
            } else {
                thisObject.openSidebarWindow = false;
                thisObject.makeAllSubMenuHide();
                if ($(".app-sidebar").hasClass("open-sub-menu")) {
                    thisObject.openSidebarWindow = thisObject.sideWin[$("#side-main-menu li.active-page > a").data("list")] = true;
                }
            }
            thisObject.$forceUpdate();
        });
        $(".app-sidebar").mouseleave(function() {
            if (!$(".app-sidebar").hasClass("open-sub-menu")) {
                thisObject.openSidebarWindow = false;
            } else {
                thisObject.makeAllSubMenuHide();
                thisObject.openSidebarWindow = thisObject.sideWin[$("#side-main-menu li.active-page > a").data("list")] = true;
            }
        });
        var setWinView = setInterval(function() {
            if ($(".btn-grid-console").attr("data-view") === "2") {
                if (!$(".app-sidebar").hasClass("open-sub-menu")) {
                    thisObject.openSidebarWindow = false;
                }
                clearInterval(setWinView);
            }
        }, 400);
        $(".side-menu-icon[data-list]").mouseenter(function() {
            if ($("#consoleWinSlider").attr("data-view") == 1) {
                ////alert("TTTTT");
                thisObject.consoleWindowViewChange($("#consoleWinSlider").attr("data-view"));
            }
            thisObject.resetFooterButtonWidth();
        });
        $("body").on("click", ".sidebar-window .dropdown-toggle", function() {
            $(".aside-dd-show").removeClass("aside-dd-show");
            $(this)
                .siblings(".dropdown-menu")
                .addClass("aside-dd-show");
        });
        $("body").on("click", ".dropdown-menu", function(e) {
            e.stopPropagation();
        });
        setTimeout(function() {
            thisObject.resetFooterButtonWidth();
        }, 1000);

        axios
            .get(thisObject.siteUrl + "user/get-loggedin-user")
            .then(function(response) {
                thisObject.currentUser = response.data;
                thisObject.loaded = 1;
            })
            .catch(function(error) {
                console.error(error.message);
            });
    },
    props: [],
};
</script>
<style scoped>
.dropdown-ul {
    background-color: rgb(245, 247, 250);
}
</style>
