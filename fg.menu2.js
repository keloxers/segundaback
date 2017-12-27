$(function(){
    // BUTTONS
    $('.fg-button').hover(
        function(){ $(this).removeClass('ui-state-default').addClass('ui-state-focus'); },
        function(){ $(this).removeClass('ui-state-focus').addClass('ui-state-default'); }
    );
    
    // MENUS        
    $('#flat').menu({ 
        content: $('#flat').next().html(), // grab content from this page
        showSpeed: 400 
    });
    
    $('#hierarchy').menu({
        content: $('#hierarchy').next().html(),
        crumbDefaultText: ' '
    });
    
    $('#hierarchybreadcrumb').menu({
        content: $('#hierarchybreadcrumb').next().html(),
        backLink: false
    });
    
    // or from an external source
    $.get('/menuContent.php', function(data){ // grab content from another page
        $('#flyout').menu({ content: data, flyOut: true });
    });
    
    
});