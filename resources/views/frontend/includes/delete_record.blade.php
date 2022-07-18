  <!-- Delete Model -->
<form action="" method="POST" class="remove-record-model">
    <div id="custom-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmation_delete_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <h5 id="confirmation_delete_msg"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        // For A Delete Record Popup
        $('.remove-record').click(function() {
            var id = $(this).attr('data-id');
            var url = $(this).attr('data-url');
            var data  = $(this).attr('data-msg');
            var title  = $(this).attr('data-title');
    
            $(".remove-record-model").attr("action",url);
            $('body').find('.remove-record-model').append('<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />');
            $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
            $('body').find('.remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
            $('body').find('.remove-record-model #confirmation_delete_msg').html(data);
            $('body').find('.remove-record-model #confirmation_delete_title').html(title);
        });

        $('.remove-data-from-delete-form').click(function() {
            $('body').find('.remove-record-model').find( "input" ).remove();
        });
    });
</script> 