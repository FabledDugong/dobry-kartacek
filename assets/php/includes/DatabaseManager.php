<?php
  class DatabaseManager extends Connection{
      public function __construct () {
          parent::__construct();
      }

      /** **********************************************************************************************************************************
       *  ********************************************************** PRODUTS ***************************************************************
       *  ********************************************************************************************************************************** */
      public function product_SelectById ($id) {
          $result = NULL;

          $query = $this->CONN->prepare(
              'SELECT product.*
                         FROM product 
                         WHERE product.id = :id'
          );

          $query->execute([ ':id' => $id ]);

          if ( $row = $query->fetch() ) {
              $query = $this->CONN->prepare(
                  'SELECT picture.url
                             FROM picture 
                             WHERE picture.id_product = :id'
              );

              $query->execute([ ':id' => $id ]);

              $result = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->color,
                  $row->toughness,
                  $row->price,
                  $row->stock,
                  $query->fetchAll()
              );
          }

          return $result;
      }

      public function product_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT product.*,
                                picture.url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         GROUP BY product.id'
          );

          $query->execute();

          $data = [];

          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->color,
                  $row->toughness,
                  $row->price,
                  $row->stock,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllByCategory ($id_category) {
          $query = $this->CONN->prepare(
              'SELECT product.*,
                                picture.url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_category = :id_category OR id_category IN (
                            SELECT DISTINCT id
                            FROM category
                            WHERE id_parent = :id_category
                         )
                         GROUP BY product.id'
          );

          $query->execute( ['id_category' => $id_category] );

          $data = [];

          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->color,
                  $row->toughness,
                  $row->price,
                  $row->stock,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllBySubCategory ($id_category) {
          $query = $this->CONN->prepare(
              'SELECT product.*,
                                picture.url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_category = :idCategory
                         GROUP BY product.id'
          );

          $query->execute( ['id_category' => $id_category] );

          $data = [];

          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->color,
                  $row->toughness,
                  $row->price,
                  $row->stock,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllByManufacturer ($id_manufacturer) {
          $query = $this->CONN->prepare(
              'SELECT product.*,
                                picture.url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_manufacturer = :id_manufacturer
                         GROUP BY product.id'
          );

          $query->execute( ['id_manufacturer' => $id_manufacturer] );

          $data = [];

          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->color,
                  $row->toughness,
                  $row->price,
                  $row->stock,
                  $row->url
              );

          return $data;
      }

      public function product_Insert (Product $product) {
          $query = $this->CONN->prepare(
              'INSERT INTO product 
                         VALUES (
                            DEFAULT, 
                            :id_category, 
                            :id_manufacturer, 
                            :name, 
                            :description,
                            :color,
                            :toughness, 
                            :price, 
                            :stock
                         )'
          );

          $query->execute([
              ':id_category'     => $product->getIdCategory(),
              ':id_manufacturer' => $product->getIdManufacturer(),
              ':name'            => $product->getName(),
              ':description'     => $product->getDescription(),
              ':color'           => $product->getColor(),
              ':toughness'       => $product->getToughness(),
              ':price'           => $product->getPrice(),
              ':stock'           => $product->getStock()
          ]);

          $id = $this->CONN->lastInsertId();

          foreach($product->getPictures() as $picture) {
              $query = $this->CONN->prepare(
                  'INSERT INTO picture 
                             VALUES (
                                DEFAULT,
                                :id_product, 
                                :url
                             )'
              );

              $query->execute([
                  ':id_product' => $id,
                  ':url'        => $picture
              ]);
          }
      }

      public function product_Delete ($id) {
          foreach($this->product_SelectById($id)->getPictures() as $picture)
              unlink("../../img/products/{$picture}");

          $query = $this->CONN->prepare(
              'DELETE 
                         FROM product 
                         WHERE id = :id'
          );

          $query->execute([ ':id' => $id ]);
      }

      /** **********************************************************************************************************************************
       *  ******************************************************** CATEGORIES **************************************************************
       *  ********************************************************************************************************************************** */
      public function category_SelectTop () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM category
                         WHERE id_parent IS NULL'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function category_SelectSub ($id_parent) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM category
                         WHERE id_parent = :id_parent'
          );

          $query->execute( [':id_parent' => $id_parent ] );
          $data = $query->fetchAll();

          return $data;
      }

      /** **********************************************************************************************************************************
       *  ******************************************************* MANUFACTURERS ************************************************************
       *  ********************************************************************************************************************************** */
      public function manufacturer_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM manufacturer'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      /** **********************************************************************************************************************************
       *  ********************************************************** INVOICES **************************************************************
       *  ********************************************************************************************************************************** */
      public function invoice_Insert () {
          $query = $this->CONN->prepare(
              ''
          );

          $query->execute([

          ]);
      }

      public function invoice_SelectAll () {
          $query = $this->CONN->prepare(
              'UNION -> protoze dve ruzny tabulky s user datama'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function invoice_SelectById ( $id_invoice ) {
          $query = $this->CONN->prepare(
              'Nejdriv selectnout one_time_customer a pak az vsechny data'
          );

          $query->execute( [':id_invoice' => $id_invoice] );
          $data = $query->fetchAll();

          return $data;
      }

      /** **********************************************************************************************************************************
       *  *********************************************************** USERS ****************************************************************
       *  ********************************************************************************************************************************** */
      public function user_SelectByLogin ( $login ) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM user
                         WHERE login = :login'
          );

          $query->execute( [':login' => $login ] );
          $data = $query->fetch();

          return $data;
      }

      public function user_SelectById ( $id ) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM user
                         WHERE id = :id'
          );

          $query->execute( [':id' => $id ] );
          $data = $query->fetch();

          return $data;
      }

      public function user_Login ( $login, $password ) {
          $query = $this->CONN->prepare(
              'SELECT id,
                                password,
                                active
                         FROM user
                         WHERE login = :login'
          );

          $query->execute([':login' => $login]);
          $data = $query->fetch();

          if ( empty($data) || !password_verify($password, $data->password) || $data->active == 0 )
              return false;

          $_SESSION['user-id'] = $data->id;
          return true;
      }

      public function user_Register ( $user ) {
          if ( !empty($this->user_SelectByLogin($user->login)) )
              return false;

          $query = $this->CONN->prepare(
              'INSERT INTO user 
                         VALUES (
                            DEFAULT, 
                            :login, 
                            :password, 
                            :f_name, 
                            :l_name, 
                            :phone, 
                            :address,
                            :city,
                            DEFAULT,
                            DEFAULT
                         )'
          );

          $query->execute([
              ':login'    => $user->login,
              ':password' => password_hash($user->password, PASSWORD_DEFAULT),
              ':f_name'   => $user->f_name,
              ':l_name'   => $user->l_name,
              ':phone'    => $user->phone,
              ':address'  => $user->address,
              ':city'     => $user->city
          ]);

          $data = $this->user_SelectByLogin($user['login']);
          $date = explode(' ', $data->registered);
          $time = explode(':', $date[1]);
          $date = explode('-', $date[0]);

          return $data->id . '-' . $date[1] . '-' . $date[2] . '-' . $time[0] . '-' . $time[1] . '-' . $time[2];
      }

      public function user_SetActive ( $token ) {
          $token = explode('-', $token);
          $user = $this->user_SelectById($token[0]);

          if ( empty($user) )
              return false;

          $date = explode(' ', $user->registered);
          $time = explode(':', $date[1]);
          $date = explode('-', $date[0]);

          if ( $token[1] != $date[1] || $token[2] != $date[2] || $token[3] != $time[0] || $token[4] != $time[1] || $token[5] != $time[2] )
              return false;

          $query = $this->CONN->prepare(
              'UPDATE user
                         SET active = 1
                         WHERE id = :id'
          );

          $query->execute([':id' => $token[0]]);

          return true;
      }

      /** **********************************************************************************************************************************
       *  ************************************************************ Q&A *****************************************************************
       *  ********************************************************************************************************************************** */
      public function qna_InsertQuestion ( $from, $question ) {
          $query = $this->CONN->prepare(
              'INSERT INTO `q&a` 
                         VALUES (
                            DEFAULT, 
                            DEFAULT, 
                            :email, 
                            :description,                             
                            DEFAULT
                         )'
          );

          $query->execute([
              ':email'       => $from,
              ':description' => $question
          ]);
      }

      public function qna_InsertAnswer ( $id, $from, $question ) {
          $query = $this->CONN->prepare(
              'INSERT INTO `q&a` 
                         VALUES (
                            DEFAULT, 
                            DEFAULT, 
                            :email, 
                            :description,                             
                            DEFAULT
                         )'
          );

          $query->execute([
              ':email'       => $from,
              ':description' => $question
          ]);

          $id_answer = $this->CONN->lastInsertId();

          $query = $this->CONN->prepare(
              'UPDATE `q&a`
                         SET id_answer = :id_answer
                         WHERE id = :id'
          );

          $query->execute([
              ':id_answer'  => $id_answer,
              ':id'         => $id
          ]);
      }

      public function qna_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM `q&a`'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function qna_SelectAllUnanswered () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM `q&a`
                         WHERE id_answer IS NULL'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function qna_SelectAllByEmail ( $email ) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM `q&a`
                         WHERE email = :email'
          );

          $query->execute([':email' => $email]);
          $data = $query->fetchAll();

          return $data;
      }
  }
?>