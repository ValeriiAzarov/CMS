<?php
    class MyDB {
        private  $mysqli;

        public function __construct() {
            $this->mysqli = null;
        }

        public function get_db_instance() {
            if (is_null($this->mysqli)) {
                $this->mysqli = new MySQLi(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            }
            return $this->mysqli;
        }

        public function close_connection() {
            $this->mysqli->close();
        }

        public function query($sqlQuery) {
            $queryResult = $this->mysqli->query($sqlQuery);
            if ($queryResult === false) {
                echo 'SQL query execution error: ' . $sqlQuery . '<br>Error text: ' . $this->mysqli->error . ' <br>';
            }
            else {
                if (is_bool($queryResult)) {
                    return $queryResult;
                }
                $result = array();
                $i=0;
                if ($queryResult->num_rows > 0) {
                    while ($row = $queryResult->fetch_assoc()) {
                        $result[$i] = $row;
                        $i++;
                    }
                    $queryResult->free();
                }
                return $result;
            }
        }
        
    }