<?php

class User
{
    private $id;
    private $login;
    private $password;
    private $email;
    private $name;

    /**
     * Создает объект пользователя с заданными свойствами.
     */
    public function __construct(array $userdata)
    {
        $this->id = ($userdata['id']) ? $userdata['id'] : null;
        $this->login = $userdata['login'];
        $this->password = $userdata['password'];
        $this->email = $userdata['email'];
        $this->name = $userdata['name'];
    }

    public function getID()
    {
        return $this->id;
    }

    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Метод построчно выводит все свойства пользователя.
     * Использовался при отладке приложения.
     */
    public function describe()
    {
        foreach($this as $key => $value)
        {
            echo "{$key}: {$value}<br>";
        }
    }
}