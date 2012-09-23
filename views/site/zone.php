<?php foreach($zone as $z):?>
    <a href="/site/zone/<?=$z->id?>"><?php echo $z->name;?></a><br/>
<?php endforeach;?>