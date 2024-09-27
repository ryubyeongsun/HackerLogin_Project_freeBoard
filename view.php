<?php
    include 'config.php';
    include 'dbconfig.php';

    $idx = (isset($_GET['idx']) && $_GET['idx'] != '' && is_numeric($_GET['idx'])) ? $_GET['idx'] : '';
    
    if($idx==''){
        exit('비정상적인 접근을 허용하지 않습니다.');
        //die('비정상적인 접근을 허용하지 않습니다.');
        //echo '비정상적인 접근을 허용하지 않습니다.';
        // die;
    }

    $sql="UPDATE mboard SET hit=hit+1 WHERE idx=:idx";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->execute();

    $sql = "SELECT * FROM mboard WHERE idx=:idx";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idx', $idx);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();

    $row = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $board_title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css " 
    rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" 
    crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <style>
        #bbs_content img {
            max-width: 100%;
        }
    </style>
</head>
<body>
    
    <div class="container mt-3 w-50">
        <h1 class="h1"><?= $board_title ?></h1>
    </div>
    <div class="container my-3 border border-1 w-50 vstack"> 
        <div class="p-3">
            <span class="h3 fw-bolder"> <?= $row['subject']; ?></span> 
        </div>
        <div class="d-flex px-3 border border-top-0 border-start-0 border-end-0 border-bottom-1">
            <span><?= $row['name']; ?></span>
            <span class="ms-5 me-auto"><?= $row['hit']; ?>회</span>
            <span><?= $row['rdate']; ?></span>
            
          
        </div>
        <div class="p-3" id="bbs_content">
            <?= $row['content']; ?> 
        </div>
   
        <div class="d-flex gap-2 p-3">
                <button class="btn btn-secondary" id="btn_list">목록</button>
                <button class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modal" id="btn_edit">수정</button>
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal" id="btn_delete">삭제</button>
        </div>
        <div style="margin-left: 540px;"> 
    <!-- ... -->
    <div class="d-flex px-3  border-top-0 border-start-0 border-end-0 border-bottom-1">
        <span style="color: red;"><?= getPostLikes($idx); ?>회</span>
        <!-- 추천 버튼 추가 -->
        <form method="post" action=""> 
            <input type="hidden" name="action" value="like">
            <button type="submit" class="btn btn-success ms-auto btn-sm" id="btn_like" <?= hasLikedPost($idx, 1) ? 'disabled' : ''; ?>>
                <?= hasLikedPost($idx, 1) ? '추천 완료' : '추천'; ?>
            </button>
        </form>
    </div>
    <!-- ... -->
</div>
</div>

<!-- Modal -->
<div class="modal" id="modal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" name="modal_form" action="./process.php">
    <input type="hidden" name="mode">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="password" name="password" class="form-control" id="password" placeholder="비밀번호를 입력해 주세요">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_password_chk">확인</button>
      </div>
    </div>
    </form>
  </div>
</div>

    <script>
        const splited = window.location.search.replace("?","").split(/[=?&]/);
                let param = {}
                for(let i=0; i<splited.length; i++){
                    param[splited[i]] = splited[++i]
                }
                


        const btn_edit = document.querySelector("#btn_edit")
        btn_edit.addEventListener("click", () => {
            const modal_title = document.querySelector("#modal_title")
            modal_title.textContent="수정하기"
            document.modal_form.mode.value = "edit"
            
        })

        const btn_delete = document.querySelector("#btn_delete")
        btn_delete.addEventListener("click", () => {
            const modal_title = document.querySelector("#modal_title")
            modal_title.textContent="삭제하기"
            document.modal_form.mode.value = "delete"
        })
        
        const btn_password_chk = document.querySelector("#btn_password_chk");
    btn_password_chk.addEventListener("click", () => {
        const password = document.querySelector("#password");
        if (password.value == '') {
            alert('비밀번호를 입력해 주세요.');
            password.focus();
            return false;
        }
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./process.php", true);
        const f1 = new FormData(document.modal_form);
        f1.append("idx", param["idx"]);
        f1.append("code", param["code"]);
        xhr.send(f1);
        xhr.onload = () => {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.result == 'edit_success') {
                    // 수정 완료 후 해당 게시물로 이동
                    // 수정된 부분: 주소에 파라미터 전달
                    self.location.href = `./edit.php?code=${param['code']}&idx=${param['idx']}`;
                } else if (data.result == 'delete_success') {
                    alert('삭제되었습니다.');
                    self.location.href = `./list.php?code=${param['code']}`;
                } else if (data.result == 'wrong_password') {
                    alert('비밀번호가 틀렸습니다.');
                    password.value = '';
                    password.focus();
                }
            } else {
                alert('오류가 발생하였습니다. 다음에 다시 시도해 주세요');
            }
        };
    });


            const btn_list =document.querySelector("#btn_list")
            btn_list.addEventListener("click",() =>{
                //?idx=6&code=freeboard
                
               
                self.location.href='./list.php?code=' + param['code']
       
            })
    </script>

    <!-- 게시물 내용 ... -->
    <script>
    const btn_like = document.querySelector("#btn_like");
    btn_like.addEventListener("click", () => {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "view.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                const likeCountSpan = document.querySelector("#btn_like").previousElementSibling;
                likeCountSpan.style.color = "red"; // 추천 수 텍스트 색상 변경
                likeCountSpan.textContent = response.likes_count + "회";
                btn_like.style.backgroundColor = "green"; // 추천 버튼 색상 변경
                btn_like.textContent = "추천 완료";
                btn_like.disabled = true; // 추천 버튼 비활성화
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        };
        const formData = new FormData();
        formData.append("post_id", <?= $idx; ?>);
        formData.append("user_id", 1); // 사용자의 고유 ID를 여기에 넣어주셔야 합니다.
        formData.append("action", "like");
        xhr.send(formData);
    });
