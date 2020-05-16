<!-- ログイン画面 -->
<?php

require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

// セッションスタート
session_start();


// すでにログイン済みだったらダッシュボードへ飛ばす
if(!empty($_SESSION['user'])){
    header('Location:'.SITE_URL. 'dashboard.php');
    exit;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $mail = get_post('mail');
    $password = get_post('password');


    $dbh = get_db_connect();
    // $data = select_users($dbh);
    // var_dump($data);
    $errs = [];
    
    // メールアドレスの形式
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errs['mail']='メールアドレスの形式が正しくありません。';
    }
    // 入力値のバリデーション メール
    elseif(!check_words($mail, 100)) {
        $errs['mail']='メール欄は必須、100文字以内です。';
    }
    // 入力値のバリデーション パスワード
    if(!check_words($password, 50)) {
        $errs['password'] = 'パスワードは必須、50文字以内です。';
    }
    //メールアドレスとパスワードが一致するか検証する
    elseif(!$user = select_user($dbh, $mail, $password)){
        $errs['password'] = 'パスワードとメールアドレスが正しくありません。';
    }
    // ログインする
    if(empty($errs)){
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        header('Location: '.SITE_URL. 'dashboard.php');
        exit;
    }
}

include_once('views/index_view.php');