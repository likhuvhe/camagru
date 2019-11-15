<?php

    class saveimg{
        private $con;

        public function __construct()
        {
            include('./config/database.php');
            $this->con = $conn;
        }

        public function saveimg($image, $userid)
        {
            try{
                $sql = 'INSERT INTO userimage (userid, images) VALUES (:users, :images)';
                $aa = $this->con->prepare($sql);
                $aa->bindParam(':users', $userid);
                $aa->bindParam(':images', $image, PDO::PARAM_LOB);
                $aa->execute();
                $sql = 'DELETE FROM tempsave';
                $aa = $this->con->prepare($sql);
                $aa->execute();
            }catch (PDOException $e)
            {
                echo $sql . "<br>" . $e->getMessage() . "\n";
            }
        }
    }
?>