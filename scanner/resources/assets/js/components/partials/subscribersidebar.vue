<template>
    <aside class="app-sidebar pos-rel" v-bind:class="[{'menu-win-show':openSidebarWindow},{'open-sub-menu':parmanentSubMenuWindow}]">
        <nav class="side-navbar shrink d-flex" > 
            <div class="side-navbar-wrapper">
                <div class="sidenav-header d-flex align-items-center justify-content-center">
                    <div class="sidenav-header-inner text-center w-100">
                        <a href="/" class="ml-5 p-0 d-inline">
                            <img v-bind:src="siteUrl+'/images/logo1.png'" alt="person" class="img-fluid rounded-circle"  />
                        </a>
                    </div>
                </div>

                <div class="main-menu">
                   <ul id="side-main-menu" class="side-menu list-unstyled">
                        <li v-for="subscriberMenuDataVal in subscriberMenuData" v-bind:key="subscriberMenuDataVal.id" :class="subscriberMenuDataVal.class_name">
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'home'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-home" aria-hidden="true" ></i>   
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'inbox'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-inbox" aria-hidden="true"></i>   
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'crm'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-bullhorn" aria-hidden="true"></i> 
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'bots'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-comments-o" aria-hidden="true" ></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'playbook_email'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-envelope-square" aria-hidden="true"></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'reports'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'setting'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-cog" aria-hidden="true"></i> 
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'addons'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-puzzle-piece" aria-hidden="true"></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'collect_subscribers'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-book" aria-hidden="true"></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'automation'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-tasks" aria-hidden="true"></i>    
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'ticket' && features.help_center  && isPermission('help_center_all')" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-ticket" aria-hidden="true" ></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'knowledgebase'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-info-circle" aria-hidden="true" v-if="subscriberMenuDataVal.menu_slug == 'knowledgebase'"></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'playbooks_email'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-inbox" aria-hidden="true" ></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'forms'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-wpforms" aria-hidden="true" ></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'facebook_ads'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-facebook-square" aria-hidden="true" ></i>  
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'team_messaging'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                               <i class="fa fa-users"></i>
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'team_suggestions'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'trend_alerts'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-bell" aria-hidden="true"></i>
                            </a>
                            <a :title="subscriberMenuDataVal.menu_name" v-if="subscriberMenuDataVal.menu_slug == 'scheduling'" :href="subscriberMenuDataVal.link" :class="subscriberMenuDataVal.sub_class_name" :data-list="subscriberMenuDataVal.data_list"  @mouseenter="checkhover(subscriberMenuDataVal.data_list,subscriberMenuDataVal.has_dropdown,subscriberMenuDataVal.show_features)" >
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="sidebar-window" >
                <div class="sidebar-window-inner">
                    <div v-show="sideWin.crm" class="side-menu-group text-left" v-if="checkSubmenuPermission.crm">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >CRM </h2>
                        <ul class="list-unstyled" data-list="crm" >
                            <li v-if="features.contact_crm && isPermission('contacts_view') && checkSubmenuPermission.contact_crm">
                                <a  class="dropdown-item sm-link" v-bind:href="siteUrl+'contact'">
                                    <span class="sm-link-text">Contacts</span>
                                </a>
                            </li>
                            <li v-if="features.companies && isPermission('companies_view') && checkSubmenuPermission.companies">
                                <a class="dropdown-item sm-link" v-bind:href="siteUrl+'companies'">
                                    <span class="sm-link-text">Companies</span>
                                </a>
                            </li>
                            <li v-if="features.deals && isPermission('deal_view') && checkSubmenuPermission.deals">
                                <a  class="dropdown-item sm-link" v-bind:href="siteUrl+'deals'">
                                    <span class="sm-link-text">Deals  </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- <div v-show="sideWin.bots" class="side-menu-group text-left" v-if="checkSubmenuPermission.bots">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >BOTS </h2>
                        <ul class="list-unstyled" data-list="bots" >
                            <li v-if="checkSubmenuPermission.chats">
                                <a  class="dropdown-item sm-link" v-bind:href="siteUrl+'contact'">
                                    <span class="sm-link-text">Chats</span>
                                </a>
                            </li>
                            <li v-if="features.playbook_sms && checkSubmenuPermission.playbook_sms">
                                <a  class="dropdown-item sm-link"  v-bind:href="addLink('playbooks_view', 'playbook?sub=sms')">
                                    <span class="sm-link-text">SMS</span>
                                </a>
                            </li>
                            <li v-if="checkSubmenuPermission.whatsapp">
                                <a  class="dropdown-item sm-link"  v-bind:href="addLink('playbooks_view', 'playbook?sub=sms')">
                                    <span class="sm-link-text">Whatsapp</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div> -->

                    <div v-show="sideWin.knowledgebase" class="side-menu-group text-left" v-if="checkSubmenuPermission.knowledgebase">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >Knowledgebase </h2>
                        <ul class="list-unstyled" data-list="knowledgebase" >
                            
                            <li v-if="checkSubmenuPermission.documents">
                                <a  class="dropdown-item sm-link" v-bind:href="siteUrl+'knowledgebase?sub=documents'">
                                    <span class="sm-link-text">Documents</span>
                                </a>
                            </li>
                            <li v-if="checkSubmenuPermission.website_help_center && isPermission('knowledgebase_website_help_center_setup')">
                                <a class="dropdown-item sm-link" v-bind:href="siteUrl+'knowledgebase?sub=whc'">
                                    <span class="sm-link-text">Website Help Center</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div v-show="sideWin.setting" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                        >Settings</h2>
                        <ul class="list-unstyled" data-list="setting">
                            <li class="list-item" v-if="checkSubmenuPermission.company">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel"
                                        data-toggle="dropdown">
                                        <span class="sm-link-text">Company</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=profile'"
                                            v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Profile</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=departments'"
                                            v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Departments</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=websites'"
                                            v-if="isPermission('company_profile_departments_websites_payment_processing')">
                                            <span class="sm-link-text">Websites</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=prod_serv'">
                                            <span class="sm-link-text">Product/Service</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=role_permission'"
                                            v-if="isPermission('company_roles_and_permissions_setup')">
                                            <span class="sm-link-text">Roles & Permissions</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="siteUrl+'company?sub=teammates'" v-if="isPermission('company_teammates_invite_edit_and_delete')">
                                            <span class="sm-link-text">Teammates</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                                                            
                            <li class="list-item" v-if="features.chat && isPermission('chat_settings') && checkSubmenuPermission.chat_setting">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Chat</span>
                                    </button> 
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'code')" v-if="checkSubmenuPermission.code">
                                            <span class="sm-link-text">Code</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'button-design')" v-if="checkSubmenuPermission.button_design">
                                            <span class="sm-link-text">Design</span>
                                        </a>
                                        <a v-bind:href="addLink('chat_settings', 'chat-scheduling')" class="dropdown-item sm-link" v-if="checkSubmenuPermission.buness_hour">
                                            <span class="sm-link-text">Business Hours</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'scripts')" v-if="checkSubmenuPermission.scripts">
                                            <span class="sm-link-text">Scripts</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'banned-visitor')" v-if="checkSubmenuPermission.banned_visitor">
                                            <span class="sm-link-text">Banned Visitors</span>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="list-item" v-if="checkSubmenuPermission.inboxes">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel" data-toggle="dropdown">
                                        <span class="sm-link-text">Inbox</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a v-bind:href="addLink('routing_set_up', 'routing')" class="dropdown-item sm-link" v-if="checkSubmenuPermission.routing">
                                            <span class="sm-link-text">Routing</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('chat_settings', 'shortcuts')" v-if="checkSubmenuPermission.shortcuts">
                                            <span class="sm-link-text">Shortcuts</span>
                                        </a>
                                        <a class="dropdown-item sm-link"  v-bind:href="addLink('monitoring_access', 'visitor')" v-if="isPermission('monitoring_access') && checkSubmenuPermission.monitoring">
                                            <span class="sm-link-text">Monitoring</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="list-item" v-if="checkSubmenuPermission.notifications">
                                <a class="sm-link" v-bind:href="siteUrl+'notifications'">
                                    <span class="sm-link-text text-dgray">Notifications</span>
                                </a>
                            </li>

                            <li class="list-item" v-if="checkSubmenuPermission.integration">
                                <a class="sm-link" v-bind:href="siteUrl+'integrations'">
                                    <span class="sm-link-text text-dgray">Integrations</span>
                                </a>
                            </li>
                                                            
                            <li class="list-item" v-if="checkSubmenuPermission.transfer || checkSubmenuPermission.address_selection">
                                <div class="dropdown">
                                    <button type="button" class="btn dropdown-toggle text-xdgray border-0 px-0 sm-link pos-rel"
                                        data-toggle="dropdown">
                                        <span class="sm-link-text">Email</span>
                                    </button>
                                    <div class="dropdown-menu pos-stt">
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=address_selection')" v-if="checkSubmenuPermission.address_selection">
                                            <span class="sm-link-text">Address Selection</span>
                                        </a>
                                        <a class="dropdown-item sm-link" v-bind:href="addLink('email_settings', 'ticket-email?sub=transfer')" v-if="checkSubmenuPermission.transfer">
                                            <span class="sm-link-text">Transfer</span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            
                            <li class="list-item" v-if="isPermission('facebook_messenger_settings') && checkSubmenuPermission.messenger">
                                <a class="sm-link" v-bind:href="addLink('facebook_messenger_settings', 'facebook?sub=messenger')">
                                    <span class="sm-link-text text-dgray">Messenger</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div v-show="sideWin.addons" v-if="checkSubmenuPermission.featured && checkSubmenuPermission.my_addon" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >Addons </h2>
                        <ul class="list-unstyled" data-list="addons" >
                            <li v-if="checkSubmenuPermission.featured">
                                <a class="sm-link" v-bind:href="siteUrl+'addons?sub=featured'">
                                    <span class="sm-link-text">Featured</span>
                                </a>
                            </li>
                            <li v-if="isPermission('my_add_ons_access') && checkSubmenuPermission.my_addon">
                                <a class="sm-link" v-bind:href="siteUrl+'addons?sub=myaddon'">
                                    <span class="sm-link-text">My Services</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div v-show="sideWin.automation" v-if="checkSubmenuPermission.automation" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >Automation </h2>
                        <ul class="list-unstyled" data-list="automation">
                            <li v-if="checkSubmenuPermission.compaigns">
                                <a class="sm-link" v-bind:href="siteUrl+'addons?sub=featured'">
                                    <span class="sm-link-text">Campaigns</span>
                                </a>
                            </li>
                            <li v-if="checkSubmenuPermission.playbooks">
                                <a class="sm-link" v-bind:href="siteUrl+'addons?sub=myaddon'">
                                    <span class="sm-link-text">Playbooks</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    
                    <div v-show="sideWin.scheduling" v-if="checkSubmenuPermission.scheduling" class="side-menu-group text-left">
                        <h2 class="fs-18 fw-600 text-black border-bottom pb-3 d-flex align-items-center text-nowrap"
                            >Scheduling </h2>
                        <ul class="list-unstyled" data-list="scheduling">
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl+'appointments?sub=type'">
                                    <span class="sm-link-text">Event type</span>
                                </a>
                            </li>
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl+'appointments?sub=events'">
                                    <span class="sm-link-text">Events</span>
                                </a>
                            </li>
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl+'appointments?sub=tasks'">
                                    <span class="sm-link-text">Tasks</span>
                                </a>
                            </li>
                            <li>
                                <a class="sm-link" v-bind:href="siteUrl+'appointments?sub=calendar'">
                                    <span class="sm-link-text">Calendar</span>
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
        name: "subscriber-Sidebar",
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
                        crm: false,
                        Conversation: false,
                        Channel: false,
                        Marketing: false,
                        Sales: false,
                        Support: false,
                        Collaboration: false,
                        Report: false,
                        System: false,
                        Addon: false,
                        setting:false
                    }
                ],
                sideWinSubSection: [],
                parmanentSubMenuWindow: false,
                features: {},
                checkSubmenuPermission:{
                        crm             :false,
                        contact_crm     :false,
                        companies       :false,
                        deals           :false,
                        chats           :false,
                        chat_setting    :false,
                        featured        :false,
                        my_addon        :false,
                        notifications   :false,
                        integration     :false,
                        routing         :false,
                        shortcuts       :false,
                        code            :false,
                        button_design   :false,
                        buness_hour     :false,
                        scripts         :false,
                        banned_visitor  :false,
                        company         :false,
                        playbook_sms    :false,
                        automation      :false,
                        inboxes         :false,
                        compaigns       :false,
                        playbooks       :false,
                        collect_subscribers:false,
                        bots            :false,
                        whatsapp        :false,
                        playbook_email  :false,
                        knowledgebase   :false,
                        documents       :false,
                        website_help_center  :false,
                        monitoring      :false,

    //////======    INTEGRATION MENU SLUG ======///////
    
                        playbooks_email         :false,
                        facebook_ads            :false,
                        forms                   :false,
                        team_messaging          :false,
                        team_suggestions        :false,
                        trend_alerts            :false,
                        scheduling              :false,
                        event_type              :false,
                        events                  :false,
                        tasks                   :false,
                        calendar                :false,
                        email                   :false,
                        address_selection       :false,
                        transfer                :false,
                        messenger               :false,
                       
                },
            };
        },
        computed: {},
        components: {},
        props: ['subscriberMenuData'],
        watch: {
            openSidebarWindow: function (newValue) {
                if (!newValue) {
                    this.resetFooterButtonWidth();
                } else {
                }
            }
        },
        methods: {
            getFeatures() {
                const thisObj = this;
                axios
                        .post(thisObj.siteUrl + "get-subscriber-features")
                        .then(function (response) {
                            if (response.data != "500") {
                                thisObj.features = {};
                                thisObj.features = response.data;
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            getUserRolePermissions: function () {
                const thisObj = this;
                axios.get(thisObj.siteUrl + "get-user-role-permission")
                        .then(function (response) {
                            if (response.data && response.data.status == "success")
                                thisObj.userRolePermissions = response.data.userRolePermissions;
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            addLink(permission_key, link_url) {
                const thisObj = this;
                let return_value = "javascript:void(0);";
                $.each(thisObj.userRolePermissions, function (role_permission_key, role_permission_value) {
                    if (role_permission_value.permission_slug == permission_key && role_permission_value.status == true)
                        return_value = thisObj.siteUrl + link_url;
                });
                return return_value;
            },
            manageDisabled(permission_key) {
                const thisObj = this;
                let return_value = true;
                $.each(thisObj.userRolePermissions, function (role_permission_key, role_permission_value) {
                    if (role_permission_value.permission_slug == permission_key)
                        return_value = role_permission_value.status;
                });
                return return_value;
            },
            isPermission(permission_key) {  
                const thisObj = this;
                let return_value = false;


                $.each(thisObj.userRolePermissions, function (role_permission_key, role_permission_value) {
                    if (role_permission_value.permission_slug == permission_key)
                        return_value = role_permission_value.status;
                });
                return return_value;
            },
            makeAllSubMenuHide: function () {
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
            
            activeLeftMenuLink: function () {
                var thisObject = this;
                ///thisObject.loadProductWiseMenuData();
                var current = location;
                var currentUrlString = String(current).split("/");
                var urlLast = currentUrlString[currentUrlString.length - 1];
                setTimeout(function () {
                    $("#side-main-menu a").each(function () {
                        if ($(this).attr("href") == current || $(this).attr("href") + "#" == current) {
                        }
                    });
                    $(".app-sidebar a").each(function (ev) {
                        var innThisObj = $(this);
                        setTimeout(function () {
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

            consoleWindowViewChange: function (winCount) {
                jQuery("#consoleWinSlider").slick("destroy");
                var defaultDetailWidth = 321;
                if (winCount == "1") {
                    defaultDetailWidth = 356;
                }
                setTimeout(function () {
                    jQuery("#consoleWinSlider").slick({
                        infinite: false,
                        draggable: false,
                        slidesToShow: winCount,
                        slidesToScroll: 1,
                        prevArrow: $(".btn-console-slider-prev"),
                        nextArrow: $(".btn-console-slider-next")
                    });
                    $(".chat-window-part").css({
                        "flex-basis": "calc(100% - " + defaultDetailWidth + "px)"
                    });
                    $(".chat-detail-part").css({
                        "flex-basis": "calc(" + (defaultDetailWidth - 6) + "px)"
                    });
                }, 1);
            },
            resetFooterButtonWidth: function () {
                var current = location;
                var currentUrlString = String(current).split("/");
                var urlLast = currentUrlString[currentUrlString.length - 1];
                if (urlLast == "playbook") {
                    setTimeout(function () {
                        $(".footer-action-wrapper").css({
                            "max-width": $(window).width() - $(".app-sidebar").width(),
                            left: "auto",
                            right: "0"
                        });
                    }, 500);
                }
            },

            disablecheckSubmenuPermission : function(){
                var thisObject = this;
                var jsonParsedArray = thisObject.checkSubmenuPermission;  /////JSON.parse(thisObject.checkSubmenuPermission);
                for(var key in jsonParsedArray){
                    //if(jsonParsedArray.hasOwnProperty(key)){
                       thisObject.checkSubmenuPermission[key] = false;
                    ///} 
                }

            },
            checkhover: function(eleVal,hasdropdawnVal,showFeatures){
                var thisObject = this;
                thisObject.disablecheckSubmenuPermission();
                if(hasdropdawnVal == 1){
                    thisObject.openSidebarWindow = true;
                    thisObject.makeAllSubMenuHide();
                    
                    thisObject.sideWin[eleVal] = true;

                    
                    if(showFeatures != ""){
                        for(var key in showFeatures){
                           if(thisObject.checkSubmenuPermission.hasOwnProperty(key)){
                                thisObject.checkSubmenuPermission[key] = true;
                            } 
                        }
                    }
                    thisObject.checkSubmenuPermission = JSON.parse(thisObject.checkSubmenuPermission);
                } else{
                    thisObject.openSidebarWindow = false;
                    thisObject.makeAllSubMenuHide();
                    thisObject.sideWin[eleVal] = false;
                }
            },
            /* checkpermission: function(str,chckAttr){
                var res = str.split(",");
                var checkSubmenuPermission = res.includes(chckAttr);
                return rtnVal;
                ///console.log(res);
            }, */
            checkSubMenuPermission(permission_key) {  
                const thisObject = this;
                let return_value = false;
                if(thisObj.checkSubmenuPermission.includes(permission_key)){
                    return return_value;
                }
                ///var i;
                ///console.log(thisObject.checkSubmenuPermission);
                ///for(i=o;i<thisObject.checkSubmenuPermission)
               /*  $.each(thisObj.checkSubmenuPermission, function (role_permission_key, role_permission_value) {
                    if (role_permission_value.permission_slug == permission_key)
                        return_value = role_permission_value.status;
                });
                return return_value; */
            }



        },
        mounted: function () {
            var thisObject = this;
            thisObject.activeLeftMenuLink();
            thisObject.getFeatures();
            thisObject.getUserRolePermissions();
            ////console.log(subscriberMenuData);

            $("body").on("click", ".btn-op-sub-menu", function () {
               //console.log('==>' + $("li.active-page > a").attr("data-list"));
                if ($(".app-sidebar").hasClass("open-sub-menu")) {
                    thisObject.makeAllSubMenuHide();
                    thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = false;
                    $('body').removeClass('side-menu-open');
                } else {
                    if ($("li.active-page > a").data("list") != "blank") {
                        thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = true;
                        $('body').addClass('side-menu-open');
                    } else {
                        thisObject.openSidebarWindow = thisObject.parmanentSubMenuWindow = false;
                        $('body').removeClass('side-menu-open');
                    }
                    thisObject.makeAllSubMenuHide();
                    thisObject.sideWin[$("li.active-page > a").attr("data-list")] = true;
                }
            });
            $(".side-menu-icon").mouseenter(function () {
               //// alert("TEST ENTER");
                if ($(this).attr("data-list") != "blank") {
                    thisObject.openSidebarWindow = true;
                    thisObject.makeAllSubMenuHide();
                    thisObject.sideWin[$(this).attr("data-list")] = true;
                } else {
                    thisObject.openSidebarWindow = false;
                    thisObject.makeAllSubMenuHide();
                    if ($(".app-sidebar").hasClass("open-sub-menu")) {
                        thisObject.openSidebarWindow = thisObject.sideWin[
                                $("#side-main-menu li.active-page > a").data("list")
                        ] = true;
                    }
                }
                thisObject.$forceUpdate();
            });
            $(".app-sidebar").mouseleave(function () {
                if (!$(".app-sidebar").hasClass("open-sub-menu")) {
                    thisObject.openSidebarWindow = false;
                } else {
                    thisObject.makeAllSubMenuHide();
                    thisObject.openSidebarWindow = thisObject.sideWin[
                            $("#side-main-menu li.active-page > a").data("list")
                    ] = true;
                }
            });
            var setWinView = setInterval(function () {
                if ($(".btn-grid-console").attr("data-view") === "2") {
                    if (!$(".app-sidebar").hasClass("open-sub-menu")) {
                        thisObject.openSidebarWindow = false;
                    }
                    clearInterval(setWinView);
                }
            }, 400);
            $(".side-menu-icon[data-list]").mouseenter(function () {
                if ($("#consoleWinSlider").attr("data-view") == 1) {
                    ////alert("TTTTT");
                    thisObject.consoleWindowViewChange(
                            $("#consoleWinSlider").attr("data-view")
                            );
                }
                thisObject.resetFooterButtonWidth();
            });
            $('body').on('click', '.sidebar-window .dropdown-toggle', function () {




                $('.aside-dd-show').removeClass("aside-dd-show");
                $(this).siblings(".dropdown-menu").addClass("aside-dd-show");
            });
            setTimeout(function () {
                thisObject.resetFooterButtonWidth();
            }, 1000);
            
            axios
                    .get(thisObject.siteUrl + "user/get-loggedin-user")
                    .then(function (response) {
                        thisObject.currentUser = response.data;
                        thisObject.loaded = 1;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
        }
    };
</script>