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
		return array(
			array('user_id, title, type, summ', 'required'),
			array('user_id, summ', 'numerical'),
			array('parent_id','numerical'),
			array('title', 'length', 'max'=>255),
			array('type', 'length', 'max'=>6),
			array('date_operation', 'safe'),
			array('id, user_id, title, type, summ, date_operation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
			'children'=>array(
				self::HAS_MANY,'Accounts',array('id'=>'parent_id')
			),
			'parent'=>array(
				self::HAS_ONE,'Accounts','parent_id'
			)
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>'ID',
			'user_id'=>'Пользователь',
			'title'=>'Наименование счёта',
			'type'=>'Тип счёта',
			'summ'=>'Сумма',
			'date_operation'=>'Дата операции',
			'parent_id'=>'Группа счетов',
		);
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

	public static function getTypes() {
		return array(
			'main'=>Yii::t('accountTypes', 'main'),
			'normal'=>Yii::t('accountTypes', 'normal'),
			'costs'=>Yii::t('accountTypes', 'costs')
		);
	}

	public function reloadAccountSumm() {
		if(time()-strtotime($this->date_operation)>86400) {

		}
	}

	public function isEnoughAmount($amount) {
		$this->reloadAccountSumm();
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

	/**
	 * @return Accounts[]
	 */
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

	private function buildTree() {
		$arAccounts=$this->children;
		if(count($arAccounts)>0) {
			foreach($arAccounts as $obAccount) {
				$arResult[]=$obAccount;
				$arResult=array_merge($arResult,$this->buildTree());
			}
		}
		return $arAccounts;
	}

	public static function getMyAccountsTree() {
		$arResult=array();
		$arAccounts=self::model()->findAllByAttributes(array(
			'user_id'=>Yii::app()->getUser()->getId(),
			'parent_id'=>0
		));
		if(count($arAccounts)>0) {
			foreach($arAccounts as $obAccount) {
				$arResult[]=$obAccount;
				$arResult=array_merge($arResult,$obAccount->buildTree());
			}
		}
		return $arResult;
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
		return NULL;
	}
	
	public static function getToById($id) {
		if($id<1) return NULL;
		return self::getById($id);
	}
}
