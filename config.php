<?php
ini_set("display_errors", true);
date_default_timezone_set( "Europe/Kiev" );
define("DB_DSN", "mysql:host=localhost;dbname=widgetBlogDB;charset=UTF8");
define("DB_USERNAME", "user_widgetBlogDB");
define("DB_PASSWORD", "user_password");
define("CLASS_PATH", "classes");
define("TEMPLATE_PATH", "templates");
define("HOMEPAGE_NUM_ARTICLES", 5);
define("ADMIN_USERNAME", "admin");
define("ADMIN_PASSWORD", "admin");
require CLASS_PATH . "/Article.php";