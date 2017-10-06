<?php

namespace Nurikabe;


class Nurikabes extends Table{
    public function __construct(Site $site){
        parent::__construct($site, 'nurikabe');
    }

    /*
     * Check if current user already has a game of the current difficulty in the table
     * return - true if found, false if not
     */
    public function exists($difficulty, $userid){
        $sql = <<<SQL
SELECT * from $this->tableName
WHERE difficulty=? AND userid=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($difficulty, $userid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        if($statement->rowCount() === 0) {
            return false;
        }

        return true;
    }

    /*
     * Get a game from the table based off userid and difficulty
     * return: NurikabeDB if found, null otherwise
     */
    public function get($difficulty, $userid){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE difficulty=? AND userid=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($difficulty, $userid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return null;
        }

        if($statement->rowCount() === 0 || $statement->rowCount() > 1) {
            return null;
        }

        return new NurikabeDB($statement->fetch(\PDO::FETCH_ASSOC));
    }

//    /* Dont ever have to update game table, if difficulty and id do not exist add them and if they do this table
        //does not change, only cell table does
//     * Update an existing game in the table
//     * return: true if successful, false if not
//     */
//    public function update($difficulty, $id){
//        $sql = <<<SQL
//UPDATE $this->tableName
//SET difficulty=?
//WHERE id=?
//SQL;
//        $statement = $this->pdo()->prepare($sql);
//        try {
//            $statement->execute(array($difficulty, $id));
//        } catch(\PDOException $e) {
//            // do something when the exception occurs...
//            return false;
//        }
//        return true;
//    }

    /*
     * Add new game to table: need id of current user and difficulty of current game being run
     * return string if user and game already exist, false if failed, true if success
     */
    public function add($difficulty, $userid){
        if($this->exists($difficulty, $userid)){
            return "User and game mode already exist.";
        }

        $sql = <<<SQL
INSERT INTO $this->tableName (difficulty, userid)
values(?,?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($difficulty, $userid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        return true;
    }



    /*
     * Delete a game from the table based off current user id and difficulty
     */
    public function delete($difficulty, $userid){
        if(!$this->exists($difficulty, $userid)){
            return "User and game mode DO NOT exist.";
        }

        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE difficulty=? AND userid=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($difficulty, $userid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        return true;
    }
}