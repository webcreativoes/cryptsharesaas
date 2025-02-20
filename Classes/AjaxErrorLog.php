<?php
require_once('lib/init.php');
writeRestLog ($input['error'],$input['rootAction'],$input['declaration'],NULL,NULL,$input['errorHeader'] );
echo json_encode( array('Message' => 'Log written'), true);