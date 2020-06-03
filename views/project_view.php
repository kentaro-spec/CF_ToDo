<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロジェクト</title>
</head>
<body>
    <h1><?php echo $project['pj_name'];?></h1>
    <h2>XXX会社WEBシステム</h2>

<!-- タスク入力フォーム -->
    <h2>タスクを追加する</h2>
    <form action="" method = "POST">
        <p>担当者①</p>
        <select name="main_user_id">
            <option value = "1">糸島</option>
            <option value = "2">高橋</option>
        </select>
        <p>担当者②</p>
        <select name="sub_user_id">
            <option value="1">糸島</option>
            <option value="2">高橋</option>
        </select>
        <p>タスク名</p>
        <input type="text" name="title">
        <?php echo $errs['title'];?>

        <p>期限</p>
        <input type="date" name="deadline">

        <p><input type="submit" value="追加する"></p>
    </form>

<!-- 共有URL表示 -->
    <p>このプロジェクトにメンバーを招待する</p>
    <p>以下のURLを共有してください</p>
    <p><?php echo "http://localhost/CF_ToDo/project.php?id=" . $id;?></p>
    <a href="dashboard.php">ダッシュボードへ戻る</a>
</body>
</html>