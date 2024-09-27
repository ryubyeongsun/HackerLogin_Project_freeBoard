<?php

    include 'config.php';
    include 'dbconfig.php';
    include 'lib.php';

    $sn = (isset($_GET['sn']) && $_GET['sn'] != '') ? $_GET['sn'] : '';
    $sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? $_GET['sf'] : '';
    $code = (isset($_GET['code']) && $_GET['code'] != '') ? $_GET['code'] : '';
    
    if($code == ''){
        echo '$code: ' . $code;

        
    }
    

    $where = "WHERE code='".$code."'";
    $params = [];
    if($sn != '' && $sf != ''){
        switch($sn){
            case 1 : $where .= "AND (subject LIKE CONCAT('%', :sf ,'%') OR content LIKE CONCAT('%', :sf2 , '%') )";
            $params = [':sf' => $sf, ':sf2' => $sf];
             break; //제목+내용
            case 2 : $where .= "AND (subject LIKE CONCAT('%', :sf, '%'))";
            $params = [':sf' => $sf];
            break; //제목
            case 3 : $where .= "AND (content LIKE CONCAT('%', :sf ,'%'))";
            $params = [':sf' => $sf];
            break; //내용
            case 4 : $where .= "AND (name =:sf)"; 
            $params = [':sf' => $sf];
            break; //이름
        }

      } 

    $limit = 5;
    $page_limit=5;

    $page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    $sql="SELECT COUNT(*) cnt FROM mboard ". $where;
    $stmt = $conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute($params);
    $row = $stmt->fetch();
    $total = $row['cnt'];

    $sql = "SELECT * FROM mboard ".$where." ORDER BY idx DESC LIMIT $start, $limit";
    $stmt=$conn->prepare($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute($params);
    $rs=$stmt->fetchAll(); 

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
            .us-cursor { cursor: pointer;}
            .text-bg-green {
    background-color: green;
}

    </style>

</head>
<body>
    <div class="container mt-3">
        <h1 class="h1"><?= $board_title ?></h1>
    </div>
    <div class="container mt-3">
        <table class="table table-bordered table-hover">
            <colgroup>
                <col width="7%" />
                <col width="63%" />
                <col width="10%" />
                <col width="10%" />
                <col width="10%" />
            </colgroup>
            <thead style="background-color:green" class="text-center">
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>글쓴이</th>
                <th>등록일</th>
                <th>조회수</th>
            </tr>
            </thead>
            <?php
            foreach($rs AS $row){
                ?>
            <tr class="view_detail us-cursor" data-idx="<?= $row['idx']; ?>" data-code="<?= $code; ?>">
                <td class="text-center"><?= $row['idx']; ?></td>
                <td><?= $row['subject']; ?></td>
                <td class="text-center"><?=$row['name']; ?></td>
                <td class="text-center"><?=substr($row['rdate'],0,10); ?></td>
                <td class="text-center"><?=$row['hit']; ?></td>
                
            </tr>
            <?php } ?>
        </table>

        <div class="container mt-3 d-flex gap-2 w-50">
            <select class="form-select w-25" id="sn">
                <option value="1"<?= ($sn == 1) ? ' selected' : ''; ?>>제목+내용</option>
                <option value="2"<?= ($sn == 2) ? ' selected' : ''; ?>>제목</option>
                <option value="3"<?= ($sn == 3) ? ' selected' : ''; ?>>내용</option>
                <option value="4"<?= ($sn == 4) ? ' selected' : ''; ?>>글쓴이</option>
            </select>
                <input type="text" calss="form-control w-25" id="sf" value="<?=$sf ?>">
                <button calss="btn btn-primary w-25" id="btn_search">검색</button>
        </div>



    <div class="mt-3 d-flex justify-content-between align-items-start">

        <?php
                $param = '&code='. $code;
                if($sn != ''){
                    $param .='&sn='. $sn;

                }
                if($sf != ''){
                    $param .= '&sf='. $sf;
                }

                $rs_str = my_pagination($total, $limit, $page_limit, $page, $param);
                echo $rs_str;

     ?>  

    <button class="btn btn-primary" id="btn_write">글쓰기</button>

    </div> 
</div>


    <script>
        function getUrlParams(){
            const params = {};

            window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,
                function(str, key, value){
                    params[key] = value;
                }
            );
            return params;  
        }


        const btn_write = document.querySelector("#btn_write")
        btn_write.addEventListener("click", () => {
            self.location.href='./html.php?code=<?= $code;?>';
        })
        const view_detail = document.querySelectorAll(".view_detail")
        view_detail.forEach( (box)=>{
            box.addEventListener("click", () =>{
            self.location.href='./view.php?idx=' + box.dataset.idx + '&code=' + box.dataset.code
        })
    })

    const btn_search = document.querySelector("#btn_search")
    btn_search.addEventListener("click",() =>{
        const sn = document.querySelector("#sn")  
        const sf = document.querySelector("#sf")
        if(sf.value == ''){
            alert('검색어를 입력해 주세요')
            sf.focus()
            return false;
        }
        const params = getUrlParams()
     
        self.location.href='./list.php?code=' + params['code'] + '&sn=' + sn.value + '&sf=' + sf.value 
    })
    </script>
    
</body>
</html> 
<body<?php>