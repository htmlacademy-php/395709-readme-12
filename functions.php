<?php
function text_split($text, $lenght = 300) {
    if (mb_strlen($text, 'utf8') > $lenght){
        $words = explode(" ", $text);
        $len = mb_strlen($words[0], 'utf8' );
        $i= 0;
        while ($len < $lenght) {
            $str[] = $words[$i];
            $len = $len + mb_strlen($words[$i+1], 'utf8' );
            $i = $i + 1;
        }
        $str = implode(" ",$str);
        $str = $str.'...';
        $read = '<div class="post-text__more-link-wrapper">
                     <a class="post-text__more-link" href="#">Читать далее</a>
                </div>';
        return $str . $read;
    }

    return $text;
}

function DateFormat($index){
  $RandomDate = date_create(generate_random_date($index));
  $date  = date_diff(new DateTime(), $RandomDate);
  if ( $date->format('%y') >= 1){
      return $RandomDate->format("d-M-Y");
  }
  elseif (1.25 <= ((int)$date->format('%m')) + ($date->format('%d'))/31 ){
    return seePlural($date ->format('%m'), 'месяц', 'месяца', 'месяцев');
  }
  elseif (7 <= (int)$date->format('%m')*31 + (int)$date->format('%d')){
    return seePlural(floor(($date->format('%d'))/7) + (int)$date->format('%m')*4, ' неделю', 'недели', 'недель');
  }
  elseif((1 <=  $date->format('%d')) ){
     return seePlural($date->format('%d'), 'день', 'дня','дней');
  }
  elseif(1 <=  $date->format('%h') ){
     return seePlural( $date->format('%h'), 'час', 'часа','часов');
  }
  else {
      return seePlural( $date->format('%i'), 'минута',  'минуты', 'минут');
  }
}

function seePlural($str, $one, $two, $many, $ending = ' назад'){
    return $str. ' '.get_noun_plural_form($str, $one, $two, $many) . $ending;
}

 function SqlRequest($reques, $from, $where, $con,$id, $as = '', $join =""){
    $sql = sprintf("SELECT  %s %s  from %s %s WHERE %s %s", $reques, $as, $from,$join, $where, $id);
    $result = mysqli_query($con, $sql);
    $Count = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // $res= $Count[0];
     return $Count;
 }

 function SQLINSERT($into, $values,$con){
    $sql = sprintf("INSERT INTO %s VALUES (%s)", $into, $values );
    $result = mysqli_query($con, $sql);
    return $result;
 }




 function getPostVal($name) {
    return $_POST[$name] ?? "";
}

function validateTag($tagValidation){
    if($tagValidation!='')
    {
        if (strpos($tagValidation, '.') || strpos($tagValidation, ',')){
            return 'Недопустимый символ';
        }
        else{
            return;
        }

    }
    else{
        return ;
    }

}

function validateVideo(){
    if(isset($_POST['Video-link']))
    {
        if($_POST['Video-link']!=''){
            if (!filter_var($_POST['Video-link'], FILTER_VALIDATE_URL) ){
                return  'Неправильная ссылка';
            }
            else{
                if (check_youtube_url($_POST['Video-link'])!=1){
                         return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
                 }
                else{
                    return ;
                }
            }
        }
        else {

            return;
        }

    }
}


function photoValidation(){
    if(isset($_FILES['userpic-file-photo']['name']) && isset($_POST['photo-link']) ){
        if($_FILES['userpic-file-photo']['name']!=''){
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = $_FILES['userpic-file-photo']['tmp_name'];
            $file_type = finfo_file($finfo, $file_name);
            $extension = array("image/gif", "image/png", "image/jpeg");
            if (!in_array($file_type, $extension)){
                return 'Неверный формат';
            }
           else{
               return ;
           }
        }
        else{
            return "Поле не заполнено";
        }

    }

}


function validatePhotoLink(){
    if(isset($_POST['photo-link'])) {

        if ($_POST['photo-link']!=''){
            if (!filter_var($_POST['photo-link'], FILTER_VALIDATE_URL) ){
                return 'Неправильная ссылка';
            }
            $content = file_get_contents($_POST['photo-link']);
            $extension = explode(".",   $_POST['photo-link']);
            $extension = end($extension);
            $checkExtension = array("gif", "png", "jpeg");
            if (!in_array($extension, $checkExtension)){
                    return 'Неверный формат';
                }
            else{
                return;
            }
        }
        else {
            return 'Не заполненное поле';
        }

    }
}

function IsEmailExist($con,$email){
    if ($email!='') {
        $sql = sprintf("SELECT  email  from users where email = '%s'",htmlspecialchars($email));
        if(mysqli_fetch_all(mysqli_query($con, $sql))){
            return " Данный email уже используется";
        }
    }
    else{
        return;
    }
}

function EmailValidation($email){
    if(isset($email)) {
        if ($email!='') {
            if (filter_input(INPUT_POST, $email, FILTER_VALIDATE_EMAIL)) {
                return "Введите корректный email";
            }
        }
        else{
            return "Поле не заполнено";
        }
    }
}

function comparePassword(){
    if (!($_POST['password'] == $_POST['password-repeat'] and $_POST['password'] != "")) {
        return "Пaроли не совпадают";
    }
    else{
        return;
    }
}


function typeRequest($id){
    $params = $_GET;
    $params['id'] = $id;
    $query = http_build_query($params);
    $url = "http://395709-readme-12/" . "?" . $query;
    return $url;
}

//function getConnectDb(){
//    static $db = mysqli_connect("395709-readme-12", "root", "root", "Blog");
//    return $db;
//}




?>
