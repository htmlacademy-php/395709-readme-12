<?php
$is_auth = rand(0, 1);
include "helpers.php";
$user_name = 'Mansur'; 
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
  $now =  date_create();
  $date  = date_diff($now, $RandomDate);
  if ( $date->format('%y') >= 1){
      return $RandomDate->format("d-M-Y");
  }
  elseif (1.25 <= ( $date->format('%m')) + ( $date->format('%d'))/31 ){
    $date = " {$date->format('%m')} " .get_noun_plural_form(
    $date->format('%m'),
        'месяц',
        'месяца',
        'месяцев'
    )." назад"; 
       return $date;
  }
  elseif (7 <= (( $date->format('%m'))*31 + $date->format('%d'))){
    $floored = floor(( $date->format('%d'))/7); 
    $date = "{$floored} " .get_noun_plural_form(
    (floor(( $date->format('%d'))/7)),
        'неделю',
        'недели',
        'недель'
         )." назад";
      return $date;
  }
  elseif((1 <=  $date->format('%d')) ){
    $date = " {$date->format('%d')} " .get_noun_plural_form(
    $date->format('%d'),
        'день',
        'дня',
        'дней'
         )." назад"; 
     return $date;
  }
  elseif(1 <=  $date->format('%h') ){
    $date = " {$date->format('%h')} " .get_noun_plural_form(
    $date->format('%h'),
        'час',
        'часа',
        'часов'
         )." назад";
     return $date;
  }
  else {
    $date = " {$date->format('%i')} " .get_noun_plural_form(
    $date->format('%i'),
       'минута',
       'минуты',
       'минут'
     )." назад"; 
      return $date;
  }
}
    require('data.php');
    $page_content = include_template('main.php', ['posts' => $posts]);
    $layout_content = include_template('layout.php', ['content' => $page_content, 'title' => 'Blog' , 'user_name' => $user_name]);
    print($layout_content);        
?>