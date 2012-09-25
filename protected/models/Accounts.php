<?php

/**
 * This is the model class for table "accounts".
 *
 * The followings are the available columns in table 'accounts':
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $type
 * @property integer $summ
 * @property string $date_operation
 */
class Accounts extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Accounts the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array( array('user_id, title, type, summ', 'required'), array('user_id, summ', 'numerical', 'integerOnly'=>true), array('title', 'length', 'max'=>255), array('type', 'length', 'max'=>6), array('date_operation', 'safe'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, user_id, title, type, summ, date_operation', 'safe', 'on'=>'search'), );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array('id'=>'ID', 'user_id'=>'User', 'title'=>'Title', 'type'=>'Type', 'summ'=>'Summ', 'date_operation'=>'Date Operation', );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('user_id', $this->user_id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('type', $this->type, true);
		$criteria->compare('summ', $this->summ);
		$criteria->compare('date_operation', $this->date_operation, true);

		return new CActiveDataProvider($this, array('criteria'=>$criteria, ));
	}

	public function getTypes() {
		return array('main'=>Yii::t('accountTypes', 'main'), 'normal'=>Yii::t('accountTypes', 'normal'), 'costs'=>Yii::t('accountTypes', 'costs'));
	}
	
	public function isEnoughAmount($amount) {
		return $this->summ-$amount>0;
	}
		
	public function lowerSumm($amount) {
		$this->summ-=$amount;
		$this->date_operation=date('Y-m-d H:i:s');
		if($this->id>0)
			$this->update(array('summ','date_operation'));
	}
	
	public function raiseSumm($amount) {
		$this->summ+=$amount;
		$this->date_operation=date('Y-m-d H:i:s');
		if($this->id>0)
			$this->update(array('summ','date_operation'));
	}

	public static function getMyTo() {
		if (Yii::app()->getUser()->getId()>0) {
			$arAccounts=self::model()->findAllByAttributes(array('user_id'=>Yii::app()->getUser()->getId()));
			return $arAccounts;
		}
		return array();
	}

	public static function getMyFrom() {
		if (Yii::app()->getUser()->getId()>0) {
			$arAccounts=self::model()->findAllByAttributes(array(
				'user_id'=>Yii::app()->getUser()->getId(),
				'type'=>array('main','normal')
			));
			array_unshift($arAccounts,self::getCommonAccount());
			return $arAccounts;
		}
		return array();
	}
	
	public static function getCommonAccount() {
		$obCommonAccount=new Accounts();
		$obCommonAccount->id=0;
		$obCommonAccount->summ=1000000;
		$obCommonAccount->title='-- Пополнение --';
		$obCommonAccount->type='base';
		return $obCommonAccount;
	}
	
	/**
	 * Method that returns account by its' ids and check if it's belong to current user
	 */
	public static function getById($id) {
		if($id==0)
			return self::getCommonAccount();
		return self::model()->findByAttributes(array('id'=>$id,'user_id'=>Yii::app()->user->id));
	}
	
	public static function getFromById($id) {
		if($obFrom=self::getById($id)) {
			if($obFrom->type!='costs')
				return $obFrom;
		}
		return null;
	}
	
	public static function getToById($id) {
		if($id<1) return null;
		return self::getById($id);
	}
}
