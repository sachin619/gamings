/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var baseUrl = $('#basePluginUrl').val();
$(document).ready(function () {
    $('.tourAuto').autocomplete({
        source: baseUrl + '/api?action=admin-tour-filter',
        select: function (event, ui) {
            matchTrigger(ui.item.label);
        },
        change: function (event, ui) {
            matchTrigger(ui.item.label);
        }
    });


});
$(document).on('keyup', '.matcAuto', function () {
    var getTourTitle = $('.tourAuto').val();
    if (getTourTitle != "")
        matchTrigger(getTourTitle);
});
function matchTrigger(term) {
    $('.matcAuto').autocomplete({
        source: baseUrl + '/api?action=admin-match-filter&tname=' + term
    });
}


