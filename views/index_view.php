<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
<h1>タスク共有アプリ</h1>
    <h2>ログインフォーム</h2>
    <form action="" method="POST" >
        
        <p>
            <label for="">mail</label>
            <input type="email" name="mail">
            <?php echo $errs['mail'];?>
        </p>
        
        <p>
            <label for="">password</label>
            <input type="password" name="password">
            <?php echo $errs['password'];?>
        </p>
        <p>
            <input type="submit" value="ログイン">
        </p>
    </form>
    <p><a href="register.php">新規登録はこちら</a></p>
</body>
</html>