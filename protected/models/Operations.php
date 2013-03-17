<?php

/**
 * This is the model class for table "operations".
 *
 * The followings are the available columns in table 'operations':
 * @property integer $id
 * @property integer $from_account_id
 * @property integer $to_account_id
 * @property integer $summ
 * @property string $title
 * @property string $date
 *
 * @property Accounts $from_account
 * @property Accounts $to_account
 */
class Operations extends CActiveRecord {
	public $date_str;
	public $time_str;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Operations the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'operations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('from_account_id, to_account_id, summ, title, date', 'required'),
			array('from_account_id, to_account_id, summ', 'numerical'),
			array('title', 'length', 'max'=>255),
			array('date_str','match','pattern'=>'#^\d{4,4}-\d\d\-\d\d$#','message'=>'Неверный формат даты'),
			array('time_str ','match','pattern'=>'#^\d\d:\d\d(:\d\d)?$#','message'=>'Неверный формат времени'),
			array('id, from_account_id, to_account_id, summ, title, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'from_account'=>array(
				CActiveRecord::BELONGS_TO,'Accounts','from_account_id'
			),
			'to_account'=>array(
				CActiveRecord::BELONGS_TO,'Accounts','to_account_id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'from_account_id'=>'Со счёта',
			'to_account_id'=>'На счёт',
			'summ' => 'Сумма',
			'title' => 'Описание',
			'date' => 'Дата операции',
			'date_str' => 'Дата операции',
			'time_str' => 'Время операции'
		);
	}

	/**
	 * Переформатирует поля даты времени, если они были заполнены
	 * @return bool|void
	 */
	public function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				if($this->date_str!='') {
					if($this->time_str!='') {
						$this->date=date('Y-m-d H:i:s',strtotime($this->date_str.' '.$this->time_str));
					} else {
						$this->date=date('Y-m-d H:i:s',strtotime($this->date_str.' 12:00'));
					}
				} else {
					$this->date=date('Y-m-d H:i:s');
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('from_account_id',$this->from_account_id);
		$criteria->compare('summ',$this->summ);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}