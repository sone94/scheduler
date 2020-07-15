$( document ).ready(function() {

$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
  }
});


$("#login-form").submit(function(event)
{
    event.preventDefault();
    $.ajax({
        type: "POST",
        dataType:"json",
        url: "api/login",
        data:({
            username : $('#username').val(),
            password: $('#password').val(),
            "_token": $('meta[name="csrf-token"]').attr('content')
        }),
        success: function(result)
        {
            if(result.success) // you should do your checking here
            {
                window.location = $dashboardURL //just to show that it went through
            }

        },
        error: function(result) {
           $("#errorLogin").removeClass('d-none').text(result.responseJSON.error);
        }
    });
    return false;
})

});
