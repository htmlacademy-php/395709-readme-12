<div class="form__invalid-block">
    <b class="form__invalid-slogan">Пожалуйста, исправьте следующие ошибки:</b>
    <ul class="form__invalid-list">
        <?php $i = 0;
        foreach ($error as $er) {
            if (! empty($er)) { ?>
                <li class='form__invalid-item'> <?= $errorHeader[$i].':'.$er ?> </li>
            <?php }
            $i++;
        } ?>
    </ul>
</div>
