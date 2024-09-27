<?php

$js_array=[ 'js/member.js'];
$menu_code='member';
include 'inc_h.php'; 
?>
 <main class="p-5 border rounded-5">
    <h1 class="text-center">회원 약관 및 개인정보 취급방침 동의</h1>
    <h4>회원 약관</h4>
    <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Amet enim officiis, quam ab iusto dolorem. 
        Tempore et illum id, molestias, numquam ipsum deleniti libero, sed totam ipsam modi. Totam dolorem, 
        fugiat aliquid sapiente, illo beatae quia dicta in quidem, rerum earum quod. Nostrum necessitatibus 
        fuga error quia ipsa temporibus, ipsam aliquam. Delectus, excepturi fuga ad maxime a assumenda cupiditate 
        totam corporis qui sed repellat amet ipsum aperiam, temporibus eos nostrum vero perspiciatis consequatur earum incidunt. 
        Dicta quae a veniam odit dolor harum magni repellat neque unde temporibus tempore voluptatum, eius ipsam odio officia voluptate 
        suscipit labore omnis modi eum eveniet. At aliquam ipsa sit natus, error accusantium eius voluptatem quidem eligendi inventore ab 
        corrupti atque dicta. Necessitatibus molestiae eaque magni dolorem provident. Recusandae porro, et explicabo eum voluptate esse 
        nihil voluptas minus eos maxime, error dolore fuga nesciunt nostrum culpa veritatis, corrupti laboriosam eligendi? Et cupiditate, 
        vitae nihil aspernatur natus fuga rem? Qui odio rerum corporis necessitatibus sequi delectus consequatur praesentium vel 
        illum similique! Nulla temporibus omnis minima hic ad sunt eius sit reiciendis perspiciatis, illum nemo voluptatum aspernatur
         deserunt debitis sequi perferendis, explicabo accusamus? Dignissimos corrupti nisi ipsam qui atque doloribus quis odio soluta 
         minima rerum. Quibusdam aliquam quisquam nihil. Perferendis, perspiciatis? Dignissimos harum doloribus deleniti delectus qui 
         expedita saepe. Nesciunt, fuga nobis dolor aut reprehenderit hic sapiente accusamus praesentium animi eum ratione corrupti eius 
         doloremque, dignissimos aspernatur odit magnam! Nobis, est enim? Consequuntur eligendi quasi illum corrupti eius neque quibusdam 
         optio quidem esse, est beatae maiores dignissimos provident magni impedit odio? Sunt totam iusto, eius in quia voluptatem 
         quibusdam, praesentium ea tempore, aliquam nemo consectetur consequuntur sequi fuga dignissimos dolorum deserunt! Laudantium 
         unde incidunt non, a ex aliquam. Fugiat dolorum a suscipit est nesciunt praesentium! Unde minus ex quas laboriosam assumenda, 
         deserunt pariatur modi doloribus eaque explicabo at.
    </textarea>

    <div class="form-check mt-2">
  <input class="form-check-input" type="checkbox" value="1" id="chk_member1">
  <label class="form-check-label" for="chk_member1">
    위 약관에 동의하시겠습니까?
  </label>
</div>

    <h4 class="mt-3">개인정보 취급방침</h4>
    <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos labore sequi facilis deserunt quam ipsam incidunt, nemo, 
        obcaecati minima reiciendis recusandae voluptas. Assumenda maiores accusamus, mollitia autem quaerat nulla. 
        Accusantium quisquam nisi ea dolore quibusdam tempore excepturi quia amet velit quaerat dicta quam aperiam,
         doloremque culpa magnam quod iusto dolor quos vero? Non libero reprehenderit ex, magnam dignissimos veritatis neque optio vitae 
         aspernatur at quasi error iure quod, nihil in sit. Molestias tenetur sequi debitis explicabo ab, eum consequuntur deserunt 
         fugiat! Ab pariatur sit eveniet repellat excepturi debitis facere libero natus iure, inventore laborum aliquid quidem aliquam 
         enim fugiat nam dolores, ipsum consequatur sequi quis! Enim doloremque dolorum voluptas at ut tempora error temporibus minima. 
         Sequi, ratione in optio quaerat corporis natus ea assumenda placeat magnam, facere, dolore rem ex aperiam corrupti et dolorum 
         eligendi animi? Aliquam id minima ducimus placeat repudiandae sit ipsum veniam dolorum. Dignissimos et sint sequi quam facilis 
         unde cupiditate sit consequatur nostrum asperiores, pariatur sed doloremque obcaecati nemo consectetur repellendus esse optio 
         ullam eum eius, autem neque? Consequatur voluptate inventore optio ea totam voluptatem voluptatibus, tempore vero dolorum, 
            facere ab molestiae obcaecati fugit eos suscipit? Animi, quo, repudiandae quisquam minima quia atque ipsam cum,
            voluptatibus vero itaque nemo veritatis. Accusamus et animi quas, nobis non numquam. Architecto molestias culpa incidunt, 
            modi minus doloribus quia consectetur, quidem neque esse fugit eveniet laborum beatae recusandae veritatis earum! Ratione,
            provident ex et quae molestiae eius tempore, esse reiciendis delectus sint id nulla ipsam porro architecto explicabo 
            non molestias praesentium vitae. Consequatur vel ullam animi laudantium ipsum repellendus eligendi cupiditate nulla esse, 
            id perspiciatis, culpa rerum molestias dolorem cum fuga dicta mollitia? Inventore, dicta repudiandae unde totam rerum sint 
            necessitatibus. Porro et corrupti, tempora aliquid eaque minus accusantium animi qui esse saepe necessitatibus quae i
            n dignissimos fuga eius quas.
    </textarea>
    <div class="form-check mt-2">
  <input class="form-check-input" type="checkbox" value="1" id="chk_member2">
  <label class="form-check-label" for="chk_member2">
    위 개인정보 취급방침에 동의하시겠습니까?
  </label>
</div>
<div class="mt-4 d-flex justify-content-center" >
    <button class="btn btn-primary" id="btn_member">회원가입</button>
    <button class="btn btn-secondary">가입취소</button>
</div>
<form method="post"  name="stipulation_form" action="member_input.php">
    <input type="hidden" name="chk" value="1">

</form>
</main>
    </div>
</body>
</html>