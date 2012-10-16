<?php
/* @var $this MailController */
/* @var $model UserMessage */

($model->sender->id == Yii::app()->user->id)?$incoming = false:$incoming = true;

$this->breadcrumbs=array(
    'Почта' => array('index'),
	($incoming)?'Входящие':'Отправленные' => ($incoming)?array('incoming'):array('outgoing'),
    date('d.m.Y H:i:s', CHtml::encode($model->date)),
);

$this->menu=array(
    array('label'=>'Входящие', 'url'=>array('/mail/incoming')),
    array('label'=>'Отправленные', 'url'=>array('/mail/outgoing')),
    array('label'=>'Удалить', 'url'=>array('/mail/delete/'.$model->id)),
);


($incoming)?array_push($this->menu, array('label'=>'Ответить', 'url'=>array('/mail/to/'.$model->sender->id))):'';
?>

<h1>View UserMessage #<?php echo $model->id; ?></h1>

<div class="view">
    <?php echo (($incoming)?'from ':'to ') . CHtml::link(
        CHtml::encode(($incoming)?$model->taker->nick:$model->sender->nick),
        array('view', 'id'=>$model->id)
    ); ?>
    <br />

    <?php echo CHtml::encode($model->text); ?>
    <br />


</div>
