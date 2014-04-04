<?php

class m140120_113024_add_soft_delete extends CDbMigration
{
	public function up()
	{
        echo 'Add deleted column at {{users}}';
        $this->addColumn('{{users}}', 'deleted', 'TINYINT(1) DEFAULT 0');
        echo 'Add deleted column at {{workers}}';
        $this->addColumn('{{workers}}', 'deleted', 'TINYINT(1) DEFAULT 0');
        echo 'Add deleted column at {{salaries}}';
        $this->addColumn('{{salaries}}', 'deleted', 'TINYINT(1) DEFAULT 0');
	}

	public function down()
	{
        echo 'Drop deleted column at {{users}}';
        $this->dropColumn('{{users}}', 'deleted');
        echo 'Drop deleted column at {{workers}}';
        $this->dropColumn('{{workers}}', 'deleted');
        echo 'Drop deleted column at {{salaries}}';
        $this->dropColumn('{{salaries}}', 'deleted');
		return true;
	}
}