</script>

<style>
 /* 댓글 목록 스타일 */
 .container {
    margin-top: 30px;
    width: 50%;
    margin: 0 auto;
}
.comment-list {
    margin-top: 20px;
   
    
}

.comment {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 10px;
    width:100%;
    
}

.comment p {
    font-size: 14px;
    color: #555;
    margin: 0;
}

.comment .date {
    font-size: 12px;
    color: #999;
    margin-top: 5px;
    
}


.comment-form {
    margin-top: 30px;
    text-align: center;
}

.comment-form .form-group {
    
    margin-top: 50px
}

.comment-form label {
    display: block;
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
    width: 40%;
}

.comment-form textarea {
    margin: 0 auto;
    width: 40%;
    height: 70px;
    resize: none;
}

.comment-submit {
    text-align: right;
    margin-left: 680px;
    margin-top: -80px;
}

    </style>





<!-- 댓글 작성 폼 -->
<form method="post" action="./process_comment.php" class="comment-form">
    <input type="hidden" name="post_id" value="<?= $idx; ?>">
    <div class="form-group">

        <textarea name="comment" id="comment" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary comment-submit">댓글 작성</button>
</form>

<!-- 게시물 하단 ... -->
<!-- 댓글 목록 -->
<div class="container">
<h3>댓글 목록</h3>
<div class="comments-list">
    <?php
    $comments_sql = "SELECT * FROM comments WHERE post_id = :post_id ORDER BY created_at DESC";
    $comments_stmt = $conn->prepare($comments_sql);
    $comments_stmt->bindParam(':post_id', $idx);
    $comments_stmt->execute();
    $comments = $comments_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            ?>
            <div class="comment">
                <p class="comment-text"><?= $comment['comment']; ?></p>
                <p class="comment-date"><?= $comment['created_at']; ?></p>
            </div>
            <?php
        }
    } else {
        echo '<p>댓글이 없습니다.</p>';
    }
    ?>
</div> </div>
<?php
// ... 기존 코드 ...

// 게시글 추천 수 조회 함수
function getPostLikes($post_id) {
    global $conn;

    $sql = "SELECT COUNT(*) AS likes_count FROM likes WHERE post_id = :post_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['likes_count'];
}

// 게시글에 대한 사용자의 추천 여부 확인 함수
function hasLikedPost($post_id, $user_id) {
    global $conn;

    $sql = "SELECT COUNT(*) AS like_count FROM likes WHERE post_id = :post_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['like_count'] > 0;
}

// 게시글 추천 처리 함수
function likePost($post_id, $user_id) {
    global $conn;

    $sql = "INSERT INTO likes (post_id, user_id) VALUES (:post_id, :user_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':post_id', $post_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'like') {
        // 추천 버튼이 클릭된 경우
        $user_id = 1; // 사용자의 고유 ID 또는 로그인 정보에서 얻어온 사용자 ID 사용
        if (!hasLikedPost($idx, $user_id)) {
            likePost($idx, $user_id);
        }
    }
}


?>






</body> 
</html> 
