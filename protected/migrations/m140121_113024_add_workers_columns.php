<?php
class m140121_113024_add_workers_columns extends CDbMigration
{
    public function up()
    {
        echo 'Add order_num column to {{workers}}';
        $this->addColumn('{{workers}}', 'employee_num', 'integer DEFAULT 0');
        echo 'Add date_of_employment column to {{workers}}';
        $this->addColumn('{{workers}}', 'date_of_employment', 'date NULL');
    }

    public function down()
    {
        $this->dropColumn('{{workers}}', 'employee_num');
        $this->dropColumn('{{workers}}', 'date_of_employment');
        return true;
    }
}