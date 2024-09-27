<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($g_title) && $g_title !='') ? g_title:'류병선'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <?php
  if(isset($js_array)){

  foreach($js_array AS $var){
    echo '<script src="'.$var.'?v='. date('YmdHis') .'"></script>'.PHP_EOL;
  } 
}
    ?>
    
</head>
<body>
    <div class="container">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
      <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-4">류병선</span>
      </a>

      <ul class="nav nav-pills">
      <?php if(isset($ses_id) && $ses_id != ''){
        //로그인 상태
        ?>  
        <li class="nav-item"><a href="index.php" class="nav-link <?= ($menu_code == 'home') ? 'active': '' ;?>">Home</a></li>
        <li class="nav-item"><a href="notic.php" class="nav-link <?= ($menu_code == 'notice') ? 'active': '' ;?>">공지사항</a></li>
        <li class="nav-item"><a href="mypage.php" class="nav-link <?= ($menu_code == 'member') ? 'active': '' ;?>">마이페이지</a></li>
        <li class="nav-item"><a href="board.php" class="nav-link <?= ($menu_code == 'board') ? 'active': '' ;?>">게시판</a></li>
        <li class="nav-item"><a href="./pg/logout.php" class="nav-link <?= ($menu_code == 'login') ? 'active': '' ;?>">로그아웃</a></li>
        <?php
      }else{
        // 로그인 안된 상태
        ?>
        <li class="nav-item"><a href="index.php" class="nav-link <?= ($menu_code == 'home') ? 'active': '' ;?>">Home</a></li>
        <li class="nav-item"><a href="notic.php" class="nav-link <?= ($menu_code == 'notice') ? 'active': '' ;?>">공지사항</a></li>
        <li class="nav-item"><a href="stipulation.php" class="nav-link <?= ($menu_code == 'member') ? 'active': '' ;?>">회원가입</a></li>
        <li class="nav-item"><a href="board.php" class="nav-link <?= ($menu_code == 'board') ? 'active': '' ;?>">게시판</a></li>
        <li class="nav-item"><a href="login.php" class="nav-link <?= ($menu_code == 'login') ? 'active': '' ;?>">로그인</a></li>
        <?php
      }
      ?>
      </ul>
</header>