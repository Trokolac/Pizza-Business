<?php

require_once './User.class.php';
require_once './Helper.class.php';

$loggedInUser = new User();
$loggedInUser->loadLoggedInUser();

if( $loggedInUser->acc_type != 'admin' ) {
  Helper::addError('404 Page not found.');
  header('Location: ./index.php');
  die();
}
