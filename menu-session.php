<?php 
require_once './Helper.class.php';
Helper::sessionStart();
require_once './Pizza.class.php';
include './header.layout.php';

    

    $p = new Pizza();
    $pizzas = $p->allPizzas();


    $product_ids = array();

    //session_destroy();
    
    if(filter_input(INPUT_POST, 'add_to_cart'))
    {
        if(isset($_SESSION['shopping_cart']))
        {
            $count = count($_SESSION['shopping_cart']);
    
    
            $product_ids = array_column($_SESSION['shopping_cart'], 'id');
    
            if(!in_array(filter_input(INPUT_GET, 'id'), $product_ids))
            {
                $_SESSION['shopping_cart'][$count] = array
                (
                    'id' => filter_input(INPUT_GET, 'id'),
                    'name' => filter_input(INPUT_POST, 'name'),
                    'price' => filter_input(INPUT_POST, 'price'),
                    'quantity' => filter_input(INPUT_POST, 'quantity')
    
                );
            }else
                {
                    for($i = 0; $i < count($product_ids); $i++)
                    {
                            if($product_ids[$i] == filter_input(INPUT_GET, 'id'))
                            {
                                $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                            }
                    }
                }
    
    
        }else{
    
            $_SESSION['shopping_cart'][0] = array
            (
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'name'),
                'price' => filter_input(INPUT_POST, 'price'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
    
            );
        }
    
    }

    if( isset($_POST['add_to_cart']) ) {
        Helper::addMessage("Pizza added to cart, check cart.");
        header("Location: ./menu-session.php");
        die();
    }
    

   
?>
<div class="container-fluid">
    <div class="row">
<?php
$connect = mysqli_connect('eu-cdbr-west-03.cleardb.net', 'b62e0e5e6cd8a8', '86318451', 'heroku_1753f8fa38b2769');

$query = "SELECT * FROM pizza ORDER BY id ASC ";

$result = mysqli_query($connect, $query);

if($result):

if(mysqli_num_rows($result)>0):

while ($product = mysqli_fetch_assoc($result)):

    
    
?>



<div class="col-md-3 mb-3">
<form method="POST" action="./menu-session.php?action=add&id=<?php echo $product['id'];?>">
    <div class="card mx-auto" style="width: 100%; height:450px;">
    <img class="card-img-top product-image" src="<?php echo ($product['img']) ? $product['img'] : './img/no-image.png' ?>">
        <div class="card-body text-center">
            
            <h4 class="card-title"><?php echo $product['title']; ?></h4>
            <div class="overflow-auto" style="height:50px;"><?php echo $product['description']; ?></div>
            <h5 class="card-text">Cost: <?php echo $product['price']; ?> $</h5> 
            <input type="number" name="quantity" class="form-control" value="1" min="1">
            <input type="hidden" name="name" value="<?php echo $product['title']?>">
            <input type="hidden" name="price" value="<?php echo $product['price']?>">
            <input type="submit" name="add_to_cart" class="btn btn-warning" value="Add to Cart" style="margin-top: 7px;">
        </div>
    </div>
    </form>
</div>

        
<?php
endwhile;
endif;
endif;

?>
    </div>
</div>

<?php include './footer.layout.php'; ?> 