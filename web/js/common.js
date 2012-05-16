// call init
$(init);

function init() {
    ajax_page_handler();
    page_load($(window.location).attr("hash")); // goto first page if #!: is available
}

function page_load($href) {
    if($href != undefined && $href.substring(0, 2) == '#!') {
        var str = document.URL.replace("http://","");
        str = str.replace("#!","");
        alert(str);
        //$('#content').load('{{ path('$href.substring(3)') }}'); // replace body the #content with loaded html
        $('#content').load('app_dev.php' + $href.substring(2)); // replace body the #content with loaded html
        $('html, body').animate({scrollTop:0}, 'slow'); // bonus
    }
}

/**
* This method load #content on every url hash change
*
* @return
*/
function ajax_page_handler() {
    $(window).bind('hashchange', function () {
        $href = $(window.location).attr("hash");
        page_load($href);
    });
    // this allow you to reload by clicking the same link
    $('a[href^="#!"]').live('click', function() {
        $curhref = $(window.location).attr("hash");
        $href = $(this).attr('href');
        if($curhref == $href) {
            page_load($href);
        }
    });
}
//page_load('#!:menu');

