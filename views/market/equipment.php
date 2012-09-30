<h1><?=$item->name;?></h1>

<?php if(Yii::app()->user->hasFlash('msg')):?>
<?php echo Yii::app()->user->getFlash('msg');?><p/><p/>
<?php endif;?>
<a href="/market/buyequipment/<?=$item->id;?>">Купить</a> ($<?=$item->price;?>)