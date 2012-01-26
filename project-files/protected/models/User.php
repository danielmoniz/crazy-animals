<?php

class User extends CActiveRecord {
    /*
     * Instance Variables.
     * @TODO Figure out how to deal with CActiveRecord wanting
     * a user_id attribute. (currently redundant $userId and $user_id!)
     * NOTE: Every changed instance variable requires changes in the
     * constructor and getAttributes.
     */

    public $userId = 0;
    public $username = "";
    public $password = "";
    public $firstName = "";
    public $lastName = "";
    public $email = "";
    public $lastLoginTimestamp = 0;
    public $registeredTimestamp = 0;
    public $avatarFilename = "";
    public $active = 1;

    /*
     * TODO:TO BE FILLED IN ONCE WE SEE HOW LOGIN IS WORKING
     */

    function __construct($userIdentifier = '') {
        // getting user info by userId
        if (is_numeric($userIdentifier)) {
            $userData = self::getMemberDetailsByUserId($userIdentifier);
        } else { // ie. getting user info by username
            $userData = self::getMemberDetailsByUsername($userIdentifier);
        }
        
        $this->userId = $userData['userId'];
        $this->username = $userData['username'];
        $this->password = $userData['password'];
        $this->firstName = $userData['firstName'];
        $this->lastName = $userData['lastName'];
        $this->email = $userData['email'];
        $this->lastLoginTimestamp = $userData['last_loginTimestamp'];
        $this->registeredTimestamp = $userData['registrationTimestamp'];
        $this->avatarFilename = $userData['avatarTilename'];
        $this->active = $userData['active'];
    }
    
    public function postLogin() {
        // Do what must be done, Lord Vader (after login).
        $this->updateLastLogin();
    }

    /**
     * Returns the attributes of the User model.
     * @return Associative Array A list of every attribute and it's value.
     */
    public function getAttributes() {
        return array('userId'=>$this->userId,
            'username'=>$this->username,
            'password'=>$this->password,
            'firstName'=>$this->firstName,
            'lastName'=>$this->lastName,
            'email'=>$this->email,
            'birthdateTimestamp'=>$this->birthdateTimestamp,
            'lastLoginTimestamp'=>$this->lastLoginTimestamp,
            'registeredTimestamp'=>$this->registeredTimestamp,
            'avatarFilename'=>$this->avatarFilename,
            'active'=>$this->active,
            );
    }
    
    /**
     * @TODO Find out if this is useful!
     * @return type 
     */
    public function getParentAttributes() {
        return parent::getAttributes();
    }

    /**
     * Sets the attributes for the User model.
     * @param Array $attributes An array containing a key for every attribute,
     * even if their values are null.
     */
    public function setAttributes($attributes) {
        foreach ($attributes as $attribute=>$value)
        {
            if (property_exists('User', $attribute))
                $this->$attribute = $value;
        }
        $this->user_id = $this->userId;
        return true;
    }
    
    /**
     * Set the user
     */
    private function updateLastLogin() {
        $sql = "UPDATE users 
            SET lastLoginTimestamp = UNIX_TIMESTAMP() 
            WHERE userId = :userId";
        $paramArray = array(':userId'=>$this->userId);
        return Utilities::query($sql, $paramArray, 'execute');
    }

