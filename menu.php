<?php include './header.layout.php'; ?>

<?php 

    require_once './Pizza.class.php';

    $p = new Pizza();
    $pizzas = $p->allPizzas();

?>

<!-- Card showing pizza information -->

<div class="container-fluid">
    <div class="row">
        <?php foreach($pizzas as $pizza) { ?>
            <div class="col-md-3 mb-3">
                <div class="card mx-auto" style="width: 100%; height:400px;">
                <img class="card-img-top product-image" src="<?php echo ($pizza->img) ? $pizza->img : './img/no-image.png' ?>">
                    <div class="card-body text-center">
                        <h3 class="card-title"><?php echo $pizza->title; ?></h3>
                        <h5 class="card-text">Cost: <?php echo $pizza->price; ?> $</h5>     
                        <a href="./pizza-details.php?id=<?php echo $pizza->id; ?>" class="btn btn-warning">Details</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include './footer.layout.php'; ?> 