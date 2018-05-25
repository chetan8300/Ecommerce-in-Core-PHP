<?php
require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

if ($cart_id != "") {
    $cart_query = "SELECT * FROM cart WHERE id='{$cart_id}'";
    $cart_ref = $db->query($cart_query);
    $cart_products = mysqli_fetch_assoc($cart_ref);
    $items = json_decode($cart_products['items'], true);
    $i = 1;
    $subtotal = 0;
    $item_count = 0;
}
?>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h2 class="text-center">My Shopping Cart</h2>
            <?php if ($cart_id == "") { ?>
                <div class="bg-danger top-buffer">
                    <p class="text-center text-danger">
                        There are no products in the Cart.
                    </p>
                </div>
            <?php } else { ?>
                <table class="table tab-content table-bordered top-buffer text-center table-striped table-condensed table-hover">
                    <thead>
                    <th>#</th>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Sub Total</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($items as $item) {
                            $product_id = $item['id'];
                            $product_query = "SELECT * FROM products WHERE id='" . $product_id . "'";
                            $product_ref = $db->query($product_query);
                            $product = mysqli_fetch_assoc($product_ref);
                            $sizeArray = explode(',', $product['sizes']);
                            foreach ($sizeArray as $sizestring) {
                                $s = explode(":", $sizestring);
                                if ($s[0] == $item['size']) {
                                    $available = $s[0];
                                }
                            }
                            $product_price = $product['price'] * $item['quantity'];
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $product['title']; ?></td>
                                <td>$<?php echo $product['price']; ?></td>
                                <td>
                                    <button class="btn btn-xs btn-danger" onclick="update_cart('removeone', '<?php echo $product['id']; ?>', '<?php echo $item['size']; ?>');">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                    <?php echo $item['quantity']; ?>
                                    <?php if ($item['quantity'] < $available) { ?>
                                        <button class="btn btn-xs btn-success" onclick="update_cart('addone', '<?php echo $product['id']; ?>', '<?php echo $item['size']; ?>');">
                                            <span class="glyphicon glyphicon-plus"></span>
                                        </button>
                                    <?php
                                    } else {
                                        ?>
                                        <span class="text-danger">Max</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo $item['size']; ?></td>
                                <td>$<?php echo $product_price; ?></td>
                            </tr>
                            <?php
                            $item_count += $item['quantity'];
                            $subtotal += $product_price;
                        }
                        $tax = TAXRATE * $subtotal;
                        $tax = number_format($tax, 2);
                        $grand_total = $tax + $subtotal;
                        ?>
                    </tbody>
                </table>
                <hr>
                <table class="table tab-content table-bordered text-right table-striped table-condensed table-hover">
                    <legend class="text-center">Totals</legend>
                    <thead>
                        <tr>
                            <th>Total Items</th>
                            <th>Sub Total</th>
                            <th>Tax</th>
                            <th>Grand Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $item_count; ?></td>
                            <td>$<?php echo $subtotal; ?></td>
                            <td>$<?php echo $tax; ?></td>
                            <td class="bg-success">$<?php echo $grand_total; ?></td>
                        </tr>
                    </tbody>
                </table>


                <!-- Check Out Button -->
                <button type="button" class="btn btn-primary btn-lg pull-right  " data-toggle="modal" data-target="#checkoutModal">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Check Out
                </button>

                <!-- Modal -->
                <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="checkoutModalLabel">Shipping Address</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form action="thankyou.php" method="post" id="payment-form">
                                        <span class="bg-danger" id="payment_error"></span>
                                        <input type="hidden" name="tax" value="<?php echo $tax; ?>">
                                        <input type="hidden" name="sub_total" value="<?php echo $subtotal; ?>">
                                        <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
                                        <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
                                        <input type="hidden" name="description" value="<?php echo $item_count.'item'.(($item_count>1)?'s':'').' from Gift Wrapper.' ; ?>">
                                        <div id="step1" style="display: block;">
                                            <div class="form-group col-md-6">
                                                <label for="full_name">Full Name: </label>
                                                <input type="text" class="form-control" id="full_name" name="full_name" data-stripe="name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email: </label>
                                                <input type="email" class="form-control" id="email" name="email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="street">Street Address: </label>
                                                <input type="text" class="form-control" id="street" name="street" data-stripe="address_line1">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="street2">Street Address 2: </label>
                                                <input type="text" class="form-control" id="street2" name="street2" data-stripe="address_line2">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="city">City: </label>
                                                <input type="text" class="form-control" id="city" name="city" data-stripe="address_city">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="state">State: </label>
                                                <input type="text" class="form-control" id="state" name="state" data-stripe="address_state">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="zip_code">Zip Code: </label>
                                                <input type="number" class="form-control" id="zip_code" name="zip_code" data-stripe="address_zip">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="country">Country: </label>
                                                <input type="text" class="form-control" id="country" name="country" data-stripe="address_country">
                                            </div>
                                        </div>
                                        <div id="step2" style="display: none;">
                                            <div class="form-group col-md-3">
                                                <label for="name">Name on Card: </label>
                                                <input type="text" id="name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="card_number">Card Number: </label>
                                                <input type="text" id="card_number" class="form-control" data-stripe="number">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="cvc">CVC: </label>
                                                <input type="text" id="cvc" class="form-control" data-stripe="cvc">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="name">Expire Month: </label>
                                                <select id="expire_month" class="form-control" data-stripe="exp_month">
                                                    <option value=""></option>
                                                    <?php for($i=1;$i<=12;$i++){ ?>
                                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="expire_year">Expire Year: </label>
                                                <select id="expire_month" class="form-control" data-stripe="exp_year">
                                                    <option value=""></option>
                                                    <?php $yr = date("Y"); ?>
                                                    <?php for($i=1;$i<=12;$i++){ ?>
                                                        <option value="<?php echo $yr+$i;?>"><?php echo $yr+$i;?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" style="display: inline-block;">Close</button>
                                <button type="button" class="btn btn-primary" onclick="check_address();" id="next_button" style="display: inline-block;">Next</button>
                                <button type="button" class="btn btn-primary" onclick="back_address();" id="back_button" style="display: none;">Back</button>
                                <button type="submit" class="btn btn-primary" id="check_out_button" style="display: none;">Check Out</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    
    function back_address(){
        $('#payment_error').html("");
        $("#step1").css("display","block");
        $('#step2').css("display","none");
        $('#next_button').css("display","inline-block");
        $('#back_button').css("display","none");
        $('#check_out_button').css("display","none");
        $('#checkoutModalLabel').html("Shipping Address");
    }
    
    function check_address(){
        var data = {'full_name': $("#full_name").val(),
                    'email': $("#email").val(),
                    'street': $("#street").val(),
                    'street2': $("#street2").val(),
                    'city': $("#city").val(),
                    'state': $("#state").val(),
                    'zip_code': $("#zip_code").val(),
                    'country': $("#country").val()
                    };
        $.ajax({
            url     : '/ecommerce/admin/parsers/check_address.php',
            method  : 'post',
            data    : data,
            success : function(data){
                        if(data != 'passed'){
                            $("#payment_error").html(data);
                        }
                        if(data == 'passed'){
                            $('#payment_error').html("");
                            $("#step1").css("display","none");
                            $('#step2').css("display","block");
                            $('#next_button').css("display","none");
                            $('#back_button').css("display","inline-block");
                            $('#check_out_button').css("display","inline-block");
                            $('#checkoutModalLabel').html("Enter Credit Card Details");
                        }
                    },
            error   : function(){
                            alert("Something Went wrong");
                    }
        });
    }
    
    Stripe.setPublishableKey('<?php echo STRIPE_PUBLIC; ?>');
    
    function stripeResponseHandler(status, response) {
      // Grab the form:
      var $form = $('#payment-form');

      if (response.error) { // Problem!

        // Show the errors on the form:
        $form.find('#payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission

      } else { // Token was created!

        // Get the token ID:
        var token = response.id;

        // Insert the token ID into the form so it gets submitted to the server:
        $form.append($('<input type="hidden" name="stripeToken">').val(token));

        // Submit the form:
        $form.get(0).submit();
      }
    };
    
    $(function() {
      var $form = $('#payment-form');
      $form.submit(function(event) {
        // Disable the submit button to prevent repeated clicks:
        $form.find('.submit').prop('disabled', true);

        // Request a token from Stripe:
        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from being submitted:
        return false;
      });
    });
</script>
<?php
include 'includes/footer.php';
?>