<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ダッシュボード</title>
</head>
<body>
<h1>ダッシュボード</h1>
    <!-- 更新されたら、更新された旨を表示する -->

    <p><?php echo $update_fin ?></p>
    <h2><?php echo html_escape($user['name']);?>さんが参加しているプロジェクト</h2>

    <!-- get送信 -->
    
        <p>XXX会社WEBシステム</p>
        <a href="project.php?id=1">タスクへ</a>
        <p>XXX会社WEBシステム</p>
        <a href="project.php?id=2">タスクへ</a>
        <p>XXX会社WEBシステム</p>
        <a href="project.php?id=3">タスクへ</a>


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
            <input name = "submit_user" type="submit" value="変更する">
        </p>
    </form>
    <!-- プロジェクトフォーム -->
    <p>プロジェクトを作る</p>
    <form action="" method="POST" >
        <p>
            <label for="">プロジェクト名</label>
            <input type="text" name="pj_name">
            <?php echo $errs['pj_name'];?>
        </p>
        <p>
            <label for="">説明</label>
            <textarea name="pj_explain" id="" cols="30" rows="10"></textarea>
            <?php echo $errs['pj_explain'];?>
        </p>
        <p>
            <input name="submit_project" type="submit" value="作成する">
        </p>
    </form>
</body>
</html>