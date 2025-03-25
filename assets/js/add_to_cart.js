

	function add() {
        
        var a = $("#noofitem").val();
    a++;
    if (a && a >= 1) {

        $("#subs").removeAttr("disabled");
    }
    $("#noofitem").val(a);
};

function subst() {
    var b = $("#noofitem").val();
    // this is wrong part
    if (b && b >= 1) {
        b--;
        $("#noofitem").val(b);
    }
    else {
        $("#subs").attr("disabled", "disabled");
    }
};



$(document).ready(function() {
     $(".spinner-border").hide();
     $('.numbering').load('engine/item-numbering.php');
     $('.btn-add').click(function() {
        
         let itemId = $(this).attr('id');
         let seller_id = $('#seller').val();
         let noofitem = $('#noofitem').val();
         let seller_type = $('#seller_type').val();
         let buyer = $('#buyer').val();

        
         var data =

         { 
             'itemId': itemId, 
             'seller_id': seller_id,       
             'seller_type':seller_type,
             'noofitem': noofitem,
             'buyer':buyer 
         };
        
      $.ajax({
             type: "POST",
             url: "engine/cart-process.php",
             data:data,
             cache: false,
             success: function(response) {

                if (response == 1) {

                    swal({
                         title:"Success",
                         icon: "success",
                         text: "Item(s) has been added successfully"
                    });
                    
                    $('.numbering').load('engine/item-numbering.php');
                } else {
                    swal({
                        title:"Notice",
                        icon: "warning",
                        text: response
                    });
                }
            }
        });
    });
});
