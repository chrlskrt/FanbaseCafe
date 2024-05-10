$(function(){
    $("#editProfile").hide();

    $("#btnUpdateProf").on("click", function(){
        $("#displayProfile").hide();
        $("#editProfile").show();
    });

    $("#cancelEditProf").on("click", function(){
        $("#editProfile").hide();
        $("#displayProfile").show();
    });

    $("#btnDeleteAccount").on("click", function (){
        $("#deleteAccountModal").modal("show");
   })


});