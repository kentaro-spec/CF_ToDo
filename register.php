<?php
require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

// セッションスタート
session_start();
var_dump($_SESSION['project_id']);
$project_id = $_SESSION['project_id'];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = get_post('name');
    $mail = get_post('mail');
    $mail2 = get_post('mail2');
    $password = get_post('password');

    // var_dump($name, $mail, $mail2, $password); 

    $dbh = get_db_connect();
    // $data = select_users($dbh);
    // var_dump($data);
    $errs = [];
    //入力値のバリデーション 名前
    if (!check_words($name, 50)){
        $errs['name'] = 'お名前欄は必須、50文字以内です。';
    }
    // メールアドレスの形式
    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errs['mail']='メールアドレスの形式が正しくありません。';
    }elseif(mail_exists($dbh, $mail)){
        $errs['mail'] = 'このメールアドレスはすでに登録されています。';
    }
    // メールアドレス2重チェック
    elseif(!empty($mail) && !empty($mail2) && $mail != $mail2){
        $errs['mail'] = '確認メールアドレスが一致しません。';
    }
    // 入力値のバリデーション メール
    elseif(!check_words($mail, 100)) {
        $errs['mail']='メール欄は必須、100文字以内です。';
    }elseif(!check_words($mail2, 100)) {
        $errs['mail']='メール欄は必須、100文字以内です。';
    }
    // 入力値のバリデーション パスワード
    if(!check_words($password, 50)) {
        $errs['password'] = 'パスワードは必須、50文字以内です。';
    }
    // エラーがなければデータ挿入後、ログインページへ
    if(empty($errs)){
        // var_dump($errs);
        // ユーザーidをとってくる
        $user_id = insert_users_data($dbh, $name, $mail, $password);
        // sessionのuserを更新
        $_SESSION['user'] = select_user_id($dbh,$user_id);
        // メンバーテーブルに挿入
        insert_Members_data($dbh, $user_id, $project_id);
            header('Location:' .SITE_URL. 'index.php');
            exit;
        
        $errs['password'] ='登録に失敗しました。';
    }
}

include_once('views/register_view.php');