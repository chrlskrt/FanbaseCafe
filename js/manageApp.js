$(function(){
    $("#createFanbaseForm").hide();
    $("#manageFanbasesTable").hide();
    $("#manageUsersTable").hide();
    $("#appReportDiv2").hide();
    $("#charts-container").hide();
    // generateCharts();
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

    $("#chartsDiv").on("click", function(){
        if ($("#charts-container").is(":visible")) {
            $("#charts-container").slideUp();
        } else {
            $("#charts-container").slideDown();
        }
    })

    // function generateCharts(){
    //     $.ajax({
    //         url: "php/getChartData.php",
    //         method: "POST",
    //         dataType: 'JSON',
    //         success: function(data){
    //             console.log(data);

    //             // for fanbase-member count chart
    //             let fanbase_members = data.fanbase_members;
    //             console.log(fanbase_members);

    //             var fanbase = [];
    //             var member_count = [];
    //             for (let i in fanbase_members) {
    //                 fanbase.push(fanbase_members[i].fanbase_name);
    //                 member_count.push(fanbase_members[i].member_count);
    //             }

    //             var ctx = document.getElementById("membersChart").getContext("2d");

    //             new Chart($("#membersChart"), {
    //                 type: 'bar',
    //                 data: {
    //                     labels: fanbase,
    //                     datasets : [
    //                         {
    //                             label: 'Fanbase Member Count',
    //                             backgroundColor: 'rgba(200, 200, 200, 0.75)',
    //                             borderColor: 'rgba(200, 200, 200, 0.75)',
    //                             hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
    //                             hoverBorderColor: 'rgba(200, 200, 200, 1)',
    //                             data: member_count
    //                         }
    //                     ]
    //                 },
    //                 options: {
    //                     legend: {
    //                         display: true,
    //                         position: 'bottom'
    //                     },
    //                     responsive: true,
    //                     maintainAspectRatio: false,
    //                     aspectRatio: 1
    //                 }
    //             })

    //             console.log(fanbase);
    //             console.log(member_count);
    //         }
    //     })
    // }
});