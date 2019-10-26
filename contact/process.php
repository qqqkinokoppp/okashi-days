<?php
    require_once('../../Config.php');
    require_once(Config::APP_ROOT_DIR . 'classes/util/Session.php');
    require_once(Config::APP_ROOT_DIR . 'classes/util/Common.php');
    require_once(Config::APP_ROOT_DIR . 'classes/util/Safety.php');
    require_once(Config::APP_ROOT_DIR . 'classes/model/ContactManage.php');
    // セッション開始
    Session::sessionStart();
    // var_dump($_SESSION['post']['contact']);
    // exit;
    try
    {
        $db = new ContactManage();
        $db ->addContact($_SESSION['post']['contact']);

        
        header('Location: complete.php');
        exit;
    }
    catch(Exception $e)
    {
        var_dump($e);
    }
?>