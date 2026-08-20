//confirm modal before delete
function confirm_delete() 
{
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: true, //false
        closeOnCancel: true //false
    }, function(isConfirm) {
        if (isConfirm) {
            form.submit();
            //swal("Deleted!", "Your record has been deleted.", "success");
        } else {
            //swal("Cancelled", "Your record was not deleted.", "error");
        }
    });
}


//confirm modal before block vendor
function confirm_block() 
{
    event.preventDefault(); // prevent form submit
    var form = event.target.form; // storing the form
    
    swal({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No, cancel!",
        closeOnConfirm: true, //false
        closeOnCancel: true //false
    }, function(isConfirm) {
        if (isConfirm) {
            form.submit();
        } else {
        }
    });
}

//confirm modal before unbook ticket
function confirm_unbook(id) 
{
    event.preventDefault(); // prevent form submit
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this record!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Cancel Booking!",
        cancelButtonText: "No, close!",
        closeOnConfirm: true, //false
        closeOnCancel: true //false
    }, function(isConfirm) {
        if (isConfirm) {
            // var form = event.target.form; // storing the form
            // form.submit();
            $('#'+id).submit();
        } else {
        }
    });
}