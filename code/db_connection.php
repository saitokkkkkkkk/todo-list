<?php

// DB接続する関数
function connectToDatabase(){
    // configファイルを要求
    require_once "../config/db_config.php";

    // 定数もらう
    $servername = DB_SERVER;
    $username = DB_USERNAME;
    $password = DB_PASSWORD;
    $dbname = DB_NAME;
    
    // DB接続
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 接続失敗したら、（connect_errorがnullではないなら）
    if ($conn->connect_error) {
        // 処理終了
        die("接続エラー: " . $conn->connect_error);
    }

    return $conn;
}

