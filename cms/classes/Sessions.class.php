<?php
    class Sessions {
        private $session_id = "";

        public function __construct($path = "") {
            if ($path != "") {
                session_save_path($path);
            }
            session_start();
            $this->session_id = session_id();
        }

        public function get_session_id() {
            return $this->session_id;
        }

    }