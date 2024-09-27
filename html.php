<?php
include 'config.php';


// 게시글 작성 기능 추가
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    try {
        $sql = "INSERT INTO mboard (user_id, subject, content) VALUES (:user_id, :subject, :content)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':content', $content);
        $stmt->execute();

        // 게시글 작성이 완료되면 게시글 목록 페이지로 이동
        header('Location: list.php');
        exit();
    } catch (PDOException $e) {
        echo "게시글 작성 중 오류가 발생하였습니다. 다시 시도해주세요.";
        // 오류 로그를 기록하는 등의 추가 작업이 필요할 수 있습니다.
    }
}
// write.php

// ... (기존 코드들)

// 게시글 작성 기능 추가


?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$board_title ?> 글쓰기</title>

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
            <input type="text" name="name" class="form-control w-25 " placeholder="글쓴이" autocomplete="off" id="id_name">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호" autocomplete="off" id="id_password">

         </div>
        <div>
            <input type="text" name="subject" class="form-control mb-2" autocomplete="off" id="id_subject"> 
        </div> 

    <div id="summernote"></div>
    <div class="mt-2 d-flex gap-2 justify-content-end">
    <button class="btn btn-primary" id="btn_submit">확인</button>
    <a href="./list.php?code=<?php echo $code; ?>" class="btn btn-secondary">목록</a>
    </div>
</div> 


    <script>
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
    if(id_password.value == ''){
        alert('비밀번호를 입력하세요.')
        id_password.focus()
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
    const aa = window.location.search.replace("?","").split(/[=?&]/)
    console.log(aa)
    let param = {}

    for (let i=0; i<aa.length; i++){
        param[aa[i]] = aa[++i]
    }
    const code = param['code']


    const f1 = new FormData()

    f1.append('name',id_name.value)
    f1.append('password',id_password.value)
    f1.append('subject',id_subject.value)
    f1.append('content',markupStr)
    f1.append('code',code)
    
    const xhr = new XMLHttpRequest()
    xhr.open("POST","./write.php","true")
    xhr.send(f1)
    btn_submit.disabled = true
   
    xhr.onload = () => {
            if (xhr.status == 200) {
                    const data = JSON.parse(xhr.responseText)
                   
                    if (data.result == 'success') {
                        alert('글이 성공적으로 등록 되었습니다.');
                        self.location.href = '/list.php?code=' + code;
                    } else {
                        alert('글 등록이 실패했습니다.');
                    }
            
                
            } else {
                alert('통신에 실패했습니다.');
            }
        }


})


        
        $('#summernote').summernote({
          placeholder: '글 내용을 입력하세요.',
          tabsize: 2,
          height: 300,
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
        document.addEventListener("click", function(event) {
            // "목록" 버튼 클릭 이벤트
            if (event.target && event.target.id === "btn_list") {
                // 여기에 목록으로 돌아가는 코드를 추가합니다.
                const aa = window.location.search.replace("?", "").split(/[=?&]/);
                let param = {};
                for (let i = 0; i < aa.length; i++) {
                    param[aa[i]] = aa[++i];
                }
                const code = param['code'];
                self.location.href = './list.php?code=' + code;
            }
        });
        
      </script> 
</body>
</html>
