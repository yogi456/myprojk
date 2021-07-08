<template>
    <header class="header pos-rel" v-if="currentUser">
        <nav class="navbar">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center w-100">
                    <!--                    <div class="navbar-header" v-if="currentUser.role_id != 5">
                                                                                    <b-dropdown id="ddown1" v-bind:text="userStatusName" class=" btn-user-status" v-bind:class="{'text-danger':userStatusName=='Away','text-success':userStatusName=='Available'}">
                                                                                        <b-dropdown-item v-if="userStatusName=='Away'" class="text-success" href="" @click="changeUserStatus('Available')">Available</b-dropdown-item>
                                                                                        <b-dropdown-item v-if="userStatusName=='Available'" class="text-danger" href="" @click="changeUserStatus('Away')">Away</b-dropdown-item>
                                                                                    </b-dropdown>
                                                                                </div>-->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-center w-100 lh-1 pl-5 ml-3">
                        <li class="nav-item pr-2 border-right" v-if="btnToggleheaderInfo">
                            <a v-if="currentUser.role_id != 5" class="waiting-chat text-nowrap fs-20 fw-600" href="javascript:void(0);">
                                Chats
                            </a>
                        </li>
                        <li class="nav-item pr-2" v-if="btnToggleheaderInfo">
                            <a v-if="currentUser.role_id != 5" class="waiting-chat text-nowrap fw-600 pl-2" href="javascript:void(0);">
                                Active:<span class="wait-chat-count fw-400 ml-2 notranslate">{{ $store.state.appHeader.self_running }}</span>
                            </a>
                        </li>
                        <li class="nav-item pr-2 ml-0" v-if="btnToggleheaderInfo">
                            <a v-if="currentUser.role_id != 5" class="waiting-chat text-nowrap fw-600 pl-2" href="javascript:void(0);">
                                Queue:<span class="wait-chat-count fw-400 ml-2 notranslate">{{ $store.state.appHeader.incoming }}</span>
                            </a>
                        </li>
                        <li class="nav-item pr-2 ml-0" v-if="btnToggleheaderInfo">
                            <a v-if="currentUser.role_id != 5" class="waiting-chat text-nowrap fw-600 pl-2" href="javascript:void(0);">
                                Agent Capacity:<span class="wait-chat-count fw-400 ml-2 notranslate">{{ $store.state.appHeader.agent_capacity }}</span>
                            </a>
                        </li>
                        <li class="nav-item ml-0" v-if="btnToggleheaderInfo">
                            <a v-if="currentUser.role_id != 5" class="waiting-chat text-nowrap fw-600 pl-2" href="javascript:void(0);">
                                Average Wait Time:<span class="wait-chat-count fw-400 ml-2 notranslate">{{ $store.state.appHeader.average_wait_time }}</span>
                            </a>
                        </li>
                        <li class="nav-item ml-0">
                            <a class="btn text-primary p-3" href="javascript:void(0);" @click="btnToggleheaderInfo = !btnToggleheaderInfo">
                                <i v-if="btnToggleheaderInfo" class="fa fa-angle-double-left fs-24" aria-hidden="true"></i>
                                <i v-else class="fa fa-angle-double-right fs-24" aria-hidden="true"></i>
                            </a>
                        </li>

                        <!--                        <div class="row" style="position: absolute;bottom: 0;/* left: 0; */right: 5rem;height: 5rem;width: 9rem;z-index: 99999;background: transparent;">
                                                    <div class="col-12">
                                                        <div id="google_translate_element"></div>
                                                    </div>
                                                </div>-->
                        <li class="nav-item ml-auto ctt-tooltip" ctt-placement="left" ctt-title="Video Conference">
                            <a href="#" class="nav-link border-0 px-2" data-toggle="modal" data-target="#videoMessageModal" @click="generateLink">
                                <i class="fa fa-video-camera text-orange fs-30" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="nav-item ctt-tooltip" ctt-placement="left" ctt-title="Video Message">
                            <a id="videoRecorder" href="#" class="nav-link border-0 px-2"  data-toggle="modal" data-target="#recordVideoMessageModal">
                                <span></span>
                            </a>
                        </li>
                        <li v-if="currentUser.role_id != 5" class="nav-item  ctt-tooltip" ctt-placement="left" ctt-title="Reminder">
                            <!--<a id="notifications"  href="#" class="nav-link" @click.prevent="activityPage()" data-toggle="modal" data-target="#activityDashboardModal">-->
                            <a id="notifications" href="#" class="nav-link border-0 px-2" @click="refreshRemider()">
                                <img v-bind:src="siteUrl + 'images/activity-icon.png'" width="30" />
                                <span v-if="$store.state.appHeader.reminders > 0" class="h-notify-count bg-danger notranslate">
                                    {{ $store.state.appHeader.reminders < 10 ? $store.state.appHeader.reminders : "9+" }}
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link border-0 px-2 pos-rel" data-toggle="modal" data-target="#headerNotificationModal">
                                <img v-bind:src="siteUrl + 'images/bell-icon.png'" width="25" />
                                <span v-if="userNotifications.length > 0" class="h-notify-count bg-danger notranslate">{{ userNotifications.length < 10 ? userNotifications.length : "9+" }}</span>
                            </a>
                        </li>
                        <li v-if="currentUser.role_id != 5" class="nav-item custm-toggle-dd pos-rel border-right pr-4">
                            <a id="helps" href="#helpsSett" class="nav-link px-2 btn-toggle-dd ml-2">
                                <img v-bind:src="siteUrl + 'images/help-icon.png'" width="14" />
                            </a>
                            <div id="helpsSett" class="p-4 content-toggle-dd setting-acc position-absolute">
                                <div id="helpAccordion" class="btn-accordion py-3 text-nowrap" role="tablist">
                                    <!--                                    <div class="card border-0">
                                                                            <div class="card-header" role="tab" id="it-help-headingOne">
                                                                                <h5 class="mb-0 card-header">
                                                                                    <a class="card-link px-4 text-xxdgray fw-400" data-toggle="collapse" href="#it-help-collapseOne" role="button" aria-expanded="false" aria-controls="">
                                                                                        <span> Tours</span>
                                                                                        <div class="arrow pull-right text-xxdgray pos-stt translate-0-0 ml-2">
                                                                                            <i class="fa fa-angle-down fs-18"></i>
                                                                                        </div>
                                                                                    </a>
                                                                                </h5>
                                                                            </div>
                                                                            <div id="it-help-collapseOne" class="collapse" role="tabpanel" aria-labelledby="it-help-headingOne" data-parent="#helpAccordion">
                                                                                <div class="card-body w-100 p-0">
                                                                                    <ul class="nav flex-column lh-1-4">
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Conversation Hub <span class="fw-400 pull-right">4 min</span></a>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Marketing</a>
                                                                                            <ul class="list-unstyled">
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Chat<span class="fw-400 pull-right">4 min</span></a>
                                                                                                </li>
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Monitoring<span class="fw-400 pull-right">4 min</span></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Sales</a>
                                                                                            <ul class="list-unstyled">
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Contact(CRM)<span class="fw-400 pull-right">2 min</span></a>
                                                                                                </li>
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Playbooks<span class="fw-400 pull-right">3 min</span></a>
                                                                                                </li>
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Scheduling<span class="fw-400 pull-right">1 min</span></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Support</a>
                                                                                            <ul class="list-unstyled">
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Help Center<span class="fw-400 pull-right">1 min</span></a>
                                                                                                </li>
                                                                                                <li class="nav-item">
                                                                                                    <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Knowledgebase<span class="fw-400 pull-right">3 min</span></a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Collaboration <span class="fw-400 pull-right">3 min</span></a>
                                                                                        </li>
                                                                                        <li class="nav-item">
                                                                                            <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Reports<span class="fw-400 pull-right">3 min</span></a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>-->
                                    <div class="card border-0">
                                        <div class="card-header" role="tab" id="it-help-headingTwo">
                                            <h5 class="mb-0 card-header">
                                                <a class="card-link px-4 text-xxdgray fw-400" data-toggle="collapse" href="#it-help-collapseTwo" role="button" aria-expanded="false" aria-controls="">
                                                    <span> Video Overviews</span>
                                                    <div class="arrow pull-right text-xxdgray pos-stt translate-0-0 ml-2">
                                                        <i class="fa fa-angle-down fs-18"></i>
                                                    </div>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="it-help-collapseTwo" class="collapse" role="tabpanel" aria-labelledby="it-help-headingTwo" data-parent="#helpAccordion">
                                            <div class="card-body w-100 p-0" >
                                                <ul class="nav flex-column lh-1-4">
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_z42wvq9n8h popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#"><span class="notranslate">ngagge</span> Introduction</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_q89bzijmdl popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#"><span class="notranslate">ngagge</span> Concept</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_bgmggmt6ic popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Solve 11 Pain Points</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_fnm6ahp6bm popover=true popoverContent=link" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Startup-SMB Feature Overview</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_1abdwvyli0 popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Mid-Size - Enterprise Feature Overview </a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_qo9figifal popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Live Chat Engagement</a>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card border-0">
                                        <div class="card-header" role="tab" id="it-help-headingTwoExtra">
                                            <h5 class="mb-0 card-header">
                                                <a class="card-link px-4 text-xxdgray fw-400" data-toggle="collapse" href="#it-help-collapseTwoExtra" role="button" aria-expanded="false" aria-controls="">
                                                    <span> Video Tutorials</span>
                                                    <div class="arrow pull-right text-xxdgray pos-stt translate-0-0 ml-2">
                                                        <i class="fa fa-angle-down fs-18"></i>
                                                    </div>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="it-help-collapseTwoExtra" class="collapse" role="tabpanel" aria-labelledby="it-help-headingTwoExtra" data-parent="#helpAccordion">
                                            <div class="card-body w-100 p-0" >
                                                <ul class="nav flex-column lh-1-4">
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_e85vhb2txj popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Installing Chat Code Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_2nhb2tu6ai popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Conversation Hub Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_o03g69rob2 popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Chat Window Design Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_lyrymivnve popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">CRM Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_0tvid95lwq popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Knowledgebase Tool Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_hpzmff6jhw popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Ticket Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_8qjtt60qq5 popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Team Messaging Tutorial</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_zp4qdk0vgg popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Playbook Email Tutorial </a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_xavfgmrin9 popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Playbook SMS Tutorial 1</a>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="wistia_embed wistia_async_pi7y927l72 popover=true popoverAnimateThumbnail=true popoverContent=link videoFoam=true" style="display:inline;position:relative">
                                                            <a class="text-xxdgray fs-16 p-1 w-100 bg-white" href="#">Playbook SMS Tutorial 2</a>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <!--                                                <ul class="nav flex-column lh-1-4">
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Conversation Hub <span class="fw-400 pull-right">4 min</span></a>
                                                                                                    </li>
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Marketing</a>
                                                                                                        <ul class="list-unstyled">
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Chat<span class="fw-400 pull-right">4 min</span></a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Sales</a>
                                                                                                        <ul class="list-unstyled">
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Contact(CRM)<span class="fw-400 pull-right">2 min</span></a>
                                                                                                            </li>
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Playbooks<span class="fw-400 pull-right">3 min</span></a>
                                                                                                            </li>
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Scheduling<span class="fw-400 pull-right">1 min</span></a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Support</a>
                                                                                                        <ul class="list-unstyled">
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Help Center<span class="fw-400 pull-right">1 min</span></a>
                                                                                                            </li>
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Knowledgebase<span class="fw-400 pull-right">3 min</span></a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Collaboration</a>
                                                                                                        <ul class="list-unstyled">
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Team Messaging<span class="fw-400 pull-right">1 min</span></a>
                                                                                                            </li>
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Customer Feedback<span class="fw-400 pull-right">3 min</span></a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                    <li class="nav-item">
                                                                                                        <a class="text-xxdgray fw-600 fs-16 p-1 w-100 bg-white" href="#">Reports</a>
                                                                                                        <ul class="list-unstyled">
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Feature Reports<span class="fw-400 pull-right">1 min</span></a>
                                                                                                            </li>
                                                                                                            <li class="nav-item">
                                                                                                                <a class="text-xxdgray fw-400 fs-16 p-1 w-100 bg-white" href="#">Trend Alerts<span class="fw-400 pull-right">1 min</span></a>
                                                                                                            </li>
                                                                                                        </ul>
                                                                                                    </li>
                                                                                                </ul>-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="card border-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 card-header" @click.prevent="knowledgebaseDDOpen()" data-toggle="tooltip" data-placement="left" title="Create your own Knowledgebase for your chat agents and website >>" data-template='<div class="tooltip" role="tooltip"><div class="arrow "></div><div class="tooltip-inner bg-dblue" style="font-size:18px;"></div></div'>
                                                <a class="card-link px-4 text-xxdgray fw-400" href="#" >
                                                    <span>Knowledgebase</span>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>-->
                                    <div class="card border-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 card-header" data-toggle="tooltip" data-placement="left" title="Create your own Knowledgebase for your chat agents and website >>" data-template='<div class="tooltip" role="tooltip"><div class="arrow "></div><div class="tooltip-inner bg-dblue" style="font-size:18px;"></div></div'>
                                                <!--<a class='card-link px-4  text-xxdgray fw-400' href="#" @click.prevent='knowledgebaseDDOpen()'>-->
                                                <a class="card-link px-4 text-xxdgray fw-400" href="#" data-toggle="modal" data-target="#kbHeaderModal">
                                                    <span>Knowledgebase</span>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card border-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 card-header">
                                                <a class="card-link px-4 text-xxdgray btn-kb-article fw-400" href="https://ngagge.com/webinar" target="_blank">
                                                    <span>Webinars</span>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="card border-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 card-header">
                                                <a class="card-link px-4 text-xxdgray btn-kb-article fw-400" href="#" data-toggle="modal" data-target="#smsUserConsentModal">
                                                    <span>SMS Compliance</span>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>
                                    <!--                                    <div class="card border-0">
                                        <div class="card-header">
                                            <h5 class="mb-0 card-header">
                                                <a class="card-link px-4 text-xxdgray btn-kb-article fw-400" href="#" data-toggle="modal" data-target="#systemStatusModal">
                                                    <span>System Status</span>
                                                </a>
                                            </h5>
                                        </div>
                                    </div>-->
                                </div>
                            </div>
                        </li>
                        <!--                        <li  class="nav-item ml-4"> 
                                                                                                    <a id="btnToggleUserStatus" v-if="btnToggleUserStatusVal" href="#" class="nav-link border-0 bg-success" @click.prevent='btnToggleUserStatusVal=!btnToggleUserStatusVal' data-toggle="tooltip" data-placement="left" title='Click to show unavailable to chat' data-template='<div class="tooltip" role="tooltip"><div class="arrow "></div><div class="tooltip-inner bg-dblue" style="font-size:18px;"></div></div'></a> 
                                                                                                    <a id="btnToggleUserStatus" v-else href="#" class="nav-link border-0 bg-danger" @click.prevent='btnToggleUserStatusVal=!btnToggleUserStatusVal' data-toggle="tooltip" data-placement="left" title='Click to show available to chat' data-template='<div class="tooltip" role="tooltip"><div class="arrow "></div><div class="tooltip-inner bg-dblue" style="font-size:18px;"></div></div'></a> 
                                                                                                </li>-->
                        <!--                        <li  class="nav-item ml-4"> 
                                                                                                    <a id="btnToggleUserStatus" v-if="btnToggleUserStatusVal" href="#" class="nav-link border-0 bg-success cstm_tooltip cstm_left" @click.prevent='btnToggleUserStatusVal=!btnToggleUserStatusVal'><span class="cstm_tooltiptext">Click to show unavailable to chat</span></a> 
                                                                                                    <a id="btnToggleUserStatus" v-else href="#" class="nav-link border-0 bg-danger cstm_tooltip cstm_left" @click.prevent='btnToggleUserStatusVal=!btnToggleUserStatusVal'><span class="cstm_tooltiptext">Click to show available to chat</span></a> 
                                                                                                </li>-->

                        <li v-if="currentUser.role_id != 5" class="nav-item custm-toggle-dd pos-rel">
                            <a id="users" rel="nofollow" href="#usersSett" class="nav-link  btn-toggle-dd pl-2">
                                <span>
                                    <img v-if="currentUser.avtar" class="br-4" v-bind:src="siteUrl + 'images/subscriber/' + currentUser.subscriber_detail.generated_id + '/' + currentUser.avtar" width="36" />
                                    <img v-else class="br-4" v-bind:src="siteUrl + 'images/subscriber/avatar.jpg'" width="36" />
                                    <a
                                        id="btnToggleUserStatus"
                                        href="#"
                                        class="nav-link border-0"
                                        v-bind:class="{
                                        'bg-success': btnToggleUserStatusVal,
                                        'bg-danger': !btnToggleUserStatusVal,
                                        }"
                                        ></a>
                                </span>
                                <!--                                <span class="mx-2">{{currentUser.name}} </span>
                                                                                                                                <i class="fa fa-caret-down" aria-hidden="true"></i>-->
                            </a>
                            <div id="usersSett" class="p-4 content-toggle-dd setting-acc position-absolute">
                                <ul aria-labelledby="notifications" class="dropdown-menu notranslate d-block border-0 m-0 lh-1">
                                    <li class="px-5 py-4 border-bottom">
                                        <div class="row row-agent-detail">
                                            <div class="col-auto pr-0">
                                                <img v-if="currentUser.avtar" class="br-4" v-bind:src="siteUrl + 'images/subscriber/' + currentUser.subscriber_detail.generated_id + '/' + currentUser.avtar" width="56" />
                                                <img v-else class="br-4" v-bind:src="siteUrl + 'images/subscriber/avatar.jpg'" width="56" />
                                            </div>
                                            <div class="col-auto pr-0">
                                                <p>{{ currentUser.name }}</p>
                                                <p>{{ currentUser.email }}</p>
                                                <p
                                                    v-bind:class="{
                                                    'text-success': btnToggleUserStatusVal,
                                                    'text-danger': !btnToggleUserStatusVal,
                                                    }"
                                                    >
                                                    {{ btnToggleUserStatusVal ? "Available" : "Away" }}
                                                </p>
                                            </div>
                                        </div>
                                        <!--                                    <a @click.prevent='btnToggleUserStatusVal=!btnToggleUserStatusVal' href="#" class="dropdown-item">   
                                                                                                                                                        {{btnToggleUserStatusVal ? 'Away':'Available'}}
                                                                                                                                                    </a>                               -->
                                    </li>
                                    <li class="px-5 py-4 border-bottom">
                                        <div class="form-group row mb-0 align-items-center">
                                            <div class="col-auto pr-0 translate">Available mode:</div>
                                            <div class="col">
                                                <label class="switch pull-right"><input v-model="btnToggleUserStatusVal" @click="changeUserAvailablityStatus()" type="checkbox"/><span class="slider round"></span></label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="px-5 py-4 border-bottom">
                                        <div class="form-group row mb-0">
                                            <div class="col-auto pr-0">{{ companyDetails.company_name }}</div>
                                        </div>
                                        <!--                                    <div class="form-group row mb-0">
                                                                                <div class="col-auto pr-0"><strong>ID:</strong><span class="pl-2">123456</span></div>
                                                                            </div>-->
                                    </li>
                                    <li class="border-bottom px-3 hover-item">
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <div id="ggLangAccordion" class="btn-accordion py-0 text-nowrap" role="tablist">
                                                    <div class="card border-0">
                                                        <div class="card-header" role="tab" id="gg-lang-headingOne">
                                                            <h5 class="mb-0 card-header">
                                                                <a class="card-link py-3 px-5 w-100 d-flex align-items-center google-translate-item" data-toggle="collapse" href="#gg-lang-collapseOne" role="button" aria-expanded="false" aria-controls="">
                                                                    <div class="col-2 p-0">
                                                                        <i class="fa fa-language mr-3" aria-hidden="true"></i>
                                                                    </div>
                                                                    <div class="col pl-0 translate">
                                                                        Language                                                                    
                                                                    </div>
                                                                    <div class="arrow pull-right text-xxdgray pos-stt translate-0-0 ml-2">
                                                                        <i class="fa fa-angle-down fs-18"></i>
                                                                    </div>
                                                                </a>
                                                            </h5>
                                                        </div>
                                                        <div id="gg-lang-collapseOne" class="collapse" role="tabpanel" aria-labelledby="gg-lang-headingOne" data-parent="#ggLangAccordion">
                                                            <div class="card-body w-100 py-0 px-5" >
                                                                <div id="google_translate_element"></div>  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a class="py-3 px-5 w-100 d-flex align-items-center" href="#" @click.prevent="feedbackPage()">
                                                    <div class="col-2 p-0"><i class="fa fa-commenting-o mr-3" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Feedback</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a class="py-3 px-5 w-100 d-flex align-items-center" href="#" data-toggle="modal" data-target="#shareApp">
                                                    <div class="col-2 p-0"><i class="fa fa-share-alt mr-3" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Share</div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- <li class="border-bottom px-3 hover-item"> <div id="google_translate_element"></div></li> -->
                                    <li class="border-bottom px-3 hover-item">
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a v-bind:href="siteUrl + 'get-started'" class="py-3 px-5 w-100 d-flex align-items-center">
                                                    <div class="col-2 p-0">
                                                        <img class="before-hover" v-bind:src="siteUrl + 'images/icon-get-started.png'" width="12.5" />
                                                        <img class="after-hover" v-bind:src="siteUrl + 'images/icon-get-started-white.png'" width="12.5" />
                                                    </div>
                                                    <div class="col pl-0 translate">Get Started</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a href="#" class="py-3 px-5 w-100 d-flex align-items-center" data-toggle="modal" data-target="#addEditComAgentHeader" v-on:click="setProfileModal('Edit', 'Update')">
                                                    <div class="col-2 p-0"><i class="fa fa-user mr-3" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Profile</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a href="#" class="py-3 px-5 w-100 d-flex align-items-center" data-toggle="modal" data-target="#userEmailSignatures" v-on:click="">
                                                    <div class="col-2 p-0"><i class="fa fa-id-card fs-15" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Personal Signature</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a class="py-3 px-5 w-100 d-flex align-items-center" href="#" @click.prevent="TeamSuggestionPage()">
                                                    <div class="col-2 p-0"><i class="fa fa-commenting-o mr-3" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Team Suggestions</div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <div class="col px-0">
                                                <a v-bind:href="siteUrl + 'settings?sub=data'" class="py-3 px-5 w-100 d-flex align-items-center">
                                                    <div class="col-2 p-0"><i class="fa fa-lock mr-3" aria-hidden="true"></i></div>
                                                    <div class="col pl-0 translate">Security</div>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="">
                                        <div class="form-group row mb-0 translate">
                                            <div class="col-auto"><a href="#" class="px-5 py-4 logout" @click.prevent="logoutUser()">Logout</a></div>
                                            <!--                    <div class="col-auto ml-auto">
                                                                                                          <a href="#" class="p-0 text-blue" @click.prevent="logoutUser()">Terms & Policies</a>
                                                                                                        </div>-->
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown ml-auto" v-else>
                            <a id="users" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link pl-2">
                                <span><img class="rounded-circle" v-bind:src="siteUrl + 'images/subscriber/' + currentUser.subscriber_detail.generated_id + '/' + currentUser.avtar" width="40"/></span>
                                <span class="mx-2">{{ currentUser.name }} </span>
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <li>
                                    <a href="#" class="dropdown-item logout translate" @click.prevent="logoutUser()">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--        <div class="alert alert-warning alert-dismissible fade show notice-alert pr-5" role="alert">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-white text-nowrap text-ellipsis tranparent mb-0"> Save personnel costs and increase business by over 40%.</p>
                                        <p class="text-white text-nowrap text-ellipsis main-msg"> Save personnel costs and increase business by over 40%.</p>
                                    </div>
                                    <div class="col-auto">
                                        <a class="text-primary text-nowrap learn-more">Learn more...</a>
                                    </div>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>-->

        <div id="imageCroppingModalSquareHeader" role="dialog" aria-labelledby="imageCroppingModalSquareHeader" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-450">
                <div class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-4">
                        <h3 class="modal-title">Image Adjustment</h3>
                        <!--<button type="button" class="btn p-0 rounded ml-auto bg-white" data-toggle="modal" @click.prevent="crop()"><i class="fa fa-eye fs-40 text-gray" aria-hidden="true"></i></button>-->
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close ml-0">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-5">
                            <vue-croppie ref="croppieHeaderAvtar" v-bind:enableOrientation="true" v-bind:mouseWheelZoom="false" v-bind:viewport="{ width: 200, height: 200, type: 'square' }" @result="result" @update="update"> </vue-croppie>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" @click.prevent="crop()" class="btn btn-orange">Save</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="videoMessageModal" role="dialog" aria-labelledby="videoMessageModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-450">
                <div class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-4">
                        <h3 class="modal-title">Start a video conference</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close ml-0">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-5">
                            <ul class="list-unstyled mb-3">
                                <li>1) Copy the below link. </li>
                                <li>2) Send it to people that you want to connect with through video conference.</li>
                                <li>3) Ensure that you save this link so that you can use it later, too. </li>
                            </ul>
                            <div class="ctc-main-wrapper pos-rel">
                                <textarea id="ctcTextarea" class="p-4 w-100 form-control notranslate" readonly="true" rows="3">{{jitsiLink}}
                                </textarea>
                                <div class="btn-ctc-wrap">
                                    <a href="#" class="btn btn-orange mt-4 text-white pull-left" @click.prevent="copyToClipboard('ctcTextarea')">Copy</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange-border" @click="resetProfile">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="recordVideoMessageModal" role="dialog" aria-labelledby="recordVideoMessageModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-450">
                <div class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-4">
                        <h3 class="modal-title">Record a video message</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close ml-0">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-5">
                            <p>This feature allows you to record video messages of your screen, cam or both and share with your contacts easily. Refer to the steps below or watch the video to understand how to get this implemented. </p>
                            <p class="fw-600">Prerequisites:</p>
                            <ul class="list-unstyled mb-3">
                                <li>1) Dropbox account – You will need a dropbox account to store these video messages and get a link for sharing. You can subscribe for a free dropbox account which gives you a storage of up to 2gb. </li>
                            </ul>                        
                            <p class="fw-600">Steps:</p>
                            <ul class="list-unstyled">
                                <li>1) Click on continue on the bottom of this popout. This will open a new tab taking you to a Jitsi URL. </li>
                                <li>2) Click on Join meeting. </li>
                                <li>3) Click on “3 horizontal dots” icon at the bottom adjacent to end call icon. </li>
                                <li>4) Click on start recording. </li>
                                <li>5) Connect to your Dropbox account and start recording. </li>
                                <li>6) Now you can choose to share your screen by clicking on share screen option at the bottom or continue to record your cam.</li>
                                <li>7) Click on stop recording. Your recording will be saved to your Dropbox account.</li>
                                <li>8) Go to your dropbox account and click on “Share” button you see adjacent to the video.</li>
                                <li>9) Click on “Create then copy link” option and then click on “Copy link”.</li>
                                <li>10) You can share this link for people to see your video message. </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-orange" type="button" @click="generateLinkOpen">Continue</button>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange-border ml-3" @click="resetProfile">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="kbHeaderModal" role="dialog" aria-labelledby="kbHeaderModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-450">
                <div class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-4">
                        <h3 class="modal-title">Knowledgebase</h3>
                        <!--<button type="button" class="btn p-0 rounded ml-auto bg-white" data-toggle="modal" @click.prevent="crop()"><i class="fa fa-eye fs-40 text-gray" aria-hidden="true"></i></button>-->
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close ml-0">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body bottom-0 top-0">
                        <!--<iframe :src="siteUrl + '/knowledgebase'" style="border:none;width:100%;height: calc(100% - 8px);"></iframe>-->
                        <iframe src="https://app.ngagge.com/articleByLink/IW8111689/1" style="border:none;width:100%;height: calc(100% - 8px);"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <knowledgebase-header></knowledgebase-header>
        <article-help-header></article-help-header>
        <div id="headerNotificationModal" role="dialog" aria-labelledby="headerNotificationModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-500">
                <div class="modal-content p-5">
                    <div class="modal-header pb-0 px-4 border-0 pt-3">
                        <h3 class="modal-title">Notifications</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    <div class="modal-body bottom-0 notranslate">
                        <div class="py-5">
                            <ul class="list-unstyled list-notify border-top">
                                <li v-for="notification in userNotifications" v-bind:key="notification.id" class="list-item border-bottom">
                                    <div v-if="notification.display_type == 'CHAT'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-16 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <ul class="list-inline lh-1 fs-13">
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_type != ''">{{ notification.body.lead_type }}</li>
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_score != ''">Lead Score&nbsp;:&nbsp;{{ notification.body.lead_score }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.priority != ''">Priority &nbsp;:&nbsp;{{ notification.body.priority }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.lead_type == '' && notification.body.lead_score == '' && notification.body.priority == ''">
                                                                <span v-if="notification.body.message">{{ notification.body.message }}</span
                                                                ><span v-else>Location &nbsp;:&nbsp;{{ notification.body.location }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>
                                    <div v-if="notification.display_type == 'SMS'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <ul class="list-inline lh-1 fs-13">
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_type != ''">{{ notification.body.lead_type }}</li>
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_score != ''">Lead Score&nbsp;:&nbsp;{{ notification.body.lead_score }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.priority != ''">Priority &nbsp;:&nbsp;{{ notification.body.priority }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.lead_type == '' && notification.body.lead_score == '' && notification.body.priority == ''">{{ notification.body.message }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>
                                    <div v-if="notification.display_type == 'DIRECT_MESSAGE'">
                                        <a v-bind:href="notification.url" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div class="col-auto notify-pics p-0 mr-3 br-4">
                                                    <span v-if="notification.unread_msg_count > 1" style="left: -10px;" class="h-notify-count bg-danger">{{ notification.unread_msg_count < 10 ? notification.unread_msg_count : "9+" }}</span>
                                                    <img class="img-fluid br-4" v-bind:src="siteUrl + 'images/subscriber/' + notification.image" />
                                                </div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ getDateFormat(notification.created_at) | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2 ">
                                                        <p class="text-truncate fs-13">{{ notification.body.message }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">x</a>
                                    </div>
                                    <div v-if="notification.display_type == 'EMAIL'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <p class="text-truncate fs-13">{{ notification.body.subject }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>
                                    <div v-if="notification.display_type == 'MESSENGER'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <ul class="list-inline lh-1 fs-13">
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_type != ''">{{ notification.body.lead_type }}</li>
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_score != ''">Lead Score&nbsp;:&nbsp;{{ notification.body.lead_score }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.priority != ''">Priority &nbsp;:&nbsp;{{ notification.body.priority }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.lead_type == '' && notification.body.lead_score == '' && notification.body.priority == ''">{{ notification.body.message }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>
                                    <div v-if="notification.display_type == 'TICKET'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>
                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">{{ notification.body.from }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat) }}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <ul class="list-inline lh-1 fs-13">
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_type != ''">{{ notification.body.lead_type }}</li>
                                                            <li class="list-inline-item mr-2 pr-2 border-right border-black" v-if="notification.body.lead_score != ''">Lead Score&nbsp;:&nbsp;{{ notification.body.lead_score }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.priority != ''">Priority &nbsp;:&nbsp;{{ notification.body.priority }}</li>
                                                            <li class="list-inline-item" v-if="notification.body.lead_type == '' && notification.body.lead_score == '' && notification.body.priority == ''">{{ notification.body.message }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>

                                    <div v-if="notification.display_type == 'CONTACT_CREATED'">
                                        <a href="#" class="d-block text-black py-4 px-5">
                                            <div class="fw-600 fs-15 lh-1">{{ notification.title }}</div>
                                            <div class="d-flex mt-3">
                                                <div v-bind:class="[notification.body.contact_letter_class, 'col-auto notify-pics p-0 mr-3 br-4 fs-16']">{{ notification.body.contact_letter }}</div>

                                                <div class="col pl-0 notify-details fs-14">
                                                    <div class="nd-head lh-1 d-flex justify-content-between">
                                                        <p class="m-0 fs-15">Name : {{ notification.body.agentname }}</p>
                                                        <p class="m-0 fs-12">{{ notification.created_at | moment(dateFormat)}}</p>
                                                    </div>
                                                    <div class="nd-body mt-2">
                                                        <p class="m-0 fs-15">Source : {{ notification.source }}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)" @click="dismissNotifications(notification.id)" class="notify-close">&times;</a>
                                    </div>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="headerReminderModal" role="dialog" aria-labelledby="headerReminderModal" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-640">
                <div class="modal-content p-5">
                    <div class="modal-header pb-0 px-4 border-0 pt-3">
                        <h3 class="modal-title">Reminders</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                    <div class="modal-body bottom-0">
                        <div class="py-5">
                            <div id="searchClsConvTab" class="">
                                <b-tabs active-nav-item-class="font-weight-bold" active-tab-class="font-weight-bold">
                                    <b-tab title="All" active>
                                        <div class="chat-detail-inner pr-0">
                                            <div id="ConvActivities" class="btn-accordion m-0 border-0 br-8" role="tablist">
                                                <div class="cards">
                                                    <div class="row py-4 br-8">
                                                        <div class="col">
                                                            <div id="ticket-sett-collapseTwo" class="collapse d-block show px-0" role="tabpanel" aria-labelledby="ticket-sett-headingTwo" data-parent="#ConvActivities">
                                                                <div class="card-body p-0 w-100 bg-white d-block">
                                                                    <header-reminder-event msgg1="0" @geteventlength="geteventlength"></header-reminder-event>
                                                                    <header-reminder-task msgg="0" @gettasklength="gettasklength"></header-reminder-task>
                                                                    <header-reminder-ticket msgg="0" @getticketlength="getticketlength"></header-reminder-ticket>
                                                                </div>
                                                                <div v-if="eventLength == 0 && taskLength == 0 && TicketLength == 0">
                                                                    <h3>No reminder found.</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="Events">
                                        <div class="chat-detail-inner pr-0">
                                            <div id="ConvActivities" class="btn-accordion m-0 border-0 br-8" role="tablist">
                                                <div class="cards">
                                                    <div class="row py-4 br-8">
                                                        <div class="col">
                                                            <div id="ticket-sett-collapseTwo" class="collapse d-block show px-0" role="tabpanel" aria-labelledby="ticket-sett-headingTwo" data-parent="#ConvActivities">
                                                                <div class="card-body p-0 w-100 bg-white d-block">
                                                                    <header-reminder-event msgg1="1"></header-reminder-event>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="Tasks">
                                        <div class="chat-detail-inner pr-0">
                                            <div id="ConvActivities" class="btn-accordion m-0 border-0 br-8" role="tablist">
                                                <div class="cards">
                                                    <div class="row py-4 br-8">
                                                        <div class="col">
                                                            <div id="ticket-sett-collapseTwo" class="collapse show px-0" role="tabpanel" aria-labelledby="ticket-sett-headingTwo" data-parent="#ConvActivities">
                                                                <div class="card-body p-0 w-100 bg-white d-block">
                                                                    <header-reminder-task msgg="1"></header-reminder-task>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                    <b-tab title="Tickets">
                                        <div class="chat-detail-inner pr-0">
                                            <div id="ConvActivities" class="btn-accordion m-0 border-0 br-8" role="tablist">
                                                <div class="cards">
                                                    <div class="row py-4 br-8">
                                                        <div class="col">
                                                            <div id="ticket-sett-collapseTwo" class="collapse show px-0" role="tabpanel" aria-labelledby="ticket-sett-headingTwo" data-parent="#ConvActivities">
                                                                <div class="card-body p-0 w-100 bg-white d-block">
                                                                    <header-reminder-ticket msgg="1"></header-reminder-ticket>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </b-tab>
                                </b-tabs>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="addEditComAgentHeader" role="dialog" aria-labelledby="addEditComAgentHeader" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-560">
                <div id="step-1" class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-3">
                        <h3 class="modal-title">Edit Profile</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="p-5 notranslate">
                            <form class="agent-add" name="addAgent" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right">
                                                <span v-if="show_src" class="rounded-cirle d-flex align-items-center">
                                                    <span class="d-inline-block translate">Photo</span>
                                                    <sup class="text-danger mr-2">*</sup>
                                                    <img class="rounded-circle d-block pull-right" v-bind:src="avatar_src" alt="" style="width: 36px; height: 36px" />
                                                </span>
                                                <span v-else-if="avatar == ''">
                                                    <img class="br-4" v-bind:src="siteUrl + 'images/subscriber/avatar.jpg'" alt style="width: 36px; height: 36px" />
                                                </span>

                                                <span v-else class="rounded-cirle d-flex align-items-center">
                                                    <span class="d-inline-block translate">Photo</span>
                                                    <sup class="text-danger mr-2">*</sup>
                                                    <img class="rounded-circle d-block pull-right" v-bind:src="siteUrl + 'images/subscriber/' + currentUser.subscriber_detail.generated_id + '/' + avatar" alt="" style="width: 36px; height: 36px" />
                                                </span>
                                            </label>
                                            <div class="col dragdrop-file">
                                                <b-form-file name="avtar" v-on:change="ProcessInviteeImage" v-bind:state="Boolean(file)" placeholder="Drag and drop or click to upload"></b-form-file>
                                                <span class="text text-danger" v-if="errorAvatar !== ''">{{ errorAvatar }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Name <sup class="text-danger">*</sup></label>
                                            <div class="col">
                                                <input name="name" v-model="agentname" type="text" class="form-control" id="" placeholder="" />
                                                <input v-if="agentid != ''" name="editId" v-model="agentid" type="hidden" />
                                                <span class="text text-danger" v-if="errorAgentName !== ''">{{ errorAgentName }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Display Name <sup class="text-danger">*</sup></label>
                                            <div class="col">
                                                <input name="displayName" v-model="displayname" type="text" class="form-control" placeholder="" />
                                                <span class="text text-danger" v-if="errorDisplayName !== ''">{{ errorDisplayName }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Email <sup class="text-danger invisible">*</sup></label>
                                            <div class="col">
                                                <input type="text" name="email" v-model="email" class="form-control" readonly placeholder="" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Cell phone <sup class="text-danger invisible">*</sup></label>
                                            <div class="col">
                                                <input name="cell_phone" v-model="cell_phone" type="text" class="form-control" placeholder="" />
                                                <span class="text text-danger" v-if="errorCellphone !== ''">{{ errorCellphone }}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                                              <label class="col-auto col-form-label text-right">Role <sup class="text-danger invisible">*</sup></label>
                                                              <div class="col">
                                                                <select name="role" v-model="role_input" class="form-control nnn" v-if="modalTitle == 'Edit'">
                                                                  <option value="">Select</option>
                                                                  <option v-for="(role, index) in roles" v-bind:value="role.id">{{ role.name }}</option>
                                                                </select>
                                                              </div>
                                                            </div> -->
                                        <div class="form-group row manage-keywords department-selection" data-toggle="tooltip" data-placement="top" title="Departments can be changed if you have the required permissions." data-template='<div class="tooltip" role="tooltip"><div class="arrow "></div><div class="tooltip-inner bg-dblue mw-500" style="font-size:18px;"></div></div'>
                                            <label class="col-auto col-form-label translate">Department</label>
                                            <div class="col ml-auto">
                                                <div class="kb-keywords-holder notranslate">
                                                    <span v-for="(seldep, index) in selectedDep" class="kb-keyword-item pos-rel">
                                                        {{ getdepartmentname(seldep) }}
                                                        <a href="#" class="kb-keyword-remove rounded-circle btn-secondary" @click.prevent="deleteDepartment(index, seldep)" v-if="isPermission('company_teammates_invite_edit_and_delete') > 0">&times;</a>
                                                    </span>
                                                    <div class="ctg-input pos-rel" v-if="NotselectedDep.length && isPermission('company_teammates_invite_edit_and_delete') > 0">
                                                        <ul class="list-unstyled bg-white p-3 list-deptt">
                                                            <li v-for="dep in deplist" class="mt-2">
                                                                <a class="text-gray">{{ dep.department }}</a
                                                                ><label class="switch pull-right"><input type="checkbox" v-bind:value="dep.dept_id" v-model="selectedDep"/><span class="slider round"></span></label>
                                                            </li>
                                                            <li v-for="dep in NotselectedDep" class="mt-2">
                                                                <a class="text-gray" v-on:click="selectDepartment(dep.dept_id)" href="#">{{ dep.department }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Time zone <sup class="text-danger">*</sup></label>
                                            <div class="col">
                                                <select name="timezone" v-model="timezone" class="form-control notranslate">
                                                    <option class="d-none translate" value="">Select</option>
                                                    <option v-for="time in timezoneList" v-bind:key="time.id" v-bind:value="time.id">{{ time.timezone }}</option>
                                                </select>
                                                <span class="text text-danger" v-if="errorTimezone != ''">{{ errorTimezone }}</span>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row" v-if="editInviteeList.is_activated == 1">
                                                              <label class="col-auto col-form-label text-right align-self-center">Chat Time Plan</label>
                                                              <div class="col">
                                                                <select name="role" v-model="chatTimePlan" class="form-control mt-2">
                                                                  <option class="d-none" value="">Select</option>
                                                                  <option v-for="plan in plans" v-bind:key="plan.id" v-bind:value="plan.id">{{ plan.name }}</option>
                                                                </select>
                                                              </div>
                                                            </div> -->
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Login default view</label>
                                            <div class="col">
                                                <select name="role" class="form-control notranslate" v-model="login_default_view">
                                                    <option class="d-none translate" value="">Select</option>
                                                    <option value="1">Reports/Features</option>
                                                    <option value="2">Inbox</option>
                                                    <option value="3">Contacts</option>
                                                    <option value="4">Team Messaging</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Status on Login</label>
                                            <div class="col">
                                                <select name="role" v-model="status_on_login" class="form-control notranslate">
                                                    <option class="d-none translate" value="">Select</option>
                                                    <option value="1">Available</option>
                                                    <option value="2">Away</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-auto col-form-label text-right translate">Max conc chats</label>
                                            <div class="col notranslate">
                                                <select name="maxChats" v-model="maxchat" class="form-control" :disabled="!isPermission('company_teammates_invite_edit_and_delete') > 0">
                                                    <option value="NULL" class="translate">More than 5</option>

                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="">Select</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-orange" name="addedit" v-on:click.prevent="updateInvitation" type="button">
                            {{ btnmodalText }}
                        </button>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-orange-border ml-3" @click="resetProfile">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="userEmailSignatures" role="dialog" aria-labelledby="userEmailSignatures" aria-hidden="true" class="modal fade text-left">
            <div role="document" class="modal-dialog mw-1000">
                <div class="modal-content">
                    <div class="modal-header pb-0 px-4 border-0 pt-4">
                        <h3 class="modal-title">Email Signature</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close" @click.prevent="resetSignature">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class>
                            <div class="border-gray p-5 notranslate translate">
                                <div class="row">
                                    <div class="col-auto" style="min-width: 375px; max-width: 375px">
                                        <div id="userEmailSignaturesAccor" class="btn-accordion m-0" role="tablist">
                                            <div class="card border-0">
                                                <div id="ticket-email-forward-collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="user-email-signature-headingTwo" data-parent="#userEmailSignaturesAccor">
                                                    <div class="card-body py-0 px-0 w-100">
                                                        <form id="emailForward">
                                                            <input type="hidden" id="btnDownloadImg" data-href="" />
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1">
                                                                    Photo Default:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.mainPhotoDefault.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4 notranslate" v-if="ticketSignSett.mainPhotoDefault.isActive">
                                                                    <select class="form-control" v-model="ticketSignSett.mainPhotoAgent">
                                                                        <option v-for="(imgSrc, index) in emailSignatureDefault" v-bind:value="siteUrl + imgSrc">{{ index }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0 manage-agent" v-if="!ticketSignSett.mainPhotoDefault.isActive">
                                                                <label class="col-12 col-form-label text-left pt-0 lh-1 translate">Agent</label>
                                                                <div class="col-12 pr-4">
                                                                    <select class="form-control" v-model="ticketSignSett.mainPhotoAgent">
                                                                        <option v-for="(agent, index) in clientsList" v-bind:value="siteUrl + 'images/subscriber/' + currentUser.subscriber_detail.generated_id + '/' + agent.avatar">{{ agent.name }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Photo Type
                                                                </div>
                                                                <div class="col-12 pr-4 notranslate">
                                                                    <select class="form-control" v-model="ticketSignSett.mainPhotoType">
                                                                        <option value="50%">Rounded</option>
                                                                        <option value="0%">Square</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Name:
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <input class="form-control" v-model="ticketSignSett.name.value" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Title:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.title.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <input class="form-control" v-model="ticketSignSett.title.value" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label pr-0 text-left pt-0 lh-1 translate">Font Size:</div>
                                                                <div class="col-12 pr-4 notranslate">
                                                                    <select class="form-control" v-model="ticketSignSett.fontSize">
                                                                        <option value="14">Low</option>
                                                                        <option value="15">Medium</option>
                                                                        <option value="16">High</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Phone:
                                                                    <label class="switch pull-right mr-2 notranslate">
                                                                        <input type="checkbox" v-model="ticketSignSett.phone.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <input class="form-control" v-model="ticketSignSett.phone.value" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Mobile:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.mobile.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <input class="form-control" v-model="ticketSignSett.mobile.value" max />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Address:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.address.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <textarea class="form-control resize-none" v-model="ticketSignSett.address.value" rows="2"></textarea>
                                                                    <label class="mt-1 text-danger fs-12" v-if="addMaxCharReach">Max char: 40</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Company:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.company.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <input class="form-control" v-model="ticketSignSett.company.value" />
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Website:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.website.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <select class="form-control" v-model="ticketSignSett.website.value">
                                                                        <option value>Select</option>
                                                                        <option v-for="wlist in WebList" v-bind:value="wlist.website_url">{{ wlist.website_url }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Logo:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.logo.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4 dragdrop-file">
                                                                    <b-form-file v-on:change="ProcessFileLogoUploadImage" name="logo" placeholder="Drag and drop or click to upload"></b-form-file>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row mr-0">
                                                                <div class="col-12 col-form-label text-left pt-0 lh-1 translate">
                                                                    Line Color:
                                                                    <label class="switch pull-right mr-2">
                                                                        <input type="checkbox" v-model="ticketSignSett.linkColor.isActive" />
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-12 pr-4">
                                                                    <color-picker v-bind:colorHex="ticketSignSett.linkColor.value"></color-picker>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col email-signature-componets">
                                        <div class="form-group row mr-0 align-items-center justify-content-center mt-3">
                                            <div class="col-auto col-form-label min-w-0 d-flex translate">
                                                Add to all email
                                                <a class="nav-link btn-toggle-dd ml-3 p-0 ctt-tooltip" href="javascript:void(0)" ctt-title="Add your signature in all emails sent." ctt-placement="top">
                                                    <img v-bind:src="siteUrl + 'images/info-icon.png'" width="20" />
                                                </a>
                                            </div>
                                            <div class="col-auto pl-0">
                                                <label class="switch pull-right ml-2">
                                                    <input type="checkbox" v-model="add_email_signature" />
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <email-signature v-bind:ticketSignSett="ticketSignSett" v-bind:source="'header'"></email-signature>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group row mb-0">
                            <div class="col te-form-wrap-btn">
                                <button class="btn btn-orange mr-3" type="button" v-on:click="updateSignature">Update</button>
                                <button class="btn btn-orange-border" data-dismiss="modal" type="button" @click.prevent="resetSignature">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
    import { site_root } from "./../../Utitlity.js";
    import knowledgebaseUl from "./../knowledgebaseUl.vue";
    import ArticleHelp from "./../ArticleHelp.vue";
    import HeaderReminder from "./HeaderReminder.vue";
    import HeaderReminderEvent from "./HeaderReminderEvent.vue";
    import HeaderReminderTask from "./HeaderReminderTask.vue";
    import HeaderReminderTicket from "./HeaderReminderTicket.vue";
    import ColorPicker from "../color-picker/color-picker.vue";
    import { EventBus } from "../../EventBus.js";
    import EmailSignature from "../company-components/email-signature/EmailSignature.vue";
    export default {
        name: "app-header",
        props: [],
        data() {
            return {
                siteUrl: site_root,
                companyDetails: "",
                isshow: 0,
                eventLength: "",
                taskLength: "",
                TicketLength: "",
                modalTitle: "",
                btnmodalText: "Save",
                currentUser: "",
                searchFilter: "Action",
                loaded: 0,
                userStatusName: "Available",
                avatar_src: "",
                errorAvatar: "",
                NotselectedDep: "",
                show_src: "",
                agentid: "",
                editInviteeList: "",
                agentname: "",
                errorAgentName: "",
                displayname: "",
                errorDisplayName: "",
                email: "",
                cell_phone: "",
                errorCellphone: "",
                role_input: "",
                skill: "",
                maxchat: "NULL",
                timezone: "",
                errorTimezone: "",
                avatar: "",
                status_on_login: "",
                email_transcript: "",
                login_default_view: "",
                chatTimePlan: "",
                selectedDep: "",
                file: "",
                cropped: "",
                timezoneList: "",
                skillList: "",
                roles: "",
                deplist: [],
                plans: "",
                btnToggleUserStatusVal: true,
                btnToggleheaderInfo: false,
                //                btnToggleUserStatusText: 'Click to show unavailable to chat',
                userNotifications: [],
                userNotificaionsIds: [],
                notificationSource: [],
                notificationType: [],
                userNotificationSettings: [],
                userRolePermissions: [],
                dateFormat: "MM-DD-YYYY hh:mm A",
                browserNotifications: false,
                WebList: "",
                emailSignatureDefault: ["images/theme/default/w/d-agent-1.jpg", "images/theme/default/w/d-agent-2.jpg", "images/theme/default/w/d-agent-3.jpg", "images/theme/default/w/d-agent-4.jpg", "images/theme/default/w/d-agent-5.jpg", "images/theme/default/w/d-agent-6.jpg"],
                emailSignatureMainImg: "",
                addMaxCharReach: false,
                add_email_signature: "",
                ticketSignSett: {
                    signatureName: "",
                    mainPhotoLoc: "Side",
                    mainPhotoType: "50%",
                    mainPhotoAgent: site_root + "images/theme/default/w/d-agent-1.jpg",
                    fontSize: "14",
                    mainPhotoDefault: {
                        isActive: true,
                        value: "1",
                    },
                    name: {
                        isActive: true,
                        value: "Steve Seeberg",
                    },
                    title: {
                        isActive: true,
                        value: "CEO",
                    },
                    phone: {
                        isActive: true,
                        value: "123-456-7890",
                    },
                    mobile: {
                        isActive: true,
                        value: "123-456-7890",
                    },
                    address: {
                        isActive: true,
                        value: "Palm Beach Miami",
                    },
                    company: {
                        isActive: true,
                        value: "FreeChat247Live",
                    },
                    website: {
                        isActive: true,
                        value: "www.FreeChat247Live.com",
                    },
                    logo: {
                        isActive: true,
                        imgSrc: "",
                    },
                    linkColor: {
                        isActive: true,
                        value: {
                            hex: "#d15223",
                        },
                    },
                    linePlacement: 1,
                    schedule: {
                        isActive: true,
                        linkURL: "www.google.com",
                    },
                    chat: {
                        isActive: true,
                        linkURL: "www.google.com",
                    },
                },
                articleList1: [],
                clientsList: [],
                jitsiLink:''
            };
        },
        computed: {
            test() {
                EventBus.$on("testEvent", ($event) => {
                    //console.log("event triggered", $event);
                });
            },
        },
        components: {
            "knowledgebase-header": knowledgebaseUl,
            "article-help-header": ArticleHelp,
            "header-reminder": HeaderReminder,
            "header-reminder-event": HeaderReminderEvent,
            "header-reminder-task": HeaderReminderTask,
            "email-signature": EmailSignature,
            "color-picker": ColorPicker,
            "header-reminder-ticket": HeaderReminderTicket,
        },
        watch: {
            "ticketSignSett.address.value": function (newVal) {
                if (typeof newVal !== "undefined" && newVal !== null) {
                    if (newVal.length > 40) {
                        this.addMaxCharReach = true;
                        this.ticketSignSett.address.value = this.ticketSignSett.address.value.substring(0, 40);
                    }
                }
            },
        },
        methods: {
            generateLink(){
               var numm = Math.floor(Math.random() * 99999999);
               var company_name =  this.companyDetails.company_name.replace(" ", "-");
               company_name =   company_name.replace("  ", "-");
               company_name =   company_name.replace(" ", "-");
               this.jitsiLink='https://meet.jit.si/ngagge/'+ company_name+'-'+numm;
            },
            generateLinkOpen(){
               var numm = Math.floor(Math.random() * 99999999);
               var company_name =  this.companyDetails.company_name.replace(" ", "-");
               company_name =   company_name.replace("  ", "-");
               company_name =   company_name.replace(" ", "-");
               this.jitsiLink='https://meet.jit.si/ngagge/'+ company_name+'-'+numm;
               window.open(this.jitsiLink, '_blank');
            },
            copyToClipboard: function (id) {
                var copyText = document.getElementById(id)
                copyText.select()
                copyText.setSelectionRange(0, 99999)
                document.execCommand("copy")                
            },
            refreshRemider() {
                var thisObject = this;
                EventBus.$emit("refresh-reminder", true);
                $("#headerReminderModal").modal("show");
            },
            getDateFormat(args) {
                var d = new Date(args);
                var newDate = new Date(d.getTime() - d.getTimezoneOffset() * 60 * 1000);
                return newDate;
            },
            getTime(args) {
                var hour = args.split(":");
                var time = new Date();
                time.setHours(hour[0]);
                time.setMinutes(hour[1]);
                var hours = time.getHours();
                var minutes = time.getMinutes();
                var ampm = hours >= 12 ? "PM" : "AM";
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? "0" + minutes : minutes;
                var strTime = hours + ":" + minutes + " " + ampm;
                return strTime;
            },
            updateSignature() {
                var thisObject = this;
                // alert("out")
                html2canvas(document.getElementById("emailSignature-header"), {
                    onrendered: function (canvas) {
                        var dataPath = canvas.toDataURL("image/png");
                        $("#btnDownloadImg").attr("data-href", dataPath);
                    },
                });
                setTimeout(
                        function () {
                            //console.log($("#btnDownloadImg").attr("href"))
                            axios
                                    .post(thisObject.siteUrl + "update-agent-signature", {
                                        add_email_signature: thisObject.add_email_signature,
                                        data: thisObject.ticketSignSett,
                                        get_html: $("#emailSignature-header").html(),
                                        signatureImage: $("#btnDownloadImg").attr("data-href"),
                                    })
                                    .then(function (response) {
                                        $("#userEmailSignatures").modal("hide");
                                        thisObject.getEmailSignature();
                                    })
                                    .catch(function (error) {
                                        console.error(error.message);
                                    });
                        }.bind(thisObject),
                        1000
                        );
            },
            resetSignature() {
                var thisObject = this
                $("#ticketEmailSignatures").modal("hide")
                thisObject.ticketSignSett.signatureName = "",
                        thisObject.ticketSignSett.mainPhotoLoc = "Side",
                        thisObject.ticketSignSett.mainPhotoType = "50%",
                        thisObject.ticketSignSett.mainPhotoAgent = site_root + "images/theme/default/w/d-agent-1.jpg",
                        thisObject.ticketSignSett.fontSize = "14",
                        thisObject.ticketSignSett.mainPhotoDefault.isActive = "true"
                thisObject.ticketSignSett.mainPhotoDefault.value = "1",
                        thisObject.ticketSignSett.name.isActive = "true"
                thisObject.ticketSignSett.name.value = "Adam Ross"
                thisObject.ticketSignSett.title.isActive = 1
                thisObject.ticketSignSett.title.value = "CEO"
                thisObject.ticketSignSett.phone.isActive = "true"
                thisObject.ticketSignSett.phone.value = "123-456-7890"
                thisObject.ticketSignSett.mobile.isActive = "true"
                thisObject.ticketSignSett.mobile.value = "123-456-7890"
                thisObject.ticketSignSett.address.isActive = "true"
                thisObject.ticketSignSett.address.value = "Palm Beach Miami"
                thisObject.ticketSignSett.company.isActive = "true"
                thisObject.ticketSignSett.company.value = "Ngagge"
                thisObject.ticketSignSett.website.isActive = "true"
                thisObject.ticketSignSett.website.value = "www.ngagge.com"
                thisObject.ticketSignSett.logo.isActive = "true"
                thisObject.ticketSignSett.logo.imgSrc = site_root + "images/theme/default/w/d-agent-1.jpg"

                thisObject.ticketSignSett.linkColor.isActive = "true"
                thisObject.ticketSignSett.linkColor.value.hex = "#d15223"
                thisObject.ticketSignSett.linePlacement = 1
                thisObject.ticketSignSett.schedule.isActive = "true"
                thisObject.ticketSignSett.schedule.linkURL = "www.google.com"
                thisObject.ticketSignSett.chat.isActive = "true"
                thisObject.ticketSignSett.chat.linkURL = "www.google.com"
                thisObject.add_email_signature = 0
                thisObject.getEmailSignature()
            },
            getEmailSignature() {
                var thisObject = this;
                axios
                        .post(thisObject.siteUrl + "get-agent-signature")
                        .then(function (response) {
                            if (response.data != "500") {
                                thisObject.ticketSignSett = "";
                                thisObject.add_email_signature = response.data.add_email_signature;
                                thisObject.ticketSignSett = JSON.parse(response.data.data);
                                //console.log(thisObject.ticketSignSett);
                            } else {
                                //console.log("No signature available for this user")
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            ProcessFileLogoUploadImage: function (e) {
                let files = e.target.files || e.dataTransfer.files;
                let vm = this;
                if (!files.length) {
                    return;
                } else {
                    vm.createImageSN(files[0]);
                }
            },
            createImageSN(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.ticketSignSett.logo.imgSrc = e.target.result;
                    $("#imageCroppingModalSquareSN").modal("show");
                    setTimeout(function () {
                        vm.cropImageSN();
                    }, 1000);
                };
                reader.readAsDataURL(file);
            },
            cropImageSN: function () {
                let vm = this;
                this.$refs.croppieSquare.bind({
                    url: vm.ticketSignSett.logo.imgSrc,
                });
            },
            crops() {
                var self = this;
                let options = {
                    format: "png",
                    circle: false,
                };
                this.$refs.croppieSquare.result(options, (output) => {
                    this.cropped = output;
                    axios
                            .post(self.siteUrl + "upload-chat-signature-images", {
                                avtar: output,
                            })
                            .then(function (response) {
                                if (response.data != "500") {
                                    self.ticketSignSett.logo.imgSrc = response.data.avtar;
                                } else {
                                    //console.log("error in upload image")
                                }
                            })
                            .catch(function (error) {
                                console.error(error.message);
                            });
                });
            },
            geteventlength: function (args) {
                this.eventLength = args;
                //console.log("Event Count")
                //console.log(args)
            },
            gettasklength: function (args) {
                this.taskLength = args;
                //console.log("Task Count")
                //console.log(args)
            },
            getticketlength: function (args) {
                this.TicketLength = args;
            },
            setProfileModal: function (title, btnText) {
                this.avatar_src = "";
                this.modalTitle = this.btnmodalText = title;
                if (btnText) {
                    this.btnmodalText = btnText;
                }
                setTimeout(
                        function () {
                            this.selectedDep = [];
                            this.NotselectedDep = [];
                            this.show_src = false;
                            this.agentid = this.currentUser.id;
                            var thisObject = this;
                            thisObject.editInviteeList = "";

                            axios
                                    .post(thisObject.siteUrl + "get-invitee-on-edit", {
                                        editId: thisObject.currentUser.id,
                                        from: "head",
                                    })
                                    .then(function (response) {
                                        thisObject.editInviteeList = response.data;
                                        //console.log('editInviteeList ', thisObject.editInviteeList);
                                        thisObject.avatar = thisObject.editInviteeList.avatar;
                                        thisObject.agentname = thisObject.editInviteeList.name;
                                        thisObject.displayname = thisObject.editInviteeList.display_name;
                                        thisObject.email = thisObject.editInviteeList.email;
                                        thisObject.cell_phone = thisObject.editInviteeList.cell_phone;
                                        // thisObject.skill = thisObject.editInviteeList.skill;
                                        thisObject.agentid = thisObject.editInviteeList.Inviteeid;
                                        thisObject.role_input = thisObject.editInviteeList.system_role;
                                        thisObject.maxchat = thisObject.editInviteeList.max_chats;
                                        thisObject.timezone = thisObject.editInviteeList.timezone;
                                        thisObject.status_on_login = thisObject.editInviteeList.login_status;
                                        thisObject.login_default_view = thisObject.editInviteeList.default_view;
                                        thisObject.chatTimePlan = thisObject.editInviteeList.time_plan;
                                        if (thisObject.editInviteeList.department != "") {
                                            thisObject.selectedDep = thisObject.editInviteeList.department.split(",");
                                        }
                                        if (thisObject.deplist)
                                            for (var i = 0; i < thisObject.deplist.length; i++) {
                                                if (thisObject.selectedDep.indexOf(thisObject.deplist[i].dept_id.toString()) == -1) {
                                                    thisObject.NotselectedDep.push(thisObject.deplist[i]);
                                                    //console.log(thisObject.deplist[i])
                                                }
                                            }
                                        setTimeout(function () {
                                            $("#addEditComAgentHeader select").selectpicker("refresh");
                                        }, 1500);
                                    })
                                    .catch(function (error) {
                                        console.error(error.message);
                                    });
                        }.bind(this),
                        1000
                        );
                setTimeout(function () {
                    $("#addEditComAgent select").selectpicker("refresh");
                }, 1500);
            },
            resetProfile() {
                var thisObject = this;
                thisObject.errorAvatar = "";
                thisObject.errorCellphone = "";
                thisObject.errorTimezone = "";
                thisObject.errorAgentName = "";
                thisObject.errorDisplayName = "";
            },
            logoutUser: function () {
                window.location.href = this.siteUrl + "logout";
            },
            activityPage: function () {
                window.location.href = this.siteUrl + "activity-dashboard";
            },
            reportPage: function () {
                window.location.href = this.siteUrl + "reports";
            },
            feedbackPage: function () {
                window.location.href = this.siteUrl + "feedback";
            },
            TeamSuggestionPage: function () {
                window.location.href = this.siteUrl + "suggestion-box";
            },
            knowledgebaseDDOpen: function () {
                $("header").addClass("kb-active");
                $("header").removeClass("ah-active");
                $("#helps")
                        .parents(".custm-toggle-dd")
                        .removeClass("op-show");
            },
            knowledgebaseAHOpen: function () {
                $("header").removeClass("kb-active");
                $("header").addClass("ah-active");
                $("#helps")
                        .parents(".custm-toggle-dd")
                        .removeClass("op-show");
            },
            changeUserStatus: function (sts) {
                this.userStatusName = sts;
            },
            ProcessInviteeImage(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.avatar_src = e.target.result;
                    vm.show_src = true;
                    $("#imageCroppingModalSquareHeader").modal("show");
                    setTimeout(function () {
                        vm.cropImage();
                    }, 1000);
                };
                reader.readAsDataURL(file);
            },
            cropImage: function () {
                let vm = this;
                this.$refs.croppieHeaderAvtar.bind({
                    url: vm.avatar_src,
                });
            },

            updateInvitation() {
                var thisObject = this;
                var validate = true;
                var regPhone = /^\d{10}$/;

                if (thisObject.avatar == "") {
                    // alert("required field");
                    thisObject.errorAvatar = "Photo is required field.";
                    validate = false;
                } else {
                    thisObject.errorAvatar = "";
                }
                if (!thisObject.agentname) {
                    thisObject.errorAgentName = "Name is required field.";
                    validate = false;
                } else {
                    thisObject.errorAgentName = "";
                }
                if (!thisObject.displayname) {
                    thisObject.errorDisplayName = "Display name is required field.";
                    validate = false;
                } else {
                    thisObject.errorDisplayName = "";
                }

                /*if(!thisObject.cell_phone){
                 thisObject.errorCellphone="Cell phone is requied field."
                 validate=false
                 }else if(!regPhone.test(thisObject.cell_phone)){
                 thisObject.errorCellphone="Cell phone is not valid no."
                 validate=false
                 }else{
                 thisObject.errorCellphone=""
                 }*/

                if (!thisObject.timezone) {
                    thisObject.errorTimezone = "Timezone is requied field.";
                    validate = false;
                } else {
                    thisObject.errorTimezone = "";
                }

                thisObject.agentid = thisObject.agentid;
                if (validate) {
                    axios
                            .post(thisObject.siteUrl + "update_invitation", {
                                avatar: thisObject.avatar_src,
                                agentname: thisObject.agentname,
                                displayname: thisObject.displayname,
                                email: thisObject.email,
                                cell_phone: thisObject.cell_phone,
                                system_role: thisObject.role_input,
                                status_on_login: thisObject.status_on_login,
                                timezone: thisObject.timezone,
                                maxchat: thisObject.maxchat,
                                email_transcript: thisObject.email_transcript,
                                login_default_view: thisObject.login_default_view,
                                selectedDep: thisObject.selectedDep,
                                eid: thisObject.agentid,
                                chatTimePlanid: thisObject.chatTimePlan,
                                from: "head",
                            })
                            .then(function (response) {
                                if (response.data == 1) {
                                    $("#addEditComAgentHeader").modal("hide");
                                } else {
                                    //console.log("not update");
                                    $("#addEditComAgentHeader").modal("hide");
                                }
                            })
                            .catch(function (error) {
                                console.error(error.message);
                            });
                    this.selectedDep = [];
                }
            },
            crop() {
                var thisObject = this;
                let options = {
                    format: "png",
                    circle: false,
                };
                this.$refs.croppieHeaderAvtar.result(options, (output) => {
                    thisObject.cropped = output;
                    thisObject.avatar_src = output;
                    thisObject.avatar = output;
                });
            },
            getdepartmentname(id) {
                for (var i = 0; i < this.deplist.length; i++) {
                    if (this.deplist[i].dept_id == id) {
                        return this.deplist[i].department;
                    }
                }
            },
            deleteDepartment(index, id) {
                this.selectedDep.splice(index, 1);
                for (var i = 0; i < this.deplist.length; i++) {
                    if (this.deplist[i].dept_id == id) {
                        this.NotselectedDep.push(this.deplist[i]);
                    }
                }
            },
            selectDepartment(depid) {
                this.selectedDep.push(depid);
                for (var i = 0; i < this.NotselectedDep.length; i++) {
                    if (this.NotselectedDep[i].dept_id == depid) {
                        this.NotselectedDep.splice(i, 1);
                    }
                }
            },
            // EVENT USAGE
            cropViaEvent() {
                this.$refs.croppieHeaderAvtar.result(options);
            },
            result(output) {
                this.cropped = output;
            },
            update(val) {
                //console.log(val)
            },
            rotate(rotationAngle) {
                // Rotates the image
                this.$refs.croppieHeaderAvtar.rotate(rotationAngle);
            },
            startIntroForGetStarted: function () {
                $("header .nav-menu #helps")
                        .parents("li")
                        .addClass("op-show");
                $("header .nav-menu #helpsSett").addClass("active");
                $("#helpAccordion > .card:first-child > .card-header a").attr({
                    "aria-expanded": "true",
                });
                $("#helpAccordion > .card:first-child #help-collapseOne").addClass("show");
                setTimeout(function () {
                    var intro = introJs();
                    intro.setOptions({
                        steps: [
                            {
                                element: "#it-help-headingZero",
                                intro:
                                        '<h1 class="text-center text-uppercase tutorial-heading fs-20">Alert</h1><div class="step-wrap px-3 py-4"><div class="row justify-content-start"><div class="col px-4 mx-2"><div class="row"><div class="col-auto"><img class="br-10  p-1 border" src="http://dev.local.com/app.freechat247live.com/images/theme/default/w/d-agent-4-white.png" width="54px"><span class="text-lgray mt-1 d-block text-center fs-12">Darlene</span></div><div class="col"><p class="feature-para bg-white pos-rel text-black px-4 py-3 rounded fs-16 d-inline-block">No problem. You can always pick up where you left off here.</p></div></div></div></div></div>',
                                position: "left",
                            },
                        ],
                        nextLabel: " <i class='fa fa-chevron-right'></i> ",
                        prevLabel: " <i class='fa fa-chevron-left'></i> ",
                        exitOnOverlayClick: false,
                    });
                    intro.onchange(function () {}).start();
                }, 500);
            },
            startChat247Live: function () {
                var $self = this;
                if (this.$store.state.isConversationPage) {
                    $self.$store.commit("initializeAndRunChat");
                    window.chatRefreshTimer = setInterval(function () {
                        $self.$store.commit("runChat");
                        $self.$store.commit("checkJSPScrollExit");
                    }, 4000);
                } else {
                    $self.$store.commit("headerChatWatch");
                    window.chatRefreshTimer = setInterval(function () {
                        $self.$store.commit("headerChatWatch");
                    }, 4000);
                }
            },
            startChat247LiveAuto: function () {
                var data = {};
                this.startChat247Live(data);
            },
            changeUserAvailablityStatus: function () {
                var $self = this;
                axios
                        .get(this.siteUrl + "change-user-availablity-status")
                        .then(function (response) {})
                        .catch(function (error) {
                            console.error(error.message);
                        });
                return true;
            },
            /** START Notifications  */
            checkIfNotificationsExistsOnPage: function (needle, haystack) {
                var length = haystack.length;
                for (var i = 0; i < length; i++) {
                    if (haystack[i] === needle)
                        return i;
                }
                return -1;
            },
            dismissNotifications: function (notificationId) {
                var thisObject = this;
                axios
                        .post(thisObject.siteUrl + "update-user-noticfication-dismissed", {id: notificationId})
                        .then(function (response) {
                            if (response.data.success == true) {
                                thisObject.removeNotificationsFromDisplay(notificationId);
                            }
                        })
                        .catch(function (error) {
                            //console.log(error)
                        });
            },
            updateNotificationsDelivered(updateNotifications) {
                var thisObject = this;
                axios
                        .post(thisObject.siteUrl + "update-user-noticfication-delivered", {updateNotifications}, {showLoader: false})
                        .then(function (response) {})
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            removeNotificationsFromDisplay: function (notificationId) {
                var thisObject = this;
                var index = thisObject.checkIfNotificationsExistsOnPage(notificationId, thisObject.userNotificaionsIds);
                if (index >= 0) {
                    // delete the element
                    thisObject.userNotificaionsIds.splice(index, 1);
                    thisObject.userNotifications.splice(index, 1);
                }
            },
            getSourcesAndTypes() {
                var thisObject = this;
                axios
                        .get(thisObject.siteUrl + "notifications-sources-types-header")
                        .then(function (response) {
                            if (response.data.sources != undefined) {
                                thisObject.notificationSource = response.data.sources;
                            }
                            if (response.data.types != undefined) {
                                thisObject.notificationType = response.data.types;
                            }
                            if (response.data.values != undefined) {
                                thisObject.userNotificationSettings = response.data.values;
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            checkIfNotificationPermittedByUser: function (notification_source, notification_type) {
                var thisObject = this;
                if (notification_source !== "" && notification_type !== "") {
                    if (thisObject.userNotificationSettings[notification_source][notification_type] !== undefined) {
                        return (thisObject.userNotificationSettings[notification_source][notification_type] ? true : false)
                    }
                }
                return false
            },
            async fetchNotificationsForUser() {
                var thisObject = this;
                //console.log("Notifs")
                axios
                        .post(thisObject.siteUrl + "get-user-noticfication", thisObject.userNotificaionsIds, {showLoader: false})
                        .then(function (response) {
                            let notifications = response.data.notifications;
                            let updates = response.data.updates;
                            let updateNotifications = [];
                            let dispayBrowserNotifications = false;
                            if (thisObject.userNotificaionsIds.length !== 0) {
                                dispayBrowserNotifications = true;
                            }
                            if (notifications.length > 0) {
                                notifications.forEach((element) => {
                                    //if bell notifications permitted by user
                                    if (thisObject.checkIfNotificationPermittedByUser(element.notification_type, 'BELL')) {
                                        // insert values into notifications array
                                        if (thisObject.checkIfNotificationsExistsOnPage(element.id, thisObject.userNotificaionsIds) == -1) {
                                            thisObject.userNotificaionsIds.unshift(element.id);
                                            thisObject.userNotifications.unshift(element);
                                            if (element.is_delivered !== 1) {
                                                updateNotifications.push(element.id);
                                            }
                                        }
                                    }
                                    //if the page is not jsut loaded
                                    if (dispayBrowserNotifications) {
                                        //if Browser notifications permitted by user
                                        if (thisObject.checkIfNotificationPermittedByUser(element.notification_type, "BROWSER")) {
                                            if (element.is_delivered !== 1) {
                                                var notification = new Notification(element.title, {
                                                    icon: element.image,
                                                    body: element.body.message,
                                                });
                                                notification.onclick = function () {
                                                    window.open(element.url);
                                                };
                                                updateNotifications.push(element.id);
                                            }
                                        }
                                    }
                                });
                            }
                            if (updateNotifications.length > 0) {
                                thisObject.updateNotificationsDelivered(updateNotifications);
                            }
                            // if exisiting notifications are dismissed from any other source remove from display
                            if (updates.length > 0) {
                                updates.forEach((update) => {
                                    if (update.is_dismissed == 1) {
                                        thisObject.removeNotificationsFromDisplay(update.id);
                                    } else {
                                        thisObject.userNotifications.forEach((updatedNotification, index) => {
                                            if (updatedNotification.display_type == "DIRECT_MESSAGE" && updatedNotification.source_id == update.source_id && updatedNotification.body.message_id !== update.body.message_id) {
                                                thisObject.userNotifications[index].body = update.body;
                                                thisObject.userNotifications[index].created_at = update.created_at;
                                                thisObject.userNotifications[index].unread_msg_count = update.unread_msg_count;
                                            }
                                        });
                                    }
                                    // insert values into notifications array
                                });
                            }
                        })
                        .catch(function (error) {
                            //console.log("error " + error)
                        })
                        .then(function () {
                            // always executed
                            setTimeout(thisObject.fetchNotificationsForUser, 5000);
                        });
            },
            checkBrowserSupportsNotificationsAndRequestPermission() {
                var thisObject = this;
                if (!Notification) {
                    return false;
                }
                thisObject.requestPermission();
            },
            getUserRolePermissions: function () {
                const thisObj = this;
                axios
                        .get(thisObj.siteUrl + "get-user-role-permission")
                        .then(function (response) {
                            if (response.data && response.data.status == "success")
                                thisObj.userRolePermissions = response.data.userRolePermissions;
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            isPermission(permission_key) {
                const thisObj = this;
                let return_value = false;
                $.each(thisObj.userRolePermissions, function (role_permission_key, role_permission_value) {
                    if (role_permission_value.permission_slug == permission_key)
                        return_value = role_permission_value.status;
                });
                //console.log(return_value);
                //return return_value;
            },
            requestPermission() {
                var thisObject = this;
                if (Notification.permission !== "granted" || Notification.permission !== "default") {
                    thisObject.browserNotifications = false;
                    //console.log("Request Notifications Permission")
                    Notification.requestPermission().then(function (permission) {
                        thisObject.browserNotifications = true;
                    });
                }
                if (Notification.permission === "granted") {
                    thisObject.browserNotifications = true;
                }
            },
            getCompantDetails() {
                var thisObject = this;
                axios
                        .get(thisObject.siteUrl + "user/company-details")
                        .then(function (response) {
                            if (response.data.status == 1) {
                                thisObject.companyDetails = response.data.record;
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            /** END Notifications  */

            openChat() {
                ///$("#desktop_chat_window_iframe").attr('src', this.siteUrl+'all-window-bot/'+this.editId);

                var urlOld = $("#oq-chat-ssp").attr("src");
                var contactid = "";
                if (this.SubscriberAsContact) {
                    contactid = this.SubscriberAsContact.id;
                }

                if (urlOld) {
                    var res = urlOld.split("/");

                    var url = res[res.length - 1];
                    if (res.length == 9) {
                        urlOld = urlOld + "/1/0/" + contactid;
                    }

                    $("#oq-chat-ssp").attr("src", urlOld);
                }
            },

            GetSubscriberAsContact() {
                var thisObject = this;
                axios
                        .get(thisObject.siteUrl + "get-subscriber-as-contact")
                        .then(function (response) {
                            if (response.data.status == 1) {
                                thisObject.SubscriberAsContact = response.data.contactData;
                                // thisObject.openChat();
                            }
                            //console.log("get-subscriber-as-contact", thisObject.SubscriberAsContact)
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
        },
        async created() {
            var $self = this;
            $self.getCompantDetails();

            await axios
                    .get(this.siteUrl + "user/get-loggedin-user")
                    .then(function (response) {
                        $self.currentUser = response.data;
                        $self.$store.commit("loginUser", $self.currentUser);
                        $self.loaded = 1;
                        if ($self.currentUser.is_available == 2) {
                            $self.btnToggleUserStatusVal = false;
                        }
                        $self.startChat247LiveAuto();
                        //                        if ($self.currentUser.role_id == 5) {
                        //                            $('body').addClass('collab-guest-page');
                        //                        }
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
        },
        mounted: function () {
            var thisObject = this;
            var isForSplit = true;
            setInterval(() => {
                if (this.$store.state.isConversationPage && isForSplit) {
                    if ($("#split-0").length) {
                        isForSplit = false;
                        this.$store.commit("bindSplitLeftRight");
                        this.$store.commit("consoleWindowViewChange", "1");
                        $("#conversation_view_oq").selectpicker("refresh");
                        $("#collapseAddOneExtra select").selectpicker("refresh");
                    }
                }
                this.$forceUpdate();
            }, 1000);
            setTimeout(() => {
                this.agentname = this.currentUser.name;
                this.displayname = this.currentUser.displayName;
                this.email = this.currentUser.email;
            }, 1000);

            this.GetSubscriberAsContact();

            setInterval(function () {
                var urlOld = $("#oq-chat-ssp").attr("src");

                if (urlOld) {
                    var res = urlOld.split("/");
                    var url = res[res.length - 1];
                    if (res.length == 9) {
                        thisObject.openChat();
                    }
                }
            }, 3000);

            //            this.getCompantDetails();
            //            var thisObject = this;
            thisObject.getSourcesAndTypes();
            thisObject.fetchNotificationsForUser();
            thisObject.getUserRolePermissions();
            thisObject.getEmailSignature();
            $("#allPluginModal").on("hidden.bs.modal", function () {
                //                thisObject.startIntroForGetStarted();
            });
            $("#addEditComAgentHeader").on("show.bs.modal", function () {
                $("body").addClass("profile-modal");
            });
            $("#addEditComAgentHeader").on("hidden.bs.modal", function () {
                $("body").removeClass("profile-modal");
            });
            thisObject.checkBrowserSupportsNotificationsAndRequestPermission();
            axios
                    .post(thisObject.siteUrl + "get-role-list")
                    .then(function (response) {
                        thisObject.roles = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            axios
                    .get(thisObject.siteUrl + "get-timezone-list")
                    .then(function (response) {
                        thisObject.timezoneList = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            axios
                    .post(thisObject.siteUrl + "get-skill-list")
                    .then(function (response) {
                        thisObject.skillList = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            axios
                    .get(thisObject.siteUrl + "getDepartment")
                    .then(function (response) {
                        //console.log("response.data ", response.data);
                        thisObject.deplist = response.data.departments;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            axios
                    .post(thisObject.siteUrl + "get-all-plan")
                    .then(function (response) {
                        thisObject.plans = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            axios
                    .post(thisObject.siteUrl + "getWebsite")
                    .then(function (response) {
                        thisObject.WebList = response.data;
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
            var uri = window.location.href.split("/");
            if (uri[uri.length - 1] == "reports") {
                $("#inhousemsgg").addClass("active");
            }
            if (uri[uri.length - 1] == "activity-dashboard") {
                $("#notifications").addClass("active");
            }
            if (uri[uri.length - 1] == "feedback") {
                $("#feedbackPage").addClass("active");
            }
            if (thisObject.currentUser.role_id == 5) {
                $("body").addClass("collab-guest-page");
            }
            EventBus.$once("setProfileModal", (edit) => {
                this.setProfileModal("edit", "update");
                //console.log(test);
            });
        },
    };
</script>

<style></style>
