<!-- 新規登録画面 -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>タスク共有アプリ</h1>
    <h2>新規登録</h2>
    <form action="register.php" method="POST" >
        <p>
            <label for="">Name</label>
            <input type="text" name="name">
            <?php echo $errs['name'];?>
        </p>
        <p>
            <label for="">mail</label>
            <input type="email" name="mail">
            <?php echo $errs['mail'];?>
        </p>
        <p>
            <label for="">mail(確認)</label>
            <input type="email" name="mail2">
            <?php echo $errs['mail'];?>
        </p>
        <p>
            <label for="">password</label>
            <input type="password" name="password">
            <?php echo $errs['password'];?>
        </p>
        <p>
            <input type="submit" value="会員登録">
        </p>
    </form>
    <p><a href="index.php">ログインはこちら</a></p>
</body>
</html>