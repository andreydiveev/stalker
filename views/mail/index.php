<?php
/* @var $this MailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'User Messages',
);

$this->menu=array(
	array('label'=>'Create UserMessage', 'url'=>array('create')),
	array('label'=>'Manage UserMessage', 'url'=>array('admin')),
);
?>

<h1>User Messages</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