    /**
     * Create an ass-tonne of users at one time given userIds.
     * @TODO This function could be expanded to allow for more generic arrays
     * containing userIds.  There just needs to be an extra check.
     * @param Array $userIdArray An array of userIds.
     * @return Array An array of User objects.
     */
    public function batchMakeUsers($userIdArray) {
        $userArray = array();
        foreach ($userIdArray as $userId) {
            $userArray[] = new User($userId);
        }
        return $userArray;
    }

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return "users";
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('username', $this->username, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

//    function __construct($username) {
//        echo 'username constructor'; exit;
    // Note currently in user_main table
    /*
      $this->bio = $userData['bio'];
     */
//    }

    /*
     * Populate instance variables with user info.
     */
    private function getMemberDetails() {

    }

    /*
     * Populate instance variables with user info given a username.
     */

    private function getMemberDetailsByUsername($username = '') {
        if (empty($username))
            $username = $this->username;

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM users
            WHERE username = :username";

        $command = $connection->createCommand($sql);
        $paramArray = array(':username' => $username);
        $command->bindValues($paramArray);
        return $command->queryRow();
    }

    /*
     * Populate instance variables with user info given a userId.
     * NOTE: This query is vulnerable to back-end SQL injection. Don't be 
     * an idiot when calling this function!
     */

    public function getMemberDetailsByUserId($userId = 0, $attributes = '*') {
        if (empty($userId))
            $userId = $this->userId;

        $sql = "SELECT $attributes FROM users
            WHERE userId = :userId";

        $paramArray = array(':userId' => $userId);
        return Utilities::query($sql, $paramArray, 'row');
    }
    
    /**
     * Get a list of values that correspond to a specific attribute, given 
     * a list of userIds. Eg. submitting userIds (1, 2) would return an array 
     * containing "csjohn" and "paragon".
     * @param Array $userIds A list of userIds to select upon.
     * @param string $attribute The attribute to select upon.
     * @return Array A list of the desired attribute from users.
     */
    public function getUserAttributeFromUserIds($userIds, $attribute = 'username') {
        if (empty($userIds))
            return false;

        $sql = "SELECT $attribute FROM users
            WHERE userId IN (0";
        $paramArray = array();
        foreach ($userIds as $key=>$userId) {
            $sql .= "," . $userId;
            $paramArray[":userId" . $key] = $userId;
        }
        $sql .= ");";
        
        return Utilities::query($sql, $paramArray, 'column');
    }
    
    /**
     * Get a single attribute from a single user.
     * @param int $userId The userId to select upon.
     * @param string $attribute The attribute to select upon.
     * @return mixed The desired attribute from the given user.
     */
    public function getUserAttributeFromUserId($userId, $attribute = 'username') {
        if (empty($userId))
            return false;

        $sql = "SELECT $attribute FROM users
            WHERE userId = :userId";
        $paramArray = array(":userId"=>$userId);
        
        return Utilities::query($sql, $paramArray, 'scalar');
    }

    /*
     * Change the value of a user attribute (i.e. bio, email, etc)
     * @param $attribute the name of the attribute to change
     * @param $value the value the attribute will be set to
     */

    public function changeUserAttribute($attribute, $value) {
        
    }

    /**
     * Get topics for the current user.
     * @return array A list of topics.
     */
    public function getUserTopics() {
        return Topics::getUserTopics($this->userId);
    }


    /**
     * Get specific fields (defaults to all) from all users
     * @param string $select A string with fields on which to select
     * @return Array an array of User objects
     */
    public function getUsers($select = '*', $limit = 10, $offset = 0) {
        $connection = Yii::app()->db;
        $sql = "SELECT $select FROM users
            LIMIT :offset, :limit";
        $command = $connection->createCommand($sql);
        $paramArray = array(":limit" => $limit, ":offset" => $offset);
        $command->bindValues($paramArray);

        $userIds = $command->queryColumn();
        return self::batchMakeUsers($userIds);
    }

    /**
     * Returns a simple array of a given attribute given an array of users.
     * Defaults to pulling the userId.
     * @param Array $userList An array of user objects.
     * @return Array A list of an attribute of users (eg. usernames)
     */
    public function getAttributeArrayFromUsers($userList, $attribute = 'userId') {
        $userAttributes = array();
        foreach ($userList as $key=>$user) {
            $userAttributes[$key] = $user->$attribute;
        }

        return $userAttributes;
    }

    /**
     * Return an ordered list of users who share common topics to this user.
     * @return array An ordered list of users.
     */
    public function findUsersWithCommonTopics() {
        return Topics::findUsersWithCommonTopics($this->userId);
    }
    
    public function findUsersWithNonsimilarTopics() {
        return Topics::findUsersWithNonsimilarTopics($this->userId);
    }
    

    /**
     * Get the most recent posts from the current user.
     * @param int $offset The number of posts to skip.
     * @param int $limit The maximum number of posts to retrieve.
     * @return array A list of posts.
     */
    public function getMostRecentUserPosts($offset = 0, $limit = 5) {
        return PostSet::getMostRecentUserPosts($this->userId, $offset, $limit);
    }

    /**
     * Get the latest post from the current user.
     * @return array A list of posts.
     */
    public function getLatestUserPost() {
        return PostSet::getMostRecentUserPosts($this->userId, 0, 1);
    }

    /**
     * Get posts ordered by latest user activity for the current user.
     * @param int $offset The number of posts to skip.
     * @param int $limit The maximum number of posts to return.
     * @return array An ordered list of Post objects.
     */
    public function getPostsByLatestUserActivity($offset = 0, $limit = 5) {
        return PostSet::getPostsByLatestUserActivity($this->userId, $offset = 0, $limit = 5);
    }

    /**
     * Get all posts favourited by the current user.
     * @param int $offset The number of posts to ignore/skip.
     * @param int $limit The maximum number of posts to return.
     * @return array A list of favourited posts.
     */
    public function getFavouritedPosts($userId, $offset = 0, $limit = 5) {
        return PostSet::getFavouritedPosts($this->userId, $offset = 0, $limit = 5);
    }

    //public function set

    /**
     * Add a topic to the current user's profile.
     * @param string $topic
     * @return boolean
     */
    public function addTopic($topicName) {
        $result = Topics::addTopicToUser($this->userId, $topicName);
        return $result;
    }


    /**
     * Get a list of posts from the current user.
     * @param int $offset The number of posts to skip.
     * @param int $limit The maximum number of posts to pull.
     */
    // function redundant with getPostsByLatestUserActivity??
    /*
      public function getPostsByUserIds($offset = 0, $limit = 5)
      {
      return PostSet::getPostsByUserIds(array($this->userId), $offset = 0, $limit = 5);
      }
     */
    public function registerUser($userRegistrationForm) {
        $loginCode = substr(sha1(uniqid()), 1, 10);

        $connection = Yii::app()->db;
        $sql = "INSERT INTO users (
                    username,
                    password,
                    loginCode,
                    email,
                    registrationTimestamp,
                    lastLoginTimestamp
                )
                VALUES (
                    :username,
                    :password,
                    :loginCode,
                    :email,
                    UNIX_TIMESTAMP(),
                    UNIX_TIMESTAMP()
                )";
        $command = $connection->createCommand($sql);

        $command->bindParam(":username", $userRegistrationForm->username, PDO::PARAM_STR);
        $command->bindParam(":password", UserHelper::hashPassword($userRegistrationForm->password), PDO::PARAM_STR);
        $command->bindParam(":loginCode", $loginCode, PDO::PARAM_STR);
        $command->bindParam(":email", $userRegistrationForm->email, PDO::PARAM_STR);
        $command->execute();

        $userId = $connection->getLastInsertId();

        return $userId;
    }
    
    public function getUserId()
    {
        $userId = Yii::app()->user->id;
        if($userId == NULL)
            return 0;
        else
            return $userId;
    }

}
?>