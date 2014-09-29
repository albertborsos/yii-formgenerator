<?php

/**
 * This is the model class for table "tbl_form_datas".
 *
 * The followings are the available columns in table 'tbl_form_datas':
 * @property integer $id
 * @property integer $input_id
 * @property string $key
 * @property string $value
 * @property integer $order_num
 * @property integer $user_create
 * @property string $date_create
 * @property integer $user_update
 * @property string $date_update
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Inputs $input
 */
class Datas extends AActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_form_datas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('input_id, order_num, user_create, user_update', 'numerical', 'integerOnly'=>true),
			array('key, value', 'length', 'max'=>100),
			array('status', 'length', 'max'=>1),
			array('date_create, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, input_id, key, value, order_num, user_create, date_create, user_update, date_update, status', 'safe', 'on'=>'search'),
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
			'input' => array(self::BELONGS_TO, 'Inputs', 'input_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'input_id' => 'Beviteli mező',
			'key' => 'Kulcs',
			'value' => 'Érték',
			'order_num' => 'Order Num',
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
		$criteria->compare('input_id',$this->input_id);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
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

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Datas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeValidate(){
        if (parent::beforeValidate()){
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
}
