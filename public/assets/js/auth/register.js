$( document ).ready(function() {

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }
    });

    function clearErrorText(){

        $("#userError").text('');
        $("#passwordError").text('');

    }
    
    
    $("#register-form").submit(function(event)
    {
        clearErrorText();

        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType:"json",
            url: "api/register",
            data:({
                username : $('#username').val(),
                password: $('#password').val(),
                "_token": $('meta[name="csrf-token"]').attr('content')
            }),
            success: function(result)
            {
                if(result && result.token.length>1) // you should do your checking here
                {
                    $("#successRegister").removeClass('d-none');
                }
    
            },
            error: function(result) {
                var dataError = JSON.parse(result.responseJSON);

                console.log(dataError);

                if(dataError['username'] !== undefined){
                    $("#userError").text(dataError['username'][0]);
                    $("#userError").css("color, #FF0000");
                }
                if(dataError['password'] !== undefined){
                    $("#passwordError").text(dataError['password'][0]);
                    $("#passwordError").css("color, #FF0000");
                }

            }
        });
        return false;
    })
    
    });
    