/**
 * Created with JetBrains PhpStorm.
 * User: willy
 * Date: 2/16/14
 * Time: 8:23 AM
 * To change this template use File | Settings | File Templates.
 */

(function(window, document, $) {

    var on = false;

    var Timer = function( options ) {
        opt = $.extend({}, $.fn.default, options);
    };

    function show(tok) {
        $("#timer").html(tok);
    }

    function formater(number) {
        if(number % 1 == 0){
            var divisor = 60;
            var min = Math.floor(number/divisor);
            var sec = Math.floor(number - (min * 60));

            return min+':'+sec;
        }
    }

    Timer.prototype.start = function() {
        if(!on) {
            on = !on;
            tik = setInterval(function() {
                show(formater(opt.limit));
                opt.limit = opt.limit-1;

                if(opt.limit === -1){
                    Timer.prototype.stop();
                }

            }, 1000);
        }
    }

    Timer.prototype.stop = function() {
        if(on == true) {
            clearInterval(tik);
            on = !on;
        }
    }

    $.fn.default = {
        limit: 150
    }

    var timer = new Timer();
    timer.start()

    $("#next").on('click', function(){

        timer.stop();

        //ajax goes here!

        timer.start();
    });

    $("#prev").click(function(){
        timer.stop();
    })

})(window, document, jQuery);