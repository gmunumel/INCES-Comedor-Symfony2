$(document).ready(function()
{
    $.validator.addMethod(
        "venezuelanDate",
        function(value, element) {
            // put your own logic here, this is just a (crappy) example
            return value.match(/^\d\d?\/\d\d?\/\d\d$/);
        },
        "Por favor coloque una fecha en formato dd/mm/yy"
    );
    $('.menu_form').validate({
        rules: {
            'inces_comedorbundle_menutype[seco]'     : { required       : true },
            'inces_comedorbundle_menutype[sopa]'     : { required       : true },
            'inces_comedorbundle_menutype[salado]'   : { required       : true },
            'inces_comedorbundle_menutype[jugo]'     : { required       : true },
            'inces_comedorbundle_menutype[ensalada]' : { required       : true },
            'inces_comedorbundle_menutype[postre]'   : { required       : true },
            'inces_comedorbundle_menutype[dia]'      : { venezuelanDate : true }
        },
        messages: {
            'inces_comedorbundle_menutype[seco]'     : { required       : 'Coloque el campo Seco' },
            'inces_comedorbundle_menutype[sopa]'     : { required       : 'Coloque el campo Sopa' },
            'inces_comedorbundle_menutype[salado]'   : { required       : 'Coloque el campo Salado' },
            'inces_comedorbundle_menutype[jugo]'     : { required       : 'Coloque el campo Jugo' },
            'inces_comedorbundle_menutype[ensalada]' : { required       : 'Coloque el campo Ensalada' },
            'inces_comedorbundle_menutype[postre]'   : { required       : 'Coloque el campo Postre' },
            'inces_comedorbundle_menutype[dia]'      : { venezuelanDate : 'Por favor coloque una fecha en formato dd/mm/yy' }
        }
    });
    /* TODO LIST */
    $('.usuario_form').validate({
        rules: {
            'inces_comedorbundle_usuariotype[seco]'     : { required       : true },
            'inces_comedorbundle_usuariotype[dia]'      : { venezuelanDate : true }
        },
        messages: {
            'inces_comedorbundle_usuariotype[seco]'     : { required       : 'Coloque el campo Seco' },
            'inces_comedorbundle_usuariotype[dia]'      : { venezuelanDate : 'Por favor coloque una fecha en formato dd/mm/yy' }
        }
    });
    $('.rol_form').validate({
        rules: {
            'inces_comedorbundle_roltype[seco]'     : { required       : true },
            'inces_comedorbundle_roltype[dia]'      : { venezuelanDate : true }
        },
        messages: {
            'inces_comedorbundle_roltype[seco]'     : { required       : 'Coloque el campo Seco' },
            'inces_comedorbundle_roltype[dia]'      : { venezuelanDate : 'Por favor coloque una fecha en formato dd/mm/yy' }
        }
    });
    // Falta definir usuariomenu
    /* END TODO LIST */

    $("#inces_comedorbundle_menutype_dia" ).datepicker({
        timeFormat: 'hh:mm:ss',
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true
    });
    $('button[type=submit]:not(.delete_form_btn)').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        if (form.valid()){
            $("form:first").ajaxForm({
                //target: '#content',
                success: function(msg) {
                    //$('#content').click(msg);
                    //$(window).attr("location",msg);
                    window.location.href = msg;
                }
            }).submit();
        }
    });
    $('.delete_form_btn').on('click', function(e) {
        e.preventDefault();
        //var url = $(this).attr("action");
        $("form").ajaxForm({
            //target: '#content',
            success: function(msg) {
                //$('#content').click(msg);
                //$(window).attr("location",msg);
                window.location.href = msg;
            }
        }).submit();
    });

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $('#search_keywords').keyup(function(key) {

        var val = this.value;
        delay(function(){
            if (val.length >= 3 || val == '')
            {
                //alert(val);
                $('#loader').show();

                $('#content').load(
                    $('#search_keywords').parents('form').attr('action') + "?page=1&query=" + encodeURI(val),
                    //$('#search_keywords').parents('form').attr('action'),
                    { query: val + '*' },
                    function() {
                        $('#loader').hide();
                        //window.location.href = $('#search_keywords').parents('form').attr('action') + "?page=1&query=" + val;
                    }
                );
            }

        }, 800 );
    });

    $(".filter").click(function(event) {
        event.preventDefault();
        var field = $(this).attr('value');
        var attr  = $(this).attr('asc');
        var url   = $(this).attr('href');
        if (attr == '1')
            attr = '0';
        else
            attr = '1';
        $('#content').load(
            url,
            { field: field, attr: attr }
        );
    });

    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    $( "#dialog" ).dialog({
        autoOpen: false,
        resizable: false,
        height:250,
        width:500,
        modal: true,
        //title: 'Notificaciones',
        open: function(){
            jQuery('#closer').bind('click',function(){
                jQuery('#dialog').dialog('close');
            })
        },
        buttons: {
            Ok: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    $( ".opener" ).on('click', function(event) {
        var url = $(this).attr("value");
        $.ajax({
            url: url,
            success: function(msg) {
                //alert(msg);
                $( "#dialog" ).html( msg );
                $( "#dialog" ).dialog( "open" );
            }
        });
        event.preventDefault();
        event.stopPropagation();
        //$( "#dialog" ).dialog( "open" );
        //return false;
    });
    /*
    var _url = $('div.pagination a').attr('href');
    var _query = $('#search_keywords').val();
    if(_url.indexOf("query") == -1 && _query != "")
        $('div.pagination a').attr('href', _url + '&query=' + _query);
        */

    /*
    $('div.pagination a').click(function(event) {
        //alert("hola");
        //event.preventDefault();
        var query = $('#search_keywords').val();
        var url = $('div.pagination a').attr('href');
        if(url.indexOf("query") == -1 && query != ""){
            //event.preventDefault();
            event.preventDefault();
            url = url + '&query=' + query;
            window.location.href = url;
        }
    });
    */

});
