<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Test something</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
            (function($) {
                var LrwLoopB = function (element, options){
                    var settings = $.extend({}, $.fn.lrwLoopB.defaults, options);
                    
                    if (settings.delay > settings.speed) return false;
                    
                    var loopB = $(element);
                    var numChild = loopB.children(settings.child).length;
                    var currentEffect = settings.effect;
                    
                    loopB.children(settings.child).each(function(i){
                        $(this).addClass("loopb-child-"+i);
                    });
                    
                    var runItem = function(el, delay, speed, start){
                        setTimeout(function(){
                            el.css(settings.show);
                            setTimeout(function(){el.css(settings.hide)}, delay);
                        }, start);
                    };
                    
                    var effectElement = function(el, delay, speed, start = 0){
                        runItem(el, delay, speed, start);
                        setInterval(function(){
                           runItem(el, delay, speed, start);
                        }, speed, true);
                    };
                    
                    loopB.children(settings.child).css(settings.hide);
                    switch(currentEffect)
                    {
                        case 'onoff': 
                            effectElement(loopB.children(settings.child), settings.delay, settings.speed);
                            break;
                        case 'zigzag':
                            effectElement(loopB.children(settings.child+":nth-child(odd)"), settings.delay, settings.speed);
                            effectElement(loopB.children(settings.child+":nth-child(even)"), settings.delay, settings.speed, settings.speed/2);
                            break;
                        case 'zigzago':
                            effectElement(loopB.children(settings.child+":nth-child(odd)"), settings.delay, settings.speed);
                            break;
                        case 'zigzage':
                            effectElement(loopB.children(settings.child+":nth-child(even)"), settings.delay, settings.speed);
                            break;
                        case 'ltr':
                            var part = settings.speed/numChild;
                            var start = 0;
                            for (var i = 0; i < numChild; i++) {
                                effectElement(loopB.children(settings.child+".loopb-child-"+i), settings.delay, settings.speed, start);
                                if (i !== numChild) start += part; else start = 0;
                            }
                            break;
                        case 'rtl':
                            var part = settings.speed/numChild;
                            var start = 0;
                            for (var i = (numChild-1); i >= 0; i--) {
                                effectElement(loopB.children(settings.child+".loopb-child-"+i), settings.delay, settings.speed, start);
                                if (i !== numChild) start += part; else start = 0;
                            }
                            break;
                        default: 
                            return false;
                    }
                };

                $.fn.lrwLoopB = function(options) {
                    var element = $(this);
                    var lrwLoopB = new LrwLoopB(this, options);
                };
                $.fn.lrwLoopB.defaults = {
                    effect: 'onoff',
                    speed: 1000,
                    delay: 500,
                    child: 'li',
                    show: {'visibility':'visible'},
                    hide: {'visibility':'hidden'},
                }
            })(jQuery);

            $(document).ready(function(){
                $("#lb1").lrwLoopB({
                    effect: 'ltr',
                    speed: 1000,
                    delay: 100,
                });
                $("#lb2").lrwLoopB({
                    effect: 'rtl',
                    speed: 1000,
                    delay: 100,
                });
            });

        </script> 
        <style>
            ul {
                list-style-type: none;
            }
            ul li {
                float: left;
                margin: 5px;
            }
        </style>
    </head>
    <body>
        <?php
            echo '<ul id="lb1">';
            for ($i = 1; $i < 10; $i++)
            {
                echo '<li>&diams;</li>';
            }
            echo '</ul><br />';

            echo '<ul id="lb2">';
            for ($i = 1; $i < 10; $i++)
            {
                echo '<li>&diams;</li>';
            }
            echo '</ul>';
        ?>
    </body>
</html>
