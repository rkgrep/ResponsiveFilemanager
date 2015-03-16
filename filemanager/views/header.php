<!-- header div start -->
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="brand"><?php echo trans('Toolbar'); ?> -></div>
			<div class="nav-collapse collapse">
				<div class="filters">
					<div class="row-fluid">
						<div class="span4 half">
							<span class="mobile-inline-visible"><?php echo trans('Operations'); ?>:</span>
							<?php if($upload_files){ ?>
								<button class="tip btn upload-btn" title="<?php echo  trans('Upload_file'); ?>"><i class="rficon-upload"></i></button>
							<?php } ?>
							<?php if($create_text_files){ ?>
								<button class="tip btn create-file-btn" title="<?php echo  trans('New_File'); ?>"><i class="icon-plus"></i><i class="icon-file"></i></button>
							<?php } ?>
							<?php if($create_folders){ ?>
								<button class="tip btn new-folder" title="<?php echo  trans('New_Folder')?>"><i class="icon-plus"></i><i class="icon-folder-open"></i></button>
							<?php } ?>
							<?php if($copy_cut_files || $copy_cut_dirs){ ?>
								<button class="tip btn paste-here-btn" title="<?php echo trans('Paste_Here'); ?>"><i class="rficon-clipboard-apply"></i></button>
								<button class="tip btn clear-clipboard-btn" title="<?php echo trans('Clear_Clipboard'); ?>"><i class="rficon-clipboard-clear"></i></button>
							<?php } ?>
						</div>
						<div class="span2 half view-controller">
							<span class="mobile-inline-visible"><?php echo trans('View'); ?>:</span>
							<button class="btn tip<?php if($view==0) echo " btn-inverse"; ?>" id="view0" data-value="0" title="<?php echo trans('View_boxes'); ?>"><i class="icon-th <?php if($view==0) echo "icon-white"; ?>"></i></button>
							<button class="btn tip<?php if($view==1) echo " btn-inverse"; ?>" id="view1" data-value="1" title="<?php echo trans('View_list'); ?>"><i class="icon-align-justify <?php if($view==1) echo "icon-white"; ?>"></i></button>
							<button class="btn tip<?php if($view==2) echo " btn-inverse"; ?>" id="view2" data-value="2" title="<?php echo trans('View_columns_list'); ?>"><i class="icon-fire <?php if($view==2) echo "icon-white"; ?>"></i></button>
						</div>
						<div class="span6 half types">
							<span><?php echo trans('Filters'); ?>:</span>
							<?php if($type!=1 && $type!=3){ ?>
								<input id="select-type-1" name="radio-sort" type="radio" data-item="ff-item-type-1" checked="checked"  class="hide"  />
								<label id="ff-item-type-1" title="<?php echo trans('Files'); ?>" for="select-type-1" class="tip btn ff-label-type-1"><i class="icon-file"></i></label>
								<input id="select-type-2" name="radio-sort" type="radio" data-item="ff-item-type-2" class="hide"  />
								<label id="ff-item-type-2" title="<?php echo trans('Images'); ?>" for="select-type-2" class="tip btn ff-label-type-2"><i class="icon-picture"></i></label>
								<input id="select-type-3" name="radio-sort" type="radio" data-item="ff-item-type-3" class="hide"  />
								<label id="ff-item-type-3" title="<?php echo trans('Archives'); ?>" for="select-type-3" class="tip btn ff-label-type-3"><i class="icon-inbox"></i></label>
								<input id="select-type-4" name="radio-sort" type="radio" data-item="ff-item-type-4" class="hide"  />
								<label id="ff-item-type-4" title="<?php echo trans('Videos'); ?>" for="select-type-4" class="tip btn ff-label-type-4"><i class="icon-film"></i></label>
								<input id="select-type-5" name="radio-sort" type="radio" data-item="ff-item-type-5" class="hide"  />
								<label id="ff-item-type-5" title="<?php echo trans('Music'); ?>" for="select-type-5" class="tip btn ff-label-type-5"><i class="icon-music"></i></label>
							<?php } ?>
							<input accesskey="f" type="text" class="filter-input <?php echo (($type!=1 && $type!=3) ? '' : 'filter-input-notype'); ?>" id="filter-input" name="filter" placeholder="<?php echo fix_strtolower(trans('Text_filter')); ?>..." value="<?php echo $filter; ?>"/><?php if($n_files>$file_number_limit_js){ ?><label id="filter" class="btn"><i class="icon-play"></i></label><?php } ?>

							<input id="select-type-all" name="radio-sort" type="radio" data-item="ff-item-type-all" class="hide"  />
							<label id="ff-item-type-all" title="<?php echo trans('All'); ?>" <?php if($type==1 || $type==3){ ?>style="visibility: hidden;" <?php } ?> data-item="ff-item-type-all" for="select-type-all" style="margin-rigth:0px;" class="tip btn btn-inverse ff-label-type-all"><i class="icon-align-justify icon-white"></i></label>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- header div end -->