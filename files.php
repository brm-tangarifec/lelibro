<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 * 
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
error_reporting(E_ALL | E_STRICT);
require('class/UploadHandler.php');
$upload_handler = new UploadHandler();

?>