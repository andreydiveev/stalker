

<?php foreach($items as $i):?>
<a href="<?=$path?><?=$i->id;?>"><?=$i->name;?></a> ($<?=$i->price;?>)<br/>
<?php endforeach;?>
