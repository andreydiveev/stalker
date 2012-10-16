<?php
/* @var $this MailController */
/* @var $model UserMessage */

$this->breadcrumbs=array(
	'Почта'=>array('index'),
	'Новое сообщение',
);

$this->menu=array(
    array('label'=>'Входящие', 'url'=>array('/mail/incoming')),
    array('label'=>'Отправленные', 'url'=>array('/mail/outgoing')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>