/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    var basePlugUrl = $('#basePluginUrl').val();
    $('.tourAuto').autocomplete({
        source: basePlugUrl + '/api?action=admin-tour-filter',
        select: function (event, ui) {
            $('#getTName').val(ui.item.label);
        },
        change: function (event, ui) {
            var getTname = $('#getTName').val();

            $('.matcAuto').autocomplete({
                source: basePlugUrl + '/api?action=admin-match-filter&tname=' + ui.item.label,
            });
        }
    });

});
