<?php
/* @var $this MailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Почта',
);

$this->menu=array(
	array('label'=>'Входящие', 'url'=>array('/mail/incoming')),
	array('label'=>'Отправленные', 'url'=>array('/mail/outgoing')),
);
?>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
