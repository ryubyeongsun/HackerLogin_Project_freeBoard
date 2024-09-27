<?php

class Member{
    private $conn;

    public function __construct($db){
        $this->conn=$db;
    }
    public function id_exists($id){
        $sql = "SELECT * FROM member WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    
        return $stmt->rowCount() ? true : false;
    }
    // 이메일 형식 체크


public function email_format_check($email){
    return filter_var($email,FILTER_VALIDATE_EMAIL);
}


    public function email_exists($email){

       
            $sql = "SELECT * FROM member WHERE email=:email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
        
            return $stmt->rowCount() ? true : false;
        
    }
    //회원정보 입력
    public function input($marray){

        //단방향 암호화
        $new_hash_password = password_hash($marray['password'],PASSWORD_DEFAULT);

        $sql = "INSERT INTO member(id,name,password,email,ip) VALUES
                (:id,:name,:password,:email,  :ip)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":email"   , $marray['email']);
        $stmt->bindParam(":id"      , $marray['id']);
        $stmt->bindParam(":name"    , $marray['name']);
        $stmt->bindParam(":password", $new_hash_password);
        $stmt->bindParam(":ip"      , $_SERVER['REMOTE_ADDR']);
        $stmt->execute();
    }

    // 로그인
    public function login($id, $pw){





        $sql = "SELECT password FROM member WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if( $stmt->rowCount()){
        $row = $stmt->fetch();
            if(password_verify($pw,$row['password'])){
                $sql = "UPDATE member SET login_dt=NOW() WHERE id=:id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();

                return true;
            }else{
                return false;
            }
    }else{
        return false;
        
    }
}

public function logout(){
    session_start();
    session_destroy();

    die('<script>self.location.href="../index.php";</script>');
}

}