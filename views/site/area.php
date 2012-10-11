<?php if(Yii::app()->user->hasFlash('fighting')){
    echo '<p style="color:red;font-weight:bold;">'.Yii::app()->user->getFlash('fighting').'<p/>';
}?>

<b>Игроки:<b/><br/>
<?php foreach($area->getAliveUsers() as $player):?>
    <?php if($player->id == Yii::app()->user->id){continue;}?>
    [<a href="/profile/public/<?=$player->id;?>"><?php echo $player->nick;?></a>]

    <? if($player->getArmed()->count > 0):?>
        Атаковать
        <? foreach(Yii::app()->user->getArmed()->userArms as $userArms):?>
            [<a href="/fight/attack/<?=$player->id;?>?weapon_type=<?=$userArms->arms->type_id;?>">
                <?=$userArms->arms->type->single_name;?>
            </a> (<?=$userArms->getShotTimeRemaining();?>)]
        <? endforeach;?>
    <? endif;?>

    (<?=$player->getHp()+$player->getArmor()?> / <?=$player->getHp()+$player->getArmor();?>)<br/>

<?php endforeach;?>
<br/><br/>


<?php $this->widget('LogWidget'); ?>

<?php foreach($area->zone->areas as $a):?>
    <?php if($area->id == $a->id){continue;}?>
    <a href="/site/area/<?=$a->id;?>"><?php echo $a->name;?></a><br/>
<?php endforeach;?>