/**
 * Created with JetBrains PhpStorm.
 * User: willy
 * Date: 2/16/14
 * Time: 8:23 AM
 * To change this template use File | Settings | File Templates.
 */

(function(window, document, $) {

    var timer = new Timer();
    timer.start()

    $("#next").on('click', function(){
        post();
    });

    $("#prev").click(function(){
        post();
    });

    function post() {
        timer.stop();
        $(".frozen").show();

        setTimeout(function(){
            $(".frozen").hide(function(){
                timer.start();
            });
        }, 2000);
    }

})(window, document, jQuery);