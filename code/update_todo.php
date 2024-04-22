<?php

// 受け取ったidを元にそのレコードを更新していく。

// データ更新の関数
function updateTodoInDatabase($id, $edited_title, $edited_content){
    
    // DBに接続
    require_once 'db_connection.php';
    $conn = connectToDatabase($dbname);

    // それらを受け取る(titleとcontentは外部からなのでエスケープ)
    $id = $_POST['id'];
    $edited_title = mysqli_real_escape_string($conn, $_POST['edited_title']);
    $edited_content = mysqli_real_escape_string($conn, $_POST['edited_content']);

    // SQLクエリを書く（$idではなく?にして安全に?）
    $sql = "UPDATE todos SET title=?, content=? WHERE id = ?";
    // stmtオブジェクトの作成
    $stmt = $conn->prepare($sql);
    // SQLの?に実際に値を入れる(文字列,文字列,整数)
    $stmt->bind_param("ssi", $edited_title, $edited_content, $id); 
    
    // stmtの実行とその後
    if ($stmt->execute()){ 
        // DBとの接続とstmtを閉じておく
        $conn->close();
        $stmt->close();
        // リダイレクト(getメソッドでパラメータupdateを渡す)
        header("Location: todo_list.php?message=update");
    }else{
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

// 入力の受け取り、関数の呼び出し
// postリクエストか否か
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 必要なデータが全て送信されているかつ、空文字ではない場合
    if (isset($_POST['id'], $_POST['edited_title'], $_POST['edited_content']) && $_POST['edited_title'] != '' && $_POST['edited_content'] != '') {
        // 受け取ったデータを引数にして関数を呼び出す
        updateTodoInDatabase($_POST['id'], $_POST['edited_title'], $_POST['edited_content']);
    } else {
        // データが不足している場合はリダイレクトとエラーメッセージ

        echo "必要なデータが送信されていません。";
    }
} else {
    // POSTリクエストでない場合はログにエラーメッセージを表示
    echo "エラー";
    error_log("POSTリクエストではありません。");
}

?>