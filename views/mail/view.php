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

<div class="view">
    <?php echo ($incoming)?'from ':'to ';?>
    <?php ($incoming)?$nick = $model->sender->nick:$nick = $model->taker->nick; ?>
    <?php ($incoming)?$reply_id = $model->sender->nick:$reply_id = $model->taker->nick; ?>
    <?php echo $nick;?>
    <br />

    <?php echo CHtml::encode($model->text); ?>
    <br />
</div>

<?php echo $this->renderPartial('_form', array('model'=>$new_message)); ?>
