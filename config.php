<!-- 設定ファイル -->

<?php

    define('DSN','mysql:dbname=sample2;host=localhost;charset=utf8');
    define('DB_USER','root');
    define('DB_PASSWORD','root');
    define('SITE_URL','http://localhost/CF_ToDo/');

    error_reporting(E_ALL & ~E_NOTICE);
    session_set_cookie_params(1440, '/');