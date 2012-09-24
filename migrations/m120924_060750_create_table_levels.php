<?php

class m120924_060750_create_table_levels extends CDbMigration
{
	public function up()
	{
        $sql = "
            CREATE TABLE IF NOT EXISTS `levels` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `hp` int(11) NOT NULL,
              `max_expo` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

            --
            -- Дамп данных таблицы `levels`
            --

            INSERT INTO `levels` (`id`, `hp`, `max_expo`) VALUES
            (1, 200, 200),
            (2, 230, 400),
            (3, 265, 800),
            (4, 304, 1600),
            (5, 350, 3200),
            (6, 402, 6400),
            (7, 462, 12800),
            (8, 531, 24600),
            (9, 610, 51200),
            (10, 701, 102400);
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
            DROP TABLE  `levels`;
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