<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
</head>
<body>
<h1>ダッシュボード</h1>
    <p><?php echo $update_fin ?></p>
    <h2><?php echo html_escape($user['name']);?>さんが参加しているプロジェクト</h2>


    <p>アカウント情報</p>
    <form action="" method="POST" >
        <p>
            <label for="">名前</label>
            <input type="text" name="name">
            <?php echo $errs['name'];?>
        </p>
        <p>
            <label for="">メール</label>
            <input type="email" name="mail">
            <?php echo $errs['mail'];?>
        </p>
        <p>
            <label for="">一言</label>
            <input type="text" name="comment">
            <?php echo $errs['comment'];?>
        </p>
        
        
        <p>
            <input type="submit" value="変更する">
        </p>
    </form>
</body>
</html>