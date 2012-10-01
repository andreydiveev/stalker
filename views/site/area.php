<b>Игроки:<b/><br/>
<?php foreach($area->getAliveUsers() as $player):?>
    <?php if($player->id == Yii::app()->user->id){continue;}?>
    [<a href="/profile/<?=$player->id;?>"><?php echo $player->nick;?></a>] <a href="/fight/attack/<?=$player->id;?>">Атаковать</a> <br/>
<?php endforeach;?>
<br/><br/>

<?php foreach($area->zone->areas as $a):?>
    <?php if($area->id == $a->id){continue;}?>
    <a href="/site/area/<?=$a->id;?>"><?php echo $a->name;?></a><br/>
<?php endforeach;?>