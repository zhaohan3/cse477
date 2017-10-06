<?php

namespace Felis;


class Validators extends Table{
    public function __construct(Site $site){
        parent::__construct($site, "validator");
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        $sql = <<<SQL
INSERT INTO $this->tableName (userid, validator, date)
VALUES(?,?,?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $validator, date("Y-m-d H:i:s")));

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
     * @return User ID or null if not found.
     */
    public function get($validator) {
        $sql = <<<SQL
SELECT userid
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
        return $row[0]['userid'];
    }

    /**
     * Remove any validators for this user ID.
     * @param $userid The USER ID we are clearing validators for.
     */
    public function remove($userid) {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE userid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($userid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        if( $statement->rowCount() == 0 ){
            return false;
        }

    }
}