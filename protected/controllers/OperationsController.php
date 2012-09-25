<?php

class OperationsController extends Controller {
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array_merge(parent::filters(),array());
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model=new Operations;

		if(isset($_POST['Operations'])) {
			$model->attributes=$_POST['Operations'];
			$model->date=date('Y-m-d H:i:s');
			$model->summ*=100;
			$obFromAccount=Accounts::getFromById($model->from_account_id);
			$obToAccount=Accounts::getToById($model->to_account_id);
			if(!$obFromAccount) {
				$model->addError('from_account_id', 'Не найден исходный счёт');
			}
			if(!$obToAccount) {
				$model->addError('to_account_id', 'Не найден счёт получатель');
			}
			if($model->validate()) {
				if($obFromAccount->id==$obToAccount->id)
					$model->addError('to_account_id','Счёт получатель не может соответствовать счёту отправителю');
				if(!$obFromAccount->isEnoughAmount($model->summ))
					$model->addError('summ', 'На исходном счёте на найдена искомая сумма');
				if(!$model->hasErrors()) {
					$obTransaction=Yii::app()->getDB()->beginTransaction();
					try {
						if($model->save()) {
							$obFromAccount->lowerSumm($model->summ);
							$obToAccount->raiseSumm($model->summ);
							$obTransaction->commit();
							$this->redirect(array('view','id'=>$model->id));
						} else {
							throw new CException('Can\'t save operation');
						}
					} catch (CException $e) {
						$obTransaction->rollback();
						$model->addError('title',$e->getMessage());
					}
				}
			}
			$model->summ/=100;
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$obCriteria=new CDbCriteria();
		$obCriteria->with='account';
		$obCriteria->addCondition('account.user_id='.Yii::app()->user->id);
		$dataProvider=new CActiveDataProvider('Operations');
		$dataProvider->setCriteria($obCriteria);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model=Operations::model()->findByPk($id);
		if($model===null || $model->account->user_id!=Yii::app()->user->id)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
