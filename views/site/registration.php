<h1>Регистрация</h1>

<!-- Открываем форму !-->
<?=CHtml::form(); ?>
<!-- То самое место где будут выводиться ошибки
если они будут при валидации !-->
<?=CHtml::errorSummary($model); ?><br>

<table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
    <tr>
        <!-- Выводим поле для логина !-->
        <td width="150"><?=CHtml::activeLabel($model, 'email'); ?></td>
        <td><?=CHtml::activeTextField($model, 'email') ?></td>
    </tr>
    <tr>
        <!-- Выводим поле для пароля !-->
        <td><?=CHtml::activeLabel($model, 'password'); ?></td>
        <td><?=CHtml::activePasswordField($model, 'password') ?></td>
    </tr>
    <tr>
        <!-- Выводим поле для ника !-->
        <td width="150"><?=CHtml::activeLabel($model, 'nick'); ?></td>
        <td><?=CHtml::activeTextField($model, 'nick') ?></td>
    </tr>
    <tr>
        <td></td>
        <!-- Кнопка "регистрация" !-->
        <td><?=CHtml::submitButton('Регистрация', array('id' => "submit")); ?></td>
    </tr>
</table>

<!-- Закрываем форму !-->
<?=CHtml::endForm(); ?>