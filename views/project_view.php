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

    <p>このプロジェクトにメンバーを招待する</p>
    <p>以下のURLを共有してください</p>
    <p><?php echo "http://localhost/CF_ToDo/project.php?id=" . $id;?></p>
    <a href="dashboard.php">ダッシュボードへ戻る</a>
</body>
</html>