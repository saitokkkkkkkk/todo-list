<!--
②新規作成機能
・フォームを持ち、タイトルと内容を入力できる。
・ToDoを新規作成できる。
-->

<?php
// リダイレクト先を取得できるようにしとく
require_once '../config/redirect_config.php';

// データを追加する関数
function addTodoToDatabase($title, $content) {
    
    // DB接続
    require_once 'db_connection.php';
    $conn = connectToDatabase();

    // titleとcontentをエスケープ
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // sqlの準備(これもstmtで)
    $sql = "INSERT INTO todos (title, content) VALUES (?, ?)";
    // stmtの準備
    $stmt = $conn->prepare($sql);
    // パラメータのバインド
    $stmt->bind_param("ss", $title, $content);

    // stmtの実行とその後
    if ($stmt->execute()){ 
        // DBとの接続とstmtを閉じておく
        $conn->close();
        $stmt->close();
        // リダイレクト
        header("Location: " . REDIRECT_ADD);
        exit();
    }else{
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }

}

// パラメータの受け取り、上の関数の呼び出し
// リクエストメソッドの確認(postか否か)
if($_SERVER["REQUEST_METHOD"]=== "POST"){
    // 必要なデータを受け取れているか、かつ空文字ではないか
    if(isset($_POST['title'], $_POST['content']) && $_POST['title'] !== '' && $_POST['content'] !== ''){
        // 受け取ったデータを引数にして関数を呼ぶ
        addTodoToDatabase($dbname, $_POST['content'], $_POST['content']);
    }else{
        // リダイレクト
        header("Location: " . REDIRECT_ADD_FAILED);
        exit();
    }
}else{
    // 関数を呼ばずにリダイレクト（原因はログに表示。ちゃんと動く？）
    error_log("POST リクエストではありません。");
}