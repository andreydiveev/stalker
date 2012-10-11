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

<?php if(Yii::app()->user->checkAlive() == 1): ?>
    <span style="color:green;font-weight:bold;">жив</span>
    <p/><p/>
<?php else:?>
    <span style="color:red;font-weight:bold;">мертв</span>
    <a href="/profile/rise">[восстановиться]</a><p/><p/>
<?php endif;?>

здоровье: <?php echo Yii::app()->user->getCurrentHp(); ?> / <?php echo Yii::app()->user->getCurrentHp(); ?><br/>
урон: <?php echo Yii::app()->user->getDamage(UserArms::KNIFE_TYPE_ID)->value; ?> / <?php echo Yii::app()->user->getDamage(UserArms::PISTOL_TYPE_ID)->value; ?>  / <?php echo Yii::app()->user->getDamage(UserArms::MACHINE_GUN_TYPE_ID)->value; ?><br/>
дата регистрации: <?php echo date('<b>d.m.Y</b> H:i:s', Yii::app()->user->getRegDate()); ?><br/>
отряд: <?php echo Yii::app()->user->getSquad(); ?><br/>
уровень: <?php echo Yii::app()->user->getLevel(); ?><br/>
опыт: <?php echo Yii::app()->user->getExpo(); ?><br/>
фраги: <?php echo Yii::app()->user->getFrag(); ?><br/>
общее время игры: <?php echo Yii::app()->user->getTotalTime(); ?><br/>
деньги: <b><?php echo Yii::app()->user->getCash(); ?></b><br/>
<p/>


<h3>Оружие:</h3>
<?php foreach (Yii::app()->user->getArms() as $userArms):?>
    <?php echo $userArms->arms->name;?>

    <?php if($userArms->armed == 1): ?>
        <b><a href="/profile/takeoffarms/<?=$userArms->id;?>">[в рюкзак]</a></b>
    <?php else:?>
        <a href="/profile/setarms/<?=$userArms->id;?>">[надеть]</a>
    <?php endif;?>

    <a href="/profile/sellarms/<?=$userArms->id;?>">[продать]</a>
    <i>(за $<?=$userArms->getPriceWithTax()?>)</i>
    <br/>
<?php endforeach; ?>

<p/>
<h3>Снаряжение:</h3>
<?php foreach (Yii::app()->user->getEquipments() as $userEquipment):?>
    <?php echo $userEquipment->equipment->name;?>

    <?php if($userEquipment->equipped == 1): ?>
        <b><a href="/profile/takeoffequipment/<?=$userEquipment->id;?>">[в рюкзак]</a></b>
        <?php else:?>
        <a href="/profile/setequipment/<?=$userEquipment->id;?>">[надеть]</a>
    <?php endif;?>

    <a href="/profile/sellequipment/<?=$userEquipment->id;?>">[продать]</a>
    <i>(за $<?=$userEquipment->getPriceWithTax()?>)</i>
    <br/>
<?php endforeach; ?>
