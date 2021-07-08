<!doctype html>
<html id="oq-active-win-desk">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/webiframe.css') }}">
    </head>
    <body>
        <div id="app" class="app-win-body">
            @yield('content')
            <loader :is-visible="isLoading"></loader>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="{{ url('') }}" />
        <input type="hidden" id="customfield" name="customfield" value="{}" />
        <input type="hidden" id="shopifyData" name="shopifyData" value="" />
        <input type="hidden" id="scrollPer" name="scrollPer" value="0" />
        <script src="{{asset('js/components/webiframe.js')}}"></script>
        <script>
var chatRefreshTimer = '';
var iFrameResizer = {
    onMessage: function (message) {
        if (message == 'start_chat') {
            jQuery('#app #lc-chatButtonWrapper-outer .button-iframe').click();
        } else if (message == 'start_chat_from_contact_page') {
            jQuery('#app #lc-chatButtonWrapper-outer .button-iframe').click();
        } else {
            alert(message, parentIFrame.getId());
        }
    }
}

var sendGoogleEvent = function (category, action, label = '', value = 0) {

    var result = window.parent.postMessage({
        'func': 'initiateAnalytics',
        'all': {
            'category': category,
            'action': action,
            'label': label,
            'value': value
        }
    }, '*');
}
/*$(function(){
        setTimeout(function () {
            //console.log('sending ga event page');
            $('#app #lc-chatButtonWrapper-outer .button-iframe #lc-onLineUploadBtn').click(function(){
               sendGoogleEvent('chat-Playbook', 'Start', 'Chat', 0); 
            });
        },5000);
});*/
var chatWindow_open=function(){
    setTimeout(function () {
                 sendGoogleEvent('chat-Playbook', 'Start', 'Chat', 0); 
             },5000);
    }
/*var chatWindow_close=function(){
     sendGoogleEvent('Chat-Playbook', 'Close', 'Chat', 0); 
}*/

var replyChat=function(){
     sendGoogleEvent('Chat-playbook-reply', 'Reply', 'Chat-reply', 0); 
}

var prechat=function(){
    sendGoogleEvent('pre-chat', 'submit-details', 'prechat', 0);
}
var ebookChat=function(){
    sendGoogleEvent('ebook-download', 'submit-details', 'download book', 0);
}
var subscribeChat=function(){
    sendGoogleEvent('Subscribes-chat', 'submit-details', 'subscribes', 0);
}
var trialChat=function(){
    sendGoogleEvent('trial-chat', 'submit-details', 'trial', 0);
}
var demoChat=function(){
    sendGoogleEvent('demo-chat', 'submit-details', 'demo', 0);
}





window.addEventListener('message', function (event) {
    var myJSON = '';

    try {
        if (event.data.data !== undefined) {
            var checkdata = JSON.stringify(event.data.data);
            checkdata = JSON.parse(checkdata);

            if (checkdata.type == 'scroll') {
                $("#scrollPer").val(checkdata.data);
            } else {
                if (event.data.data.data) {
                    if (event.data.data.data != '') {
                        myJSON = JSON.stringify(event.data.data.data);
                        $("#customfield").val(myJSON);
                    }
                }

                var idd = ''; var shopify='';
                setInterval(function () {
                    idd = $("#customfield").val();
                    if (idd == '{}') {
                        if (event.data.data.data) {
                            if (event.data.data.data != '') {
                                myJSON = JSON.stringify(event.data.data.data);
                                $("#customfield").val(myJSON);
                            }
                        }
                    }

                    
                    shopify = $("#shopifyData").val();
                    if (shopify == '') {
                        if (event.data.data.shopifyfield) {
                            if (event.data.data.shopifyfield != '') {
                                myJSON = JSON.stringify(event.data.data.shopifyfield);
                                $("#shopifyData").val(myJSON);
                            }
                        }
                    }
                }, 3000);

            }
        }
    } catch (err) {
        console.log('error')
        console.log(err)
    }

});



/*  code for visitor end for custom field*/
/*
 function test(){
 
 var test = { 
 'type':'customfield',
 'data':{
 "phone": '787978ss',
 "name": 'atul nam',
 "type": false 
 }
 };
 
 console.log(test);
 send_data_to_server(test);
 
 }
 
 // function to solve loading issue send custom field 
 for (let i=2; i<40; i++) {
 task(i); 
 } 
 
 function task(i) { 
 setTimeout(function() { 
 try {
 test();
 }
 catch(err) {
 console.log('error')
 console.log(err)
 }
 }, 2000 * i); 
 } 
 */



        </script>
        <style>
            .app-win-body .loader-overlay{background-color: transparent !important;}
        </style>
    </body>
</html>
