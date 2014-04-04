<?php

if(! isset(Yii::app()->getDb()->tablePrefix)) {
    Yii::app()->getDb()->tablePrefix = '';
};

class m140102_100636_create_workers_table extends CDbMigration
{
	public function up()
	{
        echo "Migration create workers table\n\n";
        echo "Migration create users table (id | nick | name | birthday | date_of_contract | phone | project_name | chief) \n\n";

        $this->createTable('{{workers}}', array(
            'id' => 'pk',
            'nick' => 'VARCHAR(50) NOT NULL',
            'name' => 'VARCHAR(250) NOT NULL',
            'birthday' => 'date NULL',
            'date_of_contract' => 'date NULL',
            'phone' => 'VARCHAR(250) NULL',
            'project_name' => 'VARCHAR(250) NULL',
            'chief' => 'VARCHAR(250) NULL',
        ), 'ENGINE InnoDB');
	}

	public function down()
	{
        $this->dropTable('{{workers}}');
	}
}