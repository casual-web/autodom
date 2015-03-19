$("div.linked div.well").mouseenter(function () {
    $(this).css('background', '#99CCFF');
    $(this).css('cursor', 'pointer');
}).mouseleave(function () {
    $(this).css('background', '#f5f5f5');
    $(this).css('cursor', 'default');
});

$("div.linked div.well").click(function () {
    $(location).attr('href', "http://www.autodom.biz/" + $(this).attr('rel'));
});