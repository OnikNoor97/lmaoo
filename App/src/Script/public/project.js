import Navbar from "../public/navbar.js";
import Fragment from "../Utility/Fragment.js";
import Project from "../Controller/ProjectController.js";
import notification from "../Utility/NotificationWrapper.js";

$(document).ready(() => { Navbar.projectActiveTab(); });
let projectIdData = window.location.href.split('?')[0].split("/").reverse()[0];
let projectId = Number(projectIdData);

$("#createFeatureButton").click(async function(){
    let name = $("#featureName").val();
    let result = await Project.createFeature({projectId, name});

    result == null ? notification.errorMessage("Something went wrong!") : notification.successMessage("Feature has been created!");
    $("#createFeatureModal").modal("hide");
});

$(document).on('click', '.far.fa-edit', function() {
    let featureIddata = $(this).attr('value');
    $("#editFeatureButton").val(featureIddata)
})

$("#editFeatureButton").click(async function(){
    let name = $("#newFeatureName").val();
    let data = $(this).attr('value');
    var featureId = parseInt(data, 10);
    let active = $("#editFeatureToggle").is(":checked") ? 1 : 0;
    
    let result = await Project.updateFeature({featureId,name, active})
    result == null ? notification.errorMessage("Something went wrong!"): notification.successMessage("User has been updated!");
    $("#editFeatureModal").modal("hide");
});