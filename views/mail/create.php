<?php
/* @var $this MailController */
/* @var $model UserMessage */

$this->breadcrumbs=array(
	'User Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List UserMessage', 'url'=>array('index')),
	array('label'=>'Manage UserMessage', 'url'=>array('admin')),
);
?>

<h1>Create UserMessage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>