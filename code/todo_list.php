<!DOCTYPE html>
<!--
①一覧表示画面（②新規追加とも繋げる）
・ToDoの一覧を作成日時の降順で表示できる。（3点）
・ToDoごとにタイトルと作成日時と更新日時を表示できる。（2点）
・ToDoごとの右側に編集ボタンと削除ボタンを持つ。（1点）
-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Todo</title>
</head>
<body>
    <h1>Todo List</h1>
    <?php require_once 'add_todo.php';

    // DB接続の関数を呼び、オブジェクトの取得(再利用)
    $conn = connectToDatabase($dbname);
    // sqlを準備
    $sql = "SELECT * from $todos";
    ?>
</body>
</html>

