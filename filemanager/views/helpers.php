<!-- lightbox div start -->
<div id="previewLightbox" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
	<div class='lightbox-content'>
		<img id="full-img" src="">
	</div>
</div>
<!-- lightbox div end -->

<!-- loading div start -->
<div id="loading_container" style="display:none;">
	<div id="loading" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
	<img id="loading_animation" src="img/storing_animation.gif" alt="loading" style="z-index:10001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
</div>
<!-- loading div end -->

<!-- player div start -->
<div class="modal hide fade" id="previewAV">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><?php echo trans('Preview'); ?></h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid body-preview">
		</div>
	</div>

</div>
<!-- player div end -->
<img id='aviary_img' src='' class="hide"/>