<?php

namespace Felis;


class Cases extends Table{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "case");
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns ClientCase object if successful, null otherwise.
     */
    public function get($id) {
        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
SELECT c.id, c.client, client.name as clientName,
       c.agent, agent.name as agentName,
       number, summary, status
from $this->tableName c,
     $usersTable client,
     $usersTable agent
where c.client = client.id and
      c.agent=agent.id and
      c.id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new ClientCase($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function insert($client, $agent, $number) {
        $sql = <<<SQL
insert into $this->tableName(client, agent, number, summary, status)
values(?, ?, ?, "", ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            if($statement->execute(array($client,
                        $agent,
                        $number,
                        ClientCase::STATUS_OPEN)
                ) === false) {
                $_SESSION['e'] = 'exception';
                return null;
            }
        } catch(\PDOException $e) {
            return null;
        }

        return $pdo->lastInsertId();
    }

    public function getCases(){
        $users = new Users($this->site);
        $usersTable = $users->getTableName();

        $sql = <<<SQL
SELECT c.id, c.number, c.summary, c.status, c.client, c.agent, u.name as clientName, a.name as agentName
FROM $this->tableName c
JOIN $usersTable u 
ON c.client = u.id
JOIN $usersTable a
ON c.agent = a.id
ORDER BY c.status desc, c.id desc
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute();
        } catch(\PDOException $e) {
            return array();
        }

        if( $statement->rowCount() == 0 ){
            return array();
        }

        $records =  $statement->fetchAll(\PDO::FETCH_ASSOC);
        $ClientCases = array(); // array of ClientCases to return
        for($i=0; $i<sizeof($records); $i++){
            $case = new ClientCase($records[$i]);
            $ClientCases[] = $case;
        }
        return $ClientCases;
    }

    public function update(ClientCase $case) {
        $sql = <<<SQL
UPDATE $this->tableName 
SET number=?, summary=?, status=?, agent=?
WHERE id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $params = array($case->getNumber(), $case->getSummary(), $case->getStatus(), $case->getAgent(), $case->getId());
        try {
            $ret = $statement->execute($params);
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }

        return true;
    }

    public function delete($id){
        $sql = <<<SQL
DELETE FROM $this->tableName
WHERE id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        try {
            $ret = $statement->execute(array($id));
        } catch(\PDOException $e) {
            // do something when the exception occurs...
            return false;
        }
    }
}