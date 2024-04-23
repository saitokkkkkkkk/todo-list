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

<?php

// 一覧表示の関数
function showDatabaseItems(){
    
    // DB接続
    require_once 'db_connection.php';
    $conn = connectToDatabase($dbname);

    // SQL準備
    $sql = "SELECT id, title, content, created_at, updated_at FROM todos ORDER BY created_at DESC";
    // 準備したSQLを$stmtに格納
    $stmt = $conn->prepare($sql);
    // SQL実行
    $stmt->execute();

    // 結果を取得する
    $result = $stmt->get_result();

    // テーブルの作成
    // フィールド名
    echo "<table border='1'>";
    echo "<tr>"; // trは横一列のイメージ
    echo "<th>Title</th>"; // thは見出しセル
    echo "<th>Created At</th>";
    echo "<th>Updated At</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    // DBから取得した結果を表に一列づつ入れていく($rowに値が入っている間)
    while ($row = $result->fetch_array()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>"; // tdはデータセル
        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
        echo "<td>" . htmlspecialchars($row['updated_at']) . "</td>";
        echo "<td>"; // Actionsの列に編集ボタンと削除ボタン
        // 編集ボタンの作成
        echo "<form action='edit_todo.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>"; // hiddenにしてその行のidを送信
        echo "<input type='submit' value='編集'>";
        echo "</form>";
        // 削除ボタンの作成
        echo "<form action='delete_todo.php' method='post' onsubmit=\"return confirm('本当に削除してもよろしいですか？');\">"; 
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<input type='submit' value='削除'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // データベース接続を閉じる
    $conn->close();
}

// 関数を呼ぶ
showDatabaseItems();
        
//リダイレクトの処理たち(switch？でまとめるか)+header関数にファイル名ベタ書きしてるから直すか？
// 削除後の遷移(postだと警告出るのでgetメソッドで)
if(isset($_GET['message']) && $_GET['message'] === 'deleted'){
    echo "<script>alert('削除されました。');</script>";
}

// 更新後の遷移
if(isset($_GET['message']) && $_GET['message'] === 'update'){
    echo "<script>alert('更新されました。');</script>";
}

// 更新失敗後の遷移
if(isset($_GET['message']) && $_GET['message'] === 'update_failed'){
    echo "<script>alert('更新に失敗しました。');</script>";
}

// 追加後の遷移
if(isset($_GET['message']) && $_GET['message'] === 'add'){
    echo "<script>alert('追加されました。');</script>";
}

// 追加失敗後の遷移
if(isset($_GET['message']) && $_GET['message'] === 'add_failed'){
    echo "<script>alert('追加に失敗しました。');</script>";
}

?>

<!-- 新規追加のボタン -->
<a href="display_add_todo.php" class="button">新規追加</a>
</body>

</html>