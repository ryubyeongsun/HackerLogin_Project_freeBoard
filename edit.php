<?php
session_start();


$edit_idx = isset($_SESSION['edit_idx']) && $_SESSION['edit_idx'] != '' && is_numeric($_SESSION['edit_idx']) ? $_SESSION['edit_idx'] : '';
$idx = (isset($_GET['idx']) && $_GET['idx'] != '' && is_numeric($_GET['idx'])) ? $_GET['idx'] : '';

if($idx == ''){
    die("<script>alert('게시물 번호가 없습니다.'); history.go(-1);</script>");
}



if($edit_idx != $idx){
    die("<script>alert('수정권한이 없는 게시물입니다.'); history.go(-1);</script>");

}
include 'config.php';
include 'dbconfig.php';

$sql = "SELECT * FROM mboard WHERE idx=:idx";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':idx', $idx);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$row = $stmt->fetch();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$board_title ?> 글수정</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
</head>
<body>

    <div class="container">
        <div class="mb-4 mb-3">
            <h1><?= $board_title ?></h1>
        </div>
        <div class="mb-2 d-flex gap-2">
            <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control w-25 " placeholder="글쓴이" autocomplete="off" id="id_name">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호" autocomplete="off" id="id_password">

         </div>
        <div>
            <input type="text" name="subject" value="<?= $row['subject'] ?>" class="form-control mb-2" autocomplete="off" id="id_subject"> 
        </div> 

    <div id="summernote"></div>
    <div class="mt-2 d-flex gap-2 justify-content-end">
    <button class="btn btn-primary" id="btn_submit">확인</button>
    <button class="btn btn-secondary" id="btn_list">목록</button>
    </div>
</div> 


    <script>
    const aa = window.location.search.replace("?","").split(/[=?&]/)
    console.log(aa)
    let param = {}

    for (let i=0; i<aa.length; i++){
        param[aa[i]] = aa[++i]
    }
    const code = param['code']

const btn_list = document.querySelector("#btn_list")
btn_list.addEventListener("click", ()=> {
    window.location.href='./list.php?code=' + code;
})

const btn_submit = document.querySelector('#btn_submit'); 
btn_submit.addEventListener("click", () => {
    const id_name = document.querySelector('#id_name')
    const id_password = document.querySelector('#id_password')
    const id_subject = document.querySelector('#id_subject')
    if(id_name.value == ''){
        alert('글쓴이를 입력하세요.')
        id_name.focus()
        return false
    }
 
    if(id_subject.value == ''){
        alert('제목을 입력하세요.')
        id_subject.focus()
        return false  
    }
    const markupStr = $('#summernote').summernote('code');
    if(markupStr == '<p><br></p>'){
        alert('내용을 입력하세요.')
        // markupStr.focus(); // 제거
        return false // falses를 false로 수정
    }
   

    
    const f1 = new FormData()

    f1.append('name',id_name.value)
    f1.append('password',id_password.value)
    f1.append('subject',id_subject.value)
    f1.append('content',markupStr)
    f1.append('code',code)
    f1.append('idx', param['idx'])
    
    const xhr = new XMLHttpRequest()
    xhr.open("POST","./edit1.php","true")
    xhr.send(f1)
    btn_submit.disabled = true
   
    xhr.onload = () => {
            if (xhr.status == 200) {
                    const data = JSON.parse(xhr.responseText)
                   
                    if (data.result == 'success') {
                        alert('글이 성공적으로 수정 되었습니다.');
                        window.location.href = '/view.php?code=' + code + '&idx=' + param['idx'];
                    }else if(data.result == 'denied'){
                        alert('수정 권한이 없습니다.')
                        window.location.href='/list.php?code=' + code;
                    } 
                    else {
                        alert('글 수정이 실패했습니다.');
                    }
            
                
            } else {
                alert('통신에 실패했습니다.');
            }
        }


})


        
        $('#summernote').summernote({
          placeholder: '글 내용을 입력하세요.',
          tabsize: 2,
          height: 500,
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
          ]
        }); 
        const markupStr = `<?= $row['content']; ?>`;
$('#summernote').summernote('code', markupStr);
      </script> 
</body>
</html>
