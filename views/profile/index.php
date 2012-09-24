<?php
/* @var $this ProfileController */

$this->breadcrumbs=array(
	'Profile',
);
?>
<h1><?php echo Yii::app()->user->nick; ?></h1>


дата регистрации: <?php echo Yii::app()->user->getRegDate(); ?><br/>
отряд: <?php echo Yii::app()->user->getSquad(); ?><br/>
уровень: <?php echo Yii::app()->user->getLevel(); ?><br/>
текущее здоровье :<?php echo Yii::app()->user->getCurrentHp(); ?><br/>
опыт: <?php echo Yii::app()->user->getExpo(); ?><br/>
фраги: <?php echo Yii::app()->user->getFrag(); ?><br/>
общее время игры: <?php echo Yii::app()->user->getTotalTime(); ?><br/>
<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>
