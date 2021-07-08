export const site_root = jQuery("#appBaseUrl").val() + '/';
export const siteUrl = jQuery("#appBaseUrl").val() + '/';
export var dateHolder = "";
export var dateHolder2 = "";
export function alertMessage() {


}

export function bargraphchanger(canvasid, styleheight = "220px", stylewith = "100%") {
    let parentContainer = $('#' + canvasid + '').parent();
    $('#' + canvasid + '').remove();
    $(parentContainer).append('<canvas id="' + canvasid + '" class="mw-640 mx-auto" style="width: ' + stylewith + ';height: ' + styleheight + ';"></canvas>');
    return true;
}