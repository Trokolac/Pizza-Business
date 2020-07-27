<?php
require_once './Pizza.class.php';
require_once './Helper.class.php';

Helper::sessionStart();
    
if( !isset($_SESSION['user_id']) ) {
    Helper::addError('You have to be logged in to access cart.');
    header("Location: ./index.php");
    die();
}
  
$pizzaObject = new Pizza();

if( isset($_POST['remove_from_cart']) ) {
    if( $pizzaObject->removeFromCart($_POST['cart_id']) ) {
        Helper::addMessage('Pizza removed from cart.');
        header("Location: ./cart.php");
        die();
    } else {
        Helper::addError('Failed to remove pizza from cart.');
        header("Location: ./cart.php");
        die();
    }
}

if( isset($_POST['update_qunatity']) ) {
    if( $pizzaObject->updateQuantity($_POST['cart_id'], $_POST['new_quantity']) ) {
        Helper::addMessage('Quantity updated successfully.');
    } else {
        Helper::addError('Failed to update quantity.');
    }
}

if( isset($_POST['mail_to']) ) {
    $productMail = new Pizza();
    $productMail->mail();
    if($productMail){
        Helper::addMessage('Your order has been successful.');
        header("Location: ./cart.php");
        die();
    } else {
        Helper::addError('Please refresh page and try again.');
      header("Location: ./cart.php");
      die();
    }
  }

$pizzaProduct = $pizzaObject->getCart();

if(empty($pizzaProduct)) {
    Helper::addWarning('Cart is empty you can not browse it.');
    header("Location: ./index.php");
    die();
}

?>

<?php include './header.layout.php'; ?>

<!-- Cart information -->

<div class="container-fluid">
    
    <div class="row">
        <div class="col-md-7">
        
            <h4>Cart</h4>

            <table class="table">

                <thead>
                    <tr>
                    <th>Title</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total price</th>
                    <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach($pizzaProduct as $pizzaCart) { ?>
                    <?php $total += $pizzaCart->quantity * $pizzaCart->price; ?>
                    <tr>
                        <th><?php echo $pizzaCart->title; ?></th>
                        <td>
                        <form action="./cart.php" method="post">
                            <div class="input-group input-group-sm">
                            <input type="hidden" name="cart_id" value="<?php echo $pizzaCart->id; ?>" />
                            <input type="number" name="new_quantity" class="form-control" value="<?php echo $pizzaCart->quantity; ?>" min="1" />
                            <div class="input-group-append">
                                <button name="update_qunatity" class="btn btn-warning">Update</button>
                            </div>
                            </div>
                        </form>
                        </td>
                        <td>$<?php echo number_format($pizzaCart->price, 2, '.', ','); ?></td>
                        <td>$<?php echo number_format($pizzaCart->quantity * $pizzaCart->price, 2, '.', ','); ?></td>
                        <td>
                        <form action="./cart.php" method="post">
                            <input type="hidden" name="cart_id" value="<?php echo $pizzaCart->id ?>" />
                            <button name="remove_from_cart" class="btn btn-sm btn-outline-danger"><i class="far fa-trash-alt"></i> Delete</button>
                        </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            </tfoot>

            </table>

            <form action="./cart.php" method="post">
            <div class="form-row">
                
                <div class="form-group col-md-12">
                <label for="inputAdress"><b>Adress:</b></label>
                <input type="text" class="form-control" id="inputAdress" placeholder="Reisdence address" name="adress" required>
                </div>
                
            </div>
            <div class="form-row">
                
                <div class="form-group col-md-12">
                <label for="phone"><b>Phone number:</b></label>
                <input class="form-control" type="tel" id="phone" name="phone" placeholder=""
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                    required>
                <small class="float-right">Format: 123-456-7890</small>
                </div>
            </div>


            <div class="form-row">
                <div class="col-md-12">
                    <div class="md-form">
                        <label for="message"> <b>Message:</b> </label>
                        <input type="hidden" name="order" value="<?php foreach($pizzaProduct as $pizzaCart) { ?><?php echo $pizzaCart->title; ?> x <?php echo $pizzaCart->quantity; ?>&#10;<?php } ?>">
                        <textarea rows="3" type="text" id="message" name="message" class="form-control md-textarea"></textarea>
                        
                    </div>
                </div>
            </div>

            

            <div class="form-row mt-4 mb-5">
                <div class="col-md-5">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-7"><h6>Total cart price:</h6></div>
                        <div class="col-md-5"><h5>$<?php echo number_format($total, 2, '.', ','); ?></h5></div>
                    </div>
                
                    
                </div>
                <div class="col-md-3">
                    <button name="mail_to" class="btn btn-sm btn-warning float-right">Order</button>
                </div>
            </div>

            </form>

        </div>
        <div class="col-md-5">
        <!-- PLACEHOLDER -->
        </div>
    </div>
</div>
</div>

<?php include './footer.layout.php'; ?>
