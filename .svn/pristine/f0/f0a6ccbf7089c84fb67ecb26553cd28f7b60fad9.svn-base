<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANED=-1;
        public $password_repeat;
        public $defaultScopeOn=true;
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
        
        
        public function getShortDescription() {
            $user = User::model()->findByPk($this->id);
            if(isset($user->firstname)||isset($user->lastname))
            return $user->firstname." ".$user->lastname;
            else
                return NULL;
        }
        
        public function turnDefaultScopeOff(){
            $defaultScopeOn=false;
            
        }
        
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
//        public function getExpiration(){
//            $connection=Yii::app()->db; 
//            $command=$connection->createCommand("select date_add((select FROM_UNIXTIME((select createtime from tbl_users where id =" .Yii::app()->user->id."))),INTERVAL (select sum(number_months) from Promotions join Months on Promotions.id = Months.promotion where entity = " .Yii::app()->user->entityId." xor referrer = " .Yii::app()->user->entityId.") MONTH)as exp");
//             $date=$command->queryScalar();
//             return $date;
//        
//        }
	public function rules()
	{
            $this->turnDefaultScopeOff(); //this will allow us to actually check for unique emails etc.
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
            
            if($this->scenario == "recoverPassword")
                return array();
            
            
            
            if(!Yii::app()->user->isGuest)
                $returnArray = array(
                            array('username, email, password', 'required'),
                            array('password_repeat', 'required','on'=>'createEdit'),
                            array('password', 'length', 'max'=>150, 'min' => 6,'message' => UserModule::t("Incorrect password (minimal length 6 symbols)."),'on'=>'createEdit'),
                            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Your passwords must match."),'on'=>'createEdit'),//
                            array('password', 'length', 'max'=>128, 'min' => 6,'message' => UserModule::t("Incorrect password (minimal length 6 symbols)."),'on'=>'changePassword'),
                            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Your passwords must match."),'on'=>'changePassword'),//
                            array('password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', 'message' => UserModule::t("Your password must contain a letter and a number.")),
                            array('password', 'length', 'max'=>20, 'min' => 6,'message' => UserModule::t("Your password must be between 6 and 20 characters long."),'on'=>'createEdit'),                            
                            array('firstName, lastName', 'length', 'max'=>100),
                            array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
                            array('email', 'email'),
                            array('username', 'unique', 'message' => UserModule::t("This user's username already exists.")),
                            array('email', 'unique', 'message' => UserModule::t("This user's email already exists.")),
                            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Username must be only letters, numbers, and underscores")),
                            array('id, username, email, firstName, lastName, updateTime, createTime, active', 'safe', 'on'=>'search'),
                    );
            
            else if(Yii::app()->user->id==$this->id){
            $returnArray = array(
                        array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
                     
		);
            
            }else {
                $returnArray = array( 
                        array('password_repeat', 'compare', 'compareAttribute'=>'password','on'=>'recoverPassword', 
                            'message' => UserModule::t("Your passwords must match."),'on'=>'recoverPassword'),//
                        array('password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/', 
                            'message' => UserModule::t("Your password must contain a letter and a number."),'on'=>'recoverPassword'),
                        array('password', 'length', 'max'=>20, 'min' => 6,
                            'message' => UserModule::t("Your password must be between 6 and 20 characters long."),'on'=>'recoverPassword'),                            
                );
            }
            
            
            
		return $returnArray;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'books' => array(self::HAS_MANY, 'Book', 'userId'),
			'entries' => array(self::HAS_MANY, 'Entry', 'userId'),
			'pages' => array(self::HAS_MANY, 'Page', 'userId'),
			'photos' => array(self::HAS_MANY, 'Photo', 'userId'),
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>UserModule::t("Username (letters, numbers, and underscores only)"),
			'password'=>UserModule::t("Password (must contain numbers and letters and be at least 6 characters long)"),
			'password_repeat'=>UserModule::t("Re-type Password"),
			'email'=>UserModule::t("Email"),
			'salt' => 'Salt',
			'activKey' => 'Active Key',
			'facebookId' => 'Facebook',
			'firstName' => 'First Name',
			'lastName' => 'Last Name',
			'updateTime' => 'Update Time',
			'createTime' => 'Create Time',
			'active' => 'Active',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activKey, salt, createtime, updateTime,active',
            ),
            'fblogin'=>array(
            	'select' => 'id, firstName, lastName, email, activKey, salt, facebookId,createtime, updateTime,active',
            ),
        );
    }
	
	public function defaultScope()
    {
        if(!Yii::app()->user->isGuest && $this->defaultScopeOn)
            $scope = parent::defaultScope();
        else
            $scope = array('select'=>'id, username, email, createtime, updateTime, active',);
        return $scope;
    }
	
    
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
        
        
        public function beforeSave()
        {
          //  $this->password = $this->encrypt($this->password);
            return  parent::beforeSave();
        }
       /* public function encrypt($value)
        {
            //echo sha1($value); exit;
            return sha1($value);
        }*/

        
        
}
