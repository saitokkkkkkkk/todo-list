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
    <table border="1">
        <!--テーブル作成(下のwhile文のところで、DBから中身を取得して入れていく)-->
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>

        <?php
        // db_connection.phpファイルを読み込む
        require_once 'db_connection.php';

        // データベースに接続する
        $conn = connectToDatabase($dbname);

        // SQL文を準備する
        $sql = "SELECT id, title, content, created_at, updated_at FROM todos ORDER BY created_at DESC";

        // 準備したSQLを$stmtに格納
        $stmt = $conn->prepare($sql);

        // SQLの実行
        $stmt->execute();

        // 結果を取得する
        $result = $stmt->get_result();

        // テーブルの中身を一列づつ取得
        $row = $result->fetch_array();

        //上のhtmlで作った表に結果を一列づつ入れていく($rowに値が入っている間)
        while ($row = $result->fetch_array()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>" . $row['updated_at'] . "</td>";
            echo "<td>"; // Actionsの列に編集ボタンと削除ボタン
            // 編集ボタンの作成
            echo "<form action='edit_todo.php' method='post'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";// その行のidを送信
            echo "<input type='submit' value='編集'>";
            echo "</form>";
            // 削除ボタンの作成
            echo "<form action='delete_todo.php' method='post'>"; 
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<input type='submit' value='削除'>";
            echo "</form>";

            echo "</td>";
            echo "</tr>";
        }

        // データベース接続を閉じる
        $conn->close();
        ?>

    </table>
</body>

</html>


