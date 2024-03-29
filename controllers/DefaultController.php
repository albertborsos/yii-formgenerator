<?php

class DefaultController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/center';
	public $defaultAction = 'index';

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
				'actions' => array('index'),
			//'expression' => 'Yii::app()->user->checkAccess("ModuleControllerEdit")',
			),
			array('deny', // deny all users
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

}
