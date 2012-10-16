<?php
/* @var $this MailController */
/* @var $data UserMessage */
?>

<div class="view">
    <?php ($data->sender->id == Yii::app()->user->id)?$incoming = false:$incoming = true; ?>
	<?php echo (($incoming)?'from ':'to ') . CHtml::link(
        CHtml::encode(($incoming)?$data->taker->nick:$data->sender->nick),
        array('view', 'id'=>$data->id)
    ); ?>
    <?php echo date('<b>d.m.Y</b> H:i:s', CHtml::encode($data->date)); ?>
	<br />

	<?php echo Collection::cutString(CHtml::encode($data->text),20); ?>
	<br />


</div>