<?php

namespace Model;


class TaskManager extends AbstractManager
{
    const TABLE = 'task';


    public function __construct()
    {
        parent::__construct(self::TABLE);
    }







}
