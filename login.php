<?php



$js_array = ['js/login.js'];
$menu_code='login';

include 'inc_h.php'
?>

<main class="mx-auto border rounded-2 p-5">
    
  <form method="post" class="w-25 mt-5 m-auto" action="">

  <h1 class="h3 mb-3">로그인</h1>
  <div class="form-floating mt-2">
    <input tyoe="text" class="form-control" id="f_id" placeholder="아이디 입력" autocomplete="off">
    <label for="f_id">아이디</label>
  </div> 
  
  <div class="form-floating mt-2">
    <input tyoe="text" class="form-control" id="f_pw" placeholder="비밀번호 입력">
    <label for="f_pw">비밀번호</label>
  </div> 
  
<button class="w-100 mt-2 btn btn-primary" id="btn_login" type="button">확인</button>
  </form>

</main>

