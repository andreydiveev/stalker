<?php

class m120924_055245_create_table_user_equipment extends CDbMigration
{
	public function up()
	{
        $sql = "
	        CREATE TABLE IF NOT EXISTS `user_equipment` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `user_id` int(11) NOT NULL,
              `euipment_id` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_id` (`user_id`,`euipment_id`),
              UNIQUE KEY `euipment_id` (`euipment_id`,`user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

            --
            -- Ограничения внешнего ключа сохраненных таблиц
            --

            --
            -- Ограничения внешнего ключа таблицы `user_equipment`
            --
            ALTER TABLE `user_equipment`
              ADD CONSTRAINT `user_equipment_ibfk_2` FOREIGN KEY (`euipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `user_equipment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
	    ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
	        ALTER TABLE  `user_equipment` DROP FOREIGN KEY  `user_equipment_ibfk_1` ;
            ALTER TABLE  `user_equipment` DROP FOREIGN KEY  `user_equipment_ibfk_2` ;
            DROP TABLE  `user_equipment`;
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