<!doctype html>
<html id="oq-active-win-desk" style="overflow: hidden;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('css/webiframe.css')); ?>">
    </head>
    <body>
        <style>
            *{
                box-sizing: border-box;
            }
            .editor-emoji-icon{
                height: 20px;
                float: left;
            }
            html,body{margin: 0;}
            html,body,textarea{font-family: 'Open Sans', sans-serif;}
            .v-msg div:last-child{display:none !important;}
            /*#lc-typingIcon{display: none !important;}*/
            select {
                -webkit-appearance: none;
                -moz-appearance: none;
                padding: 5px 8px;
            }
            *::placeholder {color: #ccc;opacity: 1;}
            *::-webkit-placeholder {color: #ccc;opacity: 1;}
            *::-moz-placeholder {color: #ccc;opacity: 1;}
            select:required:invalid {
                color: #ccc;
            }
            option[value=""][disabled] {
                display: none;
            }
            /* On mouse-over, add a grey background color */
            /*            .custom-checkbox:hover input ~ .checkmark {
                            background-color: #ccc !important;
                        }*/

            /* When the checkbox is checked, add a blue background */
            .custom-checkbox input:checked ~ .checkmark {
                background-color: rgb(0, 117, 217) !important;
            }
            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
                content: "";
                position: absolute;
                display: none;
            }
            /* Show the checkmark when checked */          
            .custom-checkbox input:checked ~ .checkmark:after {
                display: block;
            }
            /* Style the checkmark/indicator */
            .custom-checkbox .checkmark:after {
                left: 10px;
                top: 6px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            /* width */
            ::-webkit-scrollbar {
                width: 10px;
                position: absolute;
                left: 0;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #f1f1f1; 
                border-radius: 5px;

            }

            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #888; 
                border-radius: 5px;
            }
        </style>
        <div id="app">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <input type="hidden" id="appBaseUrl" name="app_base_url" value="<?php echo e(url('')); ?>" />
        <script src="<?php echo e(asset('js/components/iframe.js')); ?>"></script>
        <style>
            .tab-button {
                padding: 6px 10px;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
                border: 1px solid #ccc;
                cursor: pointer;
                background: #f0f0f0;
                margin-bottom: -1px;
                margin-right: -1px;
            }
            .tab-button:hover {
                background: #e0e0e0;
            }
            .tab-button.active {
                background: #e0e0e0;
            }
            .tab {
                border: 1px solid #ccc;
                padding: 10px;
            }
            .posts-tab {
                display: flex;
            }
            .posts-sidebar {
                max-width: 40vw;
                margin: 0;
                padding: 0 10px 0 0;
                list-style-type: none;
                border-right: 1px solid #ccc;
            }
            .posts-sidebar li {
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                cursor: pointer;
            }
            .posts-sidebar li:hover {
                background: #eee;
            }
            .posts-sidebar li.selected {
                background: lightblue;
            }
            .selected-post-container {
                padding-left: 10px;
            }
            .selected-post > :first-child {
                margin-top: 0;
                padding-top: 0;
            }
            .dropbtn {
                background-color: #3498DB;
                color: white;
                padding: 16px;
                font-size: 16px;
                border: none;
                cursor: pointer;
            }

            /* Dropdown button on hover & focus */
            .dropbtn:hover, .dropbtn:focus {
                background-color: #2980B9;
            }

            /* The container <div> - needed to position the dropdown content */
            .dropdown {
                position: relative;
                display: inline-block;
            }

            /* Dropdown Content (Hidden by Default) */
            .dropdown-content-oq {
                display: none;
                position: absolute;
                background-color: #f1f1f1;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
                bottom: 54px;
                right: 0;
            }

            /* Links inside the dropdown */
            .dropdown-content-oq a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            /* Change color of dropdown links on hover */
            .dropdown-content-oq a:hover {background-color: #ddd}

            /* Show the dropdown menu (use JS to add this class to the .dropdown-content-oq container when the user clicks on the dropdown button) */
            .show {display:block;}

        </style>
        <script type="text/javascript">
$("#seeMore").hide();
$("#seeLess").hide();
$("#resultYes").hide();
$("#resultNo").hide();
jQuery("#snd-e-book-oq").submit(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    jQuery.ajax({
        type: "POST",
        url: $self.siteUrl + 'send-ebook-chat-visitor',
        data: jQuery(this).serialize(),
        success: function (data)
        {
            alert(data);
        }
    });
});
jQuery("#subscriber_submit").click(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var name = jQuery("#subscribe_name").val();
    var email = jQuery("#subscribe_email").val();
    var newscheck = jQuery("#newsval").val();
    var blogcheck = jQuery("#blogval").val();
    var subscriber = jQuery("#subscriber_id").val();


    jQuery.ajax({
        type: "POST",
        url: $self.siteUrl + 'send-subscriber-data',
        data: {name: name, email: email, newscheck: newscheck, blogcheck: blogcheck, subscriber_id: subscriber},
        success: function (data)
        {
            alert(data);
        }
    });

});
jQuery("#trialsave").click(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var name = jQuery("#trialName").val();
    var email = jQuery("#trialEmail").val();
    var subscriber = jQuery("#subscriber_id").val();
    jQuery.ajax({
        type: "POST",
        url: $self.siteUrl + 'send-trial-data',
        data: {name: name, email: email, subscriber_id: subscriber},
        success: function (data)
        {
            alert(data);
        }
    });
});
jQuery("#webinarSubmit").click(function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var name = jQuery("#webinarName").val();
    var email = jQuery("#webinarEmail").val();
    var subscriber = jQuery("#subscriber_id").val();
    jQuery.ajax({
        type: "POST",
        url: $self.siteUrl + 'send-webinar-data',
        data: {name: name, email: email, subscriber_id: subscriber},
        success: function (data)
        {
            alert(data);
        }
    });
});
//        Start - code for toggle top right sidebar menu
var flg = true;
jQuery(document).on('click', '.lc-menuBtnChatWindow', function () {
    if (flg) {
        jQuery('.lc-chatWindowFeatures').css({'right': '65px'});
        flg = false;
    } else {
        jQuery('.lc-chatWindowFeatures').css({'right': '-225px'});
        flg = true;
    }
});
jQuery(document).on('click', '.lc-visitorSurveyBtn', function () {
    jQuery('.lc-chatVisitorSurveyWrap').slideToggle();
    jQuery('.lc-chatWindowFeatures').css({'right': '-225px'});
    flg = true;
});
jQuery(document).on('click', '.lc-chatVisitorSurveyWrap a', function () {
    jQuery('.lc-chatVisitorSurveyWrap').slideToggle();
});
function showSmilye() {
    setTimeout(function () {
        document.getElementById("myDropdown").classList.toggle("show");
    }, 500);
}

