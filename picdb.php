<?php

class picdb{
    private $co;
    public function __construct()
    {
        include('./config/database.php');
        $this->co = $conn;
    }

    public function tempsave($image)
    {
        try{
            $sql = 'INSERT INTO tempsave (images) VALUES (:images)';
            $aa = $this->co->prepare($sql);
            $aa->bindParam(':images', $image, PDO::PARAM_LOB);
            $aa->execute();
        }catch (PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage() . "\n";
        }
    }

    public function getsave()
    {
        try{
            $sql = 'SELECT * FROM tempsave';
            $stmt = $this->co->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }
    public function getall()
    {
        $numperpage = 5;
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * $numperpage) - $numperpage;
        }
        try{
            $sql = "SELECT * FROM userimage ORDER BY timess DESC LIMIT {$page},{$numperpage}";
            $stmt = $this->co->prepare($sql);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }
    public function getuser($userid)
    {
        $numperpage = 5;
        $page = 0;
        if (isset($_POST["page"])) {
            $page = $_POST["page"];
            $page = ($page * $numperpage) - $numperpage;
        }
        try{
            $sql = "SELECT * FROM userimage WHERE userid = :userid ORDER BY timess DESC LIMIT {$page},{$numperpage}";
            $stmt = $this->co->prepare($sql);
            $stmt->bindParam(':userid', $userid);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt->fetchAll();
        }catch (PDOException $e)
        {
            echo "Selection failed: " . $e->getMessage();
        }
    }

    public function __distruct()
    {
        $conn = NULL;
    }
}
?>