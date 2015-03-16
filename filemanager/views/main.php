<h4 id="help"><?php echo trans('Swipe_help'); ?></h4>

<?php if(isset($folder_message)): ?>
	<div class="alert alert-block"><?php echo $folder_message; ?></div>
<?php endif; ?>

<?php if($show_sorting_bar): ?>
	<!-- sorter -->
	<div class="sorter-container <?php echo "list-view".$view; ?>">
		<?php foreach (
			array(
				'name' => 'Filename',
				'date' => 'Date',
				'size' => 'Size',
				'extension' => 'Type',
			) as $filter_type => $filter_name):
			$cls = ($sort_by==$filter_type) ? ' ' . (($descending) ? "descending" : "ascending") : '';
			?>

			<div class="file-<?php echo $filter_type; ?>">
				<a class="sorter sort-<?php echo $filter_type . $cls ; ?>" href="javascript:void('')" data-sort="<?php echo $filter_type; ?>">
					<?php echo trans($filter_name); ?>
				</a>
			</div>

		<?php endforeach; ?>

		<div class='img-dimension'>
			<?php echo trans('Dimension'); ?>
		</div>

		<div class='file-operations'>
			<?php echo trans('Operations'); ?>
		</div>
	</div>
<?php endif; ?>

<input type="hidden" id="file_number" value="<?php echo $n_files; ?>" />

