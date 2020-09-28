<?php
    session_start();
    include "helpers.php";
    require("functions.php");
    $errors = [];
    $con =[];
    $con = mysqli_connect("395709-readme-12", "root", "root", "Blog");
    mysqli_set_charset($con, "utf8");
    if(isset($_POST['Send'])) {
            $required_fields = explode(" ", htmlspecialchars($_POST['Send']));
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = 'Поле не заполнено';
                } else {
                    $errors[$field] = NULL;
                }
            }

            if(is_null($errors['login']) && is_null($errors['password'])) {
                $UserData = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT  password, avatar  from users WHERE login ='%s'", htmlspecialchars($_POST['login']))), MYSQLI_ASSOC);
                if(!empty($UserData[0]['password'])) {
                    if (password_verify(htmlspecialchars($_POST['password']), $UserData[0]['password'])) {
                        $_SESSION['userName'] = htmlspecialchars($_POST['login']);
                        $_SESSION['avatar'] = is_null($UserData[0]['avatar']) ? 'img/userpic-medium.jpg' : $UserData[0]['avatar'];
                    }
                    else {
                        $errors["password"] = " Неверный логин или пароль";
                    }

                }
                else{
                    $errors["login"] = "Неверный логин или пароль";
                }

            }
        }

        if(isset($_SESSION['userName'])){
            header("Location: http://395709-readme-12/templates/feed.php");
//            echo include_template('feed.php');
        }
        else {
           echo include_template('authorization.php', ['con' => $con, 'errors' => $errors]);
        }



?>
