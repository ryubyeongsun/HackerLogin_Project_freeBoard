<?php
session_start();

$ses_id =(isset($_SESSION['ses_id']) && $_SESSION['ses_id'] != '') ? $_SESSION['ses_id'] : '';


$js_array = ['js/home.js'];
$menu_code='home';

include 'inc_h.php'
?>

<main class="w-75 mx-auto border rounded-5 p-5">
    
    <div>
        <h3>Home 입니다.</h3>
       
    </div>

</main>

