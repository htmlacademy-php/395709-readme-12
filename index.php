<?php
$is_auth = rand(0, 1);
include "helpers.php";
$user_name = 'Mansur'; // укажите здесь ваше имя
?>
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
?>



<?php 
    $posts = [
            [
                'title' => 'Цитата',
                'type' => 'post-quote',
                'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
                'author' => 'Лариса',
                'avatar' => 'userpic-larisa-small.jpg'
            ],
            [
                'title' => 'Игра престолов',
                'type' => 'post-text',
                'content' => 'Не могу дождаться начала финального сезона своего любимого сериала! ',
                'author' => 'Владик',
                'avatar' => 'userpic.jpg'
            ],
            [
                'title' => 'Наконец, обработал фотки!',
                'type' => 'post-photo',
                'content' => 'rock-medium.jpg',
                'author' => 'Виктор',
                'avatar' => 'userpic-mark.jpg'
            ],
            [
                'title' => 'Моя мечта',
                'type' => 'post-photo',
                'content' => 'coast-medium.jpg',
                'author' => 'Лариса',
                'avatar' => 'userpic-larisa-small.jpg'
            ],
            [
                'title' => 'Лучшие курсы',
                'type' => 'post-link',
                'content' => 'www.htmlacademy.ru',
                'author' => 'Владик',
                'avatar' => 'userpic.jpg'
            ]

        ];?>
 <?php       
    $page_content = include_template('main.php', ['posts' => $posts]);
    $layout_content = include_template('layout.php', ['content1' => $page_content, 'title' => 'Blog' , 'user_name' => $user_name]);
    print($layout_content);        
?>
   