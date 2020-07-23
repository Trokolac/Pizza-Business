<?php 
require_once './User.class.php';
require_once './Helper.class.php';


// adding new user to db
if( isset($_POST['register']) ) {
    $u = new User();
    $u->name = $_POST['name'];
    $u->email = $_POST['email'];
    $u->password = $_POST['password'];
    $u->password_repeat = $_POST['password_repeat'];
    if( $u->insert() ) {
        Helper::addMessage("Account created successfully!");
        header("Location: ./index.php");
        die();
    } else {
        header("Location: ./register.php");
        die();
    }
  }
?>

<?php include './header.layout.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="./register.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputName4"><b>Name</b></label>
                <input type="name" class="form-control" id="inputName4" placeholder="Name" name="name">
                </div>
                <div class="form-group col-md-6">
                <label for="inputEmail4"><b>Email</b></label>
                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" name="email">
                </div>
                
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputPassword4"><b>Password</b></label>
                <input type="password" class="form-control" id="inputPassword4" placeholder="Password" name="password">
                </div>
                <div class="form-group col-md-6">
                <label for="inputPasswordR4"><b>Password Repeat</b></label>
                <input type="password" class="form-control" id="inputPasswordR4" placeholder="Password Repeat" name="password_repeat">
                </div>
            
            </div>
            <button type="submit" class="btn btn-warning float-right" name="register">Register</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

<?php include './footer.layout.php'; ?>