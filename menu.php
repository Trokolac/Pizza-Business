<?php include './header.layout.php'; ?>

<?php 

    require_once './Pizza.class.php';

    $p = new Pizza();
    $pizzas = $p->allPizzas();

?>

<!-- Card showing pizza information -->

<div class="container-fluid mt-5">
    <div class="row">
        <?php foreach($pizzas as $pizza) { ?>
            <div class="col-md-3 mb-3">
                <div class="card mx-auto" style="width: 100%;">
                <img class="card-img-top product-image" src="<?php echo ($pizza->img) ? $pizza->img : './img/no-image.png' ?>">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $pizza->title; ?></h3>
                        <p class="card-text"><?php echo $pizza->description; ?></p>
                        <h5 class="card-text"><?php echo $pizza->price; ?> $</h5>
                        <a href="#" class="btn btn-warning">Add to cart</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include './footer.layout.php'; ?> 