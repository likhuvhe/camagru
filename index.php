<?php
    session_start();
    include "./config/database.php";
    include ('./navigation/desp.php');
    include './navigation/nev_index.php';
    echo "<br>";
    $retrive = array();
    $not_val = "";
    foreach($_POST as $key => $value)
        $retrive[$key] = $value;
    if ($_SESSION["userid"]  && isset($_POST["submit"]))
    {
        $chek = $va->fetc_pref($id[0]['userid']);
        $cheked = $chek[0]['pref'];
        if($retrive['comment'] && $retrive['userid'] && $_SESSION['userid'] && $retrive['imagenu'])
        {
            include_once('commentnlike.php');
            $ad = new commentnlike();
            $ad->addcomment($retrive['comment'], $_SESSION['userid'], $retrive['userid'], $retrive['imagenu']);
            if ($cheked == 1)
                $ad->emailcomment($retrive['userid'], 'comment');
            unset($ad);
        }
    }
    elseif ($_SESSION["userid"] && isset($_POST['like']))
    {
        if($retrive['like'] && $_SESSION['userid'])
        {
            include_once('commentnlike.php');
            $ad = new commentnlike();
            $ad->addlike($_SESSION['userid'], $retrive['like'], $retrive['imagenu']);
            unset($ad);
        }
    }
    $numperpage = 5;
        $sql1 = "SELECT * FROM userimage ORDER BY timess DESC";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        $re = $stmt1->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt1->fetchAll();

        $numrecords = count($rows);
        $numlinks = ceil($numrecords/$numperpage);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="header.css">
    <title>PublicGallery</title>

</head>
<body>
    <div class="container">
        <?php
            include_once('./picdb.php');
            include_once('commentnlike.php');
            $hold = new commentnlike();
            $arr = new picdb();
            $display = $arr->getall();
            $i = 0;
            while($i < count($display))
            {
                echo '<div><div><img src="'.$display[$i]['images'].'" class="img"></div>';
                if (!$_SESSION['userid'])
                    echo "<br>";
                if($_SESSION['userid'])
                {
                    $lik = count($hold->getlikes($display[$i]['num']));

                    $holds = $hold->getcomments($display[$i]['num']);
                    echo '<div id="'.$display[$i]['timess'].'" class="img"><button disabled id="'.$display[$i]['timess'].'" onclick="displays('.$display[$i]['num'].','.$display[$i]['timess'].')">comment '.count($holds).'</button>';
                    echo '<form action="index.php" method="post"><button id="'.$display[$i]['timess'].'" type="submit" name="like" value="'.$display[$i]['userid'].'">like '.$lik.'</button>';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'"></form></div><br/>';

                    // echo '<div id="'.$display[$i]['num'].'" style="display:none;">';
                    echo '<div id="'.$display[$i]['num'].'" >';
                    $j = 0;
                    while($j < count($holds))
                    {
                       echo '<textarea rows="4" cols="50" disabled>'.$holds[$j]['comment'].'</textarea>';
                       $j++;
                    }
                    echo '<form action="index.php" method="post"><textarea name="comment"  id="'.$display[$i]['num'].'" rows="4" cols="50"></textarea>';
                    echo '<input type="hidden" name="userid" value="'.$display[$i]['userid'].'">';
                    echo '<input type="hidden" name="imagenu" value="'.$display[$i]['num'].'">';
                    echo '<button class ="b_comment" type="submit" value="comment" id="'.$display[$i]['num'].'" name="submit">comment</button></form></div>';
                    unset($holds);
                }
                echo '</div>';
                $i++;
            }
            unset($hold); 
        ?>

    <script>
        function displays($val, $datess)
        {
            document.getElementById($val).style.display = "initial";
            document.getElementById($datess).style.display = "none";
        }
    </script>
    </div>  
        <form action="" method="POST">
            <?php
                for ($i = 1; $i <= $numlinks; $i++){
                    ?>
                    <input type="submit" value= "<?php echo $i;?>" name = "page">
                    <?php
                }?>
        </form>
        <?php
            include ('./footer/footer.php'); 
        ?>  
       
</body>
</html>