<?php

/**
 * This is the model class for table "book".
 *
 * The followings are the available columns in table 'book':
 * @property string $id
 * @property string $title
 * @property string $subtitle
 * @property string $coverId
 * @property string $userId
 * @property string $updateTime
 * @property string $createTime
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Cover $cover
 * @property User $user
 * @property Page[] $pages
 */
class Book extends TimeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Book the static model class
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
		return 'book';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, subtitle, coverId, userId, updateTime', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('subtitle', 'length', 'max'=>150),
			array('coverId, userId', 'length', 'max'=>10),
			array('createTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, subtitle, coverId, userId, updateTime, createTime, active', 'safe', 'on'=>'search'),
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
			'cover' => array(self::BELONGS_TO, 'Cover', 'coverId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'pages' => array(self::MANY_MANY, 'Page', 'book_has_page(bookId, pageId)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'subtitle' => 'Subtitle',
			'coverId' => 'Cover',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('subtitle',$this->subtitle,true);
		$criteria->compare('coverId',$this->coverId,true);
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('updateTime',$this->updateTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}