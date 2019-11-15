<?php
    include("val.php");
    include("send_mail.php");
    include("./config/database.php ");
    if($_POST['submit']){
        $email = $_POST['email'];
        if ($email){
            $valid = new va();
            if ($valid->email_verified($email)){
                $vkey = md5(time());
                $mail = new send_mail("$email","<a href=http://localhost:8080/gururepo/resetPassword.php?vkey=$vkey>reset password</a>" ,"password reset");
                $mail->send_mail();
                $sql = 'UPDATE users SET vkey = :vkey WHERE email = :email';
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":vkey", $vkey);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                header("location: passMessage.php");
            }
           else{
               echo "email not registered";
           }
        }
        else{
            echo "no email entered";
        }
    }
?>