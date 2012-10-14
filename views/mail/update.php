<?php
/* @var $this MailController */
/* @var $model UserMessage */

$this->breadcrumbs=array(
	'User Messages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserMessage', 'url'=>array('index')),
	array('label'=>'Create UserMessage', 'url'=>array('create')),
	array('label'=>'View UserMessage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserMessage', 'url'=>array('admin')),
);
?>

<h1>Update UserMessage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>