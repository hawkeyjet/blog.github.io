<?php
ini_set("display_errors", true);
date_default_timezone_set( "Europe/Kiev" );
define("DB_DSN", "mysql:host=localhost;dbname=widgetBlogDB;charset=UTF8");
define("DB_USER", "user_widgetBlogDB");
define("DB_PASS", "user_password");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("ADMIN_USER", "admin");
define("ADMIN_PASS", "admin");
require CLASS_PATH . "/Article.php";