<?php

class m120924_054601_create_table_user_arms extends CDbMigration
{
	public function up()
	{
        $sql = "
            CREATE TABLE IF NOT EXISTS `user_arms` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
              `arms_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_id` (`user_id`,`arms_id`),
              UNIQUE KEY `arms_id` (`arms_id`,`user_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

            --
            -- Ограничения внешнего ключа сохраненных таблиц
            --

            --
            -- Ограничения внешнего ключа таблицы `user_arms`
                    --
            ALTER TABLE `user_arms`
              ADD CONSTRAINT `user_arms_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              ADD CONSTRAINT `user_arms_ibfk_1` FOREIGN KEY (`arms_id`) REFERENCES `arms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
          ALTER TABLE  `user_arms` DROP FOREIGN KEY  `user_arms_ibfk_1` ;
          ALTER TABLE  `user_arms` DROP FOREIGN KEY  `user_arms_ibfk_2` ;
          DROP TABLE `user_arms`;
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