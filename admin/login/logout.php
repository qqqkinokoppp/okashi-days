<?php
require_once('../../classes/Config.php');
require_once(Config::APP_ROOT_DIR.'classes/util/Session.php');

Session::sessionDestroy();

header('Location:../login/');
?>