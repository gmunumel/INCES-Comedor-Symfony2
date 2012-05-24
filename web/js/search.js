$('#search_keywords').keyup(function(key)
{
    if (this.value.length >= 3 || this.value == '')
    {
        $('#jobs').load(
            $(this).parents('form').attr('action'), { query: this.value + '*' }
        );
    }
});

$('.search input[type="submit"]').hide();
