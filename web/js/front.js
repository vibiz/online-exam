/**
 * Created with JetBrains PhpStorm.
 * User: willy
 * Date: 2/16/14
 * Time: 8:23 AM
 * To change this template use File | Settings | File Templates.
 */

(function(window, document, $) {

    $("#next").on('click', function(){
        timer.start();
    });

    $("#prev").click(function(){
        timer.stop();
    })

})(window, document, jQuery);