</div>

<!-- Footer -->
<footer class="text-center" id="footer">&COPY; Copyright 2016 Gift Wrapper</footer>

<script>
//    function detailsmodal(id) {
//        var data = {'id': id};
//        jQuery.ajax({
//            url: '/ecommerce/includes/detailsmodal.php',
//            method: "POST",
//            data: data,
//            success: function(data){
//                jQuery('body').append(data);
//                jQuery('#details-modal').modal('toggle');
//            },
//            error: function(){
//                alert("Something went wrong");
//            }
//        });
//    }
    
    function update_cart(mode, edit_id, edit_size){
        var data = {"mode":mode, "edit_id": edit_id, "edit_size": edit_size};
        $.ajax({
            url: '/ecommerce/admin/parsers/update_cart.php',
            method: "post",
            data: data,
            success: function(){
                location.reload();
            },
            error: function(){
                alert("Something Went wrong");
            }
        });
        if(mode == "removeone"){
            notif({
                      msg   : "This Product quantity was increased.",
                      type  : "info"
            });
        }
        else if(mode == "addone"){
            notif({
                      msg   : "This Product quantity was decreased.",
                      type  : "info"
            });
        } 
    }
        
    function add_to_cart(){
        $('cart_erros').html("");
        var size = $("#size").val();
        var quantity = $("#quantity").val();
        var available = $("#available").val();
        var errors = "";
        var data = $("#add_product_form").serialize();  

        if(size=="" || quantity=="" || quantity==0){
          errors += '<p class="text-danger text-center">You must choose a size and quantity</p>';
          $("#product_errors").html(errors);
          return;
        } 
        else if(quantity > available){
          errors += '<p class="text-danger text-center">There are only '+available+' available.</p>';
          $("#product_errors").html(errors);
          return;
        }
        else{
            $.ajax({
                url : '/ecommerce/admin/parsers/add_cart.php',
                method : 'post',
                data : data,
                success : function(){
                    notif({
                      msg   : "This Product was added to your cart.",
                      type  : "info"
                    });
                },
                error : function(){
                    alert("Something went Wrong");
                }
            });
        }
    }
</script>
</body>
</html>