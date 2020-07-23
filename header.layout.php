<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizza Business</title>

    <!-- Include bootstrap -->
    <link rel="stylesheet" href="./css/bootstrap.min.css" />

</head>
<body>
    
<?php include './navbar.inc.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="content">

            <!-- Output errors -->

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