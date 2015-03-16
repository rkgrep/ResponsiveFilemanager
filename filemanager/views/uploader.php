<!-- uploader div start -->
<div class="uploader">
	<div class="text-center">
		<button class="btn btn-inverse close-uploader"><i class="icon-backward icon-white"></i> <?php echo trans('Return_Files_List') ?></button>
	</div>
	<div class="space10"></div><div class="space10"></div>
	<div class="tabbable upload-tabbable"> <!-- Only required for left/right tabs -->
		<?php if ($java_upload): ?>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab"><?php echo trans('Upload_base'); ?></a></li>
			<li><a href="#tab2" id="uploader-btn" data-toggle="tab"><?php echo trans('Upload_java'); ?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<?php endif; ?>
				<form action="dialog.php" method="post" enctype="multipart/form-data" id="myAwesomeDropzone" class="dropzone">
					<input type="hidden" name="path" value="<?php echo $cur_path ?>"/>
					<input type="hidden" name="path_thumb" value="<?php echo $thumbs_path . $subdir ?>"/>
					<div class="fallback">
						<?php echo trans('Upload_file') ?>:<br/>
						<input name="file" type="file" />
						<input type="hidden" name="fldr" value="<?php echo $subdir; ?>"/>
						<input type="hidden" name="view" value="<?php echo $view; ?>"/>
						<input type="hidden" name="type" value="<?php echo $type_param; ?>"/>
						<input type="hidden" name="field_id" value="<?php echo $field_id; ?>"/>
						<input type="hidden" name="relative_url" value="<?php echo $return_relative_url; ?>"/>
						<input type="hidden" name="popup" value="<?php echo $popup; ?>"/>
						<input type="hidden" name="lang" value="<?php echo $lang; ?>"/>
						<input type="hidden" name="filter" value="<?php echo $filter; ?>"/>
						<input type="submit" name="submit" value="<?php echo trans('OK') ?>" />
				</form>
			</div>
			<div class="upload-help"><?php echo trans('Upload_base_help'); ?></div>
			<?php if ($java_upload): ?>
		</div>
		<div class="tab-pane" id="tab2">
			<div id="iframe-container"></div>
			<div class="upload-help"><?php echo trans('Upload_java_help'); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>

</div>
<!-- uploader div start -->