<?php

class FeedModel {

    /**
     * Select all from db table and return list of feeds as object
     * @return object
     */
    public static function all() {
        $list = [];
        $db = Db::getInstance();
        $request = $db->query('SELECT * FROM rss');

        // create a list of FeedModel objects from the db results
        foreach($request->fetchAll() as $feed) {
            $list[] = (object) $feed;
        }
        return (object) $list;
    }

    /**
     * Get instance of db, ensure $id is an integer, replace :id with our actual $id value in prepared query
     * Return single feed as object from id
     *
     * @param $id
     * @return mixed
     */
    public static function find($id) {
        $db = Db::getInstance();
        $id = intval($id);
        $request = $db->prepare('SELECT * FROM rss WHERE id = :id');
        $request->execute(array('id' => $id));
        $feed = $request->fetch();
        return (object) $feed;
    }

    /**
     * Get instance of db prepare and execute delete query targeting entry by id
     *
     * @param $id
     */
    public static function delete($id) {
        $db = Db::getInstance();
        $id = intval($id);
        $request = $db->prepare('DELETE FROM rss WHERE id = :id');
        $request->execute(array('id' => $id));
    }

    /**
     * Get db instance, check feed exists using the url var, if not execute prepared insert query
     * @param $url
     * @return bool
     */
    public static function add($url) {
        $db = Db::getInstance();
        if(!self::checkFeedExistsByUrl( $url )){
            $request = $db->prepare('INSERT INTO rss (url) VALUES (:url)');
            $request->execute(array('url' => $url));
            return true;
        }
        return false;
    }

    /**
     * Get db instance, execute prepared update query
     *
     * @param $id
     * @param $url
     */
    public static function edit($id, $url) {
        $db = Db::getInstance();
        $request = $db->prepare('UPDATE rss set url = :url WHERE id = :id');
        $request->execute(array('id' => $id, 'url' => $url));
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getUrlFromId($id){
        $db = Db::getInstance();
        $request = $db->prepare('SELECT url FROM rss WHERE id = :id');
        $request->execute(array('id' => $id));
        $value = $request->fetch();
        return $value['url'];
    }

    /**
     * @param $url
     * @return bool
     */
    public static function checkFeedExistsByUrl($url ){
        $db = Db::getInstance();
        $request = $db->prepare('SELECT * FROM rss WHERE url = :url');
        $request->execute(array('url' => $url));
        if($request->fetch()) return true;
        return false;
    }
}