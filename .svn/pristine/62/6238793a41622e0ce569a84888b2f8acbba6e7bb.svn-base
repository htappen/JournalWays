<?php

/**
 * This is the model class for table "page_has_photo".
 *
 * The followings are the available columns in table 'page_has_photo':
 * @property string $pageId
 * @property string $photoId
 * @property integer $photoPosition
 */
class PageHasPhoto extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PageHasPhoto the static model class
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
		return 'page_has_photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pageId, photoId, photoPosition', 'required'),
			array('photoPosition', 'numerical', 'integerOnly'=>true),
			array('pageId, photoId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pageId, photoId, photoPosition', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pageId' => 'Page',
			'photoId' => 'Photo',
			'photoPosition' => 'Photo Position',
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

		$criteria->compare('pageId',$this->pageId,true);
		$criteria->compare('photoId',$this->photoId,true);
		$criteria->compare('photoPosition',$this->photoPosition);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}