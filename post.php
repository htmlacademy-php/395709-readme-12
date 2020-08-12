<?php 
include "helpers.php";

if (isset($_GET['id'])) {
    $id = $_GET['id']; 
   
 } 
else {
    $id = 0;
}
$con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
mysqli_set_charset($con, "utf8");
$sql = "SELECT  title  from content_type";
$result = mysqli_query($con, $sql);
$rowsType = mysqli_fetch_all($result, MYSQLI_ASSOC);
$sqlPost = "SELECT p.id, p.title, login, p.title,  conT.icon_name, p.avatar, p.content, p.views, p.typeID FROM posts p JOIN users u ON p.authorId = u.id JOIN content_type conT ON typeID = conT.id WHERE p.id = $id ORDER BY views DESC;";
$resultPosts = mysqli_query($con, $sqlPost);
$rowsPosts = mysqli_fetch_all($resultPosts, MYSQLI_ASSOC);
$page_content = include_template('post-details.php', ['posts' => $rowsPosts, 'con' =>$con, 'id' => $id ]);
 print($page_content);
?>
