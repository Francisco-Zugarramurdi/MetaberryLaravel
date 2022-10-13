jQuery(document).ready(function(){
    jQuery('#add-set-local').click(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ url('/player/indexByTeam') }}",
        method: 'POST',
        data: {
            teamName:jQuery('#name').val()
        },
        success: function(result){
            console.log(result);
        }});
    });
});