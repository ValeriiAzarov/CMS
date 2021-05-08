<?php
    class UserModel {
        private $mysqli;

        public function __construct($mysqli) {
            $this->mysqli  = $mysqli;
        }

        public function add_user($name, $login, $password) {
            $sql = "INSERT INTO " . DBTBL_USERS . " (name, login, password) VALUES ('$name', '$login',PASSWORD('$password'))";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function delete_user($id) {
            $sql = "DELETE FROM " . DBTBL_USERS . " WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_user($id) {
            $sql = "SELECT * FROM " . DBTBL_USERS . " WHERE id = '$id'";
            $query_result = $this->mysqli->query($sql);
            if (empty($query_result)) {
                return "";
            }
            else {
                return $query_result[0];
            }
        }

        public function edit_user($name, $login, $password, $id) {
            $sql = "UPDATE " . DBTBL_USERS . " SET name = '$name', login = '$login', password = PASSWORD('$password') WHERE id = $id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

        public function get_all_users() {
            $sql = "SELECT * FROM " . DBTBL_USERS ." ORDER BY id";
            $query_result = $this->mysqli->query($sql);
            return $query_result;
        }

    }