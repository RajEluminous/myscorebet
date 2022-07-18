/*
|------------------------------------------------------------------------------------
| render boolean column to checkbox
|------------------------------------------------------------------------------------
*/
// function renderBoolColumn(tableauID, boolClass) {
//   $(tableauID + ' tr').each(function (i, row) {
//     $('td', this).each(function (j, cell) {
//       if ($(tableauID + ' th').eq(j).hasClass( boolClass )) {
//         if (cell.innerHTML == 'y') {cell.innerHTML = '<div class="text-center text-success"><span class="fa fa-check-circle"></span></div>';}
//         if (cell.innerHTML == 'n') {cell.innerHTML = '<div class="text-center text-danger"><span class="fa fa-times-circle lg"></span></div>';}
//       }
//     });
//   });
// };
/*
|------------------------------------------------------------------------------------
| Confirmation with ajax call to method
|------------------------------------------------------------------------------------
*/
function confirmAction(strPostUrl, strPostData) {
    if(confirm('Are you sure?')) {
       $.ajax({
         type: "POST",
         url: strPostUrl,
         data: strPostData,
         success: function(data)
         {
            var successHtml = '';
            if(data.message != '') {
              successHtml = '<div class="alert alert-success">'+data.message +'</div>';
            }
            else {
              successHtml = '<div class="alert alert-danger">'+data.success +'</div>';
            }
            $('.messages').html(successHtml);
            setTimeout(function(){ 
               location.reload(); 
            }, 2000);
         }
      });
    }
}
/*
|------------------------------------------------------------------------------------
| select all recods
|------------------------------------------------------------------------------------
*/
//Function for select all records
function selectAllRecords(getSelectChkVal, getSelectedItems, getAppendInputId){
  var strValues = '';
  if(getSelectChkVal.checked){
    jQuery("input[name='"+getSelectedItems+"']").each(function () {
        strValues += this.value + ',';
        this.checked = true;
    });
      jQuery('#'+getAppendInputId).val(strValues);
  }else{
      jQuery("input[name='"+getSelectedItems+"']").each(function () {
        this.checked = false;
      });
      jQuery('#'+getAppendInputId).val('');
  }
}
/*
|------------------------------------------------------------------------------------
| select recods based on single click
|------------------------------------------------------------------------------------
*/
//For single click get ids of input
function selectRecords(getInput, getAppendInputId) {
  if(getInput.checked){
    strValues += getInput.value + ',';
  }
  else {
    strValues = strValues.replace(getInput.value+',','');
  }
  $("#"+getAppendInputId).val(strValues);
}

//Only characters are allowed
function checkCharter(getEle) {
    if (/\d/g.test(getEle.value)) {
        // Filter non-digits from input value.
        getEle.value = getEle.value.replace(/\d/g, '');
    }
  }
  
//Only numbers are allowed
function checkDigit(getEle) {
  if (/\D/g.test(getEle.value)) {
      // Filter non-digits from input value.
      getEle.value = getEle.value.replace(/\D/g, '');
  }
}

(function($) {
    /*
    |------------------------------------------------------------------------------------
    | Init DateTime
    |------------------------------------------------------------------------------------
    */
    $('.datetime').datetimepicker({
         format: 'Y-m-d H:i'
    });

    /*
    |------------------------------------------------------------------------------------
    | We change select we send the form
    |------------------------------------------------------------------------------------
    */
    $('select.onchange').change(function() {
        $(this).closest('form').submit();
    })


    /*
    |------------------------------------------------------------------------------------
    | Chosen
    |------------------------------------------------------------------------------------
    */
    if ($('select.chosen').length > 0) {
        $('select.chosen').chosen({
            // no_results_text: "Oops, rien n'a été trouvé!",
        });
    }

    /*
    |------------------------------------------------------------------------------------
    | iCheck
    |------------------------------------------------------------------------------------
    */
    //$('input').iCheck({
    //  checkboxClass: 'icheckbox_square-blue',
    //  radioClass: 'iradio_square-blue',
    //  increaseArea: '20%' // optional
    //});

    /*
    |------------------------------------------------------------------------------------
    | Submit delete form
    |------------------------------------------------------------------------------------
    */
    $(document).on('click', "form.delete button", function(e) {
        var _this = $(this);
        e.preventDefault();
        swal({
            title: 'Are you sure?',
            //text: 'Are you sure to continue ?',
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#DD4B39',
            cancelButtonColor: '#00C0EF',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            closeOnConfirm: false
        }).then(function(isConfirm) {
            if (isConfirm) {
                _this.closest("form").submit();
            }
        });
    });


})(jQuery);
