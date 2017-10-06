<?php

namespace Noir;


class Cookies extends Table {

    public function __construct(Site $site){
        parent::__construct($site, 'cookie');
    }

    /*
     * Create a random string
     * @author	XEWeb <>
     * @param $length the length of the string to create
     * @return $str the string
     */
    function randomString($length = 32) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
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
     * Create a new cookie token
     * @param $user User to create token for
     * @return New 32 character random string
     */
    public function create($user) {
        $sql = <<<SQL
INSERT INTO $this->tableName (user, salt, hash, date)
VALUES (?,?,?,?)
SQL;
        $pass = $this->randomString();
        $salt = $this->randomSalt();
        $hash = hash("sha256", $pass . $salt);

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array($user, $salt, $hash, date("Y-m-d H:i:s")));

        return $pass;
    }

    /**
     * Validate a cookie token
     * @param $user User ID
     * @param $token Token
     * @return null|string If successful, return the actual
     *   hash as stored in the database.
     */
    public function validate($user, $token) {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE user=?
SQL;

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array($user));

        if($stmt->rowCount() === 0) {
            return null;
        }

        $hash = '';
        foreach( $stmt as $row ){
            // Get the encrypted hash and salt from the record
            $hash = $row['hash'];
            $salt = $row['salt'];

            // Ensure it is correct
            if($hash === hash("sha256", $token . $salt)) {
                return $hash;
            }
        }
        return null;
    }

    /**
     * Delete a hash from the database
     * @param $hash Hash to delete
     * @return bool True if successful
     */
    public function delete($hash) {
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE hash=?
SQL;

        $stmt = $this->pdo()->prepare($sql);
        $stmt->execute(array($hash));

        if($stmt->rowCount() === 0) {
            return false;
        }
        return true;
    }
}