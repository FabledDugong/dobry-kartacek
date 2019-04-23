<?php
  class DatabaseManager extends Connection{
      public function __construct () {
          parent::__construct();
      }

      public function product_SelectById ($id) {
          $result = NULL;

          $query = $this->CONN->prepare(
              'SELECT *
                         FROM product 
                         WHERE id = :id'
          );

          $query->execute([ ':id' => $id ]);

          if ( $row = $query->fetch() ) {
              $query2 = $this->CONN->prepare(
                  'SELECT url 
                             FROM picture 
                             WHERE id_product = :id'
              );

              $query2->execute([ ':id' => $id ]);

              $result = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  $row->description,
                  $row->price,
                  $row->stock,
                  $query2->fetchAll()
              );
          }

          return $result;
      }

      public function product_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT   product.id,
                                  id_category,
                                  id_manufacturer,
                                  name,
                                  price,
                                  url
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
                  NULL,
                  $row->price,
                  NULL,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllByCategory ($idCategory) {
          $query = $this->CONN->prepare(
              'SELECT   product.id,
                                  id_category,
                                  id_manufacturer,
                                  name,
                                  price,
                                  url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_category = :idCategory OR id_category IN (
                            SELECT DISTINCT id
                            FROM category
                            WHERE id_parent = :idCategory
                         )
                         GROUP BY product.id'
          );
          $query->execute( ['idCategory' => $idCategory] );

          $data = [];
          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  NULL,
                  $row->price,
                  NULL,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllBySubCategory ($idCategory) {
          $query = $this->CONN->prepare(
              'SELECT   product.id,
                                  id_category,
                                  id_manufacturer,
                                  name,
                                  price,
                                  url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_category = :idCategory
                         GROUP BY product.id'
          );
          $query->execute( ['idCategory' => $idCategory] );

          $data = [];
          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  NULL,
                  $row->price,
                  NULL,
                  $row->url
              );

          return $data;
      }

      public function product_SelectAllByManufacturer ($idManufacturer) {
          $query = $this->CONN->prepare(
              'SELECT   product.id,
                                  id_category,
                                  id_manufacturer,
                                  name,
                                  price,
                                  url
                         FROM product
                         LEFT JOIN picture ON product.id = picture.id_product
                         WHERE id_manufacturer = :idManufacturer
                         GROUP BY product.id'
          );
          $query->execute( ['idManufacturer' => $idManufacturer] );

          $data = [];
          while( $row = $query->fetch() )
              $data[] = new Product(
                  $row->id,
                  $row->id_category,
                  $row->id_manufacturer,
                  $row->name,
                  NULL,
                  $row->price,
                  NULL,
                  $row->url
              );

          return $data;
      }

      public function product_Insert (Product $product) {
          $query = $this->CONN->prepare(
              'INSERT INTO product 
                         VALUES (
                            DEFAULT, 
                            :idCategory, 
                            :idManufacturer, 
                            :name, 
                            :description, 
                            :price, 
                            :stock
                         )'
          );

          $query->execute([
              ':idCategory'     => $product->getIdCategory(),
              ':idManufacturer' => $product->getIdManufacturer(),
              ':name'           => $product->getName(),
              ':description'    => $product->getDescription(),
              ':price'          => $product->getPrice(),
              ':stock'          => $product->getStock()
          ]);

          $id = $this->CONN->lastInsertId();

          foreach($product->getPictures() as $picture) {
              $query = $this->CONN->prepare(
                  'INSERT INTO picture 
                             VALUES (
                                DEFAULT,
                                :idProduct, 
                                :url
                             )'
              );

              $query->execute([
                  ':idProduct'  => $id,
                  ':url'        => $picture
              ]);
          }
      }

      public function product_Delete ($id) {
          foreach($this->product_SelectById($id)->getPictures() as $picture)
              unlink("../../img/{$picture->url}");

          $query = $this->CONN->prepare(
              'DELETE 
                         FROM product 
                         WHERE id = :id'
          );

          $query->execute([ ':id' => $id ]);
      }

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

      public function category_SelectSub ($idParent) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM category
                         WHERE id_parent = :idParent'
          );

          $query->execute( [':idParent' => $idParent ] );
          $data = $query->fetchAll();

          return $data;
      }

      public function manufacturer_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM manufacturer'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function invoice_SelectAll () {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM invoice'
          );

          $query->execute();
          $data = $query->fetchAll();

          return $data;
      }

      public function invoice_SelectById ($idInvoice) {
          $query = $this->CONN->prepare(
              'SELECT *
                         FROM invoice
                         WHERE id = :idInvoice'
          );

          $query->execute( [':idInvoice' => $idInvoice] );
          $data = $query->fetchAll();

          return $data;
      }

      public function user_Login ($name, $password) {
          $query = $this->CONN->prepare(
              'SELECT id
                                password
                         FROM user
                         WHERE login = :name'
          );

          $query->execute([':name' => $name]);
          $data = $query->fetchAll();

          if ( !password_verify($password, $data->password) )
              return false;

          $_SESSION['user-id'] = $data->id;
          return true;
      }


      /*

      public function selectAllByManufacturerAndGroup($manufacturer, $group) {
          $stmt = $this->conn->prepare('  SELECT  machines.id,
                                                            machines.manufacturer,
                                                            machines.type,
                                                            machines.kind,
                                                            SUBSTRING(machines.description, 1, 200) as "description",
                                                            images.url
                                                    FROM machines 
                                                    LEFT JOIN images ON machines.id = images.id_machine 
                                                    WHERE machines.manufacturer = :manufacturer AND machines.kind = :group
                                                    GROUP BY machines.id');
          $stmt->execute([  ':manufacturer' => $manufacturer,
                            ':group' => $group]);
          $data = [];
          while($row = $stmt->fetch()) {
              $data[] = new Machine($row['id'], $row['manufacturer'], $row['type'], $row['kind'], $row['description'], $row['url']);
          }
          return $data;
      }

      public function update(Machine $machine){
          $stmt = $this->conn->prepare('UPDATE machines SET id=:id, manufacturer=:manufacturer, type=:type, kind=:group, description=:description WHERE id=:id');
          $stmt->execute([':id' => $machine->getId(),
                          ':manufacturer' => $machine->getManufacturer(),
                          ':type' => $machine->getType(),
                          ':group' => $machine->getGroup(),
                          ':description' => $machine->getDescription()]);
          $stmt = null;
          if(count($machine->getImg()) > 0) {
              foreach($machine->getImg() as $img) {
                  $stmt = $this->conn->prepare('DELETE FROM images WHERE id_machine=:id AND url=:url');
                  $stmt->execute([':id' => $machine->getId(),
                                  ':url' => $img]);
                  $stmt = null;
                  unlink("../img/machines/{$img}");
              }
          }
      }
      public function updateImgs($id, $imgs) {
          foreach($imgs as $img) {
              $stmt = $this->conn->prepare('INSERT INTO images VALUES (DEFAULT, :id_machine, :url)');
              $stmt->execute([':id_machine' => $id,
                              ':url' => $img]);
              $stmt = null;
          }
      }
      */
  }
?>