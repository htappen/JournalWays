<?php

/**
 * This is the model class for table "book_has_page".
 *
 * The followings are the available columns in table 'book_has_page':
 * @property string $bookId
 * @property string $pageId
 * @property integer $pageNumber
 */
class BookHasPage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BookHasPage the static model class
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
		return 'book_has_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bookId, pageId, pageNumber', 'required'),
			array('pageNumber', 'numerical', 'integerOnly'=>true),
			array('bookId, pageId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bookId, pageId, pageNumber', 'safe', 'on'=>'search'),
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
			'bookId' => 'Book',
			'pageId' => 'Page',
			'pageNumber' => 'Page Number',
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

		$criteria->compare('bookId',$this->bookId,true);
		$criteria->compare('pageId',$this->pageId,true);
		$criteria->compare('pageNumber',$this->pageNumber);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}