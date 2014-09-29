<?php

/**
 * This is the model class for table "tbl_form_forms".
 *
 * The followings are the available columns in table 'tbl_form_forms':
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property string $name_replace
 * @property string $method
 * @property string $action
 * @property string $class
 * @property string $style
 * @property string $bizlogic
 * @property string $message_success
 * @property integer $user_create
 * @property string $date_create
 * @property integer $user_update
 * @property string $date_update
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Inputs[] $inputs
 */
class Forms extends AActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_form_forms';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, name, name_replace, method, status', 'required'),
			array('user_create, user_update', 'numerical', 'integerOnly' => true),
			array('title, name_replace, class, style', 'length', 'max' => 100),
			array('name, action', 'length', 'max' => 160),
			array('method', 'length', 'max' => 10),
			array('status', 'length', 'max' => 1),
			array('bizlogic, message_success', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, name, name_replace, method, action, class, style, user_create, date_create, user_update, date_update, status', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'inputs' => array(self::HAS_MANY, 'Inputs', 'form_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Megnevezés',
			'name' => 'name mező',
			'name_replace' => 'Csere kód',
			'method' => 'method',
			'action' => 'Action',
			'class' => 'class',
			'style' => 'style',
			'bizlogic' => 'Üzleti logika',
			'message_success' => 'Üzenet ha sikeres',
			'user_create' => 'Létrehozta',
			'date_create' => 'Létrehozás ideje',
			'user_update' => 'Módosította',
			'date_update' => 'Módosítás ideje',
			'status' => 'Státusz',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('name_replace', $this->name_replace, true);
		$criteria->compare('method', $this->method, true);
		$criteria->compare('action', $this->action, true);
		$criteria->compare('class', $this->class, true);
		$criteria->compare('style', $this->style, true);
		$criteria->compare('user_create', $this->user_create);
		$criteria->compare('date_create', $this->date_create, true);
		$criteria->compare('user_update', $this->user_update);
		$criteria->compare('date_update', $this->date_update, true);
		$criteria->compare('status', $this->status, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forms the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
			//üres mezők nullázása
			foreach ($this->attributes as $id => $value) {
				if ($this->$id == '') {
					$this->$id = NULL;
				}
			}
			return true;
		} else {
			return false;
		}
	}

	public function beforeSave()
	{
		if (parent::beforeSave()) {
			// update esetén változások mentése
			if (!$this->isNewRecord) {
				if (AHistorizer::historize($this)) {
					$this->date_update = date('Y-m-d H:i:s');
					$this->user_update = Yii::app()->user->id;
				}
			} else {
				$this->user_create = Yii::app()->user->id;
				$this->date_create = date('Y-m-d H:i:s');
			}
			return true;
		} else {
			return false;
		}
	}

	public function afterSave()
	{
		parent::afterSave();
		// ide jön a kódod
	}

	public function beforeDelete()
	{
		if (parent::beforeDelete()) {
			AHistorizer::historize($this);
			return true;
		} else {
			return false;
		}
	}

	public static function buildForm($form_id)
	{
		$form = Forms::model()->findByPk($form_id);

		$inputs = Inputs::model()->findAll(array(
			'condition' => 'form_id=:form_id AND status<>:status_i',
			'params' => array(
				':form_id' => $form_id,
				':status_i' => 'i',
			),
			'order' => 'order_num ASC',
		));
		$builded = null;
		// here render procedures
		$builded .= CHtml::beginForm(array($form->action), $form->method, array('id' => $form->name, 'class'=>$form->class)
		);

		switch ($form->class){
			case 'form-horizontal':
				$template = '<div class="control-group row-fluid">
								{label}
								<div class="controls">
									{inputfield}
								</div>
							</div>';

				$label_class = 'control-label';
				break;
			default:
				$template  = '<div class="row-fluid">';
				$template .= '{label}';
				$template .= '{inputfield}';
				$template .= '</div>';

				$label_class = null;
				break;
		}
		// you better create a function but
		// for the sake of the example...
		foreach ($inputs as $input) {
			$start_array = Yii::app()->request->getPost($form->name);
			$find_path   = Inputs::get_forminput_path($input->name);

			$posted_value = Forms::get_value_from_post($start_array, $find_path);
			if ($posted_value !== null){
				$input->value = $posted_value;
			}

			// here we can actually say i
			// this is very simple but you get the idea
			$type = $input->type;
			$label = CHtml::label($input->label, $input->name, array(
				'class' => $label_class,
				'required' => $input->status=='r'?true:false,
			));

			$input->name = Inputs::get_forminput_name($form->name, $input->name);

			switch ($type){
				case 'redactor':
					$inputfield = Yii::app()->controller->widget('yiiwheels.widgets.redactor.WhRedactorComment', array(
						'name' => $input->name,
						'htmlOptions' => array(
							'placeholder' => $input->placeholder,
						),
					), true);
					break;
				case 'textField':
					$inputfield = CHtml::textField($input->name, $input->value, array(
						'class' => $input->class,
						'style' => $input->style,
						'placeholder' => $input->placeholder,
					));
					break;
				case 'emailField':
					$inputfield = CHtml::emailField($input->name, $input->value, array(
						'class' => $input->class,
						'style' => $input->style,
						'placeholder' => $input->placeholder,
					));
					break;
				case 'telField':
					$inputfield = CHtml::telField($input->name, $input->value, array(
						'class' => $input->class,
						'style' => $input->style,
						'placeholder' => $input->placeholder,
					));
					break;
				case 'hiddenField':
					$inputfield = CHtml::hiddenField($input->name, $input->value, array(
						'class' => $input->class,
						'style' => $input->style,
						'placeholder' => $input->placeholder,
					));
					break;
				case 'textArea':
					$inputfield = CHtml::textArea($input->name, $input->value, array(
						'class' => $input->class,
						'style' => $input->style,
						'placeholder' => $input->placeholder,
					));
					break;
				case 'dropDownList':
					$inputfield = CHtml::dropDownList($input->name, $input->value, array(), array(
						'class' => $input->class,
						'style' => $input->style,
						'prompt' => $input->placeholder,
					));
					break;
				case 'submitButton':
					$inputfield = CHtml::submitButton($input->label, array(
						'class' => $input->class,
						'style' => $input->style,
					));
					break;
				default:
					break;
			}

			$builded .= str_replace(array('{label}', '{inputfield}'), array($label, $inputfield), $template);
			// do more here
		}
		$builded .= CHtml::endForm();

		return $builded;
	}

	public static function insert_and_process_form($content){
		$forms = Forms::model()->findAll(array(
			'condition' => 'status=:status_a',
			'params' => array(
				':status_a' => 'a',
			),
		));

		foreach ($forms as $form){
			if (isset($_POST[$form->name])){
				try{
					$form = Forms::model()->find(array(
						'condition' => 'name=:name',
						'params' => array(
							':name' => $form->name,
						),
					));

					if ($form !== null){
						$inputs = Inputs::model()->findAll(array(
							'condition' => 'form_id=:form_id AND status<>:status_i',
							'params' => array(
								':form_id' => $form->id,
								':status_i' => 'i',
							),
							'order' => 'order_num ASC',
						));
						foreach ($inputs as $input){
							$start_array = Yii::app()->request->getPost($form->name);
							$find_path   = Inputs::get_forminput_path($input->name);

							$value = Forms::get_value_from_post($start_array, $find_path);

							if ($input->status == 'r' && (is_null($value) || $value == '')){
								throw new Exception('Nem töltöttél ki minden kötelező mezőt!');
							}
						}
						// ha eljutott idáig, akkor nincs hiba
						//jöhet az üzleti logika
						$form->run_business_logic();

						// hozzá kell rendelni a userhez a cimkét
						// ilyenkor kell léteznie Yii::app()->user->id-nak
						if (isset(Yii::app()->user->id)){
							// ha létezik, akkor hozzárendelem a userhez
							// a formhoz rendelt cimkéket
							$user = Users::model()->findByPk(Yii::app()->user->id);
							$form_tag_assigns = Tags::get_assigned_tags_in_string($form);
							Tags::save_to_model($form_tag_assigns, $user);
						}

						//sikeresen feldolgoztuk
						$_POST[$form->name] = null;
					}else{
						throw new Exception('Nincs ilyen űrlap a rendszerben!');
					}
				}  catch (Exception $e){
					Yii::app()->user->setFlash('error', '<h4>'.$e->getMessage().'</h4>');
				}
			}
			if (mb_strpos($content, $form->name_replace) !== false){
				$content = str_replace($form->name_replace, Forms::buildForm($form->id), $content);
			}
		}
		return $content;
	}
	/**
	 * $path : item.item2.item3.item4
	 *
	 * @param type $start_array
	 * @param type $find_path
	 */
	public static function get_value_from_post($start_array, $find_path){
		if (is_array($start_array)){
			$route = explode('.', $find_path);
			if (isset($start_array[$route[0]])){
				$item = $start_array[$route[0]];
				if (is_array($item)){
					return self::get_value_from_post($item, str_replace($route[0].'.', '', $find_path));
				}else{
					return $item;
				}
			}else{
				return null;
			}
		}else{
			return null;
		}
	}
	private function run_business_logic(){
		// megkeresem az ehhez tartozó biznisz logikát
		return eval($this->bizlogic);
	}
}
