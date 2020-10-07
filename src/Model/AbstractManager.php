<?php

namespace Model;

use App\Connection;


abstract class AbstractManager
{
    protected $pdoConnection; 

    protected $table;
    protected $className;


    public function __construct(string $table)
    {
        $connexion = new Connection();
        $this->pdoConnection = $connexion->getPdoConnection();
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
    }


    public function selectAll(): array
    {
        return $this->pdoConnection->query('SELECT * FROM ' . $this->table, \PDO::FETCH_CLASS, $this->className)->fetchAll();
    }


    public function selectWhere($filter): array
    {

        $query = "SELECT * FROM $this->table WHERE $filter";

        $statement = $this->pdoConnection->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->execute();

        return $statement->fetchAll();

    }


    public function selectOneById(int $id)
    {
        $statement = $this->pdoConnection->prepare("SELECT * FROM $this->table WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function delete(int $id)
    {
        $statement = $this->pdoConnection->prepare("DELETE FROM $this->table WHERE id=:id");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

    }


    public function deleteWhere($filter)
    {
        $statement = $this->pdoConnection->prepare("DELETE FROM $this->table WHERE $filter");
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->execute();

    }


    public function insert(array $data)
    {
        
        $statement = $this->pdoConnection->prepare("INSERT INTO $this->table (".implode(', ', array_keys($data)).") VALUES (:".implode(', :', array_keys($data)).")");
    
        $statement->execute($data);

        /*
        return  $this->pdoConnection->query('SELECT id , name , email , password , api_token FROM user', \PDO::FETCH_CLASS, $this->className)->fetch(\PDO::FETCH_OBJ);
        */
        
        return $this->pdoConnection->query('SELECT * FROM ' . $this->table .' ORDER BY id DESC LIMIT 1', \PDO::FETCH_CLASS, $this->className)->fetch(\PDO::FETCH_OBJ);
        
        
    }


    public function update(int $id, array $data)
    {
        
        $query = "UPDATE $this->table SET";

        foreach ($data as $name => $value) {
            $query .= ' '.$name.' = :'.$name.','; 
            $values[':'.$name] = $value; 
        }
        $query = substr($query, 0, -1).' WHERE id =:id ;'; 
        
        $statement = $this->pdoConnection->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, $this->className);
        $statement->execute($data);
        /*
        return $this->pdoConnection->query('SELECT id, title, done, parent_id, user_id, created_at, updated_at FROM ' . $this->table .' WHERE id = '.$id, \PDO::FETCH_CLASS, $this->className)->fetch(\PDO::FETCH_OBJ);
        */
        /*
        return $this->pdoConnection->query('SELECT * FROM ' . $this->table .' ORDER BY id DESC LIMIT 1', \PDO::FETCH_CLASS, $this->className)->fetch(\PDO::FETCH_OBJ);
        */

        return $this->selectOneById($id);


        
    }
}
