<?php

class DatasController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/center';
	public $name = 'Adatok';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // create, admin-hoz be kell legyen jelentkezve
				'actions' => array('create', 'update', 'delete'),
				'expression' => 'Yii::app()->user->checkAccess("editor")',
			),
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('admin'),
				'expression' => 'Yii::app()->user->checkAccess("reader")',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Datas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Datas'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = Yii::app()->request->getPost('Datas');
				if (!$model->save()) {
					$model->throw_exception('<h4>Datas mentése nem sikerült</h4>');
				} else {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<h4>Datas sikeresen létrehozva!</h4>');
					$this->redirect(array('admin'));
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', $e->getMessage());
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Datas'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = Yii::app()->request->getPost('Datas');
				if (!$model->save()) {
					$model->throw_exception('<h4>Datas frissítése nem sikerült!</h4>');
				} else {
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<h4>Datas sikeresen frissítve!</h4>');
					$this->redirect(array('/update/' . $id));
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', $e->getMessage());
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->layout = '//layouts/fluid';

		$model = new Datas('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Datas']))
			$model->attributes = $_GET['Datas'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Datas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Datas::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Datas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'datas-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
