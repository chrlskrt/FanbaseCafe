$(function(){
    $("#editFanbaseDetailsDiv").hide();

    $("#edit").on("click", function(){
        $("#displayFanbaseDetailsDiv").hide();
        $("#editFanbaseDetailsDiv").show();
    });

    $("#cancelEdit").on("click", function(){
        $("#editFanbaseDetailsDiv").hide();
        $("#displayFanbaseDetailsDiv").show();
    });
});