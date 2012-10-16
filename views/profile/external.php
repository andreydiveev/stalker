<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
    'Profile',
);
?>
<h1><?php echo $user->nick; ?></h1>

здоровье: <?php echo $user->getHp() ?> / <?php echo $user->level_->hp + $user->getArmor(); ?><br/>
урон: <?php echo $user->getDamage(UserArms::KNIFE_TYPE_ID)->value; ?> / <?php echo $user->getDamage(UserArms::PISTOL_TYPE_ID)->value; ?>  / <?php echo $user->getDamage(UserArms::MACHINE_GUN_TYPE_ID)->value; ?><br/>
дата регистрации: <?php echo date('<b>d.m.Y</b> H:i:s', $user->reg_date); ?><br/>
отряд: <?php echo $user->squad; ?><br/>
уровень: <?php echo $user->level; ?><br/>
опыт: <?php echo $user->expo; ?><br/>
фраги: <?php echo $user->frag; ?><br/>
общее время игры: <?php echo $user->total_time; ?><br/>
<p/>

<a href="/mail/to/<?=$user->id;?>">Отправить сообщение</a>

<h3>Оружие:</h3>
<?php foreach ($user->userArms as $userArms):?>
    <?php echo $userArms->arms->name;?><br/>
<?php endforeach; ?>
<p/>

<h3>Снаряжение:</h3>
<?php foreach ($user->userEquipments as $userEquipment):?>
    <?php echo $userEquipment->equipment->name;?><br/>
<?php endforeach; ?>
