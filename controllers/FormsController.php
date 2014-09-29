<?php

class FormsController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/center';
	public $defaultAction = 'admin';
	public $name = 'Űrlapok';

	public function init(){
		parent::init();

		$this->actionName = array_merge($this->actionName, array(
			'editbizlogic' => 'Üzleti logika módosítása',
		));
	}

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
				'actions' => array('EditBizlogic'),
				'expression' => 'Yii::app()->user->checkAccess("admin")',
			),
			array('allow', // create, admin-hoz be kell legyen jelentkezve
				'actions' => array('create', 'update', 'delete'),
				'expression' => 'Yii::app()->user->checkAccess("editor")',
			),
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('admin', 'overview'),
				'expression' => 'Yii::app()->user->checkAccess("reader")',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionOverview($id){

		$form = Forms::model()->findByPk($id);

		$builded_form = Forms::buildForm($form->id);


		$header  = '<i>"'.$form->title.'"</i> előnézete';
		$content = '<div class="span4">';
		$content .= $builded_form;
		$content .= '</div>';

        print Yii::app()->controller->widget('bootstrap.widgets.TbModal', array(
            'id' => 'myModalBox',
            'header' => $header,
            'content' => $content,
            'footer' => array(
                TbHtml::button('Bezárás', array('data-dismiss' => 'modal')),
            ),
			'htmlOptions' => array(
				'style' => 'width: 80% !important;max-width:960px !important; left:20px;right:20px; margin:0px auto !important;',
			),
        ),true);
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Forms;
		$selected_tags = null;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Forms'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$selected_tags = Yii::app()->request->getPost('selected_tags');
				$model->attributes = Yii::app()->request->getPost('Forms');
				if (!$model->save()) {
					$model->throw_exception('<h4>Űrlap mentése nem sikerült</h4>');
				} else {
					Tags::save_to_model($selected_tags, $model);
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<h4>Űrlap sikeresen létrehozva!</h4>');
					$this->redirect(array('admin'));
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', $e->getMessage());
			}
		}

		$this->render('create', array(
			'model' => $model,
			'selected_tags' => $selected_tags,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id, $inputid = null)
	{
		$this->layout = '//layouts/fluid';
		$model = $this->loadModel($id);
		if ($inputid !== null){
			$input = Inputs::model()->findByPk($inputid);
		}else{
			$input = new Inputs();
			$input->form_id = $id;
		}
		$selected_tags = Tags::get_assigned_tags_in_string($model);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Forms'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$model->attributes = Yii::app()->request->getPost('Forms');
				$selected_tags = Yii::app()->request->getPost('selected_tags');
				if (!$model->save()) {
					$model->throw_exception('<h4>Űrlap frissítése nem sikerült!</h4>');
				} else {
					Tags::save_to_model($selected_tags, $model);
					$transaction->commit();
					Yii::app()->user->setFlash('success', '<h4>Űrlap sikeresen frissítve!</h4>');
					$this->redirect(array('/formgenerator/forms/update/' . $id));
				}
			} catch (Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', $e->getMessage());
			}
		}
		if (isset($_POST['Inputs'])){
			if (isset($_POST['Inputs'])) {
			$transaction = Yii::app()->db->beginTransaction();
				try {
					$input->attributes = Yii::app()->request->getPost('Inputs');
					if (!$input->save()) {
						$input->throw_exception('<h4>Beviteli mező frissítése nem sikerült!</h4>');
					} else {
						$transaction->commit();
						Yii::app()->user->setFlash('success', '<h4>Beviteli mező sikeresen frissítve!</h4>');
						$this->redirect(array('/formgenerator/forms/update?id='.$id.'&inputid='.$input->id));
					}
				} catch (Exception $e) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', $e->getMessage());
				}
			}
		}

		$this->render('update', array(
			'model' => $model,
			'new_input' => $input,
			'selected_tags' => $selected_tags,
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
		//$this->layout = '//layouts/fluid';

		$model = new Forms('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Forms']))
			$model->attributes = $_GET['Forms'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Forms the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Forms::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Forms $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'forms-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionEditBizlogic($id){
		$model = $this->loadModel($id);

		if (isset($_POST['bizlogic'])){
			$bizlogic = Yii::app()->request->getPost('bizlogic');

			$bizlogic = str_replace('<?php', '', $bizlogic);

			$model->bizlogic = $bizlogic;
			if ($model->save()){
				Yii::app()->user->setFlash('success', '<h4>Üzleti logika sikeresen frissítve</h4>');
			}else{
				Yii::app()->user->setFlash('error', '<h4>Üzleti logika frissítése nem sikerült</h4>');
			}
		}

		$this->render('editbizlogic', array(
			'model' => $model,
		));
	}

}
