<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="robots" content="noindex,nofollow">
	<title>Responsive FileManager</title>
	<link rel="shortcut icon" href="img/ico/favicon.ico">
	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<?php
	$sprite_lang_file = 'img/spritemap_'.$lang.'.png';
	$sprite_lang_file2 = 'img/spritemap@2x_'.$lang.'.png';

	if ( ! file_exists($sprite_lang_file) || ! file_exists($sprite_lang_file2))
	{
		//fallback
		$sprite_lang_file = 'img/spritemap_en_EN.png';
		$sprite_lang_file2 = 'img/spritemap@2x_en_EN.png';
		if ( ! file_exists($sprite_lang_file) || ! file_exists($sprite_lang_file2))
		{
			// we are in deep ****
			echo '<script>console.log("Error: Spritemap not found!");</script>';
			// exit();
		}
	}
	?>
	<style>
		.dropzone .dz-default.dz-message,
		.dropzone .dz-preview .dz-error-mark,
		.dropzone-previews .dz-preview .dz-error-mark,
		.dropzone .dz-preview .dz-success-mark,
		.dropzone-previews .dz-preview .dz-success-mark,
		.dropzone .dz-preview .dz-progress .dz-upload,
		.dropzone-previews .dz-preview .dz-progress .dz-upload {
			background-image: url(<?php echo $sprite_lang_file; ?>);
		}

		@media all and (-webkit-min-device-pixel-ratio:1.5),(min--moz-device-pixel-ratio:1.5),(-o-min-device-pixel-ratio:1.5/1),(min-device-pixel-ratio:1.5),(min-resolution:138dpi),(min-resolution:1.5dppx) {
			.dropzone .dz-default.dz-message,
			.dropzone .dz-preview .dz-error-mark,
			.dropzone-previews .dz-preview .dz-error-mark,
			.dropzone .dz-preview .dz-success-mark,
			.dropzone-previews .dz-preview .dz-success-mark,
			.dropzone .dz-preview .dz-progress .dz-upload,
			.dropzone-previews .dz-preview .dz-progress .dz-upload {
				background-image: url(<?php echo $sprite_lang_file; ?>);
			}
		}
	</style>
	<!--[if lt IE 8]>
	<style>
		.img-container span, .img-container-mini span {
			display: inline-block;
			height: 100%;
		}
	</style>
	<![endif]-->

	<script src="js/plugins.js"></script>
	<script src="../bower_components/jPlayer/jquery.jplayer/jquery.jplayer.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<?php
	if ($aviary_active):
		$aviatry_script = is_ssl() ? "https://dme0ih8comzn4.cloudfront.net/js/feather.js" : "http://feather.aviary.com/js/feather.js";
		?>
	<script src="<?php echo $aviatry_script; ?>"></script>
	<?php endif; ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
	<![endif]-->

	<script>
		var ext_img=new Array('<?php echo implode("','", $ext_img)?>');
		var allowed_ext=new Array('<?php echo implode("','", $ext)?>');
		var image_editor=<?php echo $aviary_active?"true":"false"; ?>;
		//dropzone config
		Dropzone.options.myAwesomeDropzone =
		{
			dictInvalidFileType: "<?php echo trans('Error_extension');?>",
			dictFileTooBig: "<?php echo trans('Error_Upload'); ?>",
			dictResponseError: "SERVER ERROR",
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: <?php echo $MaxSizeUpload; ?>, // MB
			url: "upload.php",
			accept: function(file, done)
			{
				var extension=file.name.split('.').pop();
				extension=extension.toLowerCase();
				if ($.inArray(extension, allowed_ext) > -1)
				{
					done();
				}
				else
				{
					done("<?php echo trans('Error_extension');?>");
				}
			}
		};
		if (image_editor)
		{
			var featherEditor = new Aviary.Feather({
			<?php
				foreach ($aviary_defaults_config as $aopt_key => $aopt_val) {
			   ?>
			<?php echo $aopt_key; ?>: <?php echo json_encode($aopt_val); ?>,
			<?php } ?>
			onSave: function(imageID, newURL) {
				show_animation();
				var img = document.getElementById(imageID);
				img.src = newURL;
				$.ajax({
					type: "POST",
					url: "ajax_calls.php?action=save_img",
					data: { url: newURL, path:$('#sub_folder').val()+$('#fldr_value').val(), name:$('#aviary_img').data('name') }
				}).done(function( msg ) {
					featherEditor.close();
					d = new Date();
					$("figure[data-name='"+$('#aviary_img').data('name')+"']").find('img').each(function(){
						$(this).attr('src',$(this).attr('src')+"?"+d.getTime());
					});
					$("figure[data-name='"+$('#aviary_img').data('name')+"']").find('figcaption a.preview').each(function(){
						$(this).attr('data-url',$(this).data('url')+"?"+d.getTime());
					});
					hide_animation();
				});
				return false;
			},
			onError: function(errorObj) {
				bootbox.alert(errorObj.message);
				hide_animation();
			}

		});
		}
	</script>
	<script src="js/include.js"></script>
</head>
<body>
	<?php include __DIR__ . '/hidden_inputs.php'; ?>
	<?php if ($upload_files): ?>
	<?php include __DIR__ . '/uploader.php'; ?>
	<?php endif; ?>
	<div class="container-fluid">
		<?php include __DIR__ . '/header.php'; ?>
		<?php include __DIR__ . '/breadcrumbs.php'; ?>
		<div class="row-fluid ff-container">
			<div class="span12">
				<?php if(@opendir($current_path.$rfm_subfolder.$subdir)===FALSE): ?>
					<br/><div class="alert alert-error">There is an error! The upload folder there isn't. Check your config.php file. </div>
				<?php
				else:

				include __DIR__ . '/main.php';

				endif; ?>
			</div>
		</div>
	</div>
<script>
	var files_prevent_duplicate = new Array();
	<?php
	foreach ($files_prevent_duplicate as $key => $value): ?>
	files_prevent_duplicate[<?php echo $key;?>] = '<?php echo $value; ?>';
	<?php endforeach; ?>
</script>

<?php include __DIR__ . '/helpers.php'; ?>

<?php if ($lazy_loading_enabled) { ?>
	<script>
		$(function(){
			$(".lazy-loaded").lazyload({
				event: 'scrollstop'
			});
		});
	</script>
<?php } ?>
</body>
</html>