<?php
    class ProductModel {
        private $mysqli;

        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function add_product($name, $price, $articles, $image, $section) {
            $sql = "INSERT INTO " . DBTBL_PRODUCTS . " (name, price, articles, image, id_section) 
            VALUES ('$name', '$price', '$articles', '$image', $section)";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function edit_product($name, $price, $articles, $image, $id_section, $id) {
            $sql = "UPDATE " . DBTBL_PRODUCTS . " SET name = '$name', price = '$price', articles = '$articles',
            image = '$image', id_section = $id_section WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_product($id) {
            $sql = "DELETE FROM " . DBTBL_PRODUCTS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_all_products() { 
            $sql = "SELECT * FROM " . DBTBL_PRODUCTS . " ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function add_param($name, $value, $sort, $id_product) {
            $sql = "INSERT INTO " . DBTBL_PARAMS . " (name, value, sort, id_product) 
            VALUES ('$name', '$value', '$sort', '$id_product')";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }
    
        public function delete_param($id) {
            $sql = "DELETE FROM " . DBTBL_PARAMS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function add_view($id_product) {
            $queryResult = $this->mysqli->query("SELECT * FROM " . DBTBL_HISTORY . " WHERE id_product = $id_product AND date = CURDATE()");
            if (empty($queryResult)) {
                $this->mysqli->query("INSERT INTO " . DBTBL_HISTORY . " (date, id_product) VALUES (CURRENT_DATE(), '.$id_product.')");
            }
            else {
                $this->mysqli->query("UPDATE " . DBTBL_HISTORY . " SET views = views + 1 WHERE id_product = $id_product AND date = CURDATE()");
            }
        }

        public function delete_views($id) {
            $sql = "DELETE FROM " . DBTBL_HISTORY . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }
        
        public function get_all_views($id_product) {
            $sql = "SELECT * FROM " . DBTBL_HISTORY . " WHERE id_product = $id_product  ORDER BY date";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_day_views_by_id($id_product) {
            $sql = "SELECT * FROM " . DBTBL_HISTORY . " WHERE id_product = $id_product AND date = CURDATE()";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_views_by_time_period($days, $id_product) {
            $sql = "DELETE FROM " . DBTBL_HISTORY . " WHERE id_product = $id_product AND date BETWEEN CURDATE() - INTERVAL $days DAY AND CURDATE()";
            $query_result  =  $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_views_by_time_period($time_period, $id_product) {
            $sql ="SELECT SUM(views) 'views' FROM " . DBTBL_HISTORY . " WHERE id_product = $id_product 
            AND date BETWEEN '.$time_period.' AND CURDATE()";
            $views =  $this->mysqli->query($sql);
            return $views[0]['views'];
        }

        public function get_params_by_id($id_product) {
            $sql = "SELECT * FROM "  . DBTBL_PARAMS . " WHERE id_product = $id_product ORDER BY sort";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_products_by_section($id_section) {
            $sql = "SELECT * FROM " . DBTBL_PRODUCTS . " WHERE id_section = $id_section";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_product_by_id($id_product) {
            $sql = "SELECT * FROM " . DBTBL_PRODUCTS . " where id = $id_product";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }

    }