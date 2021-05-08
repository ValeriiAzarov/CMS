<?php
    include 'inc/config.php';
    include 'inc/init.php';

    function createTables($db) {
        // sql to drop tables.
        $sql_options = Array(DBTBL_PRODUCTS, DBTBL_SECTIONS, DBTBL_PARAMS, DBTBL_REVIEWS, DBTBL_HISTORY, DBTBL_USERS, DBTBL_USERS_SESSIONS, DBTBL_NEWS, DBTBL_PAGES);
        $sql_drop = Array();
        
        for ($i = 0; $i < count($sql_options); $i++) {
            $sql_drop[$i] = "DROP TABLE IF EXISTS " . $sql_options[$i] . ";";
            if ($db->query($sql_drop[$i]) !== true) { 
                echo "Error dropping table: " . $db->error . "\n"; 
            }
        }

        // sql to create tables.
        $sql_create = Array();

        $sql_create[] = "CREATE TABLE " . DBTBL_SECTIONS . "(
            id              INT PRIMARY KEY AUTO_INCREMENT,
            name            VARCHAR(50)     NOT NULL UNIQUE
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_PRODUCTS . "(
            id              INT PRIMARY KEY AUTO_INCREMENT,
            name            VARCHAR(150)    NOT NULL UNIQUE,
            price           DECIMAL(10,2)   NOT NULL,
            articles        VARCHAR(50)     NOT NULL,
            image           VARCHAR(250)    NOT NULL,
            id_section      INT             NOT NULL,
            FOREIGN KEY (id_section) REFERENCES " . DBTBL_SECTIONS . " (id) 
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_PARAMS . "(
            id              INT PRIMARY KEY AUTO_INCREMENT,
            name            VARCHAR(100)    NOT NULL,
            value           VARCHAR(250)    NOT NULL DEFAULT '',
            sort            INT             NOT NULL,
            id_product      INT             NOT NULL,
            FOREIGN KEY (id_product) REFERENCES " . DBTBL_PRODUCTS . " (id)  ON DELETE CASCADE
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_REVIEWS . "
        (
            id              INT PRIMARY KEY AUTO_INCREMENT,
            name            VARCHAR(100)    NOT NULL,
            email           VARCHAR(50)     NOT NULL,
            comment         VARCHAR(200)    NOT NULL,
            id_product      INT             NOT NULL
        );";   

        $sql_create[] = "CREATE TABLE " . DBTBL_HISTORY . "(
            id              INT PRIMARY KEY AUTO_INCREMENT,
            date            DATE            NOT NULL,
            views           INT             NOT NULL DEFAULT 1,
            id_product      INT             NOT NULL,
            FOREIGN KEY (id_product) REFERENCES " . DBTBL_PRODUCTS . "(id)  ON DELETE CASCADE
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_USERS . "(
            id              INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            name            VARCHAR(50)     NOT NULL,
            login           VARCHAR(100)    NOT NULL DEFAULT '',
            password        VARCHAR(100)    NOT NULL DEFAULT ''
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_USERS_SESSIONS . "(
            id              INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            session_id      VARCHAR(100)    NOT NULL DEFAULT '',
            user_id         INT             NOT NULL,
            FOREIGN KEY (user_id) REFERENCES " . DBTBL_USERS . " (id)
        )";

        $sql_create[] = "CREATE TABLE " . DBTBL_NEWS . "(
            id              INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            url             VARCHAR(100)    NOT NULL,
            name            VARCHAR(100)    NOT NULL DEFAULT '',
            content         TEXT            NOT NULL,
            published_date  DATETIME     
        )";
        
        $sql_create[] = "CREATE TABLE " . DBTBL_PAGES . "(
            id              INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            url             VARCHAR(50)     NOT NULL,
            name            VARCHAR(100)    NOT NULL DEFAULT '',       
            content         TEXT            NOT NULL, 
            published_date  DATETIME   
        )";

        for ($i = 0; $i < count($sql_create); $i++) {
            if ($db->query($sql_create[$i]) !== true) { 
                echo "Error creating table: " . $db->error . "\n";
            }
        }

    }
    createTables($mysqli);
    $mysqli->close_connection();