<?php
require_once './Pizza.class.php';
require_once './User.class.php';
require_once './Helper.class.php';

Helper::sessionStart();
    
if( !isset($_SESSION['user_id']) ) {
    Helper::addError('You have to be logged in to see your purchase history.');
    header("Location: ./index.php");
    die();
}
  
$history = new Pizza();
$orderHistory = $history->orderHistory();

?>

<?php 

if( User::isLoggedIn() ) { 
    $loggedInUser = new User();
    $loggedInUser->loadLoggedInUser();
}

?>

<?php include './header.layout.php'; ?>

<div class="container mt-5 mb-5">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<h4><?php echo $loggedInUser->name;?> order History</h4>
			<ul class="timeline">
                <?php foreach($orderHistory as $orderedPizza) { ?>
                    <li>
                        <a target="_blank" href="./pizza-details.php?id=<?php echo $orderedPizza->id; ?>"><?php echo "$orderedPizza->title"; ?></a>
                        <p href="#" class="float-right">
                            <?php 
                            $date = date_create($orderedPizza->deleted_at);
                            echo date_format($date, 'M-d-y H:i:s');
                            ?>
                        </p>
                        <p><?php echo "$orderedPizza->description"; ?></p>
                    </li>
                    <hr>
                <?php } ?>
			</ul>
		</div>
	</div>
</div>



    
<?php include './footer.layout.php'; ?>