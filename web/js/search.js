$(document).ready(function()
{
    //$('.search input[type="submit"]').hide();

    $('#search_keywords').keyup(function(key)
    {
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            $('#menus').load(
                $(this).parents('form').attr('action'),
                { query: this.value + '*' },
                function() { $('#loader').hide(); }
            );
        }
    });
    $('#search_keywords_usuario_dyn').keyup(function(key)
    {
        if (this.value.length >= 3 || this.value == '')
        {
            $('#loader').show();

            //alert(this.value);
            $('#usuarios').load(
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
