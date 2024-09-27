<?php
session_start();

$edit_idx = isset($_SESSION['edit_idx']) && $_SESSION['edit_idx'] != '' && is_numeric($_SESSION['edit_idx']) ? $_SESSION['edit_idx'] : '';




include 'dbconfig.php';
include 'config.php';
$name = (isset($_POST['name']) && $_POST['name'] != '') ? $_POST['name'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';
$idx = (isset($_POST['idx']) && $_POST['idx'] != '' && is_numeric($_POST['idx'])) ? $_POST['idx'] : '';

if($idx==''){
    $arr = ['result' => 'empty_idx'];
    die(json_encode($arr));
}

if($edit_idx != $idx){
    $arr = ['result' => 'denied'];
    die(json_encode($arr));

}

$pwd_hash = '';
if($password != ''){
    $pwd_hash = password_hash($password, PASSWORD_BCRYPT);
}

preg_match_all("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $content, $matches);

$img_array = [];

foreach($matches[1] AS $key => $row){
    if (substr($row,0,6) == 'upload'){
        $img_array[] = $row;
        continue;
    }
    if (substr($row, 0 ,5) != 'data:'){
        continue;
    }
    list($type, $data) = explode(';', $row);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);

    //확장자 만들기
    list(, $ext) = explode('/', $type);
    // $ext : png
    $ext = ($ext == 'jpeg') ? 'jpg' : $ext;

    //파일명 만들기
    $filename = date('YmdHis') . '_'. $key . '.' . $ext;
    
    file_put_contents('upload/'. $filename, $data);

    $content = str_replace($row, 'upload/'.$filename, $content);
    $img_array[] = 'upload/' . $filename;

}
//['a','b','c'] ===? a|b|c 배열을 구분자 기준으로 해서 문자열로 만들어줌
$imglist = implode('|' , $img_array); 


if ($pwd_hash != '') {
    $sql = "UPDATE mboard SET name=:name, subject=:subject, content=:content, imglist=:imglist, password=:password WHERE idx=:idx";
} else {
    $sql = "UPDATE mboard SET name=:name, subject=:subject, content=:content, imglist=:imglist WHERE idx=:idx";
}

$stmt = $conn->prepare($sql);
$stmt->bindParam(':name', $name);
if ($pwd_hash != '') {
    $stmt->bindParam(':password', $pwd_hash);
}
$stmt->bindParam(':subject', $subject);
$stmt->bindParam(':content', $content);
$stmt->bindParam(':imglist', $imglist);
$stmt->bindParam(':idx', $idx);
$stmt->execute();



$arr = ['result' => 'success'];
die(json_encode($arr));