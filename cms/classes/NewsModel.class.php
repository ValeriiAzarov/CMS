<?php
    class NewsModel {
        private $mysqli;

        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function add_news($url, $name, $content) {
            $sql = "INSERT INTO " . DBTBL_NEWS . " (url, name, content, published_date) 
            VALUES ('$url', '$name', '$content', NOW())";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function edit_news($url, $name, $content, $id) {
            $sql = "UPDATE " . DBTBL_NEWS . " SET name = '$name', url = '$url' , content = '$content' WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_news($id) {
            $sql = "DELETE FROM " . DBTBL_NEWS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_news($id) {
            $sql = "SELECT * FROM " . DBTBL_NEWS . " WHERE id = '$id'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }      

        public function get_all_news() {
            $sql = "SELECT * FROM " . DBTBL_NEWS . " ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

    }