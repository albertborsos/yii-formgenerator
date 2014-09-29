$(function() {
    
    $(document).on('click', '.form-overview', function(e){
       e.preventDefault();
        var href          = $(this).attr('href');
        var id    = href.split('#')[1];
        
        var url_to_call = baseurl + '/formgenerator/forms/overview/'+id;
        $.ajax({
            url: url_to_call,
            type: 'GET',
            success: function(data) {
                // visszaadjuk a data értékét egy modal boxban
                $('#myModalBox').remove();
                $('body').append(data);
                $('#myModalBox').modal();
            }
        });
    });
});