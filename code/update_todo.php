<?php

// リダイレクト先を取得できるようにしとく
require_once '../config/redirect_config.php';

// 受け取ったidを元にそのレコードを更新していく。
// データ更新の関数。
function updateTodoInDatabase($id, $edited_title, $edited_content){
    
    // DBに接続
    require_once 'db_connection.php';
    $conn = connectToDatabase();

    // titleとcontentは外部からなのでエスケープ
    $id = $id;
    $edited_title = mysqli_real_escape_string($conn, $edited_title);
    $edited_content = mysqli_real_escape_string($conn, $edited_content);

    // SQLクエリの準備
    $sql = "UPDATE todos SET title=?, content=? WHERE id = ?";
    // stmtオブジェクトの作成(prepare関数で、①処理早くなる(prepareが実行前にsqlを解析)②プレースホルダ使用可能に)
    $stmt = $conn->prepare($sql);
    // SQLの?に実際に値を入れる(文字列,文字列,整数)
    $stmt->bind_param("ssi", $edited_title, $edited_content, $id); 

    // stmtの実行とその後
    if ($stmt->execute()){ 
        // DBとの接続とstmtを閉じておく
        $conn->close();
        $stmt->close();
        // リダイレクト
        header("Location: " . REDIRECT_UPDATE);
        exit();
    }else{
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
}

// 編集された情報の受け取り、関数の呼び出し
// 必要なデータが全て送信されているかつ、空文字ではない場合
if (isset($_POST['id'], $_POST['edited_title'], $_POST['edited_content']) && $_POST['edited_title'] != '' && $_POST['edited_content'] != '') {
    // 受け取ったデータを引数にして関数を呼び出す
    updateTodoInDatabase($_POST['id'], $_POST['edited_title'], $_POST['edited_content']);
}else{
    // 空文字の場合など
    header("Location: " . REDIRECT_UPDATE_FAILED);
    exit();
}

?>