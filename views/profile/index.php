<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
	'Profile',
);
?>
<h1><?php echo Yii::app()->user->nick; ?></h1>

<?php if(Yii::app()->user->hasFlash('msg')):?>
    <?php echo Yii::app()->user->getFlash('msg');?><p/><p/>
<?php endif;?>

дата регистрации: <?php echo Yii::app()->user->getRegDate(); ?><br/>
отряд: <?php echo Yii::app()->user->getSquad(); ?><br/>
уровень: <?php echo Yii::app()->user->getLevel(); ?><br/>
текущее здоровье :<?php echo Yii::app()->user->getCurrentHp(); ?><br/>
опыт: <?php echo Yii::app()->user->getExpo(); ?><br/>
фраги: <?php echo Yii::app()->user->getFrag(); ?><br/>
общее время игры: <?php echo Yii::app()->user->getTotalTime(); ?><br/>
деньги: <b><?php echo Yii::app()->user->getCash(); ?></b><br/>
<p/>


<h3>Оружие:</h3>
<?php foreach (Yii::app()->user->getArms() as $userArms):?>
    <?php echo $userArms->arms->name;?>
        <a href="/profile/sellarms/<?=$userArms->id;?>">[продать]</a>
        <i>(за $<?=$userArms->getPriceWithTax()?>)</i>
    <br/>
<?php endforeach; ?>

<p/>
<h3>Снаряжение:</h3>
<?php foreach (Yii::app()->user->getEquipments() as $userEquipment):?>
<?php echo $userEquipment->equipment->name;?>
<a href="/profile/sellequipment/<?=$userEquipment->id;?>">[продать]</a>
<i>(за $<?=$userEquipment->getPriceWithTax()?>)</i>
<br/>
<?php endforeach; ?>
