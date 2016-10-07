<?php
use Lib\Cleanse;
use Lib\Feed;

class PostsController {

    /**
     *  Called with action param index is in URL
     * Set feeds array then load the list view
     * Load index view
     */
    public function index() {
        $feeds = FeedModel::all();
        require_once(__DIR__ . '/../views/posts/index.php');
    }

    /**
     * Called with action param view is in URL
     * Set feed list array, then load the view
     * If no id in GET then redirect to the error page
     */
    public function view()
    {
        if (isset($_GET['id'])) {
            $id = Cleanse::sanitiseNum($_GET['id']);
            $feed = FeedModel::find($id);
            $feedList = Feed::getFeed($feed->url);
            require_once(__DIR__ . '/../views/posts/view.php');
        } else {
            Route::call('pages', 'error');
            return;
        }
    }

    /**
     * Called with action param delete is in URL
     * If no id in GET then redirect to the error page
     * Sanitise GET id var, get $url from id, delete entry from db by id,
     * Call delete statement then load delete view
     * If no id in GET then redirect to the error page
     * Call error page when GET id var is missing
     */
    public function delete() {
        if (isset($_GET['id'])) {
            $id = Cleanse::sanitiseNum($_GET['id']);
            $url = FeedModel::getUrlFromId($id);
            FeedModel::delete($id);
            require_once(__DIR__ . '/../views/posts/delete.php');
        }
        else{
            Route::call('pages', 'error');
        }
    }

    /**
     * Called with action param add is in URL
     * Check for non-empty POST url var, sanitise and validate, call add statement in model
     * if feed does not already exist, set msg for display, load add view
     */
    public function add() {
        $msg = "";
        if (isset($_POST['url'])) {
            if (!empty($_POST['url'])) {
                $url = Cleanse::sanitiseUrl($_POST['url']);
                if (Cleanse::validateUrl($url)){
                    if(!FeedModel::checkFeedExistsByUrl($url)){
                        FeedModel::add($url);
                        $msg = "feed added" . "<br>";
                    } else {
                        $msg = "feed already exists" . "<br>";
                    }
                } else {
                    $msg = "feed invalid" . "<br>";
                }
            } else {
                $msg = "empty field, try again" . "<br>";
            }
        }
        require_once(__DIR__ . '/../views/posts/add.php');
    }

    /**
     * Called with action param edit is in URL
     * Check for GET id var, clean if found, set url var from id
     * Check for POST var, if form has been posted santitise url, id vars
     * If url is valid, changed from original load the edit view with msg
     */
    public function edit() {

        if (isset($_GET['id'])) {
            if (!empty($_GET['id'])) {
                $id = Cleanse::sanitiseNum($_GET['id']);
                $url = FeedModel::getUrlFromId($id);
            }
        }

        $msg = "";
        if (isset($_POST['url'])) {
            if (!empty($_POST['url'])) {
                $url = Cleanse::sanitiseUrl($_POST['url']);
                $id = Cleanse::sanitiseNum($_POST['id']);
                $new_url = $url;
                $orig_url = FeedModel::getUrlFromId($id);

                $new_url = trim(Cleanse::sanitiseUrl($new_url));

                if (Cleanse::validateUrl($new_url)) {
                    if( $new_url != $orig_url) {
                        FeedModel::edit($id, $new_url);
                        $msg = "feed changed" . "<br>";
                    }
                    else{
                        $msg = "feed left unchanged" . "<br>";
                    }
                } else {
                    $msg = "feed invalid" . "<br>";
                }
            } else {

                $msg = "empty field, try again" . "<br>";
            }
        }
        //declare empty vars if cant be set to avoid error in view
        //@TODO - vars need to be retrieved from db on empty submit

        if(!isset($id)) $id = "";
        if(!isset($url)) $url = "";

        require_once(__DIR__ . '/../views/posts/edit.php');
    }

}
