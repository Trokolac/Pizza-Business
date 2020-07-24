<?php

if( !isset($_GET['id']) ) {
  header("Location: ./index.php");
}

require_once './Pizza.class.php';
require_once './Helper.class.php';

$pizza = new Pizza($_GET['id']);


?>

<?php include './header.layout.php'; ?>


<div class="container">
    <h1 class="mt-5 mb-5"><?php echo $pizza->title; ?></h1>
    <div class="row">

        <div class="col-md-5">
            <img src="<?php echo ($pizza->img) ? $pizza->img : './img/no-image.png' ?>" class="img-fluid mb-4" />
        </div>

        <div class="col-md-7">

            <h3 class="mb-5">Description</h3>
            <p class="mb-5"><?php echo $pizza->description; ?></p>
            
            <h5 class="float-right mt-5">Cost: <?php echo $pizza->price; ?> $</h5>

            <br clear="all" />
            <hr>
            <form action="./product-details.php?id=<?php echo $_GET['id']; ?>" method="post" class="float-right">

                <div class="input-group mt-3">

                    <input type="number" name="quantity" class="form-control" value="1" min="1" />

                    <div class="input-group-append">
                    <button name="add_to_cart" class="btn btn-warning mb-5">
                        Add to cart
                    </button>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>




    
<?php include './footer.layout.php'; ?>