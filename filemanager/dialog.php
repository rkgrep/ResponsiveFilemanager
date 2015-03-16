<?php
use Illuminate\Http;

require dirname(__DIR__) . '/vendor/autoload.php';

$config = include 'config/config.php';
//TODO switch to array
extract($config, EXTR_OVERWRITE);

$request = Http\Request::createFromGlobals();
$filesystem = new \Illuminate\Filesystem\Filesystem();

$akey = $request->get('akey', 'key');

if (USE_ACCESS_KEYS == true)
{
	$access_keys = array_get($config, 'access_keys', array());
	if ( ! $akey || empty($access_keys) || ! in_array($akey, $access_keys))
	{

		$r = new Http\Response('Access denied', Http\Response::HTTP_UNAUTHORIZED);
		$r->send();
		exit;
	}
}

$_SESSION['RF']["verify"] = "RESPONSIVEfilemanager";

if ($request->getMethod() == 'POST')
{
	include 'upload.php';
	exit;
}

include 'include/utils.php';

$fldr = $request->get('fldr', '');

if (strpos($fldr, './') !== false)
{
	$r = new Http\Response('Access denied', Http\Response::HTTP_UNAUTHORIZED);
	$r->send();
	exit;
}

if ($fldr)
{
	$subdir = urldecode(trim(strip_tags($fldr), "/") . "/");
	$_SESSION['RF']["filter"] = '';
}
else
{
	$subdir = '';
}

if ($subdir == '')
{
	if ( ! empty($_COOKIE['last_position']) && strpos($_COOKIE['last_position'], '.') === false)
	{
		$subdir = trim($_COOKIE['last_position']);
	}
}

//remember last position
setcookie('last_position', $subdir, time() + (86400 * 7));

// If hidden folders are specified
if (count($config['hidden_folders']))
{
	// If hidden folder appears in the path specified in URL parameter "fldr"
	$dirs = explode('/', $subdir);
	foreach ($dirs as $dir)
	{
		if ($dir !== '' && in_array($dir, $hidden_folders))
		{
			// Ignore the path
			$subdir = "";
			break;
		}
	}
}

/***
 *SUB-DIR CODE
 ***/

if ( ! isset($_SESSION['RF']["subfolder"]))
{
	$_SESSION['RF']["subfolder"] = '';
}
$rfm_subfolder = '';

if ( ! empty($_SESSION['RF']["subfolder"]) && strpos($_SESSION['RF']["subfolder"], '../') === false
	&& strpos($_SESSION['RF']["subfolder"], './') === false && strpos($_SESSION['RF']["subfolder"], "/") !== 0
	&& strpos($_SESSION['RF']["subfolder"], '.') === false
)
{
	$rfm_subfolder = $_SESSION['RF']['subfolder'];
}

if ($rfm_subfolder != "" && $rfm_subfolder[ strlen($rfm_subfolder) - 1 ] != "/")
{
	$rfm_subfolder .= "/";
}

if ( ! file_exists($current_path . $rfm_subfolder . $subdir))
{
	$subdir = '';
	if ( ! file_exists($current_path . $rfm_subfolder . $subdir))
	{
		$rfm_subfolder = "";
	}
}

if (trim($rfm_subfolder) == "")
{
	$cur_dir = $upload_dir . $subdir;
	$cur_path = $current_path . $subdir;
	$thumbs_path = $thumbs_base_path;
	$parent = $subdir;
}
else
{
	$cur_dir = $upload_dir . $rfm_subfolder . $subdir;
	$cur_path = $current_path . $rfm_subfolder . $subdir;
	$thumbs_path = $thumbs_base_path . $rfm_subfolder;
	$parent = $rfm_subfolder . $subdir;
}

$cycle = true;
$max_cycles = 50;
$i = 0;
while ($cycle && $i < $max_cycles)
{
	$i++;
	if ($parent == "./")
	{
		$parent = "";
	}

	if (file_exists($current_path . $parent . "config.php"))
	{
		require_once $current_path . $parent . "config.php";
		$cycle = false;
	}

	if ($parent == "")
	{
		$cycle = false;
	}
	else
	{
		$parent = fix_dirname($parent) . "/";
	}
}

if (array_get($config, 'thumbs_type', 'local') == 'local')
{
	if ( ! is_dir($thumbs_path . $subdir))
	{
		$filesystem->makeDirectory($thumbs_path . $subdir, 0755, true);
	}
}

$popup = ! ! strip_tags($request->get('popup', 0));
$crossdomain = ! ! strip_tags($request->get('crossdomain', 0));

//view type
if ($request->has('view'))
{
	$view = fix_get_params($request->get('view', $view));
	$_SESSION['RF']["view_type"] = $view;
}

