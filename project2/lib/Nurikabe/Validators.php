<?php

namespace Nurikabe;


class Validators extends Table{
    public function __construct(Site $site){
        parent::__construct($site, "validator");
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator(User $user) {
        $validator = $this->createValidator();

        $sql = <<<SQL
INSERT INTO $this->tableName (validator, date, name, email)
VALUES(?,?,?,?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($validator, date("Y-m-d H:i:s"), $user->getName(), $user->getEmail()));

        return $validator;
    }

    /**
     * Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     */
    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    /**
     * Determine if a validator is valid. If it is,
     * return the user ID for that validator.
     * @param $validator Validator to look up
     * @return email or null if not found.
     */
    public function get($validator) {
        $sql = <<<SQL
SELECT email
FROM $this->tableName
WHERE validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($validator));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return null;
        }

        if( $statement->rowCount() == 0 ){
            return null;
        }

        $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $row[0]['email'];
    }

    /**
     * Remove any validators for this email address
     * @param $email The email we are clearing validators for.
     */
    public function remove($email) {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($email));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        if( $statement->rowCount() == 0 ){
            return false;
        }

    }

    public function getName($validator){
        $sql = <<<SQL
SELECT name
FROM $this->tableName
WHERE validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($validator));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return null;
        }

        if( $statement->rowCount() == 0 ){
            return null;
        }

        $row = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $row[0]['name'];
    }

}