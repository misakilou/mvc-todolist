<?php

namespace Model;
class User
{

    private const PASSWORD_BCRYPT = PASSWORD_BCRYPT;

    private $name;
    private $email;
    private $password;
    private $api_token;
    private $id;


    public function getId(): int
    {
        return $this->id;
    }


    public function setId($id): User
    {
        $this->id = $id;

        return $this;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): User
    {
        $this->name = $name;

        return $this;
    }


    public function getApiToken(): string
    {
        return $this->api_token;
    }


    public function setApiToken($done): User
    {
        $this->api_token = $api_token;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }







   
}