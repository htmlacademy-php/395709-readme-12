<?php
/**
 * Возвращает обрезанный до определенной длины текст
 * Пример использования:
 * text_split("Пример использования",6);
 * результат: "Пример"
 * @param string $text ваш тескст
 * @param int $lenght длина до которой хотите его сократить
 * @return string обрезанный текст
 */
function text_split($text, $lenght = 300)
{
    if (mb_strlen($text, 'utf8') > $lenght) {
        $words = explode(" ", $text);
        $len = mb_strlen($words[0], 'utf8');
        $i = 0;
        while ($len < $lenght) {
            $str[] = $words[$i];
            $len = $len + mb_strlen($words[$i + 1], 'utf8');
            $i = $i + 1;
        }
        $str = implode(" ", $str);
        $str = $str.'...';
        $read = '<div class="post-text__more-link-wrapper">
                     <a class="post-text__more-link" href="#">Читать далее</a>
                </div>';

        return $str.$read;
    }

    return $text;
}

/**
 * Возвращает разницу во времени публикации с текущим временем если задана $data
 * или рандомное значение времени если указан только индекс
 * Пример использования:
 * DateFormat("1");
 * результат: "час назад"
 * DateFormat("1",$now)
 * результат: "ноль минут назад"
 * @param int $index значение для  рандомного  значения даты
 * @param string $data значение даты, с которой хотите сравнить текущее время
 * @return data разница с текущим временем
 */

function DateFormat($index, $data = '')
{
    date_default_timezone_set('Asia/Almaty');
    $RandomDate = date_create(generate_random_date($index));
    if (! empty($data)) {
        $RandomDate = new DateTime($data);
    }
    $current_time = new DateTime();
    $date = $current_time->diff($RandomDate);

    if ($date->format('%y') >= 1) {
        return $RandomDate->format("d-M-Y");
    } elseif (1.25 <= ((int)$date->format('%m')) + ($date->format('%d')) / 31) {
        return seePlural($date->format('%m'), 'месяц', 'месяца', 'месяцев');
    } elseif (7 <= (int)$date->format('%m') * 31 + (int)$date->format('%d')) {
        return seePlural(
            floor(($date->format('%d')) / 7) + (int)$date->format('%m') * 4,
            ' неделю',
            'недели',
            'недель'
        );
    } elseif ((1 <= $date->format('%d'))) {
        return seePlural($date->format('%d'), 'день', 'дня', 'дней');
    } elseif (1 <= $date->format('%h')) {
        return seePlural($date->format('%h'), 'час', 'часа', 'часов');
    } else {
        return seePlural($date->format('%i'), 'минута', 'минуты', 'минут');
    }
}

/**
 * Вспомогательная функция, помогающая определить множественную форму существительного и объединить в предложение
 * @param string $str дата
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 * @param string $ending окончанае предложения
 * @return string
 */


function seePlural($str, $one, $two, $many, $ending = ' назад')
{
    return $str.' '.get_noun_plural_form($str, $one, $two, $many).$ending;
}


/**
 * Функция формирующая sql запрос
 * @param int $index значение для  рандомного  значения даты
 * @param string $reques столбцы которые вы хотите получить
 * @param string $from из какой таблицы
 * @param string $where условие
 * @param string $con подключение к бд
 * @param string $id для удобства при, внесении данных запроса
 * @param string $as переименовать значение полученного стобца
 * @param string $join присоединить таблицу
 * @return array  массив данных из бд
 */

function SqlRequest($reques, $from, $where, $con, $id = '', $as = '', $join = "")
{
    $sql = sprintf("SELECT  %s %s  from %s %s WHERE %s %s", $reques, $as, $from, $join, $where, $id);
    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}

/**
 * Функция формирующая sql запрос на добавление данных в бд
 * @param string $into в какую таблицу и стобцы
 * @param string $values значения, которые вы хотите добавить
 * @param string $con подключение к бд
 * @return bool  результат выполнения
 */

function SqlInsert($into, $values, $con)
{
    $sql = sprintf("INSERT INTO %s VALUES (%s)", $into, $values);
    $result = mysqli_query($con, $sql);

    return $result;
}

/**
 * Функция сохранющая значение, которое внес пользователь в поле формы, при перегрузке
 * @param string $name имя формы, в которую были внесены данные
 * @param string $con подключение к бд
 * @return string  значение внесееное пользователем
 */

function getPostVal($name, $con)
{
    return mysqli_real_escape_string($con, $_POST[$name] ?? "");
}

/**
 * Функция проводящая валидацию тегов
 * @param string $tagValidation тег, который нужно провалидировать
 * @return string   ошибка полученная при валидации
 */

function validateTag($tagValidation)
{
    if (! empty($tagValidation)) {
        if (strpos($tagValidation, '.') || strpos($tagValidation, ',')) {
            return 'Недопустимый символ';
        }
    }
    return null;
}

/**
 * Функция проводящая валидацию ссылки на видео
 * @param string $tagValidation ссылка на видео
 * @return string   ошибка полученная при валидации
 */

