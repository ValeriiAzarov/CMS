<?php
    class UserSessions extends Sessions {
        protected $mysqli;
        protected $user_id = 0;

        public function __construct($db,$path = "") {
            parent::__construct($path);
            $this->mysqli = $db;
            $this->check_user_session();
        }

        public function check_user_session() {
            $this->user_id = 0;
            $sql_check_auth = "SELECT * FROM " . DBTBL_USERS_SESSIONS . " WHERE session_id ='".$this->get_session_id()."'";
            $result = $this->mysqli->query($sql_check_auth);
            if (!empty($result)) {
                $this->user_id = $result[0]['user_id'];
            }
            return ($this->user_id == 0);
        }

        public function logout() {
            $this->mysqli->query("DELETE FROM ". DBTBL_USERS_SESSIONS . " WHERE session_id ='".$this->get_session_id()."'");
        }

        public function make_user_login() {
            $sql_make_user_login = "INSERT INTO " . DBTBL_USERS_SESSIONS . "(user_id, session_id)
            VALUES( ".$this->user_id.",'".$this->get_session_id()."')";
            $result = $this->mysqli->query($sql_make_user_login);
            if (!empty($result)) {
                return true;
            }
            return false;
        }

        public function get_user_id() {
            return $this->user_id;
        }

        public function check_user_login($user_login, $user_password) {
            $result = $this->mysqli->query("SELECT * FROM " . DBTBL_USERS . " WHERE login='$user_login' AND password = PASSWORD('$user_password')");
            if (empty($result)) {
                return false;
            }
            else {
                $this->user_id = $result[0]['id'];
                return true;
            }
        }
        
    }