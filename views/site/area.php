<?php if(Yii::app()->user->hasFlash('fighting')){
    echo '<p style="color:red;font-weight:bold;">'.Yii::app()->user->getFlash('fighting').'<p/>';
}?>

<?=Yii::app()->session['trace'];?>

<b>Игроки:<b/><br/>
<?php foreach($area->getAliveUsers() as $player):?>
    <?php if($player->id == Yii::app()->user->id){continue;}?>
    [<a href="/profile/id/<?=$player->id;?>"><?php echo $player->nick;?></a>]

    <? if(Yii::app()->user->getArmed()->count > 0):?>
        Атаковать
        <? foreach(Yii::app()->user->getArmed()->userArms as $userArms):?>
            [<a href="/fight/attack/<?=$player->id;?>?weapon_type=<?=$userArms->arms->type_id;?>">
                <?=$userArms->arms->type->single_name;?>
            </a> (<?=$userArms->getShotTimeRemaining();?>)]
        <? endforeach;?>
    <? endif;?>

    (<?=$player->getHp()+$player->getArmor()?> / <?=$player->getLevel()->hp+$player->getArmor();?>)<br/>

<?php endforeach;?>
<br/><br/>

<p><b>Мобы:</b><br/>
<?php foreach($area->loadMobs() as $mob):?>
    [<a href="#<?=$mob->id;?>"><?=$mob->name;?></a>]

    <? if(Yii::app()->user->getArmed()->count > 0):?>
        Атаковать
        <? foreach(Yii::app()->user->getArmed()->userArms as $userArms):?>
            [<a href="/fight/attackmob/<?=$mob->id;?>?weapon_type=<?=$userArms->arms->type_id;?>">
                <?=$userArms->arms->type->single_name;?>
            </a> (<?=$userArms->getShotTimeRemaining();?>)]
        <? endforeach;?>
    <? endif;?>

    (<?=$mob->getHp()?> / <?=$mob->type->level_->hp;?>)<br/>
<?php endforeach;?>
</p>


<?php $this->widget('LogWidget'); ?>

<?php foreach($area->zone->areas as $a):?>
    <?php if($area->id == $a->id){continue;}?>
    <a href="/site/area/<?=$a->id;?>"><?php echo $a->name;?></a><br/>
<?php endforeach;?>