<?php
/* @var $this MailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Messages',
);

$this->menu=array(
	array('label'=>'Входящие', 'url'=>array('/mail/incoming')),
	array('label'=>'Отправленные', 'url'=>array('/mail/outgoing')),
);
?>

<h1>User Messages</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
)); ?>
