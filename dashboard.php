<?php

require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

// セッションスタート
session_start();


// ログインしてなかったら、ログインページに戻す
if(empty($_SESSION['user'])){
    header('Location:'.SITE_URL. 'index.php');
    exit;
}

// var_dump($_SESSION['user']);

// クライアントのデータを取得
$user = $_SESSION['user'];

// 更新されたら、更新された旨を表示する

// ポスト送信されたデータを受け取る
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = get_post('name');
    $mail = get_post('mail');
    $comment = get_post('comment');

    $id = $user[id];
    
    $dbh = get_db_connect();

// バリデーションして、問題なければUPDATE
    $errs = [];

    if (!check_words($name, 50)){
        $errs['name'] = 'お名前欄は必須、50文字以内です。';
    }

    if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errs['mail']='メールアドレスの形式が正しくありません。';
    }
    // すでに存在しているメールアドレスをはじく
    elseif(mail_exists($dbh, $mail)){
        $errs['mail'] = 'このメールアドレスはすでに登録されています。';
    }
    // 入力値のバリデーション メール
    elseif(!check_words($mail, 100)) {
        $errs['mail']='メール欄は必須、100文字以内です。';
    }

    // コメントのバリデーション
    if (!check_words($comment, 100)){
        $errs['comment'] = 'コメント欄は必須、100文字以内です。';
    }
    //エラーがなければ更新する
    if(empty($errs)){
        if(update_user($dbh, $name, $mail,$comment,$id)) {
            $update_fin = 'アカウント情報を変更しました。';
            $user = select_user_id($dbh,$id);
        }
    }
}

// プロジェクトを作成

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $pj_name = get_post('pj_name');
    $pj_explain = get_post('pj_explain');
    
    $dbh = get_db_connect();

    // バリデーションして問題なかったら、projectsテーブルに挿入
    $errs = [];

    if (!check_words($pj_name, 50)){
        $errs['pj_name'] = 'プロジェクト名は必須、50文字以内です。';
    }
    if(!check_words($pj_explain, 100)) {
        $errs['pj_explain']='説明欄は必須、100文字以内です。';
    }
    //エラーがなかったら、Projectテーブルにデータを挿入し、パラメータにそのレコードのIDをつけて、リンクに飛ばす。 
    if(empty($errs)) {
        if($project_id = insert_projects_data($dbh, $pj_name, $pj_explain) ) {
            header('Location:' .SITE_URL. 'project.php?id='.$project_id);
            exit;
        }
        $errs['password'] ='登録に失敗しました。';
    }

}
include_once('views/dashboard_view.php');