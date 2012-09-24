<?php

class m120924_162052_alter_table_user extends CDbMigration
{
	public function up()
	{
        $sql = "
            ALTER TABLE  `user` ADD  `current_area` INT NULL AFTER  `current_hp`;
        ";
        Yii::app()->db->createCommand($sql)->execute();
	}

	public function down()
	{
        $sql = "
            ALTER TABLE `user` DROP `current_area`;
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