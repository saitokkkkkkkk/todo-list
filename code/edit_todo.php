
<!-- 
③ 編集機能
・編集ボタンを押して編集画面に移動できる。(action属性で付与完了)
・フォームを持ち、タイトルと内容を入力できる。
・ToDoを更新できる。
-->

<?php
    // POSTリクエストでIDが送信されていれば
    if(isset($_POST['id'])) {
        // IDを受け取る
        $id = $_POST['id'];

        // DBに接続
        require_once 'db_connection.php';
        $conn = connectToDatabase($dbname);

        // SQLクエリを書く（$idではなく?にして安全に?）
        $sql = "SELECT title, content FROM todos WHERE id = ?";
        // stmtオブジェクトの作成
        $stmt = $conn->prepare($sql);
        // SQLの?に実際に値を入れる
        $stmt->bind_param("i", $id); 
        // クエリの実行
        $stmt->execute();
        
        // 結果を取得する
        $result = $stmt->get_result();
        
        // 編集対象のToDoの情報を取得する
        $todo = $result->fetch_assoc();
        print_r($todo);

        // DB接続を閉じる
        $conn->close();
    } else {
        // もしIDが送信されていない場合、エラーメッセージを表示
        echo "IDが指定されていません。";
        exit;
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
</head>
<body>
    <h1>Edit Todo</h1>

    <form action="update_todo.php" method="post">
        <label for="title">Title:</label><br>
        <!-- ToDoのタイトルを表示 -->
        <input type="text" id="title" name="edited_title" value="<?php echo htmlspecialchars($todo['title']); ?>"><br>
        <label for="content">Content:</label><br>
        <!-- ToDoの内容を表示 -->
        <textarea id="content" name="edited_content"><?php echo htmlspecialchars($todo['content']); ?></textarea><br>
        <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- ToDoのIDを送信 -->
        <input type="submit" value="変更">
    </form>
</body>
</html>



