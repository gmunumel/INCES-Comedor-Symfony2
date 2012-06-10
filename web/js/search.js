$(document).ready(function()
{
    $('.menu_form').validate({
        rules: {
            'inces_comedorbundle_menutype[seco]'     : { required : true },
            'inces_comedorbundle_menutype[sopa]'     : { required : true },
            'inces_comedorbundle_menutype[salado]'   : { required : true },
            'inces_comedorbundle_menutype[jugo]'     : { required : true },
            'inces_comedorbundle_menutype[ensalada]' : { required : true },
            'inces_comedorbundle_menutype[postre]'   : { required : true }
        },
        messages: {
            'inces_comedorbundle_menutype[seco]'     : { required : 'Coloque el campo Seco' },
            'inces_comedorbundle_menutype[sopa]'     : { required : 'Coloque el campo Sopa' },
            'inces_comedorbundle_menutype[salado]'   : { required : 'Coloque el campo Salado' },
            'inces_comedorbundle_menutype[jugo]'     : { required : 'Coloque el campo Jugo' },
            'inces_comedorbundle_menutype[ensalada]' : { required : 'Coloque el campo Ensalada' },
            'inces_comedorbundle_menutype[postre]'   : { required : 'Coloque el campo Postre' },
            'inces_comedorbundle_menutype[postre]'   : { required : 'Coloque el campo Postre' }
        }
    });
    $('.usuario_form').submit(function(e) {
        return true;
    });
    $("#inces_comedorbundle_menutype_dia" ).datepicker({
        timeFormat: 'hh:mm:ss',
        dateFormat: 'dd/mm/yy',
        showButtonPanel: true
    });
    $('form:not(.usuario_form)').submit(function(e) {

        var url = $(this).attr("action");
        //alert(url);

        if ($(this).valid()){
            $.ajax({
                type: "POST",
                url: url, // Or your url generator like Routing.generate('discussion_create')
                data: $(this).serialize(),
                dataType: "html",
                success: function(msg){
                    //alert(msg);
                    $('#content').load(msg);
                }
            });
        }

        return false;
    });
    //$('.search input[type="submit"]').hide();
    $('#search_keywords_menu').keypress(function(key){
        if ( key.which == 13 ) key.preventDefault();
    });
    $('#search_keywords_menu').keyup(function(key){
        if ( key.which == 13 ) key.preventDefault();
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            $('#content').load(
                $(this).parents('form').attr('action'),
                { query: this.value + '*' },
                function() { $('#loader').hide(); }
            );
        }
    });
    //$('#search_keywords_usuario').focus();
    $('#search_keywords_usuario').keyup(function(key)
    {
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            //alert(this.value);
            $('#content').load(
                $(this).parents('form').attr('action'),
                { query: this.value},
                function() { $('#loader').hide(); }
            );
        }
    });
    $('#search_keywords_usuario_dyn').keypress(function(key){
        if ( key.which == 13 ) key.preventDefault();
    });
    $('#search_keywords_usuario_dyn').keyup(function(key){
        if ( key.which == 13 ) key.preventDefault();
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            //alert(this.value);
            $('#content').load(
                $(this).parents('form').attr('action'),
                { query: this.value + '*'},
                function() { $('#loader').hide(); }
            );
        }
    });
    $('#search_keywords_facturar').keypress(function(key){
        if ( key.which == 13 ) key.preventDefault();
    });
    $('#search_keywords_facturar').keyup(function(key){
        if ( key.which == 13 ) key.preventDefault();
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            //alert(this.value);
            $('#content').load(
                $(this).parents('form').attr('action'),
                { query: this.value + '*'},
                function() { $('#loader').hide(); }
            );
        }
    });
    $(".filter_menus").click(function(event) {
        event.preventDefault();
        var field = $(this).attr('value');
        var attr  = $(this).attr('asc');
        var url   = $(this).attr('href');
        if (attr == '1')
            attr = '0';
        else
            attr = '1';
        $('#menus').load(
            url,
            { field: field, attr: attr }
        );
    });
    $(".filter_usuarios").click(function(event) {
        event.preventDefault();
        var field = $(this).attr('value');
        var attr  = $(this).attr('asc');
        var url   = $(this).attr('href');
        if (attr == '1')
            attr = '0';
        else
            attr = '1';
        $('#usuarios').load(
            url,
            { field: field, attr: attr }
        );
    });
});
