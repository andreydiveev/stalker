<?php foreach($items as $i):?>
    <?php /**
     * @TODO add count
     */?>
    <a href="<?=$path?><?=$i->id;?>"><?=$i->name;?></a><br/>
<?php endforeach;?>