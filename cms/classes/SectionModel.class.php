<?php
    class SectionModel {
        private $mysqli;

        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function add_section($name) {
            $sql = "SELECT * FROM " . DBTBL_SECTIONS . " WHERE name = '$name'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                $sql = "INSERT INTO " . DBTBL_SECTIONS . " (name) VALUES ('$name')";
                $query_result = $this->mysqli->query($sql);
            }
            else {
                $query_result = false;
            }
            return $query_result;
        }

        public function delete_section($id) {
            $sql = "DELETE FROM " . DBTBL_SECTIONS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_section($id) {
            $sql = "SELECT * FROM ". DBTBL_SECTIONS." WHERE id = '$id'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }

        public function edit_section($name, $id) {
            $sql = "UPDATE " . DBTBL_SECTIONS . " SET name = '$name' WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_all_sections() {
            $sql = "SELECT * FROM " . DBTBL_SECTIONS . " ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

    }