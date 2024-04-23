<?php

// 削除の関数
function deleteTodoFromDatabase($id){
    // DBに接続
    require_once 'db_connection.php';
    $conn = connectToDatabase($dbname);

    // sqlの準備（これもstmtで）
    $sql = "DELETE FROM todos WHERE id = ?";
    // stmtオブジェクトの作成
    $stmt = $conn->prepare($sql);
    // sqlの?に実際に値を入れる
    $stmt->bind_param("i", $id); 

    // stmtの実行とその後
    if ($stmt->execute()){ 
        // DBとの接続とstmtを閉じておく
        $conn->close();
        $stmt->close();
        // リダイレクト(getメソッドでパラメータaddを渡す)
        header("Location: todo_list.php?message=deleted");
    }else{
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

// idの受け取り、上の関数の呼び出し
// リクエストメソッドの確認
if($_SERVER["REQUEST_METHOD"] === "POST"){
    // 必要なデータが送信されているか
    if(isset($_POST['id'])) {
        // それを受け取る
        $id = $_POST['id'];
        // 削除の関数を呼ぶ
        deleteTodoFromDatabase($id);
    } else {
        // もしIDが送信されていない場合
        echo "エラー";
        error_log("idが指定されていません。");
        exit;
    } 
}else{
    // 関数を呼ばずにリダイレクト（原因はログに表示。ちゃんと動くかをどう確認する？→）
    error_log("POSTリクエスト以外でidが送信されました。");
    //header("Location: add_todo.php");
}


