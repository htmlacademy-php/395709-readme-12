<?php
$sql = "SELECT  * from subscription where userId =".mysqli_real_escape_string($con, $userId)."  AND authorId =".mysqli_real_escape_string($con, $subscription);
if (empty(mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC))) {
    SqlInsert("subscription(authorId,userId)", mysqli_real_escape_string($con, $subscription).','.mysqli_real_escape_string($con, $_SESSION['id']), $con);
    $UserInfo = SqlRequest('email, login', 'users', 'id = ', $con, mysqli_real_escape_string($con, $subscription));
    $login = $UserInfo[0]['login'];
    $email = $UserInfo[0]['email'];
    $message = (new Swift_Message("Новый подписчик."))
        ->setTo([$email => $login])
        ->setFrom("keks@phpdemo.ru", "keks")
        ->setBody("Здравствуйте, $login. На вас подписался новый пользователь ".$_SESSION['userName'].". Вот ссылка на его профиль: $url");
    $mailer->send($message);
} else {
    $sqlPost = "DELETE FROM subscription WHERE userId =".  mysqli_real_escape_string($con, $userId)."  AND authorId =". mysqli_real_escape_string($con, $subscription);
    mysqli_query($con, $sqlPost);
}
header("Location: ".$_SERVER["REQUEST_URI"]);
exit;
