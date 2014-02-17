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

    $items = $(".question-container>li");
    $paletteItems = $(".palette-container>li");

    currentId = getId($items.first().addClass('active'));

    checkControlState();

    $("#controller-prev").click(function() {
        post();
        $question = getPrevQuestion();
        currentId = getId(getPrevQuestion().addClass('active'));
        $items.not($question).removeAttr('class');

        checkControlState();
    });

    $("#controller-next").on('click', function() {
        post();
        $question = getNextQuestion();
        currentId = getId(getNextQuestion().addClass('active'));
        $items.not($question).removeAttr('class');

        checkControlState();
    });

    function checkControlState() {
        if(currentId === 1) {
            disabledPrevControl();
        } else {
            enabledPrevControl();
        }

        if(currentId > getTotalQuestion()-1) {
            disabledNextControl();
        } else {
            enabledNextControl();
        }

        $(".question-count").html("Exam Question - "+getCurrentId()+"/"+getTotalQuestion());

        checkPaletteState();
    }

    function checkPaletteState() {
        var curentPalette = findPalette(getCurrentId()).addClass('current');
        $paletteItems.not(curentPalette).removeClass('current');
    }

    function enabledPrevControl() {
        enabled($("#controller-prev"));
    }

    function disabledPrevControl() {
        disabled($("#controller-prev"));
    }

    function enabledNextControl() {
        enabled($("#controller-next"));
    }

    function disabledNextControl() {
        disabled($("#controller-next"));
    }

    function enabled($controller) {
        return $controller.removeClass('disabled').removeAttr('disabled');
    }

    function disabled($controller) {
        return $controller.addClass('disabled').attr('disabled', 'disabled');
    }

    function getQuestion() {
        return findElementByData(currentId);
    }

    function getNextQuestion() {
        return getQuestion().next();
    }

    function getPrevQuestion() {
        return getQuestion().prev();
    }

    function getId($el) {
        return $el.data('id');
    }

    function getCurrentId() {
        return getId(getQuestion());
    }

    function findElementByData(id) {
        return $items.parent().find("[data-id='"+id+"']");
    }

    function findPalette(id) {
        return $paletteItems.parent().find("[data-id='"+id+"']");
    }

    function getTotalQuestion() {
        return $items.length;
    }

    function post() {
        timer.stop();
        $(".frozen").show();

        setTimeout(function(){
            $(".frozen").fadeOut(function(){
                timer.start();
            });
        }, 1000);
    } 

})(window, document, jQuery);