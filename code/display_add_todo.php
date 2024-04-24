<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Todo</title>
    <link rel="stylesheet" href="todo_list.css">
</head>
<body>
    <h1>新規追加</h1>
    <form action="add_todo.php" method="post">
      <div class='form-container'>
        <label for="title">Title</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="content">Content</label><br>
        <textarea id="content" name="content"></textarea><br>
        <input type="submit" value="追加">
      </div>
    </form>
</body>
</html>

<?php

if(isset($_GET['message']) && $_GET['message'] === 'notempty'){
    echo "<script>alert('空欄があります。');</script>";
}

?>
