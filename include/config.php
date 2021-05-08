<?php 
    define('DB_HOST', '127.0.0.1'); 
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'test');
    define('HOST', "http://localhost/lab12/");

    /*define('DB_HOST', '10.0.0.5');
    define('DB_USER', 'k503labs_u2');
    define('DB_PASS', 'VrXkCm5ZO');
    define('DB_NAME', 'k503labs_db2');
    define('HOST', "http://k503labs.ukrdomen.com/labs/535a/v.azarov/lab12/");*/

    // tables. 
    define("DB_PREFIX", "azarov_");
    define("DBTBL_PRODUCTS", DB_PREFIX . "products");
    define("DBTBL_SECTIONS", DB_PREFIX . "sections");
    define("DBTBL_PARAMS", DB_PREFIX . "params");
    define("DBTBL_REVIEWS", DB_PREFIX . "reviews");

    // extra tables.
    define("DBTBL_HISTORY", DB_PREFIX . "history");
    define("DBTBL_USERS", DB_PREFIX . "users");
    define("DBTBL_USERS_SESSIONS", DB_PREFIX . "users_sessions");
    define("DBTBL_PAGES", DB_PREFIX . "pages");
    define("DBTBL_NEWS", DB_PREFIX . "news");
?>