<?php require_once './User.class.php'; ?>
<?php require_once './Pizza.class.php'; ?>
  
<!-- This is navbar -->

<nav class="navbar navbar-expand-lg navbar-light bg-warning">
  <a class="navbar-brand" href="./index.php">Pizza Business</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./menu.php">Menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact us</a>
      </li>

    
      <?php 
          if( User::isLoggedIn() ) { 
      ?>
      <?php
          $loggedInUser = new User();
          $loggedInUser->loadLoggedInUser();
      ?>
      <?php 
      $pizzaObject = new Pizza();
      $pizzaProduct = $pizzaObject->getCart();
      if(!empty($pizzaProduct)) { ?> 
      <li class="nav-item">
        <a class="nav-link" href="./cart.php"><i class="fas fa-shopping-cart"></i> Cart<?php $cartNum = new Pizza();
        $sumOfPizza = $cartNum->showCartQuantity(); ?></a>
      </li>
      <?php } ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo $loggedInUser->name;?>
          </a> 
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <?php if($loggedInUser->acc_type == 'admin') { ?>
            <a class="dropdown-item" href="./create-menu.php">Add new pizza</a>
        <?php } ?>
          <a class="dropdown-item" href="./history.php">Order History</a>
          <a class="dropdown-item" href="./logout.php">Log out</a>
        </div>
      </li>

    <?php }  else {?>
      <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Have account
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="./register.php">Sign up</a>
        <a class="dropdown-item" href="./login.php">Log in</a>
      </div>
      </li>
    <?php } ?>
      
      
    </ul>
  </div>
</nav>

