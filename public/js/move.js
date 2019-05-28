(function($){
    $.fn.floatAd = function(options){
        var defaults = {
            imgSrc : "http://wenwen.soso.com/p/20100204/20100204193850-483274619.jpg", //婕傛诞鍥剧墖璺緞
            url : "http://map.yanue.net", //鍥剧墖鐐瑰嚮璺宠浆椤�
            openStyle : 1, //璺宠浆椤垫墦寮€鏂瑰紡 1涓烘柊椤甸潰鎵撳紑  0涓哄綋鍓嶉〉鎵撳紑
            speed : 10, //婕傛诞閫熷害 鍗曚綅姣
            hasClose: true
        };
        var options = $.extend(defaults,options);
        var _target = options.openStyle == 1 ?  "target='_blank'" : '' ;
        var html = "<div id='float_ad' style='position:absolute;left:0px;top:0px;z-index:1000000;cleat:both;'>";
        html += "  <a href='" + options.url + "' " + _target + "><img src='" + options.imgSrc + "' border='0' class='float_ad_img'/></a>";
        if(options.hasClose){
            html += "<a href='javascript:;' id='close_float_ad' style=''>x</a>"
        }
        html += "</div>";

        $('body').append(html);

        function init(){
            var x = 0,y = 0
            var xin = true, yin = true
            var step = 1
            var delay = 10
            var obj=$("#float_ad")
            obj.find('img.float_ad_img').load(function(){
                var float = function(){
                    var L = T = 0;
                    var OW = obj.width();//褰撳墠骞垮憡鐨勫
                    var OH = obj.height();//楂�
                    var DW = document.documentElement.clientWidth; //娴忚鍣ㄧ獥鍙ｇ殑瀹�
                    var DH = document.documentElement.clientHeight;

                    x = x + step *( xin ? 1 : -1 );
                    if (x < L) {
                        xin = true; x = L
                    }
                    if (x > DW-OW-1){//-1涓轰簡ie
                        xin = false; x = DW-OW-1
                    }

                    y = y + step * ( yin ? 1 : -1 );
                    if (y > DH-OH-1) {

                        yin = false; y = DH-OH-1 ;
                    }
                    if (y < T) {
                        yin = true; y = T
                    }

                    var left = x ;
                    var top = y;

                    obj.css({'top':top,'left':left});
                }
                var itl = setInterval(float,options.speed);
                $('#float_ad').mouseover(function(){clearInterval(itl)});
                $('#float_ad').mouseout(function(){itl=setInterval(float, options.speed)} )
            });
            // 鐐瑰嚮鍏抽棴
            $('#close_float_ad').live('click',function(){
                $('#float_ad').hide();
            });
        }

        init();

    }; //floatAd

})(jQuery);