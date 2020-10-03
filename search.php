<?php
    session_start();
    if(isset($_SESSION['userName'])) {
        include "helpers.php";
        require('functions.php');
        $rowsPosts = [];
        $GetRequest = htmlspecialchars($_GET['request']);
        $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
        if(isset($GetRequest)){
            $request = trim($GetRequest);
            if($GetRequest[0]=='#'){
                $GetRequest = substr($GetRequest,1);
                $hashtagId = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT id FROM  hashtag WHERE MATCH(title) AGAINST('%s')",$request)), MYSQLI_ASSOC);
                $rowsPosts = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT * FROM posts WHERE id IN (SELECT postId FROM posthashtag WHERE hashtagId = %s ORDER BY creationDate DESC)",$hashtagId[0]['id'])), MYSQLI_ASSOC);
            }
            else{
                $rowsPosts = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT * FROM  posts WHERE MATCH(title,content) AGAINST('%s') ORDER BY views DESC",$request)), MYSQLI_ASSOC);
            }
            if(empty($rowsPosts)){

                echo include_template('no-results.php',['search'=>$GetRequest]);
            }
            else{

                    echo include_template('search-results.php', ['posts' =>$rowsPosts, 'con'=>$con, 'search'=>$GetRequest]);
            }

        }
    }
?>
