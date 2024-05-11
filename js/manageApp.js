$(function(){
    $("#createFanbaseForm").hide();
    $("#manageFanbasesTable").hide();
    $("#manageUsersTable").hide();
    $("#appReportDiv2").hide();
    $("#charts-container").hide();
    generateCharts();
    $("#createFanbaseDiv").on("click", function(){
        if ($("#createFanbaseForm").is(":visible")) {
            $("#fanbase_name").val("");
            $("#fanbase_artist").val("");
            $("#fanbase_description").val("");
            $("#createFanbaseForm").slideUp();
        } else {
            $("#createFanbaseForm").slideDown();
        }
    })

    $("#manageFanbasesDiv").on("click", function(){
        if ($("#manageFanbasesTable").is(":visible")) {
            $("#manageFanbasesTable").slideUp();
        } else {
            $("#manageFanbasesTable").slideDown();
        }
    })

    $("#manageUsersDiv").on("click", function(){
        if ($("#manageUsersTable").is(":visible")) {
            $("#manageUsersTable").slideUp();
        } else {
            $("#manageUsersTable").slideDown();
        }
    })

    $("#appReportDiv").on("click", function(){
        if ($("#appReportDiv2").is(":visible")) {
            $("#appReportDiv2").slideUp();
        } else {
            $("#appReportDiv2").slideDown();
        }
    })

    async function generateCharts(){
        
    }
});