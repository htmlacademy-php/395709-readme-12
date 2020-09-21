<?php
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
            if($errors['login']==null && $errors['password']==null) {
                $hash = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT  password  from users WHERE login ='%s'", htmlspecialchars($_POST['login']))), MYSQLI_ASSOC);
                $photo = mysqli_fetch_all(mysqli_query($con, sprintf("SELECT  avatar  from users WHERE login ='%s'", htmlspecialchars($_POST['login']))), MYSQLI_ASSOC);
                if(!empty($hash)) {
                    if (password_verify(htmlspecialchars($_POST['password']), $hash[0]["password"])) {
                        session_start();
                        $_SESSION['userName'] = htmlspecialchars($_POST['login']);
                        $_SESSION['avatar'] = $photo[0]['avatar']==NULL ? 'img/userpic-medium.jpg' : $photo[0]['avatar'];
                    }
                    else {
                        $errors["password"] = "Неверный пароль";
                    }

                }
                else{
                    $errors["login"] = "Неверный логин";
                }

            }
        }

        if(isset($_SESSION)){
            header("Location: http://395709-readme-12/templates/feed.php");
        }
        else {
            print(include_template('authorization.php', ['con' => $con, 'errors' => $errors]));
        }



?>
