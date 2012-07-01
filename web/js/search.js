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
    $.validator.addMethod(
        "userImageExtension",
        function(value, element) {
            // put your own logic here, this is just a (crappy) example
            //return value.match(/^\d\d?\/\d\d?\/\d\d$/);
            var val = value.split('.').pop();
            if(val != "jpg" || val != "gif" || val != "png")
                return false
        },
        "Por favor coloque un archivo jpg|gif|png"
    );
    $.validator.addMethod(
        "cmFileExtension",
        function(value, element) {
            // put your own logic here, this is just a (crappy) example
            //return value.match(/^\d\d?\/\d\d?\/\d\d$/);
            var val = value.split('.').pop();
            //alert(val);
            if(val != "csv")
                return false
        },
        "Por favor coloque un archivo .csv"
    );
    $.validator.addMethod(
        "dateRange",
        function(value, element) {
            // put your own logic here, this is just a (crappy) example
            //var valid = value.match(/^\d\d?\/\d\d?\/\d\d$/);
            var from = $('#inces_comedorbundle_contabilidadtype_from').val();
            var to   = $('#inces_comedorbundle_contabilidadtype_to').val();
            if((from == "" && to != "") || (from != "" && to == ""))
                return false;
            return value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
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
    // TODO hacer validacion con archivo image y extension .gif|.jpg|.
    $('.usuario_form').validate({
        rules: {
            'inces_comedorbundle_usuariotype[seco]'     : { required       : true },
            'inces_comedorbundle_usuariotype[dia]'      : { venezuelanDate : true },
            'inces_comedorbundle_usuariotype[image]'    : { userImageExtension : true }
        },
        messages: {
            'inces_comedorbundle_usuariotype[seco]'     : { required       : 'Coloque el campo Seco' },
            'inces_comedorbundle_usuariotype[dia]'      : { venezuelanDate : 'Por favor coloque una fecha en formato dd/mm/yy' },
            'inces_comedorbundle_usuariotype[image]'    : { userImageExtension: 'La extension de la imagen debe ser gif|jpg|png' }
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
    $('.reporte_usuarios_form').validate({
        rules: {
            'inces_comedorbundle_contabilidadtype[cedula]'   : { required       : true },
            'inces_comedorbundle_contabilidadtype[from]'     : { dateRange      : true },
            'inces_comedorbundle_contabilidadtype[to]'       : { dateRange      : true }
        },
        messages: {
            'inces_comedorbundle_contabilidadtype[cedula]'   : { required       : 'Coloque el campo Cedula' },
            'inces_comedorbundle_contabilidadtype[from]'     : { dateRange      : 'Por favor verifique las fechas' },
            'inces_comedorbundle_contabilidadtype[to]'       : { dateRange      : 'Por favor verifique las fechas' }
        }
    });
    $('.reporte_ingresos_form').validate({
        rules: {
            //'inces_comedorbundle_contabilidadtype[rol]'      : { required       : true },
            'inces_comedorbundle_contabilidadtype[from]'     : { dateRange      : true },
            'inces_comedorbundle_contabilidadtype[to]'       : { dateRange      : true }
        },
        messages: {
            //'inces_comedorbundle_contabilidadtype[rol]'      : { required     : 'Coloque el campo Rol' },
            'inces_comedorbundle_contabilidadtype[from]'     : { dateRange    : 'Por favor verifique las fechas' },
            'inces_comedorbundle_contabilidadtype[to]'       : { dateRange    : 'Por favor verifique las fechas' }
        }
    });
    // TODO hacer validacion con archivo file que sea .csv
    $('.carga_masiva_form').validate({
        rules: {
            'inces_comedorbundle_carga_masivatype[file]'     : { cmFileExtension : true }
        },
        messages: {
            'inces_comedorbundle_carga_masivatype[file]'     : { cmFileExtension : 'El archivo debe ser .csv'}
        }
    });

    // Falta definir usuariomenu
    /* END TODO LIST */

    $("#inces_comedorbundle_menutype_dia" ).datepicker({
        timeFormat: 'hh:mm:ss',
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true
    });
    $( "#inces_comedorbundle_contabilidadtype_from" ).datepicker({
        //defaultDate: "+1w",
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        numberOfMonths: 3,
        onSelect: function( selectedDate ) {
            $( "#inces_comedorbundle_contabilidadtype_to" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $( "#inces_comedorbundle_contabilidadtype_to" ).datepicker({
        //defaultDate: "+1w",
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        numberOfMonths: 3,
        onSelect: function( selectedDate ) {
            $( "#inces_comedorbundle_contabilidadtype_from" ).datepicker( "option", "maxDate", selectedDate );
        }
    });

    function changeDate(date){
        var year = date.substring(6);
        var month = date.substring(3,5);
        var day = date.substring(0,2);
        return year + '-' + month + '-' + day;
    }
    $('.reporte_usuarios_link').on('click', function(e) {
        e.preventDefault();
        //$('.pprint').val("print");
        //alert("print");
        var form = $(this).closest('form');

        if (form.valid()){
            var url  = $(this).attr('href');
            var ced  = $('#inces_comedorbundle_contabilidadtype_cedula').val();
            var from = $('#inces_comedorbundle_contabilidadtype_from').val();
            var to   = $('#inces_comedorbundle_contabilidadtype_to').val();
            var urlFinal = url;

            if(ced != "")
                urlFinal = urlFinal + '/' + ced;
            if(from != ""){
                from = changeDate(from);
                urlFinal = urlFinal + '/' + from;
            }
            if(to != ""){
                to = changeDate(to);
                urlFinal = urlFinal + '/' + to;
            }

            //alert(urlFinal);
            window.location.href = urlFinal;
        }
    });
    $('.reporte_ingresos_link').on('click', function(e) {
        e.preventDefault();
        //$('.pprint').val("print");
        //alert("print");
        var form = $(this).closest('form');

        if (form.valid()){
            var url  = $(this).attr('href');
            var rol  = $('#inces_comedorbundle_contabilidadtype_rol').val();
            var from = $('#inces_comedorbundle_contabilidadtype_from').val();
            var to   = $('#inces_comedorbundle_contabilidadtype_to').val();
            var urlFinal = url;

            if(from != ""){
                from = changeDate(from);
                urlFinal = urlFinal + '/' + from;
            }
            if(to != ""){
                to = changeDate(to);
                urlFinal = urlFinal + '/' + to;
            }
            if(rol != "")
                urlFinal = urlFinal + '/' + rol;

            alert(urlFinal);
            window.location.href = urlFinal;
        }
    });
    $('button[type=submit]:not(.delete_form_btn, .reporte_form_btn)').on('click', function(e) {
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

    $('.reporte_form_btn').on('click', function(e) {
        e.preventDefault();
        //$('.pprint').val("");
        //var url = $('.reporte_form_btn').parents('form').attr('action');
        var form = $(this).closest('form');
        if (form.valid()){
            //var url = $(this).attr("action");
            /*
            $('#content').load(
                url,
                datatype: html,
                { field: field, attr: attr }
            );
            */
            $("form").ajaxForm({
                target: '#results',
                success: function(msg) {
                    //$('#content').click(msg);
                    //$(window).attr("location",msg);
                    //window.location.href = msg;
                }
            }).submit();
        }
    });

    $('.carga_masiva_btn').on('click', function(e) {
        e.preventDefault();
        //alert("hoal");
        //var ur = $(this).parents('form').attr('action');
        var form = $(this).closest('form');
        if (form.valid()){
            $("form").ajaxForm({
                target: '#results',
                success: function(msg) {
                    //$('#content').click(msg);
                    //$(window).attr("location",msg);
                    //window.location.href = msg;
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
