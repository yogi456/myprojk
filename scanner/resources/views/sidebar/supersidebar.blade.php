<?php
$chatMenuClass = '';
$systemMenuClass = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $urlArr = explode('/', $_SERVER['REQUEST_URI']);
    $urlLast = $urlArr[count($urlArr) - 1];
    if ($urlLast == 'console' || $urlLast == 'notifications' || $urlLast == 'scripts' || $urlLast == 'shortcuts' || $urlLast == 'languages' || $urlLast == 'transcript-archive' || $urlLast == 'visitor' || $urlLast == 'button-design' || $urlLast == 'triggers' || $urlLast == 'routing' || $urlLast == 'chat-scheduling' || $urlLast == 'code' || $urlLast == 'company' ||  $urlLast == 'integration' || $urlLast == 'apps' || $urlLast == 'settings') {
        if ($urlLast == 'console'  || $urlLast == 'scripts' || $urlLast == 'shortcuts' || $urlLast == 'languages' ||  $urlLast == 'transcript-archive' || $urlLast == 'visitor' || $urlLast == 'button-design' || $urlLast == 'triggers' || $urlLast == 'routing' || $urlLast == 'chat-scheduling' || $urlLast == 'code') {
            $chatMenuClass = 'show';
            $systemMenuClass = '';
        }
        if ($urlLast == 'company' ||  $urlLast == 'integration' || $urlLast == 'apps' || $urlLast == 'settings'|| $urlLast == 'notifications' || $urlLast == 'features') {
            $systemMenuClass = 'show';
            $chatMenuClass = '';
        }
    } else {
        $chatMenuClass = '';
        $systemMenuClass = '';
    }
}
?>

<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <div class="sidenav-header-inner text-center w-100">
                <a href="{{url('/')}}" class="ml-5 p-0 d-inline"><img src="{{ url('/images/logo1.png')}}" alt="person" class="img-fluid rounded-circle "></a>
                <div class="navbar-header pull-right align-self-center"><a id="toggle-btn" href="#" class="menu-btn pt-3"><i class="fa fa-bars m-0" aria-hidden="true"></i></i></a></div>
            </div>
            <div class="sidenav-header-logo"><a id="toggle-btn" href="#" class="menu-btn brand-small"><i class="fa fa-bars m-0" aria-hidden="true"></i></a></div>
        </div>
        <div class="main-menu">
            <ul id="side-main-menu" class="side-menu list-unstyled">                    
                <li class="contact-menu"> <a href="{{url('admin/contact')}}" ><i class="fa fa-ticket" aria-hidden="true"  data-toggle="tooltip" data-placement="right" title="Contacts"  data-template='<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner" style="font-size:18px;"></div></div'></i><span>Contacts</span></a></li>
            </ul>
        </div>
        <!--<a class="waiting-chat" href=""><span class="wait-chat-count">0</span> Chats waiting</a>-->
    </div>
</nav>
