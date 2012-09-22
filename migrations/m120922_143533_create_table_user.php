<?php

class m120922_143533_create_table_user extends CDbMigration
{
	public function up()
    {
	    $sql = "
	          CREATE TABLE IF NOT EXISTS `user` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `email` varchar(128) NOT NULL,
              `password` varchar(128) NOT NULL,
              `nick` varchar(20) NOT NULL,
              `reg_date` int(11) NOT NULL,
              `last_activity` int(11) NOT NULL,
              `total_time` int(11) NOT NULL DEFAULT '0',
              `frag` int(11) NOT NULL DEFAULT '0',
              `squad` int(11) DEFAULT NULL,
              `expo` int(11) NOT NULL DEFAULT '0',
              `level` int(11) NOT NULL DEFAULT '0',
              `current_hp` int(11) NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	    ";
        Yii::app()->db->createCommand($sql)->execute();
    }

	public function down()
	{
        $sql = "
	         drop table `stalker`.`user`;
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