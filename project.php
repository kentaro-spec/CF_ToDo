<?php

require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

session_start();
// $_SESSION = [];
// var_dump($_SESSION);

// リンクからきたらGETで受け取る
if(isset($_GET['id'])) { $id = $_GET['id']; }{
    // echo $id;
    $dbh = get_db_connect();
    $project = select_project_id($dbh,$id);
}


include_once('views/project_view.php');
