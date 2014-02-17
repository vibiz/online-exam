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

    currentId = getId($items.first().addClass('active'));

    $("#next").on('click', function(){
        post();
        $question = getNextQuestion();
        currentId = getId(getNextQuestion().addClass('active'));
        $items.not($question).removeAttr('class');
    });

    $("#prev").click(function(){
        post();
        $question = getPrevQuestion();
        currentId = getId(getPrevQuestion().addClass('active'));
        $items.not($question).removeAttr('class');
    });

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

    function findElementByData(id) {
        return $items.parent().find("[data-id='"+id+"']");
    }

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