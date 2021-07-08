/*
 * This Template used to load chat button Multip.
 */

(function($) {
    $.fn.lc = function(oq) {
        oq.refererUrl = window.location.href;
        var lcUrl = document.getElementById('s1').src;
//        Create Url For getting Button code
        var $url = lcUrl.substr(0, (lcUrl.length - 3));
        butttonCode(oq, $url);
        function butttonCode(oq, $url) {
            $.ajax({
                async: false,
                contentType: 'application/json',
                type: 'GET',
                url: $url + '?callback=mycallback',
                data: {oq: oq},
                dataType: 'jsonp',
                success: function(data) {
                        if (data.button_code) {
                            $(target).html(data.button_code);
                        }
                }
            });
        }
    };
}(jQuery));






