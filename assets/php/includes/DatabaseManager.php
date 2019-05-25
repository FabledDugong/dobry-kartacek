<?php

    class DatabaseManager extends Connection {

        public function __construct () {

            parent::__construct();

        }

        public function manufacturer_SelectAll () {

            return $this -> exec(

                'SELECT *
                 FROM manufacturer',

                []

            );

        }

        public function manufacturer_Insert ( $name, $description ) {

            $this -> authorize_admin();

            return $this -> exec(

                'INSERT INTO manufacturer 
                 VALUES ( 
                  DEFAULT,
                  :name, 
                  :description 
                )',

                [
                    ':name'         => $name,
                    ':description'  => $description
                ]

            );

        }

        public function manufacturer_Update ( $id, $name, $description ) {

            $this -> authorize_admin();

            return $this -> exec(

                'UPDATE manufacturer
                 SET name = :name, 
                     description = :description
                 WHERE id = :id',

                [
                    ':id'           => $id,
                    ':name'         => $name,
                    ':description'  => $description
                ]

            );

        }

        public function manufacturer_Delete ( $id ) {

            $this -> authorize_admin();

            return $this -> exec(

                'DELETE
                 FROM manufacturer
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function category_SelectMain () {

            return $this -> exec(

                'SELECT *
                 FROM category
                 WHERE id_parent IS NULL',

                []

            );

        }

        public function category_SelectSub ( $id_parent ) {

            return $this -> exec(

                'SELECT *
                 FROM category
                 WHERE id_parent = :id_parent',

                [
                    ':id_parent' => $id_parent
                ]

            );

        }

        public function category_Insert ( $name, $description, $id_parent = null ) {

            $this -> authorize_admin();

            return $this -> exec(

                'INSERT INTO category 
                 VALUES ( 
                  DEFAULT,
                  :id_parent,
                  :name, 
                  :description 
                )',

                [
                    ':id_parent'    => $id_parent,
                    ':name'         => $name,
                    ':description'  => $description
                ]

            );

        }

        public function category_Update ( $id, $name, $description, $id_parent = null ) {

            $this -> authorize_admin();

            return $this -> exec(

                'UPDATE category
                 SET id_parent = :id_parent,
                     name = :name, 
                     description = :description
                 WHERE id = :id',

                [
                    ':id'           => $id,
                    ':id_parent'    => $id_parent,
                    ':name'         => $name,
                    ':description'  => $description
                ]

            );

        }

        public function category_Delete ( $id ) {

            $this -> authorize_admin();

            return $this -> exec(

                'DELETE
                 FROM category
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function qNa_SelectAll () {

            $this -> authorize_admin();

            return $this -> exec(

                'SELECT *
                 FROM qNa
                 WHERE id_question IS NULL
                 ORDER BY date DESC',

                []

            );

        }

        public function qNa_SelectByUser ( $email ) {

            $this -> authorize_user();

            return $this -> exec(

                'SELECT *
                 FROM qNa
                 WHERE email = :email AND id_question IS NULL
                 ORDER BY date DESC',

                [
                    ':email' => $email
                ]

            );

        }

        public function qNa_SelectUnanswered () {

            $this -> authorize_admin();

            return $this -> exec(

                'SELECT *
                 FROM qNa
                 WHERE id_question IS NULL AND id NOT IN (
                    SELECT DISTINCT id_question
                    FROM qNa
                 )
                 ORDER BY date DESC',

                []

            );

        }

        public function qNa_SelectAnswers ( $id_question ) {

            $this -> authorize_user();

            return $this -> exec(

                'SELECT *
                 FROM qNa
                 WHERE id_question = :id_question
                 ORDER BY date ASC',

                [
                    ':id_question' => $id_question
                ]

            );

        }

        public function qNa_InsertQuestion ( $email, $description ) {

            $m = new Mail( $this -> user_SelectAdmins(), $email, 'Dobrý Kartáček - nový dotaz', $description );
            $m -> send_NewQuestionMail();

            return $this -> exec(

                'INSERT INTO qNa
                 VALUES ( 
                  DEFAULT,
                  DEFAULT,
                  :email, 
                  :description,
                  DEFAULT
                )',

                [
                    ':email'        => $email,
                    ':description'  => $description
                ]

            );

        }

        public function qNa_InsertAnswer ( $id_question, $email, $description ) {

            $this -> authorize_admin();

            $question = $this -> exec(

                'SELECT *
                 FROM qNa
                 WHERE id = :id_question',

                [
                    ':id_question' => $id_question
                ]

            );


            $m = new Mail( $question[0] -> email, $email, 'Dobrý Kartáček - Váš dotaz byl zodpovězen', $question[0] -> description );
            $m -> send_NewAnswerMail( $description );

            return $this -> exec(

                'INSERT INTO qNa 
                 VALUES ( 
                  DEFAULT,
                  :id_question,
                  :email, 
                  :description,
                  DEFAULT
                )',

                [
                    ':id_question'  => $id_question,
                    ':email'        => $email,
                    ':description'  => $description
                ]

            );

        }

        public function qNa_Delete ( $id ) {

            $this -> authorize_admin();

            return $this -> exec(

                'DELETE
                 FROM qNa
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function product_SelectAll () {

            $data = $this -> exec(

                'SELECT product.*,
                        category.name as `name_category`,
                        manufacturer.name as `name_manufacturer`,
                        picture.url as `picture_url`
                 FROM product
                 JOIN category ON product.id_category = category.id
                 JOIN manufacturer ON product.id_manufacturer = manufacturer.id
                 JOIN picture ON product.id = picture.id_product
                 GROUP BY product.id',

                []

            );

            $products = [];

            foreach ( $data as $p )
                $products[] = new Product(
                    $p -> id,
                    $p -> id_category,
                    $p -> id_manufacturer,
                    $p -> name,
                    $p -> name_category,
                    $p -> name_manufacturer,
                    $p -> description,
                    $p -> color,
                    $p -> toughness,
                    $p -> price,
                    $p -> stock,
                    $p -> picture_url
                );

            return $products;

        }

        public function product_SelectByCategory ( $id_category ) {

            $data = $this -> exec(

                'SELECT product.*,
                        category.name as `name_category`,
                        manufacturer.name as `name_manufacturer`,
                        picture.url as `picture_url`
                 FROM product
                 JOIN category ON product.id_category = category.id
                 JOIN manufacturer ON product.id_manufacturer = manufacturer.id
                 JOIN picture ON product.id = picture.id_product
                 WHERE id_category = :id_category OR id_category IN (
                    SELECT DISTINCT id
                    FROM category
                    WHERE id_parent = :id_category
                 )
                 GROUP BY product.id',

                [
                    ':id_category' => $id_category
                ]

            );

            $products = [];

            foreach ( $data as $p )
                $products[] = new Product(
                    $p -> id,
                    $p -> id_category,
                    $p -> id_manufacturer,
                    $p -> name,
                    $p -> name_category,
                    $p -> name_manufacturer,
                    $p -> description,
                    $p -> color,
                    $p -> toughness,
                    $p -> price,
                    $p -> stock,
                    $p -> picture_url
                );

            return $products;

        }

        public function product_SelectByManufacturer ( $id_manufacturer ) {

            $data = $this -> exec(

                'SELECT product.*,
                        category.name as `name_category`,
                        manufacturer.name as `name_manufacturer`,
                        picture.url as `picture_url`
                 FROM product
                 JOIN category ON product.id_category = category.id
                 JOIN manufacturer ON product.id_manufacturer = manufacturer.id
                 JOIN picture ON product.id = picture.id_product
                 WHERE id_manufacturer = :id_manufacturer
                 GROUP BY product.id',

                [
                    ':id_manufacturer' => $id_manufacturer
                ]

            );

            $products = [];

            foreach ( $data as $p )
                $products[] = new Product(
                    $p -> id,
                    $p -> id_category,
                    $p -> id_manufacturer,
                    $p -> name,
                    $p -> name_category,
                    $p -> name_manufacturer,
                    $p -> description,
                    $p -> color,
                    $p -> toughness,
                    $p -> price,
                    $p -> stock,
                    $p -> picture_url
                );

            return $products;

        }

        public function product_SelectById ( $id ) {

            $product = $this -> exec(

                'SELECT product.*,
                        category.name as `name_category`,
                        manufacturer.name as `name_manufacturer`
                 FROM product
                 JOIN category ON product.id_category = category.id
                 JOIN manufacturer ON product.id_manufacturer = manufacturer.id
                 WHERE product.id = :id',

                [
                    ':id' => $id
                ]

            );

            $pictures = $this -> exec(

                'SELECT url
                 FROM picture
                 WHERE id_product = :id_product',

                [
                    ':id_product' => $id
                ]

            );

            $urls = [];

            foreach ( $pictures as $p )
                $urls[] = $p -> url;

            return new Product(
                $product[0] -> id,
                $product[0] -> id_category,
                $product[0] -> id_manufacturer,
                $product[0] -> name,
                $product[0] -> name_category,
                $product[0] -> name_manufacturer,
                $product[0] -> description,
                $product[0] -> color,
                $product[0] -> toughness,
                $product[0] -> price,
                $product[0] -> stock,
                $urls
            );

        }

        public function product_Insert ( Product $product ) {

            $this -> authorize_admin();

            $this -> exec(

                'INSERT INTO product
                 VALUES(
                    DEFAULT,
                    :id_category,
                    :id_manufacturer, 
                    :name,
                    :description,
                    :color,
                    :toughness,
                    :price,
                    :stock
                 )',

                [
                    ':id_category'      => $product -> id_category,
                    ':id_manufacturer'  => $product -> id_manufacturer,
                    ':name'             => $product -> name,
                    ':description'      => $product -> description,
                    ':color'            => $product -> color,
                    ':toughness'        => $product -> toughness,
                    ':price'            => $product -> price,
                    ':stock'            => $product -> stock
                ]

            );

            $id_last = $this -> conn -> lastInsertId();

            foreach ( $product -> pictures as $p )
                $this -> exec(

                    'INSERT INTO picture
                     VALUES(
                        DEFAULT,
                        :id_product,
                        :url
                     )',

                    [
                        ':id_product'   => $id_last,
                        ':url'          => $p
                    ]

                );

            return true;

        }

        public function product_Update ( Product $product ) {

            $this -> authorize_admin();

            $this -> exec(

                'UPDATE product
                 SET id_category = :id_category,
                     id_manufacturer = :id_manufacturer,
                     name = :name,
                     description = :description,
                     color = :color,
                     toughness = :toughness,
                     price = :price,
                     stock = :stock
                  WHERE id = :id',

                [
                    ':id'               => $product -> id,
                    ':id_category'      => $product -> id_category,
                    ':id_manufacturer'  => $product -> id_manufacturer,
                    ':name'             => $product -> name,
                    ':description'      => $product -> description,
                    ':color'            => $product -> color,
                    ':toughness'        => $product -> toughness,
                    ':price'            => $product -> price,
                    ':stock'            => $product -> stock
                ]

            );

            $urls = '';

            foreach ( $product -> pictures as $p )
                $urls .= '\'' . $p . '\', ';

            $this -> exec(

                'DELETE
                 FROM picture
                 WHERE id_product = :id AND url NOT IN ( ' . substr( $urls, 0, -1 ) . ' )',

                [
                    ':id'   => $product -> id
                ]

            );

            foreach ( $product -> pictures as $p )
                $this -> exec(

                    'INSERT IGNORE INTO picture
                     VALUES(
                        DEFAULT,
                        :id_product,
                        :url
                     )',

                    [
                        ':id_product'   => $product -> id,
                        ':url'          => $p
                    ]

                );

            return true;

        }

        public function product_UpdateStockStatus ( $id ) {

            $this -> authorize_admin();

            $status = 1;

            if ( $this -> product_SelectById( $id ) -> stock )
                $status = 0;

            $this -> exec(

                'UPDATE product
                 SET stock = :stock
                 WHERE id = :id',

                [
                    ':id'    => $id,
                    ':stock' => $status
                ]

            );

            return $status;

        }

        public function product_Delete ( $id ) {

            $this -> authorize_admin();

            $product = $this -> product_SelectById( $id );

            $this -> exec(

                'INSERT INTO product_backup
                 VALUES(
                    :id,
                    :category,
                    :manufacturer, 
                    :name,
                    :description,
                    :color,
                    :toughness,
                    :price
                 )',

                [
                    ':id'               => $id,
                    ':id_category'      => $product -> name_category,
                    ':id_manufacturer'  => $product -> name_manufacturer,
                    ':name'             => $product -> name,
                    ':description'      => $product -> description,
                    ':color'            => $product -> color,
                    ':toughness'        => $product -> toughness,
                    ':price'            => $product -> price
                ]

            );

            return $this -> exec(

                'DELETE
                 FROM product
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function customer_SelectById ( $id ) {

            $this -> authorize_user();

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $data = $this -> exec(

                'SELECT *
                 FROM customer
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

            return new User(
                $data[0] -> id,
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> f_name, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> l_name, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> email, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> phone, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> address, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> city, $key )
            );

        }

        private function customer_Insert ( User $user ) {

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            return $this -> exec(

                'INSERT INTO customer
                 VALUES(
                    DEFAULT,
                    :f_name,
                    :l_name,
                    :email,
                    :phone,
                    :address,
                    :city
                 )',

                [
                    ':f_name'   => \Defuse\Crypto\Crypto::encrypt( $user -> f_name, $key ),
                    ':l_name'   => \Defuse\Crypto\Crypto::encrypt( $user -> l_name, $key ),
                    ':email'    => \Defuse\Crypto\Crypto::encrypt( $user -> email, $key ),
                    ':phone'    => \Defuse\Crypto\Crypto::encrypt( $user -> phone, $key ),
                    ':address'  => \Defuse\Crypto\Crypto::encrypt( $user -> address, $key ),
                    ':city'     => \Defuse\Crypto\Crypto::encrypt( $user -> city, $key )
                ]

            );

        }

        private function customer_Update ( User $user ) {

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            return $this -> exec(

                'UPDATE customer
                 SET f_name = :f_name,
                     l_name = :l_name,
                     email = :email,
                     phone = :phone,
                     address = :address,
                     city = :city
                 WHERE id = :id',

                [
                    ':id'       => $user -> id_customer,
                    ':f_name'   => \Defuse\Crypto\Crypto::encrypt( $user -> f_name, $key ),
                    ':l_name'   => \Defuse\Crypto\Crypto::encrypt( $user -> l_name, $key ),
                    ':email'    => \Defuse\Crypto\Crypto::encrypt( $user -> email, $key ),
                    ':phone'    => \Defuse\Crypto\Crypto::encrypt( $user -> phone, $key ),
                    ':address'  => \Defuse\Crypto\Crypto::encrypt( $user -> address, $key ),
                    ':city'     => \Defuse\Crypto\Crypto::encrypt( $user -> city, $key )
                ]

            );

        }

        private function customer_Delete ( $id ) {

            $count = $this -> exec(

                'SELECT count(1) as cnt
                 FROM invoice
                 GROUP BY id_customer
                 HAVING id_customer = :id',

                [
                    ':id' => $id
                ]

            );

            if ( $count -> cnt )
                return false;

            return $this -> exec(

                'DELETE
                 FROM customer
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function user_SelectAll () {

            $this -> authorize_admin();

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $data = $this -> exec(

                'SELECT *
                 FROM user
                 JOIN customer ON user.id_customer = customer.id',

                []

            );

            $users = [];

            foreach ( $data as $u )
                $users[] = new User(
                    $u -> id,
                    \Defuse\Crypto\Crypto::decrypt( $u -> f_name, $key ),
                    \Defuse\Crypto\Crypto::decrypt( $u -> l_name, $key ),
                    \Defuse\Crypto\Crypto::decrypt( $u -> email, $key ),
                    \Defuse\Crypto\Crypto::decrypt( $u -> phone, $key ),
                    \Defuse\Crypto\Crypto::decrypt( $u -> address, $key ),
                    \Defuse\Crypto\Crypto::decrypt( $u -> city, $key ),
                    $u -> id_customer,
                    $u -> password,
                    $u -> registration_time,
                    $u -> active,
                    $u -> admin
                );

            return $users;

        }

        public function user_SelectById ( $id ) {

            $this -> authorize_user();

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $data = $this -> exec(

                'SELECT *
                 FROM user
                 JOIN customer ON user.id_customer = customer.id
                 WHERE user.id = :id',

                [
                    ':id' => $id
                ]

            );

            return new User(
                $data[0] -> id,
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> f_name, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> l_name, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> email, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> phone, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> address, $key ),
                \Defuse\Crypto\Crypto::decrypt( $data[0] -> city, $key ),
                $data[0] -> id_customer,
                $data[0] -> password,
                $data[0] -> registration_time,
                $data[0] -> active,
                $data[0] -> admin
            );

        }

        private function user_SelectAdmins () {

            $this -> authorize_admin();

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $data = $this -> exec(

                'SELECT login
                 FROM user
                 WHERE admin = 1',

                []

            );

            $admins = [];

            foreach ( $data as $a )
                $admins[] = \Defuse\Crypto\Crypto::decrypt( $a -> login, $key );

            return $admins;

        }

        public function user_Insert ( User $user ) {

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $this -> customer_Insert( $user );

            $id_customer = $this -> conn -> lastInsertId();

            $this -> exec(

                'INSERT INTO user
                 VALUES(
                    DEFAULT,
                    :id_customer,
                    :login,
                    :password,
                    DEFAULT,
                    DEFAULT,
                    DEFAULT
                 )',

                [
                    ':id_customer'  => $id_customer,
                    ':login'        => \Defuse\Crypto\Crypto::encrypt( $user -> email, $key ),
                    ':password'     => password_hash( $user -> password, PASSWORD_DEFAULT ),
                ]

            );

            $id_last = $this -> conn -> lastInsertId();

            $registration_time = $this -> user_SelectById( $id_last ) -> registration_time;

            $date = explode( ' ', $registration_time );
            $time = explode( ':', $date[1] );
            $date = explode( '-', $date[0] );

            $token = $user -> id_user . '-' . $date[1] . '-' . $date[2] . '-' . $time[0] . '-' . $time[1] . '-' . $time[2];

            $m = new Mail(

                $user -> email,

                $GLOBALS['settings'] -> DEFAULT_EMAIL,

                'Dobrý Kartáček - potvrzení registrace',

                \Defuse\Crypto\Crypto::encrypt( $token, $key )

            );

            $m -> send_RegistrationMail();

            return true;

        }

        public function user_Update ( User $user ) {

            $this -> authorize_user();

            $this -> customer_Update( $user );

            return $this -> exec(

                'UPDATE user
                 SET login = :login
                 WHERE id = :id',

                [
                    ':id'       => $user -> id_user,
                    ':login'    => \Defuse\Crypto\Crypto::encrypt(

                                        $user -> email,

                                        \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY )

                                    )
                ]

            );

        }

        public function user_UpdateAdminStatus ( $id ) {

            $this -> authorize_admin();

            $status = 1;

            if ( $this -> user_SelectById( $id ) -> admin )
                $status = 0;

            return $this -> exec(

                'UPDATE user
                 SET admin = :status
                 WHERE id = :id',

                [
                    ':id'       => $id,
                    ':status'   => $status
                ]

            );

        }

        public function user_UpdatePassword ( $id, $password_old, $password_new ) {

            $this -> authorize_user();

            if ( !password_verify( $password_old, $this -> user_SelectById( $id ) -> password ) )
                return false;

            return $this -> exec(

                'UPDATE user
                 SET password = :password
                 WHERE id = :id',

                [
                    ':id'       => $id,
                    ':password' => password_hash( $password_new, PASSWORD_DEFAULT )
                ]

            );

        }

        public function user_Delete ( $id ) {

            $this -> authorize_user();

            $this -> customer_Delete( $this -> user_SelectById( $id ) -> id_customer );

            return $this -> exec(

                'DELETE
                 FROM user
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function user_Activate ( $token ) {

            $token = \Defuse\Crypto\Crypto::decrypt(

                $token,

                \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY )

            );

            $token = explode( '-', $token );

            $user = $this -> user_SelectById( $token[0] );

            if ( empty( $user ) )
                return false;

            $date = explode( ' ', $user -> registration_time );
            $time = explode( ':', $date[1] );
            $date = explode( '-', $date[0] );

            if ( $token[1] != $date[1] || $token[2] != $date[2] || $token[3] != $time[0] || $token[4] != $time[1] || $token[5] != $time[2] )
                return false;

            return $this -> exec(

                'UPDATE user
                 SET active = 1
                 WHERE id = :id',

                [
                    ':id' => $token[0]
                ]

            );

        }

        public function user_Login ( $login, $password ) {

            $user = $this -> exec(

                'SELECT id,
                        password,
                        admin,
                        active
                 FROM user
                 WHERE login = :login',

                [
                    ':login' => $login
                ]

            );

            if ( !password_verify( $password, $user[0] -> password ) || !$user[0] -> active )
                return false;

            $_SESSION['user'] = [
                'id'    => $user[0] -> id,
                'admin' => $user[0] -> admin
            ];

            return true;

        }

        public function user_Logout () {

            unset( $_SESSION['user'] );

        }

        public function user_RequestResetPassword ( $email ) {

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $user = $this -> exec(

                'SELECT id
                 FROM user
                 WHERE login = :email',

                [
                    ':email' => $email
                ]

            );

            if ( empty( $user ) )
                return false;

            $keys = array_merge(range(0,9), range('a', 'z'));

            $token = '';
            for( $i = 0; $i < 64; $i++ )
                $token .= $keys[mt_rand( 0, count( $keys ) - 1 )];

            return $this -> exec(

                'INSERT INTO password_reset
                 VALUES(
                    DEFAULT,
                    :email,
                    :token,
                    :expiration
                 )',

                [
                    ':email'      => \Defuse\Crypto\Crypto::encrypt( $email, $key ),
                    ':token'      => $token,
                    ':expiration' => time() + 3600
                ]

            );

        }

        public function user_ConfirmResetPassword ( $token ) {

            $auth = $this -> exec(

                'SELECT *
                 FROM password_reset
                 WHERE token = :token',

                [
                    ':token' => $token
                ]

            );

            if ( empty( $auth ) || $auth[0] -> expiration < time() )
                return false;

            return true;

        }

        public function user_ResetPassword ( $token, $password_new ) {

            $key = \Defuse\Crypto\Key::loadFromAsciiSafeString( $GLOBALS['settings'] -> CRYPT_KEY );

            $user = $this -> exec(

                'SELECT *
                 FROM password_reset
                 WHERE token = :token',

                [
                    ':token' => $token
                ]

            );

            return $this -> exec(

                'UPDATE user
                 SET password = :password
                 WHERE login = :email',

                [
                    ':email'    => \Defuse\Crypto\Crypto::decrypt( $user[0] -> login, $key ),
                    ':password' => password_hash( $password_new, PASSWORD_DEFAULT )
                ]

            );

        }

        public function invoice_SelectAll () {

            $this -> authorize_admin();

            return $this -> exec(

                'SELECT *
                 FROM invoice
                 JOIN customer ON invoice.id_customer = customer.id
                 ORDER BY date DESC',

                []

            );

        }

        public function invoice_SelectUnpayed () {

            $this -> authorize_admin();

            return $this -> exec(

                'SELECT *
                 FROM invoice
                 JOIN customer ON invoice.id_customer = customer.id
                 WHERE payed = 0
                 ORDER BY date DESC',

                []

            );

        }

        public function invoice_SelectUnfinished () {

            $this -> authorize_admin();

            return $this -> exec(

                'SELECT *
                 FROM invoice
                 JOIN customer ON invoice.id_customer = customer.id
                 WHERE finished = 0
                 ORDER BY payed DESC, date ASC',

                []

            );

        }

        public function invoice_SelectAllByUserId ( $id ) {

            $this -> authorize_user();

            return $this -> exec(

                'SELECT *
                 FROM invoice
                 JOIN customer ON invoice.id_customer = customer.id AND customer.id = :id
                 ORDER BY date DESC',

                [
                    ':id' => $id
                ]

            );

        }

        public function invoice_Insert ( ShoppingCart $sc, User $user, $type_of_delivery = null ) {

            $sn = date( 'Ymd' );

            $last_sn = $this -> exec(

                'SELECT serial_number
                 FROM invoice
                 WHERE serial_number LIKE concat( :date, \'\', \'-%\' )
                 ORDER BY serial_number DESC
                 LIMIT 1',

                [
                    ':date' => $sn
                ]

            );

            if ( empty( $last_sn ) )
                $sn .= '-1';
            else
                $sn .= '-' . ( explode( '-', $last_sn[0] -> serial_number )[1] + 1 );

            $customer_id = $user -> id_customer;

            if ( empty( $user -> id_user ) ) {

                $this -> customer_Insert( $user );
                $customer_id = $this -> conn -> lastInsertId();

            }

            $this -> exec(

                'INSERT INTO invoice 
                 VALUES (
                    DEFAULT, 
                    :id_customer, 
                    :serial_number, 
                    DEFAULT, 
                    :price, 
                    :delivery,
                    DEFAULT,
                    DEFAULT
                 )',

                [
                    ':id_customer'   => $customer_id,
                    ':serial_number' => $sn,
                    ':price'         => $sc -> price,
                    ':delivery'      => ( empty( $type_of_delivery ) ? 'DEFAULT' : $type_of_delivery )
                ]

            );

            $inv_id = $this -> conn -> lastInsertId();

            foreach ( $sc -> products as $p )
                $this -> exec(

                    'INSERT INTO products_in_invoice
                     VALUES(
                        DEFAULT,
                        :id_invoice,
                        :id_product,
                        :count
                     )',

                    [
                        ':id_invoice' => $inv_id,
                        ':id_product' => $p['id'],
                        ':count'      => $p['count']
                    ]

                );

            new Invoice( $sc, $user );

            unset( $_SESSION['shopping-cart'] );

            return true;

        }

        public function invoice_UpdatePayedStatus ( $id ) {

            $this -> authorize_admin();

            return $this -> exec(

                'UPDATE invoice
                 SET payed = 1
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

        public function invoice_UpdateFinishedStatus ( $id ) {

            $this -> authorize_admin();

            return $this -> exec(

                'UPDATE invoice
                 SET finished = 1
                 WHERE id = :id',

                [
                    ':id' => $id
                ]

            );

        }

    }

?>