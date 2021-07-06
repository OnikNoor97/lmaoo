import Navbar from "../public/navbar.js";
import Fragment from "../Utility/Fragment.js";
import notification from "../Utility/NotificationWrapper.js";
import WebComponent from "../Utility/WebComponent.js";
import Feature from "../Controller/featureController.js";

Navbar.projectActiveTab();

let projectId = window.location.href.split('?')[0].split("/").reverse()[0]; // gets ProjectId form URL

// create Feature
$("#createFeatureBtn").click(async function() {
    let name = $("#featureName").val();
    let result = await Feature.createFeature({ projectId, name });

    result == null ? notification.errorMessage("Something went wrong!") : notification.successMessage("Feature has been created!");
    WebComponent.Feature("#activeFeatures", result[0]);
    $("#createFeatureModal").modal("hide");
});

// read Features (active & inactive)
$("#featureToggle").click(function() {
    if ($(this).is(":checked")) {
        $("#inactiveFeatures").hide(); $("#activeFeatures").show();
    }
    else {
        $("#activeFeatures").hide(); $("#inactiveFeatures").show();
    }
});

// using this to get the featureId for editFeatures
$(document).on('click', '.far.fa-edit', async function() {
    let featureId = $(this).attr('value');
    $("#editFeatureBtn").val(featureId)

    let { name, active }  = await Feature.readFeature(featureId);
    $("#editFeatureName").val(name);
    active == 1 ? $("#editFeatureToggle").attr("checked", true) : $("#editFeatureToggle").attr("checked", false)
})

// Edit Feature
$("#editFeatureBtn").on("click",async function() {
    let name = $("#editFeatureName").val();
    let featureId = $(this).attr('value');
    let active = $("#editFeatureToggle").is(":checked") ? 1 : 0;
    let test = {featureId, name,}
    
    let result = await Feature.updateFeature({ featureId, name, active })
    result == null ? notification.errorMessage("Something went wrong!"): notification.successMessage("Feature has been updated!");
    $("#editFeatureModal").modal("hide");
});