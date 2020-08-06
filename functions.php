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
?>