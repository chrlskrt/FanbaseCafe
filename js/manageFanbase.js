$(function(){
    $("#manageMembers").hide();
    $("#editFanbaseConfirm").hide();

    $("#edit").on("click", function(){
        $("#editFanbaseModal").modal("show");
    });
    
    $("#btnDeleteFanbase").on("click", function(){
        $("#deleteFanbaseModal").modal("show");
    })

    $("#btnManageMembers").on("click", function(){
        $("#manageMembers").toggle();
    })

    $("#btnUpdateFanbaseDetails").on("click", function(){
        $(".editFanbaseDiv").hide();
        $("#fanbase_date_confirm").html($("#date_created").val())
        $("#fanbase_description_confirm").html($("#fanbase_description").val())

        if ($("#fanbase_photo").get(0).files.length > 0){
            console.log("fdfj")
            file = $("#fanbase_photo").prop("files")[0];
            imageSRC = URL.createObjectURL(file);
            $("#fanbase_photo_confirm").attr("src", imageSRC);
        }

        if ($("#fanbase_logo").get(0).files.length > 0){
            console.log("fdfj")
            file = $("#fanbase_logo").prop("files")[0];
            imageSRC = URL.createObjectURL(file);
            $("#fanbase_logo_confirm").attr("src", imageSRC);
        }

        $("#editFanbaseConfirm").show();
    })

    $(".btnCancelFanbaseEdit").on("click", ()=>{
        $("#editFanbaseModal").modal("hide");
        $(".editFanbaseDiv").show();
        $("#editFanbaseConfirm").hide();
    })
});