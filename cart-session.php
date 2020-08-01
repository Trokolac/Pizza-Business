<?php
require_once './Helper.class.php';
Helper::sessionStart();
include './header.layout.php';

if( isset($_SESSION['user_id']) ) {
    Helper::addError('404 Page not found.');
    header("Location: ./index.php");
    die();
}

if(filter_input(INPUT_GET, 'action') == 'delete')
{
    foreach ($_SESSION['shopping_cart'] as $key => $product)
    {
        if ($product['id'] == filter_input(INPUT_GET, 'id'))
        {
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
$_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}

// Handle cart alerts

if( isset($_POST['remove_from_cart'])) {
    Helper::addMessage('Pizza removed from cart.');
    header("Location: ./cart-session.php");
}

if( isset($_POST['mail_to']) ) {
    $productMail = new Pizza();
    $productMail->mailSession();
    if($productMail){
        Helper::addMessage('Your order has been successful.');
        header('Location: ./cart-session.php');
        unset($_SESSION['shopping_cart']);
    } 
}

if(empty($_SESSION['shopping_cart'])) {
Helper::addWarning('Cart is empty you can not browse it.');
header("Location: ./index.php");
die();
}

if(isset($_SESSION['shopping_cart'])){
?>
<!-- Cart information -->

<div class="container-fluid">
    
    <div class="row">
        <div class="col-md-7">
        
            <h4>Cart</h4>

            <table class="table">

                <thead>
                    <tr>
                    <th>Title</th>
                    <th>*</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $total = 0;
                    if(!empty($_SESSION['shopping_cart']))
                    {
                        foreach ($_SESSION['shopping_cart'] as $key =>$product){
                        
                            $total += number_format($product['quantity']*$product['price'], 2);
                        
                    ?>
                    <tr>
                        <th><?php echo $product['name']?></th>
                        <td><?php echo $product['quantity'];?></td>
                        <?php
                            $pizzaPriceinUsd = number_format($product['price'], 2);
                            $pizzaPriceinEur = number_format($pizzaPriceinUsd * 0.845073, 2);
                            $pizzaPriceTotalUsd = number_format($product['quantity'] * $pizzaPriceinUsd, 2);
                            $pizzaPriceTotalEur = number_format($pizzaPriceTotalUsd * 0.845073, 2);
                        ?>
                        <td>$ <?php echo $pizzaPriceinUsd; ?> / €<?php echo $pizzaPriceinEur; ?></td>
                        <td>$ <?php echo $pizzaPriceTotalUsd; ?> / €<?php echo $pizzaPriceTotalEur; ?></td>
                        <td> 
                            <form action="./cart-session.php?action=delete&id=<?php echo $product['id']?>" method="POST">
                            <a href=""><button class="btn btn-sm btn-outline-danger" name="remove_from_cart"><i class="far fa-trash-alt"></i> Delete</button> 
                            </a>
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
                <?php 
                    }
                }
                ?>
                <td>
                    <?php
                        if (isset($_SESSION['shopping_cart'])):
                        if (count($_SESSION['shopping_cart']) > 0):
                        endif; endif; ?>
                </td>
                </tr>
            </tfoot>

            </table>

            <form action="./cart-session.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="inputAdress"><b>Name:</b></label>
                <input type="text" class="form-control" id="inputName" placeholder="Your name" name="name" required>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                <label for="inputEmailAdress"><b>Email adress:</b></label>
                <input type="email" class="form-control" id="inputAdress" placeholder="Email address" name="emailAdress" required>
                </div>
            </div>

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
                        <input type="hidden" name="order" value="<?php foreach ($_SESSION['shopping_cart'] as $key =>$product){ ?><?php echo $product['name'];?> x <?php echo $product['quantity'];?>&#10;<?php } ?>">
                        <textarea rows="3" type="text" id="message" name="message" class="form-control md-textarea"></textarea>
                    </div>
                </div>
            </div>

            <div class="form-row mt-4 mb-5">
                <div class="col-md-3"></div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-7"><h6>Total cart price:</h6></div>
                        <?php
                            $totalPriceUsd = number_format($total, 2); 
                            $totalPriceEur = number_format($totalPriceUsd * 0.845073, 2);
                        ?>
                        <div class="col-md-5"><h5>$<?php echo $totalPriceUsd;?> / €<?php echo $totalPriceEur; ?></h5></div>
                    </div>
                </div>
                <div class="col-md-2">
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