<?php

$db=require './db.inc.php';
$conf=require './config.inc.php';

// ADDING USERS TABLE TO DB

$stmt_createUsersTable = $db->prepare("
    CREATE TABLE IF NOT EXISTS `users`(
        `id` int AUTO_INCREMENT PRIMARY KEY,
        `email` varchar(30),
        `name` varchar(30),
        `password` varchar(60),
        `acc_type` enum('user', 'admin') DEFAULT 'user',
        `created_at` datetime DEFAULT now(),
        `updated_at` datetime DEFAULT now() ON UPDATE now(),
        `deleted_at` datetime DEFAULT NULL  
    )
");

$stmt_createUsersTable->execute();

// ADDING ADMIN TO USERS

$stmt_getUsers = $db->prepare("
  SELECT *
  FROM `users`
");
$stmt_getUsers->execute();
$numOfUsers = $stmt_getUsers->rowCount();

if( $numOfUsers <= 0 ) {
  $stmt_addAdmin = $db->prepare("
    INSERT INTO `users`
      (`name`, `email`, `password`, `acc_type`)
    VALUES
      (:name, :email, :password, :acc_type)
  ");
  $stmt_addAdmin->execute([
    ':name' => $conf['admin_name'],
    ':email' => $conf['admin_email'],
    ':password' => md5($conf['admin_password']),
    ':acc_type' => 'admin'
  ]);
}

var_dump( $db->errorInfo() );