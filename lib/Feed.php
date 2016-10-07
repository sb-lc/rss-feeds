<?php

namespace Lib;

class Feed
{
    /**
     * Get http status of url, follows multiple redirects
     * @param string $url
     * @return bool return false if
     * @access private
     */

    private static function urlExists($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // set time out to 10 seconds
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //follow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($code == 200){
            $status = true;
        } else {
            $status = false;
        }
        curl_close($ch);

        return $status;
    }

    /**
     * Check for valid XML file
     *
     * @param $feed_url
     * @return bool
     */
    private static function xmlCheck($feed_url) {
        $xml = new \XMLReader();
        $xml->open($feed_url);
        $xml->setParserProperty(\XMLReader::VALIDATE, true);
        if( $xml->isValid()) {

            if( @simplexml_load_file($feed_url)) {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * Call XML check method, return true if valid
     *
     * @param $feed_url
     * @return bool
     */
    private static function checkFeed($feed_url){
        if( self::urlExists($feed_url)){
            if( self::xmlCheck($feed_url)){
                return true;
            }
        }
        return false;
    }

    /**
     * further inspection of XML file, validate XML structure
     * @param $feed_url
     * @return bool|\SimpleXmlElement
     */
    private static function setXml($feed_url){
        $content = file_get_contents($feed_url);
        if( $xml = new \SimpleXmlElement($content)) return $xml;
        return false;
    }


    /** Get object of feeds from XML file, check 2nd and 3rd level to recognise
     * common structures for RSS feeds
     *
     * @param $xml
     * @return mixed
     */
    private static function getFeedItems($xml){

        if (isset($xml->item)) {
            $obj = $xml->item;
        } else {
            $obj = $xml->channel->item;
        }

        return $obj;
    }

    /**
     * Get feed calling the check methods and output html
     *
     * @param $feed_url
     * @return bool
     */
    public static function getFeed($feed_url) {

        #Override with test urls
        #$feed_url = 'http://slashdot.org/rss/slashdot.rss'; #valid url with multiple url redirects - 200
        #$feed_url = 'https://slashdot.org/rss/slashdot.rss'; #valid url with single url redirect - 200
        #$feed_url = "http://rss.slashdot.org/Slashdot/slashdot"; #valid url with no url redirect - 200
        #$feed_url = 'https://slashdot.org/rss/slashdot2.rss'; #invalid url - 404
        #$feed_url = 'https://my-made-up-domain.com/fake.rss';# well-formed 404
        #$feed_url = "http://rtfi7rdxtcfygvubhjhgcf.com"; #nonesense url - still returns 200 ?? investigate

        if(self::checkFeed($feed_url)){

            $xml = self::setXml($feed_url);

            if($xml) {

                $obj = self::getFeedItems($xml);

                echo "<ul>";
                foreach ($obj as $entry) {
                    echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
                }
                echo "</ul>";
            }
        }
        else{
            echo "bad feed";//remove
            return false;
        }

        return true;
    }
}