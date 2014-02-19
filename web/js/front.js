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
        $question = getQuestion().prev();
        currentId = getId(getQuestion().prev().addClass('active'));
        $items.not($question).removeAttr('class');

        checkControlState();
    });

    $("#controller-next").on('click', function() {
        $question = getQuestion().next();
        currentId = getId(getQuestion().next().addClass('active'));
        $items.not($question).removeAttr('class');

        checkControlState();
    });

    $("input[type='radio']").change(function(){
        post(currentId, getId($(this)));
    });

    function checkControlState() {
        if(currentId === 1) {
            disabled($("#controller-prev"));
        } else {
            enabled($("#controller-prev"));
        }

        if(currentId > getTotalQuestion()-1) {
            disabled($("#controller-next"));
        } else {
            enabled($("#controller-next"));
        }

        $(".question-count").html("Exam Question - "+getId(getQuestion())+"/"+getTotalQuestion());

        checkPaletteState();
    }

    function checkPaletteState() {
        var curentPalette = findPalette(getId(getQuestion())).addClass('current');
        $paletteItems.not(curentPalette).removeClass('current');
    }

    function enabled($controller) {
        return $controller.removeClass('disabled').removeAttr('disabled');
    }

    function disabled($controller) {
        return $controller.addClass('disabled').attr('disabled', 'disabled');
    }

    function getQuestion() {
        return $items.parent().find("[data-id='"+currentId+"']");
    }

    function getId($el) {
        return $el.data('id');
    }

    function findPalette(id) {
        return $paletteItems.parent().find("[data-id='"+id+"']");
    }

    function getTotalQuestion() {
        return $items.length;
    }

    function post(questionId, answerId) {
        timer.stop();

        var data = {
            questionId: questionId,
            answerId: answerId
        }

        $.post('/exam/attempt', data, function() {
            $(".frozen").show();
        })
            .complete(function() {
            $(".frozen").fadeOut(function() {
                timer.start();
            });

            if(!(currentId > getTotalQuestion()-1)) {
                $("#controller-next").click();
            }
        });
    } 

})(window, document, jQuery);