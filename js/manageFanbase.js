$(function(){
    $("#manageMembers").hide();

    $("#edit").on("click", function(){
        $("#editFanbaseModal").modal("show");
    });
    
    $("#btnDeleteFanbase").on("click", function(){
        $("#deleteFanbaseModal").modal("show");
    })

    $("#btnManageMembers").on("click", function(){
        $("#manageMembers").toggle();
    })
});