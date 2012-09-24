<?php

class m120924_055733_create_table_area extends CDbMigration
{
	public function up()
	{
        $sql = "
	        CREATE TABLE IF NOT EXISTS `area` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `zone_id` int(11) NOT NULL,
              `name` varchar(128) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `zone_id` (`zone_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

            --
            -- Дамп данных таблицы `area`
            --

            INSERT INTO `area` (`id`, `zone_id`, `name`) VALUES
            (1, 1, 'район первы'),
            (2, 1, 'район второ'),
            (3, 2, 'район первый второй зоны'),
            (4, 2, 'районй воторй второй хзоны'),
            (5, 1, 'третий');

            --
            -- Ограничения внешнего ключа сохраненных таблиц
            --

            --
            -- Ограничения внешнего ключа таблицы `area`
            --
            ALTER TABLE `area`
              ADD CONSTRAINT `area_ibfk_1` FOREIGN KEY (`zone_id`) REFERENCES `zone` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	    ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
	          ALTER TABLE  `area` DROP FOREIGN KEY  `area_ibfk_1` ;
	          DROP TABLE  `area`;
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