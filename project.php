<?php

require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

session_start();
// $_SESSION = [];
// var_dump($_SESSION);

$dbh = get_db_connect();

// リンクからきたらGETで受け取る
if(isset($_GET['id'])) { $id = $_GET['id']; }{
    // プロジェクトテーブルからIDが一致するレコードをとってくる
    $project = select_project_id($dbh,$id);
}


// Membersテーブルでチェック、もしデータが該当しない場合ダッシュボードへ
$user_id = $_SESSION["user"]["id"];
// $user_id = 0;
$project_id = $project["id"];

// var_dump($user_id);
// var_dump($project_id);

if(!check_Members_data($dbh, $user_id, $project_id)){
    if(!empty($user_id)){
        // Membersテーブルに$user_idとproject_idを挿入
        // $project_id = $_SESSION['project_id'];
        insert_Members_data($dbh, $user_id, $project_id);
        // header("Location: " . $_SERVER['PHP_SELF']);
    }
    else
    $_SESSION['project_id'] = $project_id;
    header('Location:'.SITE_URL. 'register.php');
    exit;
}

// Taskテーブルにバリデーションをかけて挿入
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $main_user_id = (int)$_POST['main_user_id'];
    $sub_user_id = (int)$_POST['sub_user_id'];
    $title = get_post('title');
    $deadline = date($_POST['deadline']);

    var_dump($main_user_id, $sub_user_id, $title, $deadline);

    $dbh = get_db_connect();
    $errs = [];

    if (!check_words($title, 50)){
        $errs['title'] = 'タスク名は必須、50文字以内です。';
    }else{
        // データを挿入
       if(insert_task_data($dbh, $main_user_id, $sub_user_id, $title, $deadline)){
           echo 'データの挿入に成功しました。';
       }
    }

}

include_once('views/project_view.php');
