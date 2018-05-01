$(document).ready(function () {
    if ($("#content").hasClass("contentAccueil")) {
        $("body").css('background', 'url(lib/bg.jpg) fixed no-repeat');
    }

    // FAQ Slide code
    $(".open").click(function () {
        var container = $(this).parents(".topic");
        var answer = container.find(".answer");
        var trigger = container.find(".faq-t");

        answer.slideToggle(200);

        if (trigger.hasClass("faq-o")) {
            trigger.removeClass("faq-o");
        } else {
            trigger.addClass("faq-o");
        }

        if (container.hasClass("expanded")) {
            container.removeClass("expanded");
        } else {
            container.addClass("expanded");
        }
    });

});