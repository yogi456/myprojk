(function($) {
    $.fn.lc = function() {
        var lcUrl = document.getElementById('s1').src;
        for (var i = 0; i < this.length; i++) {
            var lc = $(this[i]).attr('class');
            var d = lc.split(" ");
            var target = '.' + d[0];
//          Get subscriber Id
            var sid = d[1];
//          Create Url For getting Button code
            var $url = lcUrl.substr(0, (lcUrl.length - 3));
            $(target).html(butttonCode(target, $url, sid));
        }
        function butttonCode(target, $url, sid) {
            $.ajax({
                async: false,
                contentType: 'application/json',
                type: 'GET',
                url: $url + '?callback=mycallback',
                data: {subscriber_id: sid},
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






