$(function(){
    // $("#birthdate").datepicker({
    //     dateFormat: 'MM-dd-yyyy',
    //     maxDate: '-15y'
    // });

    let pass;

    $("#btnRegister").attr("disabled", "disabled");
    $("#cpassword").parent().hide();

    $("#password").on("keyup", function(){
        pass = $("#password").val();

        if (pass.length > 0){
            $("#cpassword").parent().show();
        } else {
            $("#cpassword").parent().hide();
        }
    })

    $("#cpassword").on("keyup", function(){
        pass = $("#password").val();
        cpass = $("#cpassword").val();

        if (pass === cpass){
            console.log("password matched")
            $("#btnRegister").removeAttr("disabled");
        }
    })
});