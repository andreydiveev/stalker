<?php

class m120924_053500_create_table_arms extends CDbMigration
{
	public function up()
	{
        $sql = "
            CREATE TABLE IF NOT EXISTS `arms` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `type_id` int(11) NOT NULL,
              `name` varchar(128) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `type_id` (`type_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

            --
            -- Дамп данных таблицы `arms`
            --

            INSERT INTO `arms` (`id`, `type_id`, `name`) VALUES
            (2, 1, 'Нож'),
            (3, 2, 'Пистолет макарова'),
            (4, 3, 'Автомат калашникова');

            --
            -- Ограничения внешнего ключа сохраненных таблиц
            --

            --
            -- Ограничения внешнего ключа таблицы `arms`
            --
            ALTER TABLE `arms`
              ADD CONSTRAINT `arms_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `arms_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
            ALTER TABLE  `arms` DROP FOREIGN KEY  `arms_ibfk_1` ;
            ALTER TABLE  `arms` DROP INDEX `type_id`;
            delete from `arms`;
            DROP TABLE `stalker`.`arms`;
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