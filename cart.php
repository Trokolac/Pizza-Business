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

$pizzaProduct = $pizzaObject->getCart();

?>

<?php include './header.layout.php'; ?>

<!-- Cart information -->

<div class="container mt-5">
    <div class="row">
        <h1>Cart</h1>

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
                <td><h6>Total cart price:</h6></td>
                <td><h5>$<?php echo number_format($total, 2, '.', ','); ?></h5></td>
                <td></td>
                </tr>
            </tfoot>

        </table>
    </div>
</div>
  


<?php include './footer.layout.php'; ?>
