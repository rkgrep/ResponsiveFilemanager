<!-- breadcrumb div start -->

<div class="row-fluid">
	<?php
	$link="dialog.php?".$get_params;
	?>
	<ul class="breadcrumb">
		<li class="pull-left"><a href="<?php echo $link?>/"><i class="icon-home"></i></a></li>
		<li><span class="divider">/</span></li>
		<?php
		$bc=explode("/",$subdir);
		$tmp_path='';
		if(!empty($bc))
			foreach($bc as $k=>$b){
				$tmp_path.=$b."/";
				if($k==count($bc)-2){
					?> <li class="active"><?php echo $b?></li><?php
				}elseif($b!=""){ ?>
					<li><a href="<?php echo $link.$tmp_path?>"><?php echo $b?></a></li><li><span class="divider"><?php echo "/"; ?></span></li>
				<?php }
			}
		?>
		<li class="pull-right"><a class="btn-small" href="javascript:void('')" id="info"><i class="icon-question-sign"></i></a></li>
		<li class="pull-right"><a class="btn-small" href="javascript:void('')" id="lang_change_btn"><i class="icon-globe"></i></a></li>
		<li class="pull-right"><a id="refresh" class="btn-small" href="dialog.php?<?php echo $get_params.$subdir."&".uniqid() ?>"><i class="icon-refresh"></i></a></li>

		<li class="pull-right">
			<div class="btn-group">
				<a class="btn dropdown-toggle sorting-btn" data-toggle="dropdown" href="#">
					<i class="icon-signal"></i>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu pull-left sorting">
					<li class="text-center"><strong><?php echo trans('Sorting') ?></strong></li>
					<li><a class="sorter sort-name <?php if($sort_by=="name"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="name"><?php echo trans('Filename'); ?></a></li>
					<li><a class="sorter sort-date <?php if($sort_by=="date"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="date"><?php echo trans('Date'); ?></a></li>
					<li><a class="sorter sort-size <?php if($sort_by=="size"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="size"><?php echo trans('Size'); ?></a></li>
					<li><a class="sorter sort-extension <?php if($sort_by=="extension"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="extension"><?php echo trans('Type'); ?></a></li>
				</ul>
			</div>
		</li>
	</ul>
</div>
<!-- breadcrumb div end -->