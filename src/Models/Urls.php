<?php

class Urls
{
    public static function getUrlsList(): array
    {
        $db = Db::getConnection();
        $result = $db->query('SELECT `id`, `url`, `clicks` FROM `urls` ORDER BY ID DESC');
        $urlsList = array();
        $i = 0;
        while($row = $result->fetch()) {
            $urlsList[$i]['id'] = $row['id'];
            $urlsList[$i]['url'] = $row['url'];
            $urlsList[$i]['clicks'] = $row['clicks'];
            $i++;
        }
        return $urlsList;
    }
    public static function incrementUrl($url): bool
    {
        $db = Db::getConnection();
        $result = $db->query("UPDATE `urls` SET `clicks` = `clicks` + 1 WHERE `url`='{$url}'");
        return true;
    }
    public static function addUrl($url): bool
    {
        $db = Db::getConnection();
        $result = $db->query("INSERT INTO `urls`(`url`) VALUES ('{$url}')");
        return true;
    }
    public static function removeUrlById($id): bool
    {
        $db = Db::getConnection();
        $result = $db->query("DELETE FROM `urls` WHERE `id`='{$id}'");
        return true;
    }

}