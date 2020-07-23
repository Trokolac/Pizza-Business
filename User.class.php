<?php 

class User {
    private $db;
    public $id;
    public $email;
    public $name;
    public $password;
    public $password_repeat;
    public $created_at;
    public $updated_at;
    public $deleted_at;

    function __construct($id = null) {
      require_once './Helper.class.php';
      $this->db = require './db.inc.php';
  
      if( $id != null ) {
        $this->id = $id;
        $this->loadUserFromDB();
      }
    }
  
    public function loadUserFromDB() {
      $stmt_get = $this->db->prepare("
        SELECT *
        FROM `users`
        WHERE `id` = :id
      ");
      $stmt_get->execute([ ':id' => $this->id ]);
      $user = $stmt_get->fetch();
  
      if( !$user ) {
        return false;
      }
  
      foreach( get_object_vars($user) as $key => $value ) {
        $this->$key = $value;
      }
    }
     
    
    public function insert() {

    // functions that validate registration requirements are  below this function

      if( !$this->nameIsEmpty() ) {
        return false;
      }  

      if( !$this->emailIsValid() ) {
        return false;
      }  

      if( !$this->passwordIsValid() ){
        return false;
      }

      if( !$this->emailIsAvailable() ){
        return false;
      }

      $stmt_insert = $this->db->prepare("
          INSERT INTO `users`
            (`name`, `email`, `password`)
          VALUES
            (:name, :email, :password)
        ");
      $success = $stmt_insert->execute([
          ':name' => ucfirst($this->name),
          ':email' => $this->email,
          ':password' => md5($this->password) //encrypts the password
        ]);
        
      if(!$success) {
        return false;
      }

      Helper::sessionStart();
      $_SESSION['user_id'] = $this->db->lastInsertId();
      return true;

    }

    // checks if password field is empty and if passwords match before importing to db
    public function passwordIsValid() {

      if( $this->password == "" ) {
        Helper::addError('Password is empty.');
        return false;
      }
  
      if( $this->password != $this->password_repeat ) {
        Helper::addError('Passwords dont match.');
        return false;
      }
  
      return true;
    }
    
    // checks if email is in valid format
    public function emailIsValid() {

      if( !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
        Helper::addError('Check email again.');
        return false;
      }
  
      return true;
    }

    // checks if name field is empty or not
    public function nameIsEmpty() {

      if( $this->name == "" ) {
        Helper::addError('Username must be filled.');
        return false;
      }

      return true;

    }

    // checks if db contains the same email or not
    public function emailIsAvailable() {
      $stmt_getUserByEmail = $this->db->prepare("
        SELECT *
        FROM `users`
        WHERE `email` = :email
      ");
      $stmt_getUserByEmail->execute([ ':email' => $this->email ]);
  
      if( $stmt_getUserByEmail->rowCount() > 0 ) {
        Helper::addError('Email is already taken.');
        return false;
      }
  
      return true;
    }  

    // Log in user

    public function login() {
      $stmt_getUser = $this->db->prepare("
        SELECT *
        FROM `users`
        WHERE `email` = :email
        AND `password` = :password
      ");
      $stmt_getUser->execute([
        ':email' => $this->email,
        ':password' => md5($this->password)
      ]);
  
      $user = $stmt_getUser->fetch();
  
      if( !$user ) {
        Helper::addError('Login failed. Please check your email and/or password.');
        return false;
      }
  
      Helper::sessionStart();
      $_SESSION['user_id'] = $user->id;
      return true;
    }

    public static function isLoggedIn() {
      require_once './Helper.class.php';
      Helper::sessionStart();
      return isset($_SESSION['user_id']) && $_SESSION['user_id'] != "";
    }
  
    public function loadLoggedInUser() {
      if( !User::isLoggedIn() ) {
        return false;
      }
      Helper::sessionStart();
      $this->id = $_SESSION['user_id'];
      $this->loadUserFromDB();
    }
  
}