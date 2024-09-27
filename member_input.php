<?php
if(!isset($_POST['chk']) or $_POST['chk'] != 1){
    // die("<script>
    // alert('약관 등을 동의하시고 접근하시기 바랍니다.')
    // self.location.href='./stipulation.php'
    // </script>");
}

$js_array=['js/member_input.js'];


include 'inc_h.php';
?>

<main class="w-50 mx-auto border rounded-5 p-5"> 
<h1 class="text-center">회원가입</h1>
<form name="input_form" method="post" enctype="multipart/form-data" autocomplete="off" action="pg/member_process.php">
    <input type="hidden" name="mode" value="input">
    <input type="hidden" name="id_chk" value="0">
    <input type="hidden" name="email_chk" value="0">
<div class="d-flex gap-2 align-items-end"> 
    <div>
    <label for="f_id"class="form-label">아이디</label>
    <input type="text" name="id" class="form-control" id="f_id" placeholder="아이디를 입력해 주세요.">
    </div>
    <button type="button" class="btn btn-secondary" id="btn_id_check" >아이디 중복확인</button>
  </div>

  <div class="mt-3 d-flex gap-2 align-items-end"> 
    <div>
    <label for="f_id"class="form-label">이름</label>
    <input type="text" name="name" class="form-control" id="f_name" placeholder="이름을 입력해 주세요.">
    </div>
  </div>


  <div class="d-flex mt-3 gap-2 justify-content-betweem"> 
    <div class="flex-grow-1">
    <label for="f_password" class="form-label">비밀번호</label>
    <input type="password" name="password" class="form-control" id="f_password" placeholder="비밀번호를 입력해 주세요.">
    </div>
    <div class="flex-grow-1">
    <label for="f_password2" class="form-label">비밀번호 확인</label>
    <input type="password" name="password2" class="form-control" id="f_password2" placeholder="비밀번호를 입력해 주세요.">
    </div>
  </div>

  <div class="d-flex mt-3 gap-2 align-items-end"> 
    <div class="flex-grow-1">
    <label for="f_email"class="form-label">이메일</label>
    <input type="text" name="email"class="form-control" id="f_email" placeholder="이메일를 입력해 주세요.">
    </div>
    <button type="button" id="btn_email_check" class="btn btn-secondary">이메일 중복확인</button>
  </div>
  <div class="mt-3 d-flex gap-2">
    <button type="button"class="btn btn-primary" id="btn_submit">가입확인</button>
    <button type="button" class="btn btn-danger">가입취소</button>
  </div>
  </form>
</main>
