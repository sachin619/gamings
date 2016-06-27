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


$(document).ready(function () {
    
    $(".datepickerEnd").datepicker({format: 'yyyy-mm-dd'});  //default format of end date
    $('.datepickerStart').datepicker({//onchange start date
        format: 'yyyy-mm-dd'
    }).on('changeDate', function () {
      hideSeachError();
        var date = new Date($(this).val());
        date.setDate(date.getDate() + 1);
        $('.datepickerEnd').datepicker('setStartDate', date);
        ;
    });


    $('.datepickerEnd').datepicker({//onchange enddate
        format: 'yyyy-mm-dd'
    }).on('changeDate', function () {
      hideSeachError();
        var date = new Date($(this).val());
        date.setDate(date.getDate() - 1);
        $('.datepickerStart').datepicker('setStartDate', date);
        ;
    });


    $('.reset').click(function () {                     //reset date
        hideSeachError();
        $('.datepickerStart').data('datepicker').setDate(null);
        $('.datepickerEnd').data('datepicker').setDate(null);
    });
});

function hideSeachError(){
       $('.errorEndDate').hide();
        $('.errorStartDate').hide();
}




