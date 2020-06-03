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
    $sql = 'SELECT COUNT(id) FROM Users where mail = :mail';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue('mail', $mail, PDO::PARAM_STR);
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    if($count['COUNT(id)'] > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}
// Usersデータベースに入力して、そのレコードのIDを返す
function insert_users_data($dbh, $name, $mail, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    // $comment = 'あ';
    $sql = "INSERT INTO Users (name, mail, pass) VALUE (:name, :mail, :pass)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
    $stmt->bindValue(':pass', $password, PDO::PARAM_STR);
    // $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
    if($stmt->execute()) {
        $user_id = $dbh->lastInsertId();
            return $user_id;
    }else{
        return FALSE;
    }
}

// メールアドレスとパスワードが一致するかしらべる関数

    function select_user($dbh, $mail, $password) {
        $sql = 'SELECT * FROM Users WHERE mail = :mail LIMIT 1';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $data['pass'])){
                return $data;
            }else{
                return FALSE;
            }
            return FALSE;
        }
    }

    // 会員情報を更新する関数

    function update_user($dbh, $name, $mail,$comment,$id) {
        $sql = "UPDATE Users SET name = :name , mail = :mail, comment = :comment WHERE id = :id ";
        $stmt = $dbh->prepare($sql);
        
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
        $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        // $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        if($stmt->execute()) {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    // IDが一致するUserのnameをとってくる
    
    function select_user_id($dbh,$id) {
        $sql = 'SELECT * FROM Users WHERE id = :id LIMIT 1';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // プロジェクトテーブルにデータを挿入し、そのレコードのIDを返す

    function insert_projects_data($dbh, $pj_name, $pj_explain) {
        
        $sql = "INSERT INTO Projects (pj_name, pj_explain) VALUE (:pj_name, :pj_explain)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':pj_name', $pj_name, PDO::PARAM_STR);
        $stmt->bindValue(':pj_explain', $pj_explain, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            $project_id = $dbh->lastInsertId();
            return $project_id;
        }else{
            return FALSE;
        }
    }

    // IDが一致するProjectsのレコードをとってくる

    function select_project_id($dbh,$id) {
        $sql = 'SELECT * FROM Projects WHERE id = :id LIMIT 1';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
        return $project;
    }


    // taskデータベースに挿入
function insert_task_data($dbh, $main_user_id, $sub_user_id, $title, $deadline) {
    $sql = "INSERT INTO Tasks (main_user_id, sub_user_id, title, deadline) VALUE (:main_user_id, :sub_user_id, :title, :deadline)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':main_user_id', $main_user_id, PDO::PARAM_INT);
    $stmt->bindValue(':sub_user_id', $sub_user_id, PDO::PARAM_INT);
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
    if($stmt->execute()) {
        return TRUE;
    }else{
        return FALSE;
    }
}

// Membersテーブルのチェック
function check_Members_data($dbh, $user_id, $project_id) {
    $sql = 'SELECT * FROM Members WHERE project_id = :project_id AND user_id = :user_id ';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($result);
    if($result) {
        return TRUE;
    }else{
        return FALSE;
    }
}

// Membersテーブルにデータを挿入
function insert_Members_data($dbh, $user_id, $project_id) {
    $sql = 'INSERT INTO Members (user_id, project_id) VALUE (:user_id, :project_id)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
    
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->execute()) {
        return TRUE;
    }else{
        return FALSE;
    }
}

// データベースからデータをとってくる(確認用)
// function select_users($dbh{
//     $data = [];
//     $sql = "SELECT * FROM Users";
//     $stmt = $dbh->prepare($sql);
//     $stmt->execute();
//     $data[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     return $data;
// }