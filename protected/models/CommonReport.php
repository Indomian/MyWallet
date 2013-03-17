<?php

class CommonReport extends CModel {
	public $date_from;
	public $date_to;

	public function attributeNames() {
		return array('date_from','date_to');
	}

	public function attributeLabels() {
		return array(
			'date_from'=>'С',
			'date_to'=>'по'
		);
	}

	public function rules() {
		return array(
			array('date_from,date_to','required'),
			array('date_from,date_to','match','pattern'=>'#^\d\d\.\d\d\.\d\d\d\d$#','message'=>'Неверный формат даты от-до')
		);
	}

	public function generate() {
		if($this->validate()) {
			$query="SELECT SUM(A.`summ`) as `summ`, B.`title` as `title`, COUNT(A.`id`) as `count` FROM `operations` as A, `accounts` as B WHERE
				A.`to_account_id`=B.`id` AND B.`user_id`=:userid AND B.`type`='costs' AND
				A.`date`>=:datefrom AND A.`date`<=:dateto GROUP BY A.`to_account_id`";
			$obCommand=Yii::app()->db->createCommand($query);
			$arList=$obCommand->queryAll(true,array(
				':userid'=>Yii::app()->user->id,
				':datefrom'=>date('Y-m-d H:i:s',strtotime($this->date_from)),
				':dateto'=>date('Y-m-d H:i:s',strtotime($this->date_to))
			));
			return new CArrayDataProvider($arList,array(
				'pagination'=>array(
					'pageSize'=>20
				),
				'keyField'=>'title'
			));
		}
	}
}