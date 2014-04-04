<?php
class User extends Model
{
    public $pass_dup;

    public function setPass($pass)
    {
        $this->hash = $this->hashPassword($pass);
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{users}}';
	}

	public function rules()
	{
		return array(
			array('login, hash', 'required'),
			array('login', 'unique'),
			array('login', 'length', 'max'=>50),
			array('hash', 'length', 'max'=>32),
			array('id, login, hash', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'salaries' => array(self::HAS_MANY, 'Salary', 'creator_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Логин',
			'hash' => 'Хэш',
		);
	}

    public function validatePassword($password)
    {
        return $this->hash ==$this->hashPassword($password);
    }

    public function hashPassword($password)
    {
        return md5(md5($password));
    }
}