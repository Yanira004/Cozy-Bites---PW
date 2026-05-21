
$(function() {
    
    $(".expandabil").click(function(event) {
        event.stopPropagation(); 
        $(this).toggleClass("deschis"); 
    });
});