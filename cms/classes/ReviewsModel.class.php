<?php
    class ReviewsModel {
        private $mysqli;
        
        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function get_reviews($id_product) { 
            $sql = "SELECT * FROM " . DBTBL_REVIEWS . " WHERE id_product = " . $id_product . ";";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_all_reviews() { 
            $sql = "SELECT * FROM " . DBTBL_REVIEWS . " ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function set_review($id_product, $name, $email, $comment) {
            $sql = "INSERT INTO " . DBTBL_REVIEWS . " (name, email, comment, id_product) 
            VALUES ('$name', '$email', '$comment', '$id_product')";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_review($id) {
            $sql = "DELETE FROM " . DBTBL_REVIEWS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

    }