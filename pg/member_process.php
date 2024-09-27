<?php
include '../inc/dbconfig.php';
include '../inc/member.php';

$mem = new Member($db);

$id    = (isset($_POST['id']) && $_POST['id'] !='') ? $_POST['id'] : '';
$email = (isset($_POST['email']) && $_POST['email'] !='') ? $_POST['email'] : '';
$password = (isset($_POST['password']) && $_POST['password'] !='') ? $_POST['password'] : '';
$name  = (isset($_POST['name']) && $_POST['name'] !='') ? $_POST['name'] : '';
$mode  = (isset($_POST['mode']) && $_POST['mode'] !='') ? $_POST['mode'] : '';
//아이디 중복확인
if($mode == 'id_chk'){
    if($id==''){
        die(json_encode(['result' => 'empty_id']));
    }


if($mem->id_exists($id)){
    die(json_encode(['result' => 'fail']));
}else{
    die(json_encode(['result' => 'success']));
}
//이메일 중복확인
}else if($mode== 'email_chk'){
    if($email==''){
        die(json_encode(['result' => 'empty_email']));
    }

    // 이메일 형식체크
    if($mem->email_format_check($email) ===false){
        die(json_encode(['result' => 'email_format_wrong']));
    }


    if($mem->email_exists($email)){
        die(json_encode(['result' => 'fail']));
    }else{
        die(json_encode(['result' => 'success']));
    }
    }else if($mode=='input'){
        $arr=[
        'id' => $id,
        'email' => $email,
        'password'=>$password,
        'name' => $name
        ];
        $mem->input($arr);

        echo "
        <script>
            self.location.href='../member_success.php'
        </script> 
        ";
    }