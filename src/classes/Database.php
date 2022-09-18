<?php

class Database
{
    private $database = [];
    private $pathToDump = '';
    private $arrayIDs = [];
    private $arrayLogins = [];
    private $arrayEmails = [];
    public $salt = 'p-fJzViZIc2ze9wpI5uleuhQpPeUbBUf-XP6YRI1ZBY';

    /**
     * Попытка открытия файла базы данных, если файла нет - 
     * выводится сообщение и работа приложения прекращается.
     */
    public function __construct(string $fileDump = 'database')
    {
        $path = 'private/' . $fileDump . '.json';
        if (file_exists($path)) 
        {
            $this->pathToDump = $path;
            $dbDump = file_get_contents($this->pathToDump);
            if ($dbDump)
            {
                $this->database = json_decode($dbDump, true);
                $this->cacheDB();
            }
            else
            {
                $this->database = [];
            }
        }
        else
        {
            echo "ERROR: Cannot find database file.";
            exit;
        }
    }

    /**
     * Импровизированный кеш.
     */
    private function cacheDB()
    {
        $this->arrayIDs = array_column($this->database, 'id');
        $this->arrayLogins = array_column($this->database, 'login');
        $this->arrayEmails = array_column($this->database, 'email');
    }

    /**
     * Возвращает количество записей в базе данных.
     */
    public function length()
    {
        return count($this->database);
    }

    /**
     * Возвращает массив из имен пользователей.
     * Использовался в процесс отладки.
     */
    public function listUsernames()
    {
        return array_column($this->database, 'name');
    }

    /**
     * Create-метод добавления нового пользователя в базу.
     * Вычисляет следующий порядковый ID и сохраняет в базе 
     * вместе с другими данными пользователя.
     * Записывает базу данных в файл. Возвращает ID нового пользователя.
     */
    public function addUser(User $user)
    {
        $id = (!count($this->arrayIDs)) ? 1 : max($this->arrayIDs) + 1;
        
        $this->database[] = 
        [
            'id' => $id,
            'login' => $user->getLogin(),
            'password' => md5($user->getPassword() . $this->salt),
            'email' => $user->getEmail(),
            'name' => $user->getName()
        ];
        $this->cacheDB();
        file_put_contents($this->pathToDump, json_encode($this->database));

        return $id;
    }

    /**
     * Read-метод выборки пользователя по их уникальным свойствам.
     * В случае успеха возвращает объект класса User, иначе - false.
     */
    public function selectUser(string $key, $value)
    {
        if ($this->length())
        {
            switch ($key)
            {
                case 'id':
                    settype($value, 'integer');
                    $index = array_search($value, $this->arrayIDs);
                    break;
                case 'login':
                    $index = array_search($value, $this->arrayLogins);
                    break;
                case 'email':
                    $index = array_search($value, $this->arrayEmails);
                    break;
            }

            if ($index !== false)
            {
                return new User($this->database[$index]);
            }
            else
            {
                return false;
            }
        }
        else
        {
        return false;
        }
    }

    /**
     * Update-метод обновления неуникальных свойств пользователя.
     * В случае успеха возвращает ID пользователя.
     */
    public function updateUser(User $user)
    {
        $index = array_search($user->getID(), $this->arrayIDs);

        $this->database[$index]['password'] = md5($user->getPassword() . $this->salt);
        $this->database[$index]['email'] = $user->getEmail();
        $this->database[$index]['name'] = $user->getName();
        
        $this->cacheDB();
        file_put_contents($this->pathToDump, json_encode($this->database));

        return $user->getID();
    }

    /**
     * Delete-метод удвления пользователя из базы данных.
     * В случае успеха возвращает true.
     */
    public function deleteUser(User $user)
    {
        $index = array_search($user->getID(), $this->arrayIDs);

        unset($this->database[$index]);
        
        $this->cacheDB();
        file_put_contents($this->pathToDump, json_encode($this->database));

        return true;
    }
}