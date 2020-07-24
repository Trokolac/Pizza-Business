<?php

class Pizza {
    private $db;
    public $id;
    public $title;
    public $description;
    public $price;
    public $img;
    public $imageData;
    public $pizzaImgDir = './img/pizza/';
    public $allowedImgTypes = ['image/jpeg', 'image/gif', 'image/png'];
    public $maxImageSize = 2097152; // 2 * 1024 * 1024
    public $created_at;
    public $updated_at;
    public $deleted_at;

    function __construct($id = null) {
        $this->db = require './db.inc.php';

        if($id) {
            $this->id = $id;
            $this->loadFromDB();
        }
    }

    public function loadFromDB() {
        $stmt_get = $this->db->prepare("
        SELECT *
        FROM `pizza`
        WHERE `id` = :id
        ");
        $stmt_get->execute([ ':id' => $this->id ]);
        $pizza = $stmt_get->fetch();

        if( !$pizza ) {
        return false;
        }

        foreach( get_object_vars($pizza) as $key => $value ) {
        $this->$key = $value;
        }
    }

    // Insert pizza into db 

    public function insert() {

        if( !$this->titleIsEmpty() ) {
            return false;
        }

        if( !$this->pizzaIsAvailable() ) {
            return false;
        } 

        if( !$this->priceIsEmpty() ) {
            return false;
        } 

        $stmt_insert = $this->db->prepare("
        INSERT INTO `pizza`
            (`title`, `description`, `price`, `img`)
        VALUES
            (:title, :description, :price, :img)
        ");
        $success = $stmt_insert->execute([
        ':title' => ucfirst($this->title),
        ':description' => $this->description,
        ':price' => $this->price,
        ':img' => $this->img
        ]);

        if( $success && $this->imageData ) {
            $this->id = $this->db->lastInsertId();
            return $this->handleImageUpload();
        } else {
            return $success;
        }
    }

    //   Handle image upload 

    public function handleImageUpload() {
        
        file_exists($this->pizzaImgDir) or mkdir($this->pizzaImgDir, 0777, true);
        $ext = pathinfo($this->imageData['name'], PATHINFO_EXTENSION);
        $imagePath = "{$this->pizzaImgDir}{$this->id}.$ext";

        if( !$this->imageIsValid() ) {
        return false;
        }

        move_uploaded_file($this->imageData['tmp_name'], $imagePath);
        $this->img = $imagePath;
        $this->update();
        return true;
    }

    // Required for image upload

    public function update() {
        $stmt_update = $this->db->prepare("
          UPDATE `pizza`
          SET
           `img` = :img
          WHERE `id` = :id
        ");
        return $stmt_update->execute([
          ':img' => $this->img,
          ':id' => $this->id
        ]);
      }

    //  Check image type and size

    public function imageIsValid() {
        if( !in_array($this->imageData['type'], $this->allowedImgTypes) ) {
        Helper::addError('File type not allowed, default picture is set.');
        return false;
        }

        if ( $this->imageData['size'] > $this->maxImageSize ) {
        Helper::addError('Please choose smaller image.');
        return false;
        }

        return true;
    }

    // Check if pizza input title field is empty

    public function titleIsEmpty() {

        if( $this->title == "" ) {
        Helper::addError('Pizza has to have a name.');
        return false;
        }

        return true;
    }

    // Check if pizza input price field is empty

    public function priceIsEmpty() {

        if( $this->price == "" ) {
        Helper::addError('Pizza has to have a price.');
        return false;
        }

        return true;
    }

    // Check if pizza name already exists in DB

    public function pizzaIsAvailable() {
        $stmt_getName = $this->db->prepare("
        SELECT *
        FROM `pizza`
        WHERE `title` = :title
        ");
        $stmt_getName->execute([ ':title' => $this->title ]);

        if( $stmt_getName->rowCount() > 0 ) {
        Helper::addError('Name is already taken.');
        return false;
        }

        return true;
    }

    // Pull data from DB and show in order they are put in

    public function allPizzas() { 
        $stmt_get = $this->db->prepare("
        SELECT *
        FROM `pizza`
        WHERE `deleted_at` IS NULL
        ORDER BY id ASC
        ");
        $stmt_get->execute();
        return $stmt_get->fetchAll();
    }
    
    // Handle adding to cart

    public function addToCart($quantity) {
        Helper::sessionStart();
    
        if( !isset($_SESSION['user_id']) ) {
          Helper::addError('You have to be logged in to add product to cart.');
          return false;
        }

        // Showing cart info

        $stmt_getCartProduct = $this->db->prepare("
          SELECT *
          FROM `carts`
          WHERE `pizza_id` = :pizza_id
          AND `user_id` = :user_id
        ");
        $stmt_getCartProduct->execute([
          ':pizza_id' => $this->id,
          ':user_id' => $_SESSION['user_id']
        ]);
        $pizzaInCart = $stmt_getCartProduct->fetch();
    
        // Update  quantity

        if($pizzaInCart) {
          $stmt_updateQuantity = $this->db->prepare("
            UPDATE `carts`
            SET `quantity` = :new_quantity
            WHERE `id` = :cart_id
          ");
          return $stmt_updateQuantity->execute([
            ':new_quantity' => $pizzaInCart->quantity + $quantity,
            ':cart_id' => $pizzaInCart->id
          ]);
        } else {

        // Insert pizza into cart

          $stmt_addToCart = $this->db->prepare("
            INSERT INTO `carts`
            (`user_id`, `pizza_id`, `quantity`)
            VALUES
            (:user_id, :pizza_id, :quantity)
          ");
          return $stmt_addToCart->execute([
            ':user_id' => $_SESSION['user_id'],
            ':pizza_id' => $this->id,
            ':quantity' => $quantity
          ]);
        }
      }
}