if ( ! isset($_SESSION['RF']["view_type"]))
{
	$view = $default_view;
	$_SESSION['RF']["view_type"] = $view;
}

$view = $_SESSION['RF']["view_type"];

//filter
$filter = "";
if (isset($_SESSION['RF']["filter"]))
{
	$filter = $_SESSION['RF']["filter"];
}

if ($request->has("filter"))
{
	$filter = fix_get_params($request->get("filter"));
}

if ( ! isset($_SESSION['RF']['sort_by']))
{
	$_SESSION['RF']['sort_by'] = 'name';
}

if ($request->has("sort_by"))
{
	$sort_by = $_SESSION['RF']['sort_by'] = fix_get_params($request->get("sort_by"));
}
else
{
	$sort_by = $_SESSION['RF']['sort_by'];
}


if ( ! isset($_SESSION['RF']['descending']))
{
	$_SESSION['RF']['descending'] = true;
}

if ($request->has("descending"))
{
	$descending = $_SESSION['RF']['descending'] = fix_get_params($request->get("descending")) === "true";
}
else
{
	$descending = $_SESSION['RF']['descending'];
}

$return_relative_url = $request->get('relative_url', "0") == "1" ? true : false;

$type = $request->get('type', 0);
$field_id = $request->get('field_id', '');


$get_params = http_build_query(array(
	'type'         => $type,
	'lang'         => $lang,
	'popup'        => $popup,
	'crossdomain'  => $crossdomain,
	'field_id'     => $field_id,
	'relative_url' => $return_relative_url,
	'akey'         => (isset($_GET['akey']) && $_GET['akey'] != '' ? $_GET['akey'] : 'key'),
	'fldr'         => ''
));

$class_ext = '';
$src = '';

if ($type==1) 	 $apply = 'apply_img';
elseif($type==2) $apply = 'apply_link';
elseif($type==0 && $field_id=='') $apply = 'apply_none';
elseif($type==3) $apply = 'apply_video';
else $apply = 'apply';

$files = $filesystem->allFiles($current_path.$rfm_subfolder.$subdir);
$n_files=count($files);

//php sorting
$sorted = array();
$current_folder = array();
$prev_folder = array();

foreach ($files as $k => $file)
{
	/** @var \Symfony\Component\Finder\SplFileInfo $file */
	$file->getRealPath();
	if (is_dir($file->getRealPath()))
	{
		$date = $file->getMTime();
		if ($show_folder_size)
		{
			$size = $file->getSize();
			//$size = foldersize($current_path . $rfm_subfolder . $subdir . $file);
		}
		else
		{
			$size = 0;
		}
		$file_ext = trans('Type_dir');
		$sorted[ $k ] = array(
			'file' => $file->getFilename(),
			'file_lcase' => strtolower($file->getFilename()),
			'date' => $file->getMTime(),
			'size' => $size,
			'extension' => $file->getExtension(),
			'extension_lcase' => strtolower($file->getExtension())
		);
	}
	else
	{
		$sorted[ $k ] = array(
			'file' => $file->getFilename(),
			'file_lcase' => strtolower($file->getFilename()),
			'date' => $file->getMTime(),
			'size' => $file->getSize(),
			'extension' => $file->getExtension(),
			'extension_lcase' => strtolower($file->getExtension())
		);
	}
}

// Should lazy loading be enabled
$lazy_loading_enabled = ($lazy_loading_file_number_threshold == 0 || $lazy_loading_file_number_threshold != -1 && $n_files > $lazy_loading_file_number_threshold) ? true : false;


switch($sort_by){
	case 'date':
		usort($sorted, function($x, $y) {
			return $x['date'] <  $y['date'];
		});
		break;
	case 'size':
		usort($sorted, function($x, $y) {
			return $x['size'] <  $y['size'];
		});
		break;
	case 'extension':
		usort($sorted, function($x, $y) {
			return $x['extension_lcase'] <  $y['extension_lcase'];
		});
		break;
	default:
		usort($sorted, function($x, $y) {
			return $x['file_lcase'] <  $y['file_lcase'];
		});
		break;
}

if(!$descending){
	$sorted = array_reverse($sorted);
}

$files = array_merge(array($prev_folder),array($current_folder),$sorted);

$jplayer_ext=array("mp4","flv","webmv","webma","webm","m4a","m4v","ogv","oga","mp3","midi","mid","ogg","wav");


ob_start();
include __DIR__ . '/views/dialog.php';
$html = ob_get_contents();
ob_end_clean();

$r = new Http\Response($html, Http\Response::HTTP_OK);
$r->send();