<?php 

// end session with user and log him out

require_once './Helper.class.php';

Helper::sessionStart();

unset($_SESSION['user_id']);

header("Location: ./index.php");