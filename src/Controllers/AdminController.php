<?php

class AdminController
{
    private $login;
    private $password;

    public function __construct()
    {
        $this->login = 'admin';
        $this->password = md5('admin');
    }

    private function isLogged(): bool
    {
        return isset($_SESSION['login'])
            && isset($_SESSION['password'])
            && $_SESSION['login'] == $this->login
            && $_SESSION['password'] == $this->password;
    }

    private function checkLogging()
    {
        session_start();
        if (!$this->isLogged()) {
            header('Location: /admin/login');
            session_destroy();
            die();
        }
    }
    public function actionIndex(): bool
    {
        $this->checkLogging();
        $urlsList = array();
        $urlsList = Urls::getUrlsList();
        require_once (ROOT.'/Views/admin/index.php');
        return true;
    }
    public function actionUrlAdd()
    {
        $this->checkLogging();
        if (isset($_POST)) {
            Urls::addUrl($_POST['url']);
        }
        header('Location: /admin');
        die();
    }
    public function actionUrlRemove($id)
    {
        $this->checkLogging();
        Urls::removeUrlById($id);
        header('Location: /admin');
        die();
    }
    public function actionLogin()
    {
        if ($this->isLogged()) {
            header('Location: /admin');
            die();
        } else {
            if (isset($_POST['login']) && isset($_POST['password'])) {
                $login = $_POST['login'];
                $password = md5(trim($_POST['password']));
                if ($this->login == $login && $this->password == $password) {
                    session_start();
                    $_SESSION['login'] = $this->login;
                    $_SESSION['password'] = $this->password;
                    header('Location: /admin');
                    //die();
                } else {
                    header('Location: /admin/login');
                    die();
                }
            } else {
                require_once (ROOT.'/Views/admin/login.php');
            }
        }
        return true;
    }
    public function actionLogout()
    {
        session_start();
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        session_destroy();
        header('Location: /admin');
        die();
    }
}