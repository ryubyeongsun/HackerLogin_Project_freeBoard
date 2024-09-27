<?php
include 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];

    // 댓글 저장
    $insert_sql = "INSERT INTO comments (post_id, comment, created_at) VALUES (:post_id, :comment, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bindParam(':post_id', $post_id);
    $insert_stmt->bindParam(':comment', $comment);
    $insert_stmt->execute();

    // 댓글 저장 후, 원래 페이지로 돌아감
    header("Location: ./view.php?idx={$post_id}&code={$code}");
    exit();
}
