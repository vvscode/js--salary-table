<?php

class Salary extends Model
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{salaries}}';
	}

    public function getAttributes(){
        $attrs =  parent::getAttributes();
        $attrs['creator'] = $this->getCreatorName();
        return $attrs;
    }

    public function getCreatorName(){
        $name = "---";
        if(!empty($this->creator)){
            $name = $this->creator->login;
        }
        return $name;
    }

    public function afterSave(){
        if($this->is_active && !$this->deleted){
            $this::model()->updateAll(
                array('is_active' =>false),
                'worker_id=:worker_id AND id<>:salary_id',
                array(
                    ':worker_id' => $this->worker_id,
                    ':salary_id' => $this->id
                )
            );
        }
    }


	public function rules()
	{
		return array(
			array('creator_id, worker_id, is_active', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('comment, date', 'safe'),
            array('date', 'date', 'format' => 'yyyy-MM-dd', 'message' => 'Проверьте формат даты'),
		);
	}

	public function relations()
	{
		return array(
			'worker' => array(self::BELONGS_TO, 'Worker', 'worker_id'),
			'creator' => array(self::BELONGS_TO, 'User', 'creator_id'),
		);
	}

    public function defaultScope()
    {
        $scope = array();
        $scope['with'] = array("creator");
        return $scope;
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'creator_id' => 'Создатель',
			'worker_id' => 'Работник',
			'amount' => 'Сумма',
			'comment' => 'Комментарий',
			'date' => 'Дата',
			'is_active' => 'Активна',
		);
	}

}