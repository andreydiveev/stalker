<b>Игроки:<b/><br/>
<?php foreach($area->getAliveUsers() as $player):?>
    <?php if($player->id == Yii::app()->user->id){continue;}?>
    [<a href="/profile/public/<?=$player->id;?>"><?php echo $player->nick;?></a>]

    <? if($player->getArmed()->count > 0):?>
        Атаковать
        <? foreach(Yii::app()->user->getArmed()->arms as $arms):?>
            [<a href="/fight/attack/<?=$player->id;?>?weapon_type=<?=$arms->type->id;?>"><?=$arms->type->single_name;?></a>]
        <? endforeach;?>
    <? endif;?>

    (<?=$player->getHp()+$player->getArmor()?> / <?=$player->getHp()+$player->getArmor();?>)<br/>

<?php endforeach;?>
<br/><br/>

<?php foreach($area->zone->areas as $a):?>
    <?php if($area->id == $a->id){continue;}?>
    <a href="/site/area/<?=$a->id;?>"><?php echo $a->name;?></a><br/>
<?php endforeach;?>