<?php
/* @var $this MailController */
/* @var $data UserMessage */
?>

<div class="view">
    <?php ($data->sender->id == Yii::app()->user->id)?$incoming = false:$incoming = true; ?>

    <?php ($incoming)?$nick = $data->taker->nick:$nick = $data->sender->nick?>
    <?php $link = CHtml::link(CHtml::encode($nick),array('view', 'id'=>$data->id));?>
    <?php ($data->readed == 1)?'':$link = '<b>'.$link.'</b>';?>
    <?php echo (($incoming)?'from ':'to ') . $link; ?>
    <?php echo date('<b>d.m.Y</b> H:i:s', CHtml::encode($data->date)); ?>
	<br />

	<?php echo Collection::cutString(CHtml::encode($data->text),20); ?>
	<br />


</div>