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

//     $("#btnDelete").on("click", function (){
//         $("#deleteAccount").modal("show");
//    })



    // $("#cancelDelete").on("click", function (){
    //     $("#deleteAccount").modal("hide");
    // });

});