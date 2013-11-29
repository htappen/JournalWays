<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $activKey
 * @property string $facebookId
 * @property string $firstName
 * @property string $lastName
 * @property string $updateTime
 * @property string $createTime
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property Book[] $books
 * @property Entry[] $entries
 * @property Page[] $pages
 * @property Photo[] $photos
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updateTime', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			array('email, password, salt, activKey, facebookId', 'length', 'max'=>150),
			array('firstName, lastName', 'length', 'max'=>100),
			array('createTime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, password, salt, activKey, facebookId, firstName, lastName, updateTime, createTime, active', 'safe', 'on'=>'search'),
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
			'books' => array(self::HAS_MANY, 'Book', 'userId'),
			'entries' => array(self::HAS_MANY, 'Entry', 'userId'),
			'pages' => array(self::HAS_MANY, 'Page', 'userId'),
			'photos' => array(self::HAS_MANY, 'Photo', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
			'salt' => 'Salt',
			'activKey' => 'Activ Key',
			'facebookId' => 'Facebook',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('activKey',$this->activKey,true);
		$criteria->compare('facebookId',$this->facebookId,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('lastName',$this->lastName,true);
		$criteria->compare('updateTime',$this->updateTime,true);
		$criteria->compare('createTime',$this->createTime,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}