<ul class="grid cs-style-2 list-view<?php echo $view; ?>" id="main-item-container">
	<?php

	foreach ($files as $file_array)
	{
		$file = $file_array['file'];

		if (
			$file == '.'
			|| (isset($file_array['extension']) && $file_array['extension']!=trans('Type_dir'))
			|| ($file == '..' && $subdir == '')
			|| in_array($file, $hidden_folders)
			|| ($filter!='' && $n_files>$file_number_limit_js && $file!=".." && strpos($file,$filter)===false))
		{
			continue;
		}

		$new_name = fix_filename($file,$transliteration);

		if ($file!='..' && $file!=$new_name) {
			//rename
			rename_folder($current_path.$subdir.$file,$new_name,$transliteration);
			$file=$new_name;
		}
		//add in thumbs folder if not exist
		if (!file_exists($thumbs_path.$subdir.$file))
		{
			create_folder(false,$thumbs_path.$subdir.$file);
		}

		$class_ext = 3;
		if ($file=='..' && trim($subdir) != '' )
		{
			$src = explode("/",$subdir);
			unset($src[count($src)-2]);
			$src=implode("/",$src);
			if($src=='') $src="/";
		}
		elseif ($file!='..')
		{
			$src = $subdir . $file."/";
		}

		?>
		<li data-name="<?php echo $file ?>" class="<?php if($file=='..') echo 'back'; else echo 'dir'; ?>" <?php if(($filter!='' && strpos($file,$filter)===false)) echo ' style="display:none;"'; ?>><?php
			$file_prevent_rename = false;
			$file_prevent_delete = false;
			if (isset($filePermissions[$file])) {
				$file_prevent_rename = isset($filePermissions[$file]['prevent_rename']) && $filePermissions[$file]['prevent_rename'];
				$file_prevent_delete = isset($filePermissions[$file]['prevent_delete']) && $filePermissions[$file]['prevent_delete'];
			}
			?><figure data-name="<?php echo $file ?>" class="<?php if($file=="..") echo "back-"; ?>directory" data-type="<?php if($file!=".."){ echo "dir"; } ?>">
				<?php if($file==".."){ ?>
					<input type="hidden" class="path" value="<?php echo str_replace('.','',dirname($rfm_subfolder.$subdir)); ?>"/>
					<input type="hidden" class="path_thumb" value="<?php echo dirname($thumbs_path.$subdir)."/"; ?>"/>
				<?php } ?>
				<a class="folder-link" href="dialog.php?<?php echo $get_params.rawurlencode($src)."&".uniqid() ?>">
					<div class="img-precontainer">
						<div class="img-container directory"><span></span>
							<img class="directory-img"  src="img/<?php echo $icon_theme; ?>/folder<?php if($file==".."){ echo "_back"; }?>.png" />
						</div>
					</div>
					<div class="img-precontainer-mini directory">
						<div class="img-container-mini">
							<span></span>
							<img class="directory-img"  src="img/<?php echo $icon_theme; ?>/folder<?php if($file==".."){ echo "_back"; }?>.png" />
						</div>
					</div>
					<?php if($file==".."){ ?>
					<div class="box no-effect">
						<h4><?php echo trans('Back') ?></h4>
					</div>
				</a>

			<?php }else{ ?>
				    </a>
				    <div class="box">
					<h4 class="<?php if($ellipsis_title_after_first_row){ echo "ellipsis"; } ?>"><a class="folder-link" data-file="<?php echo $file ?>" href="dialog.php?<?php echo $get_params.rawurlencode($src)."&".uniqid() ?>"><?php echo $file; ?></a></h4>
				    </div>
				    <input type="hidden" class="name" value="<?php echo $file_array['file_lcase'];  ?>"/>
				    <input type="hidden" class="date" value="<?php echo $file_array['date']; ?>"/>
				    <input type="hidden" class="size" value="<?php echo $file_array['size'];  ?>"/>
				    <input type="hidden" class="extension" value="<?php echo trans('Type_dir'); ?>"/>
				    <div class="file-date"><?php echo date(trans('Date_type'),$file_array['date'])?></div>
				    <?php if($show_folder_size){ ?><div class="file-size"><?php echo makeSize($file_array['size'])?></div><?php } ?>
				    <div class='file-extension'><?php echo trans('Type_dir'); ?></div>
				    <figcaption>
					    <a href="javascript:void('')" class="tip-left edit-button rename-file-paths <?php if($rename_folders && !$file_prevent_rename) echo "rename-folder"; ?>" title="<?php echo trans('Rename')?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir.$file; ?>">
					    <i class="icon-pencil <?php if(!$rename_folders || $file_prevent_rename) echo 'icon-white'; ?>"></i></a>
					    <a href="javascript:void('')" class="tip-left erase-button <?php if($delete_folders && !$file_prevent_delete) echo "delete-folder"; ?>" title="<?php echo trans('Erase')?>" data-confirm="<?php echo trans('Confirm_Folder_del'); ?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>"  data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
					    <i class="icon-trash <?php if(!$delete_folders || $file_prevent_delete) echo 'icon-white'; ?>"></i>
					    </a>
				    </figcaption>
			<?php } ?>
			</figure>
		</li>
	<?php
	}

	$files_prevent_duplicate = array();
	foreach ($files as $nu=>$file_array) {
	$file=$file_array['file'];

	if($file == '.' || $file == '..' || is_dir($current_path.$rfm_subfolder.$subdir.$file) || in_array($file, $hidden_files) || !in_array(fix_strtolower($file_array['extension']), $ext) || ($filter!='' && $n_files>$file_number_limit_js && strpos($file,$filter)===false))
		continue;

	$file_path=$current_path.$rfm_subfolder.$subdir.$file;
	//check if file have illegal caracter

	$filename=substr($file, 0, '-' . (strlen($file_array['extension']) + 1));

	if($file!=fix_filename($file,$transliteration)){
		$file1=fix_filename($file,$transliteration);
		$file_path1=($current_path.$rfm_subfolder.$subdir.$file1);
		if(file_exists($file_path1)){
			$i = 1;
			$info=pathinfo($file1);
			while(file_exists($current_path.$rfm_subfolder.$subdir.$info['filename'].".[".$i."].".$info['extension'])) {
				$i++;
			}
			$file1=$info['filename'].".[".$i."].".$info['extension'];
			$file_path1=($current_path.$rfm_subfolder.$subdir.$file1);
		}

		$filename=substr($file1, 0, '-' . (strlen($file_array['extension']) + 1));
		rename_file($file_path,fix_filename($filename,$transliteration),$transliteration);
		$file=$file1;
		$file_array['extension']=fix_filename($file_array['extension'],$transliteration);
		$file_path=$file_path1;
	}

	$is_img=false;
	$is_video=false;
	$is_audio=false;
	$show_original=false;
	$show_original_mini=false;
	$mini_src="";
	$src_thumb="";
	$extension_lower=fix_strtolower($file_array['extension']);
	if(in_array($extension_lower, $ext_img)){
		$src = $base_url . $cur_dir . rawurlencode($file);
		$mini_src = $src_thumb = $thumbs_path.$subdir. $file;
		//add in thumbs folder if not exist
		if(!file_exists($src_thumb)){
			try {
				if(!create_img($file_path, $src_thumb, 122, 91)){
					$src_thumb=$mini_src="";
				}else{
					new_thumbnails_creation($current_path.$rfm_subfolder.$subdir,$file_path,$file,$current_path,'','','','','','','',$fixed_image_creation,$fixed_path_from_filemanager,$fixed_image_creation_name_to_prepend,$fixed_image_creation_to_append,$fixed_image_creation_width,$fixed_image_creation_height,$fixed_image_creation_option);
				}
			} catch (Exception $e) {
				$src_thumb=$mini_src="";
			}
		}
		$is_img=true;
		//check if is smaller than thumb
		list($img_width, $img_height, $img_type, $attr)=@getimagesize($file_path);
		if($img_width<122 && $img_height<91){
			$src_thumb=$current_path.$rfm_subfolder.$subdir.$file;
			$show_original=true;
		}

		if($img_width<45 && $img_height<38){
			$mini_src=$current_path.$rfm_subfolder.$subdir.$file;
			$show_original_mini=true;
		}
	}
	$is_icon_thumb=false;
	$is_icon_thumb_mini=false;
	$no_thumb=false;
	if($src_thumb==""){
		$no_thumb=true;
		if(file_exists('img/'.$icon_theme.'/'.$extension_lower.".jpg")){
			$src_thumb ='img/'.$icon_theme.'/'.$extension_lower.".jpg";
		}else{
			$src_thumb = "img/".$icon_theme."/default.jpg";
		}
		$is_icon_thumb=true;
	}
	if($mini_src==""){
		$is_icon_thumb_mini=false;
	}

	$class_ext=0;
	if (in_array($extension_lower, $ext_video)) {
		$class_ext = 4;
		$is_video=true;
	}elseif (in_array($extension_lower, $ext_img)) {
		$class_ext = 2;
	}elseif (in_array($extension_lower, $ext_music)) {
		$class_ext = 5;
		$is_audio=true;
	}elseif (in_array($extension_lower, $ext_misc)) {
		$class_ext = 3;
	}else{
		$class_ext = 1;
	}
	if((!($type==1 && !$is_img) && !(($type==3 && !$is_video) && ($type==3 && !$is_audio))) && $class_ext>0){
	?>
	<li class="ff-item-type-<?php echo $class_ext; ?> file"  data-name="<?php echo $file; ?>" <?php if(($filter!='' && strpos($file,$filter)===false)) echo ' style="display:none;"'; ?>><?php
		$file_prevent_rename = false;
		$file_prevent_delete = false;
		if (isset($filePermissions[$file])) {
			if (isset($filePermissions[$file]['prevent_duplicate']) && $filePermissions[$file]['prevent_duplicate']) {
				$files_prevent_duplicate[] = $file;
			}
			$file_prevent_rename = isset($filePermissions[$file]['prevent_rename']) && $filePermissions[$file]['prevent_rename'];
			$file_prevent_delete = isset($filePermissions[$file]['prevent_delete']) && $filePermissions[$file]['prevent_delete'];
		}
		?>		<figure data-name="<?php echo $file ?>" data-type="<?php if($is_img){ echo "img"; }else{ echo "file"; } ?>">
			<a href="javascript:void('')" class="link" data-file="<?php echo $file; ?>" data-field_id="<?php echo $field_id; ?>" data-function="<?php echo $apply; ?>">
				<div class="img-precontainer">
					<?php if($is_icon_thumb){ ?><div class="filetype"><?php echo $extension_lower ?></div><?php } ?>
					<div class="img-container">
						<span></span>
						<img class="<?php echo $show_original ? "original" : "" ?><?php echo $is_icon_thumb ? " icon" : "" ?><?php echo $lazy_loading_enabled ? " lazy-loaded" : ""?>" <?php echo $lazy_loading_enabled ? "data-original" : "src"?>="<?php echo $src_thumb; ?>">
					</div>
				</div>
				<div class="img-precontainer-mini <?php if($is_img) echo 'original-thumb' ?>">
					<div class="filetype <?php echo $extension_lower ?> <?php if(in_array($extension_lower, $editable_text_file_exts)) echo 'edit-text-file-allowed' ?> <?php if(!$is_icon_thumb){ echo "hide"; }?>"><?php echo $extension_lower ?></div>
					<div class="img-container-mini">
						<span></span>
						<?php if($mini_src!=""){ ?>
							<img class="<?php echo $show_original_mini ? "original" : "" ?><?php echo $is_icon_thumb_mini ? " icon" : "" ?><?php echo $lazy_loading_enabled ? " lazy-loaded" : ""?>" <?php echo $lazy_loading_enabled ? "data-original" : "src"?>="<?php echo $mini_src; ?>">
					<?php } ?>
					</div>
				</div>
				<?php if($is_icon_thumb){ ?>
					<div class="cover"></div>
				<?php } ?>
			</a>
			<div class="box">
				<h4 class="<?php if($ellipsis_title_after_first_row){ echo "ellipsis"; } ?>"><a href="javascript:void('')" class="link" data-file="<?php echo $file; ?>" data-field_id="<?php echo $field_id; ?>" data-function="<?php echo $apply; ?>">
						<?php echo $filename; ?></a> </h4>
			</div>
			<input type="hidden" class="date" value="<?php echo $file_array['date']; ?>"/>
			<input type="hidden" class="size" value="<?php echo $file_array['size'] ?>"/>
			<input type="hidden" class="extension" value="<?php echo $extension_lower; ?>"/>
			<input type="hidden" class="name" value="<?php echo $file_array['file_lcase']; ?>"/>
			<div class="file-date"><?php echo date(trans('Date_type'),$file_array['date'])?></div>
			<div class="file-size"><?php echo makeSize($file_array['size'])?></div>
			<div class='img-dimension'><?php if($is_img){ echo $img_width."x".$img_height; } ?></div>
			<div class='file-extension'><?php echo $extension_lower; ?></div>
			<figcaption>
				<form action="force_download.php" method="post" class="download-form" id="form<?php echo $nu; ?>">
					<input type="hidden" name="path" value="<?php echo $rfm_subfolder.$subdir?>"/>
					<input type="hidden" class="name_download" name="name" value="<?php echo $file?>"/>

					<a title="<?php echo trans('Download')?>" class="tip-right" href="javascript:void('')" onclick="$('#form<?php echo $nu; ?>').submit();"><i class="icon-download"></i></a>
					<?php if($is_img && $src_thumb!=""){ ?>
						<a class="tip-right preview" title="<?php echo trans('Preview')?>" data-url="<?php echo $src;?>" data-toggle="lightbox" href="#previewLightbox"><i class=" icon-eye-open"></i></a>
					<?php }elseif(($is_video || $is_audio) && in_array($extension_lower,$jplayer_ext)){ ?>
						<a class="tip-right modalAV <?php if($is_audio){ echo "audio"; }else{ echo "video"; } ?>"
						   title="<?php echo trans('Preview')?>" data-url="ajax_calls.php?action=media_preview&title=<?php echo $filename; ?>&file=<?php echo $current_path.$rfm_subfolder.$subdir.$file; ?>"
						   href="javascript:void('');" ><i class=" icon-eye-open"></i></a>
					<?php }elseif($preview_text_files && in_array($extension_lower,$previewable_text_file_exts)){ ?>
						<a class="tip-right file-preview-btn" title="<?php echo trans('Preview')?>" data-url="ajax_calls.php?action=get_file&sub_action=preview&preview_mode=text&title=<?php echo $filename; ?>&file=<?php echo $current_path.$rfm_subfolder.$subdir.$file; ?>"
						   href="javascript:void('');" ><i class=" icon-eye-open"></i></a>
					<?php }elseif($googledoc_enabled && in_array($extension_lower,$googledoc_file_exts)){ ?>
						<a class="tip-right file-preview-btn" title="<?php echo trans('Preview')?>" data-url="ajax_calls.php?action=get_file&sub_action=preview&preview_mode=google&title=<?php echo $filename; ?>&file=<?php echo $current_path.$rfm_subfolder.$subdir.$file; ?>"
						   href="docs.google.com;" ><i class=" icon-eye-open"></i></a>

					<?php }elseif($viewerjs_enabled && in_array($extension_lower,$viewerjs_file_exts)){ ?>
						<a class="tip-right file-preview-btn" title="<?php echo trans('Preview')?>" data-url="ajax_calls.php?action=get_file&sub_action=preview&preview_mode=viewerjs&title=<?php echo $filename; ?>&file=<?php echo $current_path.$rfm_subfolder.$subdir.$file; ?>"
						   href="docs.google.com;" ><i class=" icon-eye-open"></i></a>

					<?php }else{ ?>
						<a class="preview disabled"><i class="icon-eye-open icon-white"></i></a>
					<?php } ?>
					<a href="javascript:void('')" class="tip-left edit-button rename-file-paths <?php if($rename_files && !$file_prevent_rename) echo "rename-file"; ?>" title="<?php echo trans('Rename')?>" data-path="<?php echo $rfm_subfolder.$subdir .$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
						<i class="icon-pencil <?php if(!$rename_files || $file_prevent_rename) echo 'icon-white'; ?>"></i></a>

					<a href="javascript:void('')" class="tip-left erase-button <?php if($delete_files && !$file_prevent_delete) echo "delete-file"; ?>" title="<?php echo trans('Erase')?>" data-confirm="<?php echo trans('Confirm_del'); ?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
						<i class="icon-trash <?php if(!$delete_files || $file_prevent_delete) echo 'icon-white'; ?>"></i>
					</a>
				</form>
			</figcaption>
		</figure>
	</li>
	<?php
	}
	}

	?></div>
</ul>
