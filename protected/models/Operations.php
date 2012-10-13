<?php

/**
 * This is the model class for table "operations".
 *
 * The followings are the available columns in table 'operations':
 * @property integer $id
 * @property integer $account_id
 * @property integer $summ
 * @property string $title
 * @property string $date
 */
class Operations extends CActiveRecord {
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_account_id, to_account_id, summ, title, date', 'required'),
			array('from_account_id, to_account_id, summ', 'numerical'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_account_id, to_account_id, summ, title, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
            'account'=>array(
                CActiveRecord::BELONGS_TO,'Accounts','to_account_id'
            )
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
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('summ',$this->summ);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}