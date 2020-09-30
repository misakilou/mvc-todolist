<?php


namespace Model;
use JsonSerializable;
/**
 * Class Task
 *
 */
class Task implements JsonSerializable
{
    private $id;
    private $title;
    private $done;
    private $user_id;
    private $parent_id;
    public $subtasks;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Task
     */
    public function setId($id): Task
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return Task
     */
    public function setTitle($title):Task
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDone(): bool
    {
        return $this->done;
    }

    /**
     * @param mixed $done
     *
     * @return Task
     */
    public function setDone($done):Task
    {
        $this->done = $done;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @param mixed $done
     *
     * @return Task
     */
    public function setUserId($user_id):Task
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParentId()
    {
        return $this->parent_id;
    }

    /**
     * @param mixed $done
     *
     * @return Task
     */
    public function setParentId($parent_id):Task
    {
        $this->parent_id = $parent_id;

        return $this;
    }


    public function getSubtasks(){
        return $this->subtasks; 
    }

    public function setSubtasks($subtasks):Task
    {
        $this->subtasks = $subtasks;

        return $this;
    }


    
    public function jsonSerialize() {
        // do something 
        return [
                'id' => $this->id,
                'title' => $this->title,
                'done' => $this->done,
                'user_id' => $this->user_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'subtasks' => $this->subtasks
        ];
    }


}


