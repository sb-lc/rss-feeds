<?php
use Lib\Cleanse;

Class Route{

    private $controller;
    private $action;

    /**
     * Route constructor.
     * call setters with sanitised $_GET variables : controller, action
     */
    public function __construct(){
        if (isset($_GET['controller'])) {
            $this->setController(Cleanse::sanitiseStr($_GET['controller']));
        }
        if (isset($_GET['action'])) {
            $this->setAction(Cleanse::sanitiseStr($_GET['action']));
        }
    }

    /**
     * Define dynamic path for controller, either posts or pages, wordpress style
     * @param $ctl
     * @param $act
     *
     *
     */
    static function call($ctl, $act) {

        $controllerPath = 'controllers/' . $ctl . '_controller.php';

        require_once($controllerPath);

        switch($ctl) {
            case 'pages':
                $ctl = new PagesController();
                break;
            case 'posts':
                // we need the model to query the database later in the controller
                require_once('models/feedModel.php');
                $ctl = new PostsController();
                break;
        }

        $ctl->{ $act }();
    }

    /**
     * Set $controllers array containing all valid controller URL params
     * call home page as default if both url params are not present
     * check URL params are present in array of permitted params
     * call error page if prohibited params are used
     */
    public function set(){

        $controllers = array(
            'pages' => ['home', 'error'],
            'posts' => ['index', 'view', 'add', 'edit', 'delete'],
        );

        if( !$this->getController() && !$this->getAction()){
            self::call('posts', 'index');
        }

        else {
            if (array_key_exists($this->controller, $controllers)) {
                if (in_array($this->action, $controllers[$this->controller])) {
                    self::call($this->controller, $this->action);
                } else {
                    self::call('pages', 'error');
                }
            } else {
                self::call('pages', 'error');
            }
        }

    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }
}

