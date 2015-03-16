<?php

use Illuminate\Http;

require dirname(__DIR__) . '/vendor/autoload.php';

$config = include 'config/config.php';
//TODO switch to array
extract($config, EXTR_OVERWRITE);

$request = Http\Request::createFromGlobals();

if($_SESSION['RF']["verify"] != "RESPONSIVEfilemanager") die('forbiden');

include 'include/utils.php';
include 'include/mime_type_lib.php';

$path = $request->get('path', null);
$name = $request->get('name', null);

if (
	!$path || !$name
	|| strpos($path,'/') === 0
    || strpos($path,'../') !== false
    || strpos($path,'./') === 0
	|| strpos($name,'/') !== false
)
{
	$r = new Http\Response('Wrong path', Http\Response::HTTP_BAD_REQUEST);
	$r->send();
	exit;
}

$path = $current_path . $path;

$info = pathinfo($name);

if (!in_array(fix_strtolower($info['extension']), $ext))
{
	$r = new Http\Response('Wrong extension', Http\Response::HTTP_BAD_REQUEST);
	$r->send();
	exit;
}

$img_size = (string)(filesize($path.$name)); // Get the image size as string

$mime_type = get_file_mime_type( $path.$name ); // Get the correct MIME type depending on the file.

header('Pragma: private');
header('Cache-control: private, must-revalidate');
header("Content-Type: " . $mime_type); // Set the correct MIME type
header("Content-Length: " . $img_size );
header('Content-Disposition: attachment; filename="'.($name).'"');
readfile($path.$name);

exit;