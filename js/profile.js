$(function(){
    $("#editProfile").hide();

    $("#btnUpdateProf").on("click", function(){
        $("#displayProfile").hide();
        $("#editProfile").show();
    });

    $("#cancelEdit").on("click", function(){
        $("#editProfile").hide();
        $("#displayProfile").show();
    });
});