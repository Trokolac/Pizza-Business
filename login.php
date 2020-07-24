<?php require_once './User.class.php';

if( isset($_POST['login']) ) {
    $u = new User();
    $u->email = $_POST['email'];
    $u->password = $_POST['password'];
    if( $u->login() ) {
        Helper::addMessage("You have been logged in.");
        header("Location: ./index.php");
        die();
    } else {
        header("Location: ./login.php");
        die();
    }
}

?>

<?php include './header.layout.php'; ?>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="./login.php" method="post">
                <div class="form-group">
                    <label for="inputEmail"><b>Email address</b></label>
                    <input type="text" class="form-control" id="inputEmail" placeholder="Enter email" name="email" >
                </div>
                <div class="form-group">
                    <label for="inputPassword"><b>Password</b></label>
                    <input type="password" class="form-control" id="inputPassword" placeholder="Enter password" name="password">
                </div>
                <button name="login" class="btn btn-warning float-right">Log in</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<?php include './footer.layout.php'; ?>