$(document).click(function (event) {
    if (!$(event.target).closest('#myDropdown').length) {
        if ($('#myDropdown').is(":visible")) {
            document.getElementById("myDropdown").classList.remove("show");
        }
    }
});

function pasteHtmlAtCaret(event) {
    var html = '<img src="' + event.target.currentSrc + '" class="editor-emoji-icon" alt=""/>';
    $("#chatWindowFooterInput").html($("#chatWindowFooterInput").html() + html + ' ');

    cursorManager();
}
var voidNodeTags = ['AREA', 'BASE', 'BR', 'COL', 'EMBED', 'HR', 'IMG', 'INPUT', 'KEYGEN', 'LINK', 'MENUITEM', 'META', 'PARAM', 'SOURCE', 'TRACK', 'WBR', 'BASEFONT', 'BGSOUND', 'FRAME', 'ISINDEX'];
function cursorManager() {
    Array.prototype.contains = function (obj) {
        var i = this.length;
        while (i--) {
            if (this[i] === obj) {
                return true;
            }
        }
        return false;
    }
    setEndOfContenteditable(document.getElementById('chatWindowFooterInput'));
}
function setEndOfContenteditable(contentEditableElement)
{
    while (getLastChildElement(contentEditableElement) &&
            canContainText(getLastChildElement(contentEditableElement))) {
        contentEditableElement = getLastChildElement(contentEditableElement);
    }
    var range, selection;
    if (document.createRange)
    {
        range = document.createRange();
        range.selectNodeContents(contentEditableElement);
        range.collapse(false);
        selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    } else if (document.selection)
    {
        range = document.body.createTextRange();
        range.moveToElementText(contentEditableElement);
        range.collapse(false);
        range.select();
    }
}
function canContainText(node) {
    if (node.nodeType == 1) {
        return !voidNodeTags.contains(node.nodeName);
    } else {
        return false;
    }
}
function getLastChildElement(el) {
    var lc = el.lastChild;
    while (lc && lc.nodeType != 1) {
        if (lc.previousSibling)
            lc = lc.previousSibling;
        else
            break;
    }
    return lc;
}
$(document).ready(function () {
    $('#allFormWrapper').scroll(function () {
        if ($(this).scrollTop() < 200) {
            $('#lc-chatHeadMainWrap').css({'margin-top': -0.3 * $(this).scrollTop(), 'opacity': (-1 * ($(this).scrollTop() - 99)) / 100});
        }
    });
    $('.custom-checkbox span').click(function () {
        $(this).hide();
//                    if ($(this).is(":checked")) {
//                        var returnVal = confirm("Are you sure?");
//                        $(this).attr("checked", returnVal);
//                    }
    });
});
        </script>
    </body>
</html>
