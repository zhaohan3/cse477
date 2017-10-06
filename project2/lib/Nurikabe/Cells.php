<?php

namespace Nurikabe;


class Cells extends Table {
    public function __construct(Site $site){
        parent::__construct($site, 'cell');
    }

    /*
     * Functions needed:
     *      delete?
     */

    public function exists($row, $col, $Nurikabeid){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE c_row=? AND c_col=? AND Nurikabeid=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($row, $col, $Nurikabeid));
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
     * Return one cell based on row, col, Nurikabeid
     * returns: cell if found, null otherwise
     */
    public function get($row, $col, $Nurikabeid){
        $sql = <<<SQL
SELECT * FROM $this->tableName
WHERE c_row=? AND c_col=? AND Nurikabeid=?
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($row, $col, $Nurikabeid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return null;
        }

        if($statement->rowCount() === 0) {
            return null;
        }

        return new Cell($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function add($row, $col, $val, $Nurikabeid){
        $sql = <<<SQL
INSERT INTO $this->tableName (c_row, c_col, c_val, Nurikabeid)
values(?,?,?,?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($row, $col, $val, $Nurikabeid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        return true;
    }

    /*
     * Update a c_val in the table based on row, col, Nurikabeid
     */
    public function update($val, $row, $col, $Nurikabeid){
        $sql = <<<SQL
UPDATE $this->tableName
SET c_val=?
WHERE c_row=? AND c_col=? AND Nurikabeid=?
SQL;

        $statement = $this->pdo()->prepare($sql);
        try {
            $statement->execute(array($val, $row, $col, $Nurikabeid));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
        return true;
    }

    public function save($row, $col, $val, $Nurikabeid){
        if($this->exists($row, $col, $Nurikabeid)){
            $this->update($val, $row, $col, $Nurikabeid);
            return "Updated";
        }
        else{
            $this->add($row, $col, $val, $Nurikabeid);
            return "Added";
        }
    }
}