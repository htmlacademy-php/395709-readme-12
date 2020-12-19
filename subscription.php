<?php
$sql = "SELECT  * from subscription where userId =  $userId  AND authorId = $subscription";
if (empty(mysqli_fetch_all(mysqli_query($con, $sql), MYSQLI_ASSOC))) {
    SqlInsert("subscription(authorId,userId)", $subscription.','.$_SESSION['id'], $con);
    $UserInfo = SqlRequest('email, login', 'users', 'id = ', $con, $subscription);
    $login = $UserInfo[0]['login'];
    $email = $UserInfo[0]['email'];
    $message = (new Swift_Message("Новый подписчик."))
        ->setTo([$email => $login])
        ->setFrom("keks@phpdemo.ru", "keks")
        ->setBody("Здравствуйте, $login. На вас подписался новый пользователь ".$_SESSION['userName'].". Вот ссылка на его профиль: $url");
    $mailer->send($message);

} else {
    $sqlPost = "DELETE FROM subscription WHERE userId =  $userId  AND authorId = $subscription";
    mysqli_query($con, $sqlPost);
}
header("Location: ".$_SERVER["REQUEST_URI"]);
exit;
