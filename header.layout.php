<!DOCTYPE html>
<?php require_once './Helper.class.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Business</title>

    <!-- Include bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <!-- Include custom CSS -->
    <link rel="stylesheet" href="./css/style.css" />
    <!-- Font awsome icons -->
    <link rel="stylesheet" href="./css/all.css">
</head>
<body>

<?php include './navbar.inc.php'; ?>

<!-- Output errors -->

<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
        <?php require_once './Helper.class.php'; ?>
        <?php if(Helper::ifError()) { ?>
            <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo Helper::getError(); ?>
            </div>
        <?php } ?>

        <?php if(Helper::ifMessage()) { ?>
            <div class="alert alert-warning">
            <strong>Success!</strong> <?php echo Helper::getMessage(); ?>
            </div>
        <?php } ?>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>





        
            

            