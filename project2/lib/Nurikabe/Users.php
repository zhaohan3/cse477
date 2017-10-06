<?php

namespace Nurikabe;


class Users extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);

    }

    /**
     * Get a user based on email of user
     * @param $email email of user
     * @returns User object if successful, null otherwise.
     */
    public function get($email) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     */
//    public function update(User $user) {
//        $sql = <<<SQL
//UPDATE $this->tableName
//SET email=?, name=?, phone=?, address=?, notes=?, role=?
//WHERE id=?
//SQL;
//
//        $pdo = $this->pdo();
//        $statement = $pdo->prepare($sql);
//        $params = array($user->getEmail(), $user->getName(), $user->getPhone(), $user->getAddress(), $user->getNotes(), $user->getRole(), $user->getId());
//        try {
//            $ret = $statement->execute($params);
//        } catch(\PDOException $e) {
//            // do something when the exception occurs...
//            //$this->message = $e;
//            return false;
//        }
//        if( $statement->rowCount() == 0 ){
//            //$this->message = "Row count is zero";
//            return false;
//        }
//        return true;
//    }

    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($email) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return false;
        }
        else{
            return true;
        }

        $row = $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Submit a request to create a new user. Will not add user to the system, will only add them to validator and
     *      request they validate their email and setup a password
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     */
    public function add(User $user, Email $mailer) {
        // Ensure we have no duplicate email address
        if($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }
        // Create a validator and add to the validator table(done in newValidator)
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($user);
        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
        $name = $user->getName();

        $subject = "Confirm your email";
        $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Nifty Nurikabe. In order to complete your registration,
please verify your email address and set your password by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
        $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
        $mailer->mail($user->getEmail(), $subject, $message, $headers);

    }

    /**
     * Actually add the user into the system once validated
     * @param User $user
     */
    public function addValidated(User $user, $password){
        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(name, email, joined, password, salt)
values(?, ?, ?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array(
                $user->getName(), $user->getEmail(), date("Y-m-d H:i:s"), " ", " "));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        $u = $this->get($user->getEmail());
        $id = $u->getId();

        $this->setPassword($id, $password);
        return true;
    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     */
    public static function randomSalt($len = 16) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     */
    public function setPassword($userid, $password) {
        $sql = <<<SQL
UPDATE $this->tableName
SET password=?, salt=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $salt = $this->randomSalt();
        $hash = hash("sha256", $password . $salt);
        $statement->execute(array($hash, $salt, $userid));

    }

    public function getUsers(){
        $sql = <<<SQL
SELECT *
FROM $this->tableName
ORDER BY name ASC
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute();
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return array();
        }

        if( $statement->rowCount() == 0 ){
            return array();
        }

        $records = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $users = array(); // array of ClientCases to return
        for($i=0; $i<sizeof($records); $i++){
            $user = new User($records[$i]);
            $users[] = $user;
        }
        return $users;
    }
}