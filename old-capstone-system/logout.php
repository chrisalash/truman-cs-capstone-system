<?php
//Logs user out of CAS
require_once( 'config.php' );
require_once( $phpcas_path . '/CAS.php' );
phpCAS::setDebug();
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
phpCAS::setNoCasServerValidation();
phpCAS::logout();
session_destroy();
session_regenerate_id(TRUE);
session_start();
?>
