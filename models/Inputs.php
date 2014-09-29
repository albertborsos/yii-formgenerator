<?php

/**
 * This is the model class for table "tbl_form_inputs".
 *
 * The followings are the available columns in table 'tbl_form_inputs':
 * @property integer $id
 * @property integer $form_id
 * @property string $type
 * @property string $model_class
 * @property string $model_attribute
 * @property string $label
 * @property string $name
 * @property string $value
 * @property string $placeholder
 * @property string $class
 * @property string $style
 * @property integer $order_num
 * @property integer $user_create
 * @property string $date_create
 * @property integer $user_update
 * @property string $date_update
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Datas[] $datases
 * @property Forms $form
 */
class Inputs extends AActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_form_inputs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('form_id, name, status, type', 'required'),
			array('form_id, order_num, user_create, user_update', 'numerical', 'integerOnly'=>true),
			array('type, model_class, model_attribute, name, value, placeholder, class, style', 'length', 'max'=>100),
			array('status', 'length', 'max'=>1),
			array('label', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, form_id, type, model_class, model_attribute, name, value, placeholder, class, style, order_num, user_create, date_create, user_update, date_update, status', 'safe', 'on'=>'search'),
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
			'datases' => array(self::HAS_MANY, 'Datas', 'input_id'),
			'form' => array(self::BELONGS_TO, 'Forms', 'form_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'form_id' => 'Form',
			'type' => 'Típus',
			'model_class' => 'Model Osztály',
			'model_attribute' => 'Model mező',
			'label' => 'Cimke',
			'name' => 'Egyedi azonosító',
			'value' => 'Alapértelmezett érték',
			'placeholder' => 'Placeholder/Prompt',
			'class' => 'Class',
			'style' => 'Style',
			'order_num' => 'Sorszám',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('form_id',$this->form_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('model_class',$this->model_class,true);
		$criteria->compare('model_attribute',$this->model_attribute,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('placeholder',$this->placeholder,true);
		$criteria->compare('class',$this->class,true);
		$criteria->compare('style',$this->style,true);
		$criteria->compare('order_num',$this->order_num);
		$criteria->compare('user_create',$this->user_create);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('user_update',$this->user_update);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function search_by_form($form_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('form_id',$this->form_id);
		$criteria->order = 'order_num ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inputs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeValidate(){
        if (parent::beforeValidate()){
			//üres mezők nullázása
			foreach ($this->attributes as $id => $value) {
				if ($this->$id == '') {
					$this->$id = NULL;
				}
			}
            return true;
        }else{
            return false;
        }
    }

    public function beforeSave(){
        if (parent::beforeSave()){
            // update esetén változások mentése
            if (!$this->isNewRecord){
               if (AHistorizer::historize($this)){
                   $this->date_update = date('Y-m-d H:i:s');
                   $this->user_update = Yii::app()->user->id;
               }
            }else{
               $this->user_create = Yii::app()->user->id;
               $this->date_create = date('Y-m-d H:i:s');
            }
            return true;
        }else{
            return false;
        }
    }
    public function afterSave() {
        parent::afterSave();
        // ide jön a kódod
    }
    public function beforeDelete() {
        if (parent::beforeDelete()){
            AHistorizer::historize($this);
            return true;
        }else{
            return false;
        }
    }
	public static function get_forminput_name($form_name, $input_name){
		// input name Users[valami][valami2]
		$attributes = explode('[', $input_name);
		$input_name = $form_name;
		foreach ($attributes as $attribute){
			$input_name .= '['.str_replace(']', '', $attribute).']';
		}
		return $input_name;
	}
	public static function get_forminput_path($input_name){
		// input name Users[valami][valami2]
		$attributes = explode('[', $input_name);
		$input_name = '';
		$n = 1;
		foreach ($attributes as $attribute){
			if ($n !== 1){
				$input_name .= '.';
			}
			$input_name .= str_replace(']', '', $attribute);
			$n++;
		}
		return $input_name;
	}
}
