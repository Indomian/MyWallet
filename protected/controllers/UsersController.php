<?php

class UsersController extends Controller {
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
	public function actionView() {
	    $id=Yii::app()->user->id;
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate() {
	    $id=Yii::app()->user->id;
		$model=$this->loadModel($id);

		if(isset($_POST['Users'])) {
			$model->attributes=$_POST['Users'];
            $arSaveList=array('login','active');
            if($model->password!='') {
                $arSaveList[]='password';
                $model->password=Users::getHash($model->password);
            }
			if($model->save($arSaveList))
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array('model'=>$model));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
	    $this->redirect($this->createUrl('users/view'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
