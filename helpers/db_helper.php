<!-- データベース系関数 -->

<!-- データベースに接続 -->
<?php
function get_db_connect() {
    try{
        $dsn = DSN;
        $user = DB_USER;
        $password = DB_PASSWORD;

        $dbh = new PDO($dsn, $user, $password);
    }catch(PDOException $e){
        echo($e->getMessage());
        die();
    }
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

// メールアドレスの重複チェック 重複してたらtrueを返す
function mail_exists($dbh, $mail) {
    $sql = "SELECT COUNT(id) FROM Users where mail = :mail";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('mail', $mail, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count['COUNT(id)']>0){
        return TRUE;
    }else{
        return FALSE;
    }
}
// データベースに入力
function insert_users_data($dbh, $name, $mail, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $comment = 'あ';
    $sql = "INSERT INTO Users (name, mail, pass) VALUE (:name, :mail, :pass)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindValue(':pass', $password, PDO::PARAM_STR);
    // $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    if($stmt->execute()) {
        return TRUE;
    }else{
        return FALSE;
    }
}

// データベースからデータをとってくる(確認用)
function select_users($dbh){
    $data = [];
    $sql = "SELECT * FROM Users";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $data[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}