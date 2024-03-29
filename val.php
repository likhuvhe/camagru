<?php
    class va{
        private $conns;
        public function __construct()
        {
            include('./config/database.php');
            $this->conns = $conn;
        }
        
        public function test_user($uname)
        {
            if (!preg_match('/[A-Za-z0-9]{6,}/', $uname))
                return 0;
            try{
                $sql = 'SELECT * FROM users WHERE username = :uname';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":uname", $uname);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }
        public function test_user1($uname)
        {
            try{
                $sql = 'SELECT * FROM users WHERE username = :uname';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":uname", $uname);
                $stmt->execute();
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }

        /*     */
        public function test_password($password)
        {
            if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password))
                return 0;
            return 1;
        }

        /*      */
        public function test_email($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                return 0;
            try{
                $sql = 'SELECT * FROM users WHERE email = :email';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }
        public function test_email1($email)
        {
            try{
                $sql = 'SELECT * FROM users WHERE email = :email';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                if (count($stmt->fetchAll()))
                    return 0;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }
            return 1;
        }
        public function valid_login($uname, $passwd)
        {
            if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $passwd))
                 return 0; 
               
            if (preg_match('/[A-Za-z0-9]{6,}/', $uname)){
                try{
                    $sql = 'SELECT * FROM users WHERE username = :uname && passwd = :passwd';
                    $stmt = $this->conns->prepare($sql);
                    $stmt->bindParam(":uname", $uname);
                    $stmt->bindParam(":passwd", hash("md5",$passwd));
                    $stmt->execute();
                    $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if (count($stmt->fetchAll()))
                        return 1;
                }catch (PDOException $e)
                {
                    echo "Selection failed: " . $e->getMessage();
                }
            }
            if(filter_var($uname, FILTER_VALIDATE_EMAIL)){
                try{
                    $sql = 'SELECT * FROM users WHERE email = :uname && passwd = :passwd';
                    $stmt = $this->conns->prepare($sql);
                    $stmt->bindParam(":uname", $uname);
                    $stmt->bindParam(":passwd", hash("md5",$passwd));
                    $stmt->execute();
                    $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if (count($stmt->fetchAll()))
                        return 1;
                }catch (PDOException $e)
                {
                    echo "Selection failed: " . $e->getMessage();
                }
             }
             return 0;
        }

        public function get_user($uname)
        {
            try{
                $sql = 'SELECT * FROM users WHERE username = :uname OR email = :email';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":uname", $uname);
                $stmt->bindParam(":email", $uname);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                return ($stmt->fetchAll());
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }

        }
        public function get_username($uid)
        {
            try{
                $sql = 'SELECT * FROM users WHERE userid = :usid';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":usid", $uid);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                return ($stmt->fetchAll());
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }

        }

        public function updatekey($vkey)
        {
            try{
                $sql = 'UPDATE users SET verify = 1 WHERE vkey = :vkey';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(':vkey', $vkey);
                $stmt->execute();
                return 1;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            } 
            
        }
        public function fetc_pref($uid)
        {
            try{
                $sql = 'SELECT pref FROM users WHERE userid = :uids';
                $stmt = $this->conns->prepare($sql);
                $stmt->bindParam(":uids", $uid);
                $stmt->execute();
                $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                return ($stmt->fetchAll());
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            }

        }

        public function email_verified($username)
        {
            if (preg_match('/[A-Za-z0-9]{6,}/', $username)){
            try{
                // if (SELECT from user where verifie = 1)
                 $sql = 'SELECT verify FROM users WHERE verify = 1 && username = :username' ;
                 $stmt = $this->conns->prepare($sql);
                 $stmt->bindParam(":username", $username);
                 $stmt->execute();
                 $stmt->setFetchMode(PDO::FETCH_ASSOC);
                 if (count($stmt->fetchAll()))
                     return 1;
             }catch (PDOException $e)
             {
                 echo "Selection failed: " . $e->getMessage();
             }
            }
             if(filter_var($username, FILTER_VALIDATE_EMAIL)){
                try{
                    $sql = 'SELECT * FROM users WHERE verify = 1 && email = :uname';
                    $stmt = $this->conns->prepare($sql);
                    $stmt->bindParam(":uname", $username);
                    $stmt->execute();
                    $rot = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    if (count($stmt->fetchAll()))
                        return 1;
                }catch (PDOException $e)
                {
                    echo "Selection failed: " . $e->getMessage();
                }
             }
             return 0;
        }

        public function updatePassword($password, $email)
        {
            try{
                $sql = 'UPDATE users SET passwd = :passwd WHERE email = :email'; echo 'a';
                $stmt = $this->conns->prepare($sql); echo 'b';
                $stmt->bindParam(':passwd', md5($password));
                $stmt->bindParam(':email', $email);
                $stmt->execute(); echo 'g';
                return 1;
            }catch (PDOException $e)
            {
                echo "Selection failed: " . $e->getMessage();
            } 
        }
    }
?>