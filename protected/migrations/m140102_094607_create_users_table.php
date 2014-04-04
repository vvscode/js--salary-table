<?php

if(! isset(Yii::app()->getDb()->tablePrefix)) {
    Yii::app()->getDb()->tablePrefix = '';
};


class m140102_094607_create_users_table extends CDbMigration
{
	public function up()
	{
        echo "Migration create users table (id | login | hash) \n\n";
        $this->createTable('{{users}}', array(
            'id' => 'pk',
            'login' => 'VARCHAR(50) NOT NULL',
            'hash' => 'VARCHAR(32) NOT NULL',
        ), 'ENGINE InnoDB');
	}

	public function down()
	{
        $this->dropTable('{{users}}');
	}
}