$(document).ready(function(){
    $(".submenu").click(function(){
        
        $(this).children("ul").slideToggle();
    });
    $(".submenu ul").click(function(e){
        e.stopPropagation();
    });

});