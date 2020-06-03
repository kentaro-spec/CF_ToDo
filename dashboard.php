<?php

require_once('./config.php');
require_once('helpers/db_helper.php');
require_once('helpers/extra_helper.php');

// セッションスタート
session_start();
var_dump($_SESSION);


// ログインしてなかったら、ログインページに戻す
if(empty($_SESSION['user'])){
    header('Location:'.SITE_URL. 'index.php');
    exit;
}

// var_dump($_SESSION['user']);

// クライアントのデータを取得
$user = $_SESSION['user'];


// ポスト送信されたデータを受け取る
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // アカウントを変更するボタンを押した場合
    if(isset($_POST['submit_user'])){
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
            // セッションのuserを上書き
            $_SESSION['user'] = select_user_id($dbh,$id); 
            // 上書きしたsessionを$userに格納
            $user = $_SESSION['user'];
        }
    }
    }
    // プロジェクトを作成するボタンを押した場合
    elseif(isset($_POST['submit_project'])){
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
            $project_id = insert_projects_data($dbh, $pj_name, $pj_explain);
            // Membersテーブルに挿入。
            $user_id = $user['id'];
            insert_Members_data($dbh, $user_id, $project_id);

                header('Location:' .SITE_URL. 'project.php?id='.$project_id);
                exit;
            
            $errs['password'] ='登録に失敗しました。';
        }
    
    }
}

// 分岐しないで別々にPOSTを受け取ろうとしたコード ※アカウントのコードがプロジェクトのコードに上書きされて失敗
// プロジェクトを作成

// if($_SERVER['REQUEST_METHOD'] === 'POST'){
//     $pj_name = get_post('pj_name');
//     $pj_explain = get_post('pj_explain');
    
//     $dbh = get_db_connect();

//     // バリデーションして問題なかったら、projectsテーブルに挿入
//     $errs = [];

//     if (!check_words($pj_name, 50)){
//         $errs['pj_name'] = 'プロジェクト名は必須、50文字以内です。';
//     }
//     if(!check_words($pj_explain, 100)) {
//         $errs['pj_explain']='説明欄は必須、100文字以内です。';
//     }
//     //エラーがなかったら、Projectテーブルにデータを挿入し、パラメータにそのレコードのIDをつけて、リンクに飛ばす。 
//     if(empty($errs)) {
//         if($project_id = insert_projects_data($dbh, $pj_name, $pj_explain) ) {
//             header('Location:' .SITE_URL. 'project.php?id='.$project_id);
//             exit;
//         }
//         $errs['password'] ='登録に失敗しました。';
//     }

// }
include_once('views/dashboard_view.php');