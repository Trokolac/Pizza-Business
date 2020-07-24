<?php require_once './admin-only.inc.php'; ?>

<?php
require_once './Helper.class.php';
?>

<?php include './header.layout.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1 class="mb-5">Add pizza</h1>

            <form action="./add-product.php" method="post" class="clearfix" enctype="multipart/form-data">

            <div class="form-row">

                <div class="form-group col-md-6">
                <label for="inputTitle">Title</label>
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Product title">
                </div>

                <div class="form-group col-md-6">
                <label for="inputImage">Image</label>
                <input type="file" name="image" id="inputImage" class="form-control-file" />
                </div>

            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                <label for="inputPrice">Price</label>
                <input type="number" name="price" id="inputPrice" class="form-control" />
                </div>

                <div class="form-group col-md-6">
                <label for="inputDescription">Description</label>
                <textarea name="description" class="form-control" id="inputDescription" rows="3"></textarea>
                </div>

            </div>

            <button name="add" class="btn btn-warning float-right">Add pizza</button>

            </form>

        </div>
    </div>
</div>


    
<?php include './footer.layout.php'; ?>