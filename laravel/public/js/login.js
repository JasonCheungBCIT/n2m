


$(document).ready(function() {

    document.forms[0].email.select();


    var error = false;
    $('#errormessage').hide();

    $("#submit").click(function() {
        resetFields();
        var emptyfields = $("input[value=]");
        if (emptyfields.size() > 0) {
            $('#errormessage').text("Missing required fields");
            error = true;
            $('#errormessage').show();

            emptyfields.each(function() {
                $(this).stop()
                    .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                    .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                    .animate({ left: "0px" }, 100)
                    .addClass("required");
            });
        };

        if($("#password").val().length < 6){
            $("#password").each(function() {
                $(this).stop()
                    .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                    .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
                    .animate({ left: "0px" }, 100)
                    .addClass("required");
            });

            if(error == false){
                $('#errormessage').text("Password must be 6+ characters long");
                error = true;
                $('#errormessage').show();
            }
        };

        if(error == true){
            $('#errormessage').show();
        }else{
            $('#errormessage').hide();
        }

        error = false;
    });


    // give immediate email validation feedback
    $("#email").blur(function(){
        var email = $("#email").val();
        if(email != 0){
            if(isValidEmailAddress(email)){
                $("#validEmailIndicator").css({
                    "background-image": "url('images/resources/validYes.png')"
                });
            } else {
                $("#validEmailIndicator").css({
                    "background-image": "url('images/resources/validNo.png')"
                });
            }
        } else {
            $("#validEmailIndicator").css({
                "background-image": "none"
            });
        }
    });
    
    // give immediate email validation feedback
    $("#email").keyup(function(){
        var email = $("#email").val();
        if(email != 0){
            if(isValidEmailAddress(email)){
                $("#validEmailIndicator").css({
                    "background-image": "url('images/resources/validYes.png')"
                });
            } else {
                $("#validEmailIndicator").css({
                    "background-image": "url('images/resources/validNo.png')"
                });
            }
        } else {
            $("#validEmailIndicator").css({
                "background-image": "none"
            });
        }
    });
    
});


function resetFields() {
    error = false;
    $("input[type=text], input[type=password]").removeClass("required");
}

function isValidEmailAddress(emailAddress) {
    //var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    var pattern = new RegExp(/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/i);
    
    return pattern.test(emailAddress);
}



function isFormDataValid(){

    var dataIsValid = true;
    var message     = "";
    $('#errormessage').hide();

    // is the email address valid?
    // is the password long enough?
    // is the password free of illegal characters?
    // does passwd_conf match the password?
    // is the captcha correct?
    // if so, the form data is valid so return true (else return false)

    if(dataIsValid == true)
    {
        if(!(isValidEmailAddress($("#email").val()))){
            dataIsValid = false;

            message = "Invalid email address: " + $("#email").val();
        }
    }

    if(dataIsValid == true)
    {
        if($("#password").val().length < 1){
            dataIsValid = false;
            message = "Password missing";
        }
    }


    if(dataIsValid == true)
    {
        if($("#password").val().length < 6){
            dataIsValid = false;
            message = "Password too short";
        }
    }



    if(dataIsValid == true)
    {
        if($("#password_confirmation").val().length < 1){
            dataIsValid = false;
            message = "Password confirmation missing";
        }
    }


    if(dataIsValid == true)
    {
        if($("#password").val() != $("#password_confirmation").val()){
            dataIsValid = false;
            message = "Passwords do not match";
        }
    }


    if(dataIsValid == true)
    {
        // no tags allowed
        if($("#password").val().indexOf('<') != -1){
            dataIsValid = false;
            message = "Ilegal character in password";
        }
    }

    if(dataIsValid == true)
    {
        if($("#password").val().indexOf('>') != -1){
            dataIsValid = false;
            message = "Ilegal character in password";
        }
    }


    /*
    if(dataIsValid == true)
    {
        if($("#code").val().length != 4){
            dataIsValid = false;
            message = "Incorrect CAPTCHA code entered";
        }
    }
    
    if(dataIsValid == true)
    {
        isValidCaptchaCode($("#code").val());

        if(itsValid != "success")
        {
            dataIsValid = false;
            //				alert('finally true');
            message = "Incorrect CAPTCHA code entered";
        }
        itsValid = false; // reset it
    }
    */
    
    if(false == dataIsValid){
        $('#errormessage').text(message);
        //$('#errormessage').show('slow');
        $('#errormessage').fadeIn(3000);

        // get a new captcha
        document.getElementById('captcha').src = './captcha/latest/securimage_show.php?' + Math.random();
    }else{
        var message     = "";
        $('#errormessage').hide();
    }
    /*
     if(dataIsValid == true){
     alert('valid');
     }else{
     alert('invalid');
     }
     */
    return dataIsValid;
}



var itsValid = false;

function isValidCaptchaCode(attempt){
    
    itsValid = $.ajax({
        url: "validatecaptcha.php?captcha_code=" + $("#code").val(),
        async: false
    }).responseText;

}
