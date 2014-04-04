<?php

if(! isset(Yii::app()->getDb()->tablePrefix)) {
    Yii::app()->getDb()->tablePrefix = '';
};

class m140102_100716_create_salaries_table extends CDbMigration
{
	public function up()
	{
        echo "Create 'salaries' table and FK to users and workers tables.\n";
        $this->createTable('{{salaries}}', array(
            'id'=>'pk',
            'creator_id'=>'integer',
            'worker_id'=>'integer',
            'amount'=>'integer',
            'comment'=>'text',
            'date'=>'date',
            'is_active'=>'TINYINT(1) DEFAULT 0'
        ), 'ENGINE InnoDB');
        $this->addForeignKey('FK_salaries__creator_id_2_users__id',
            '{{salaries}}', 'creator_id',
            '{{users}}', 'id',
            'CASCADE', 'NO ACTION');
        $this->addForeignKey('FK_salaries__worker_id_2_workers__id',
            '{{salaries}}', 'worker_id',
            '{{workers}}', 'id',
            'CASCADE', 'NO ACTION');
    }

	public function down()
	{
		$this->dropForeignKey('FK_salaries__creator_id_2_users__id', '{{salaries}}');
		$this->dropForeignKey('FK_salaries__worker_id_2_workers__id', '{{salaries}}');
        $this->dropTable('{{salaries}}');
	}
}