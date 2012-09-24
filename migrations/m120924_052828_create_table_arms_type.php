<?php

class m120924_052828_create_table_arms_type extends CDbMigration
{
	public function up()
	{
        $sql = "
            CREATE TABLE IF NOT EXISTS `arms_type` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(128) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

            --
            -- Дамп данных таблицы `arms_type`
            --

            INSERT INTO `arms_type` (`id`, `name`) VALUES
            (1, 'Холодное оружие'),
            (2, 'Легкое оружие'),
            (3, 'Тяжелое оружие');
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
            drop table `stalker`.`arms_type`;
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}