function validateVideo($videoValidation = null)
{
    if (isset($videoValidation)) {
        if (!empty($videoValidation)) {
            if (! filter_var($_POST['Video-link'], FILTER_VALIDATE_URL)) {
                return 'Неправильная ссылка';
            }
            if (intval(check_youtube_url($videoValidation)) !== 1) {
                return "Видео по такой ссылке не найдено. Проверьте ссылку на видео";
            }
        } else {
            return 'Поле не заполнено';
        }
    }
    return null;
}

/**
 * Функция проводящая валидацию фотографии
 * @param string $photo получает картинку на вход
 * @return string   ошибка полученная при валидации
 */

function photoValidation($photo)
{
    if (isset($photo)) {
        if (! empty($_FILES['userpic-file-photo']['name'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_name = strip_tags($_FILES['userpic-file-photo']['tmp_name']);
            $file_type = finfo_file($finfo, $file_name);
            $extension = array("image/gif", "image/png", "image/jpeg");
            if (! in_array($file_type, $extension)) {
                return 'Неверный формат';
            }
        } else {
            return 'Поле не заполнено';
        }
    }
    return null;
}

/**
 * Функция проводящая валидацию ссылки на фото
 * @param string $photoLink ссылка на фото
 * @return string   ошибка полученная при валидации
 */

function validatePhotoLink($photoLink)
{
    if (isset($photoLink)) {
        if (! empty($photoLink)) {
            if (! filter_var($photoLink, FILTER_VALIDATE_URL)) {
                return 'Неправильная ссылка';
            }
            $extension = explode(".", $photoLink);
            $extension = end($extension);
            $checkExtension = array("gif", "png", "jpeg", "jpg");
            if (! in_array($extension, $checkExtension)) {
                return 'Неверный формат';
            }
        } else {
            return 'Не заполненное поле';
        }
    }
    return null;
}

/**
 * Функция проводящая валидацию ссылки
 * @param string $link ссылка
 * @return string   ошибка полученная при валидации
 */

function validateLink($link)
{
    if (! filter_var($link, FILTER_VALIDATE_URL)) {
        return 'Неправильная ссылка';
    }
    return null;
}

/**
 * Функция проверки существования пользователя с таким email
 * @param string $con подключение к бд
 * @param string $email
 * @return string   ошибка полученная при валидации
 *
 */

function IsEmailExist($con, $email)
{
    if (! empty($email)) {
        $email = mysqli_real_escape_string($con, $email);
        if (SqlRequest("email", "users", "email = ", $con, "'$email'")) {
            return " Данный email уже используется";
        }
    }
    return null;
}

/**
 * Валидация email
 * @param string $email
 * @return string   ошибка полученная при валидации
 *
 */


function EmailValidation($email)
{
    if (isset($email)) {
        if (! empty($email)) {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return "Введите корректный email";
            }
        } else {
            return "Поле не заполнено";
        }
    }
    return null;
}

/**
 * Проверка совпадения введенных паролей
 * @param string $password пароль
 * @param string $repeat повторите пароль
 * @return string   ошибка полученная при несовпадении паролей
 *
 */

function comparePassword($password, $repeat)
{
    if (! ($password === $repeat && ! empty($password))) {
        return "Пaроли не совпадают";
    }
    return  null;
}


/**
 * сортировка постов по типу
 * @param int $id тип
 * @param int $vertical для страницы feed
 * @return string  ссылка на страницу на которой только посты выбранного типа
 */

function typeRequest($id, $vertical = 0)
{
    $url = "popular.php?id=$id&offset=0&tab=popular";
    if (intval($vertical) === 1) {
        $url = "index.php?id=$id&offset=0&tab=feed";
    }
    return $url;
}

/**
 * получить список тегов для поста
 * @param string $con подключение к бд
 * @param int $id id поста
 * @return array массив тегов
 */

function getTags($con, $id)
{
    $tags = array();
    $tagsId = SqlRequest('hashtagId', 'posthashtag', 'postId =', $con, mysqli_real_escape_string($con, $id));
    foreach ($tagsId as $tag) {
        $tagLink = SqlRequest(
            'title',
            'hashtag',
            'id= ',
            $con,
            mysqli_real_escape_string($con, $tag["hashtagId"])
        );
        $title = $tagLink[0]['title'];
        array_push($tags, $title);
    }
    return $tags;
}

/**
 * получить массив данных для вывода статистики поста (like, comment ...)
 * @param string $con подключение к бд
 * @param int $id id поста
 * @return array массив данных
 */
function preparePostSatatisticDate($con, $id)
{
    $data = array();
    $like = SqlRequest('COUNT(userId)', 'likes', 'recipientId =', $con, mysqli_real_escape_string($con, $id));
    $comment = SqlRequest('COUNT(content)', 'comments', 'postId =', $con, mysqli_real_escape_string($con, $id));
    $reposts = SqlRequest("repostCount", "posts", "id = ", $con, mysqli_real_escape_string($con, $id));
    $view = SqlRequest('views', 'posts', ' id =', $con, mysqli_real_escape_string($con, $id));
    array_push($data, array(
        'like' => $like[0]['COUNT(userId)'],
        'comment' => $comment[0]['COUNT(content)'],
        'reposts' => $reposts[0]['repostCount'],
        'view' => $view[0]['views'],
    ));
    return $data;
}
