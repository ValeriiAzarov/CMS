<?php
    class PagesModel {
        private $mysqli;
        
        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function add_page($url, $name, $content) {
            $sql = "INSERT INTO " . DBTBL_PAGES . " (url, name, content, published_date)
            VALUES ('$url', '$name', '$content', NOW())";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function edit_page($url, $name, $content, $id) {
            $sql = "UPDATE " . DBTBL_PAGES . " SET name = '$name', url = '$url' , content = '$content' WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_page($id) {
            $sql = "DELETE FROM " . DBTBL_PAGES . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_page_url($url) {
            $sql = "SELECT * FROM " . DBTBL_PAGES . " WHERE url = '$url'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }

        public function get_page($id) {
            $sql = "SELECT * FROM " . DBTBL_PAGES . " WHERE id = '$id'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }

        public function get_all_pages() {
            $sql = "SELECT * FROM " . DBTBL_PAGES . " ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

    }