<?php
class Worker extends Model
{

    public function getSalary(){
        $amount = "---";
        foreach($this->salaries as $salary){
            if(!$salary->deleted && $salary->is_active)
                $amount = (float)$salary->amount;
        }
        return $amount;
    }



    public function getSalaryDate(){
        $date  = null;
        foreach($this->salaries as $salary){
            if(!$salary->deleted && $salary->is_active)
                $date = $salary->date;
        }
        return $date;
    }

    public function getSalaryComment(){
        $comment = "---";
        foreach($this->salaries as $salary){
            if(!$salary->deleted && $salary->is_active)
                $comment = $salary->comment;
        }
        return $comment;
    }

    public function getAttributes(){
        $attrs =  parent::getAttributes();
        $attrs['salary'] = $this->getSalary();
        $attrs['salary_comment'] = $this->getSalaryComment();
        $attrs['salary_date'] = $this->getSalaryDate();
        return $attrs;
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{workers}}';
	}

	public function rules()
	{
		return array(
			array('nick, name', 'required'),
			array('nick', 'unique'),
			array('nick', 'length', 'max'=>50),
			array('name, phone, project_name, chief', 'length', 'max'=>250),
			array('birthday, date_of_contract', 'safe'),
            array('date_of_employment, date_of_contract, birthday', 'date', 'format' => 'yyyy-MM-dd', 'message' => 'Проверьте формат даты')
        );
	}

	public function relations()
	{
		return array(
			'salaries' => array(self::HAS_MANY, 'Salary', 'worker_id'),
		);
	}

    public function defaultScope()
    {
        $scope = array();
        $scope['with'] = array(
            "salaries"
        );
        return $scope;
    }

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee_num' => 'Табельный №',
			'nick' => 'Ник',
			'name' => 'Ф.И.О.',
			'birthday' => 'День рождения',
			'date_of_employment' => 'Дата принятия на работу',
			'date_of_contract' => 'Окончание контракта',
			'phone' => 'Телефон',
			'project_name' => 'Проект',
			'chief' => 'Руководитель',
		);
	}
}