<h1>Новый бот</h1>

<!-- Открываем форму !-->
<?=CHtml::form(); ?>

<h3><?=Yii::app()->session['nick'];?></h3>
<h3><?=Yii::app()->session['pass'];?></h3>

<table id="form2" border="0" width="400" cellpadding="10" cellspacing="10">
    <tr>
        <!-- Выводим поле для логина !-->
        <td width="150">nick</td>
        <td><?=CHtml::textField('setup[nick]') ?></td>
    </tr>
    <tr>
        <!-- Выводим поле для пароля2 !-->
        <td>pass</td>
        <td><?=CHtml::passwordField('setup[pass]') ?></td>
    </tr>
    <tr>
        <!-- Выводим поле для логина !-->
        <td width="150">level</td>
        <td><?=CHtml::textField('setup[lvl]') ?></td>
    </tr>
    <tr>
        <td></td>
        <!-- Кнопка "регистрация" !-->
        <td><?=CHtml::submitButton('Регистрация', array('id' => "submit")); ?></td>
    </tr>
</table>

<!-- Закрываем форму !-->
<?=CHtml::endForm(); ?>