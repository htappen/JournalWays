<?php

/**
 * This is the model class for table "cover".
 *
 * The followings are the available columns in table 'cover':
 * @property string $id
 * @property string $name
 * @property string $s3Key
 * @property string $userId
 * @property string $updateTime
 * @property string $createTime
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Book[] $books
 */
class Cover extends TimeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cover the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cover';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, s3Key, userId, updateTime', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name, s3Key', 'length', 'max'=>150),
			array('userId', 'length', 'max'=>10),
			array('createTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, s3Key, userId, updateTime, createTime, active', 'safe', 'on'=>'search'),
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
			'books' => array(self::HAS_MANY, 'Book', 'coverId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			's3Key' => 'S3 Key',
			'userId' => 'User',
			'updateTime' => 'Update Time',
			'createTime' => 'Create Time',
			'active' => 'Active',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('s3Key',$this->s3Key,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('updateTime',$this->updateTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}