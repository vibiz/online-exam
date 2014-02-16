/**
 * Created with JetBrains PhpStorm.
 * User: willy
 * Date: 2/16/14
 * Time: 8:23 AM
 * To change this template use File | Settings | File Templates.
 */

(function(window, document, $, undefinede) {

    var timer = function( options ) {
        var opt = $.extend(false, $.fn.timer.default, options);

    };

    timer.prototype.start = function() {

    }

    timer.prototype.stop = function() {

    }

    $.fn.timer.default = {
        limit: 1000
    }

})(window, document, jQuery);