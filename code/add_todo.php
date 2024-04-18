<!--
②新規作成機能
・フォームを持ち、タイトルと内容を入力できる。
・ToDoを新規作成できる。
-->

<?php

// DB接続する関数→どのDB（テーブル）かをここで限定。オブジェクトを返してくれる。（別ファイルにしたほうが良いのか？）
function connectToDatabase($dbname) {
    $servername = "localhost";
    $username = "root";
    $password = "root";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // 接続失敗したら、（connect_errorがnullではないなら）
    if ($conn->connect_error) {
        // 処理終了
        die("接続エラー: " . $conn->connect_error);
    }

    return $conn;
}

// 限定されたDB(テーブル)に行を追加する関数
function addTodoToDatabase($dbname, $title, $content) {
    // 上の関数を動かしてDB接続し、戻り値(オブジェクト？)を取得
    $conn = connectToDatabase($dbname);
    // sqlの準備
    $sql = "INSERT INTO todos (title, content) VALUES ('$title', '$content')";
    // sqlの実行とその後
    if ($conn->query($sql) === TRUE) {
        echo "新しい行が正常に挿入されました。";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }
    // DBとの接続を閉じる
    $conn->close();
}

// DBの名前（関数の外に書いておくことで、これが変わっても関数の中身を変更しなくて済むっぽい）
$dbname = "todo_list";

// フォームを受け取る
$title = $_POST['title'];
$content = $_POST['content'];

// 受け取ったフォームを元に、DBに行を追加
addTodoToDatabase($dbname, $title, $content);


