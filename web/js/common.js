// call init

$(init);

function init() {
    ajax_page_handler();
    page_load($(window.location).attr("hash")); // goto first page if #!: is available
}

function page_load($href) {
    //alert($href);
    //alert(document.URL);
    if($href != undefined && $href.substring(0, 2) == '#!') {
        $str      = document.URL;
        $str      = $str.split("/#!");
        $href     = $href.replace("#!","");
        $loadPage = $str[0] + $href;
        //alert($str);
        //str = str.replace("/#!","");
        //alert("hola "+ $href);
        if($href != "/")
            $('#content').load($loadPage, function(response, status, xhr) {
                if (status == "error") $('#content').load($str[0] + '/error');
            }); // replace body the #content with loaded html

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
        //alert($href);
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
