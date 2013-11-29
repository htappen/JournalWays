<?php

/**
 * This is the model class for table "layout".
 *
 * The followings are the available columns in table 'layout':
 * @property string $id
 * @property string $updateTime
 * @property string $createTime
 * @property integer $active
 * @property integer $numLandscapePics
 * @property integer $numPortraitPics
 * @property string $pic1pos
 * @property integer $pic1isPortrait
 * @property double $pic1widthRatio
 * @property string $pic2pos
 * @property integer $pic2isPortrait
 * @property double $pic2widthRatio
 * @property string $pic3pos
 * @property integer $pic3isPortrait
 * @property double $pic3WidthRatio
 * @property string $pic4pos
 * @property integer $pic4isPortrait
 * @property double $pic4widthRatio
 *
 * The followings are the available model relations:
 * @property Template[] $templates
 */
class Layout extends TimeActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Layout the static model class
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
		return 'layout';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updateTime, numLandscapePics, numPortraitPics', 'required'),
			array('active, numLandscapePics, numPortraitPics, pic1isPortrait, pic2isPortrait, pic3isPortrait, pic4isPortrait', 'numerical', 'integerOnly'=>true),
			array('pic1widthRatio, pic2widthRatio, pic3WidthRatio, pic4widthRatio', 'numerical'),
			array('createTime, pic1pos, pic2pos, pic3pos, pic4pos', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, updateTime, createTime, active, numLandscapePics, numPortraitPics, pic1pos, pic1isPortrait, pic1widthRatio, pic2pos, pic2isPortrait, pic2widthRatio, pic3pos, pic3isPortrait, pic3WidthRatio, pic4pos, pic4isPortrait, pic4widthRatio', 'safe', 'on'=>'search'),
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
			'templates' => array(self::HAS_MANY, 'Template', 'layoutId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'updateTime' => 'Update Time',
			'createTime' => 'Create Time',
			'active' => 'Active',
			'numLandscapePics' => 'Num Landscape Pics',
			'numPortraitPics' => 'Num Portrait Pics',
			'pic1pos' => 'Pic1pos',
			'pic1isPortrait' => 'Pic1is Portrait',
			'pic1widthRatio' => 'Pic1width Ratio',
			'pic2pos' => 'Pic2pos',
			'pic2isPortrait' => 'Pic2is Portrait',
			'pic2widthRatio' => 'Pic2width Ratio',
			'pic3pos' => 'Pic3pos',
			'pic3isPortrait' => 'Pic3is Portrait',
			'pic3WidthRatio' => 'Pic3 Width Ratio',
			'pic4pos' => 'Pic4pos',
			'pic4isPortrait' => 'Pic4is Portrait',
			'pic4widthRatio' => 'Pic4width Ratio',
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
		$criteria->compare('updateTime',$this->updateTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('numLandscapePics',$this->numLandscapePics);
		$criteria->compare('numPortraitPics',$this->numPortraitPics);
		$criteria->compare('pic1pos',$this->pic1pos,true);
		$criteria->compare('pic1isPortrait',$this->pic1isPortrait);
		$criteria->compare('pic1widthRatio',$this->pic1widthRatio);
		$criteria->compare('pic2pos',$this->pic2pos,true);
		$criteria->compare('pic2isPortrait',$this->pic2isPortrait);
		$criteria->compare('pic2widthRatio',$this->pic2widthRatio);
		$criteria->compare('pic3pos',$this->pic3pos,true);
		$criteria->compare('pic3isPortrait',$this->pic3isPortrait);
		$criteria->compare('pic3WidthRatio',$this->pic3WidthRatio);
		$criteria->compare('pic4pos',$this->pic4pos,true);
		$criteria->compare('pic4isPortrait',$this->pic4isPortrait);
		$criteria->compare('pic4widthRatio',$this->pic4widthRatio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}