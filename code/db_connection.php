<?php

// DB接続する関数
function connectToDatabase($dbname) {
    // configファイルを要求
    //require_once "/../config/config.php";

    // (configファイルからもらう)
    $servername = "localhost";
    $username = "root";
    $password = "root";
    
    // DB接続
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 接続失敗したら、（connect_errorがnullではないなら）
    if ($conn->connect_error) {
        // 処理終了
        die("接続エラー: " . $conn->connect_error);
    }

    return $conn;
}

// DB名もここに書いておく
$dbname = "todo_list";