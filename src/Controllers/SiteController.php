<?php

class SiteController
{
    public function actionIndex()
    {
        $urlsList = array();
        $urlsList = Urls::getUrlsList();
        require_once (ROOT.'/Views/site/index.php');
        return true;
    }
    public function actionGo($url)
    {
        $realUrl = base64_decode($url);
        Urls::incrementUrl($realUrl);
        header('Location: '.$realUrl);
        die();
    }
}