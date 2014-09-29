<?php

class AFormGeneratorModule extends CWebModule
{
	public $name = 'Űrlapkezelő';

	public function init()
	{
		$this->defaultController = 'forms';
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'application.modules.AFormGenerator.models.*',
			'application.modules.AFormGenerator.components.*',
		));

		$path = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.AFormGenerator.assets'));
		Yii::app()->clientScript->registerScriptFile($path . '/js/formgenerator-admin.js');
	}

	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action)) {
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		} else
			return false;
	}

}
