<?php

class Validator
{
    private static $MIN_LOGIN_LENGTH = 6;
    private static $MIN_PASSWORD_LENGTH = 6;
    private static $MIN_NAME_LENGTH = 2;

    // Массив сообщений об ошибках
    private static $errors = 
    [
        'login' => '',
        'password' => '',
        'confirm_password' => '',
        'email' => '',
        'name' => '',
    ];
    
    /**
     * Статический метод проверки на соблюдение требований при регистрации нового пользователя.
     * Вызываются методы проверки отдельных полей. Если все требования соблюдены возвращает
     * false (ошибок нет), иначе - массив сообщений об ошибках.
     */
    public static function hasErrors(array $userdata)
    {
        $isLoginCorrect = self::loginValidation($userdata['login']);
        $isPasswordCorrect = self::passwordValidation($userdata['password'], $userdata['confirm_password']);
        $isEmailCorrect = self::emailValidation($userdata['email']);
        $isNameCorrect = self::nameValidation($userdata['name']);
        
        if ($isLoginCorrect && $isPasswordCorrect && $isEmailCorrect && $isNameCorrect)
        {
            return false;
        }
        else
        {
            return self::$errors;
        }
    }

    /**
     * Статических метод проверки при попытке входа пользователя.
     * Если введенные данный верны возвращает true, иначе - 
     * массив сообщений об ошибках.
     */
    public static function tryLogin(array $userdata)
    { 
        if (!$userdata['login'])
        {
            self::$errors['login'] = 'Required';
            return self::$errors;
        }

        if (!$userdata['password'])
        {
            self::$errors['password'] = 'Required';
            return self::$errors;
        }

        $db = new Database();
        $user = ($db) ? $db->selectUser('login', $userdata['login']): false;
        
        if (!$user)
        {
            self::$errors['login'] = 'User is not found';
            return self::$errors;
        }
        
        if ($user->getPassword() === md5($userdata['password'] . $db->salt))
        {
            return true;
        }
        else
        {
            self::$errors['password'] = 'Password is incorrect';
            return self::$errors;
        }
  }

  private static function loginValidation(string $login)
  {
        if (!$login) // если пустое поле
        {
            self::$errors['login'] = 'Required';
            return false;
        }

        if (preg_match("/\s+/u", $login)) // проверка на пробелы и другие пробельные символы
        {
            self::$errors['login'] = 'Login cannot contain whitespace characters';
            return false;
        }

        if (iconv_strlen($login) < self::$MIN_LOGIN_LENGTH) // проверка длины логина
        {
            self::$errors['login'] = 'Minimum ' . self::$MIN_LOGIN_LENGTH . ' characters';
            return false;
        }

        $db = new Database();
        $user = $db->selectUser('login', $login);
        if ($user) // проверка не занят ли указанный логин другим пользователем
        {
            self::$errors['login'] = 'This login is already registered';
            return false;
        }
        
        return true;
  }

  private static function passwordValidation(string $password, string $confirm)
  {
        if (!$password) // если пустое поле
        {
            self::$errors['password'] = 'Required';
            return false;
        }

        if (iconv_strlen($password) < self::$MIN_PASSWORD_LENGTH) // проверка длины пароля
        {
            self::$errors['password'] = 'Minimum ' . self::$MIN_PASSWORD_LENGTH . ' characters';
            return false;
        }

        // проверка на обязательное использование букв и цифр
        if (!preg_match("/[a-zA-Zа-яёЁ]+/u", $password) || !preg_match("/[0-9]+/u", $password))
        {
            self::$errors['password'] = 'Password must contain letters and numbers';
            return false;
        }

        if ($password !== $confirm) // проверка идентичности пароля и его подтверждения
        {
            self::$errors['confirm_password'] = 'Password and password confirmation must be identical';
            return false;
        }

        return true;
  }

  private static function emailValidation(string $email)
  {
        if (!$email) // если пустое поле
        {
            self::$errors['email'] = 'Required';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // проверка на соответствие E-mail
        {
            self::$errors['email'] = 'Enter a valid E-mail';
            return false;
        }

        $db = new Database();
        $user = $db->selectUser('email', $email);
        if ($user) // проверка не зарегистрирован ли указанный E-mail другим пользователем
        {
            self::$errors['email'] = 'This E-mail is already registered';
            return false;
        }

        return true;
  }

  private static function nameValidation(string $name)
  {
        if (!$name) // если пустое поле
        {
            self::$errors['name'] = 'Required';
            return false;
        }

        if (iconv_strlen($name) < self::$MIN_NAME_LENGTH) // проверка длины пароля
        {
            self::$errors['name'] = 'Minimum ' . self::$MIN_NAME_LENGTH . ' characters';
            return false;
        }

        if (!preg_match("/^[A-Za-zА-ЯЁа-яё]{2,}$/u", $name)) // проверка на использование только букв
        {
            self::$errors['name'] = 'Only letters are accepted';
            return false;
        }
        
        return true;
  }
}