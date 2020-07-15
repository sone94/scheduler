
function setResponseMessage(id, message, time=5000){
    $('#flash-response').css('display','block');
    $(id).removeClass('invisible');
    $(id).text(message);
    var left = $(id).offset().left;
    $(id).css({left:left}).animate({"left":"0px"}, "slow");
    $(id).slideDown(function() {
    setTimeout(function() {
        $(id).slideUp();
        $('#flash-response').css('display','none');
    }, time);
    });
}

