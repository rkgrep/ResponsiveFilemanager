<input type="hidden" id="popup" value="<?php echo $popup; ?>" />
<input type="hidden" id="crossdomain" value="<?php echo $crossdomain; ?>" />
<input type="hidden" id="view" value="<?php echo $view; ?>" />
<input type="hidden" id="subdir" value="<?php echo $subdir; ?>" />
<input type="hidden" id="cur_dir" value="<?php echo $cur_dir; ?>" />
<input type="hidden" id="cur_dir_thumb" value="<?php echo $thumbs_path.$subdir; ?>" />
<input type="hidden" id="insert_folder_name" value="<?php echo trans('Insert_Folder_Name'); ?>" />
<input type="hidden" id="new_folder" value="<?php echo trans('New_Folder'); ?>" />
<input type="hidden" id="ok" value="<?php echo trans('OK'); ?>" />
<input type="hidden" id="cancel" value="<?php echo trans('Cancel'); ?>" />
<input type="hidden" id="rename" value="<?php echo trans('Rename'); ?>" />
<input type="hidden" id="lang_duplicate" value="<?php echo trans('Duplicate'); ?>" />
<input type="hidden" id="duplicate" value="<?php if($duplicate_files) echo 1; else echo 0; ?>" />
<input type="hidden" id="base_url" value="<?php echo $base_url?>"/>
<input type="hidden" id="base_url_true" value="<?php echo base_url(); ?>"/>
<input type="hidden" id="fldr_value" value="<?php echo $subdir; ?>"/>
<input type="hidden" id="sub_folder" value="<?php echo $rfm_subfolder; ?>"/>
<input type="hidden" id="return_relative_url" value="<?php echo $return_relative_url == true ? 1 : 0;?>"/>
<input type="hidden" id="lazy_loading_file_number_threshold" value="<?php echo $lazy_loading_file_number_threshold?>"/>
<input type="hidden" id="file_number_limit_js" value="<?php echo $file_number_limit_js; ?>" />
<input type="hidden" id="sort_by" value="<?php echo $sort_by; ?>" />
<input type="hidden" id="descending" value="<?php echo $descending?1:0; ?>" />
<input type="hidden" id="current_url" value="<?php echo str_replace(array('&filter='.$filter),array(''),$base_url.$_SERVER['REQUEST_URI']); ?>" />
<input type="hidden" id="lang_show_url" value="<?php echo trans('Show_url'); ?>" />
<input type="hidden" id="copy_cut_files_allowed" value="<?php if($copy_cut_files) echo 1; else echo 0; ?>" />
<input type="hidden" id="copy_cut_dirs_allowed" value="<?php if($copy_cut_dirs) echo 1; else echo 0; ?>" />
<input type="hidden" id="copy_cut_max_size" value="<?php echo $copy_cut_max_size; ?>" />
<input type="hidden" id="copy_cut_max_count" value="<?php echo $copy_cut_max_count; ?>" />
<input type="hidden" id="lang_copy" value="<?php echo trans('Copy'); ?>" />
<input type="hidden" id="lang_cut" value="<?php echo trans('Cut'); ?>" />
<input type="hidden" id="lang_paste" value="<?php echo trans('Paste'); ?>" />
<input type="hidden" id="lang_paste_here" value="<?php echo trans('Paste_Here'); ?>" />
<input type="hidden" id="lang_paste_confirm" value="<?php echo trans('Paste_Confirm'); ?>" />
<input type="hidden" id="lang_files_on_clipboard" value="<?php echo trans('Files_ON_Clipboard'); ?>" />
<input type="hidden" id="clipboard" value="<?php echo ((isset($_SESSION['RF']['clipboard']['path']) && trim($_SESSION['RF']['clipboard']['path']) != null) ? 1 : 0); ?>" />
<input type="hidden" id="lang_clear_clipboard_confirm" value="<?php echo trans('Clear_Clipboard_Confirm'); ?>" />
<input type="hidden" id="lang_file_permission" value="<?php echo trans('File_Permission'); ?>" />
<input type="hidden" id="chmod_files_allowed" value="<?php if($chmod_files) echo 1; else echo 0; ?>" />
<input type="hidden" id="chmod_dirs_allowed" value="<?php if($chmod_dirs) echo 1; else echo 0; ?>" />
<input type="hidden" id="lang_change" value="<?php echo trans('Lang_Change'); ?>" />
<input type="hidden" id="edit_text_files_allowed" value="<?php if($edit_text_files) echo 1; else echo 0; ?>" />
<input type="hidden" id="lang_edit_file" value="<?php echo trans('Edit_File'); ?>" />
<input type="hidden" id="lang_new_file" value="<?php echo trans('New_File'); ?>" />
<input type="hidden" id="lang_filename" value="<?php echo trans('Filename'); ?>" />
<input type="hidden" id="lang_file_info" value="<?php echo fix_strtoupper(trans('File_info')); ?>" />
<input type="hidden" id="lang_edit_image" value="<?php echo trans('Edit_image'); ?>" />
<input type="hidden" id="lang_extract" value="<?php echo trans('Extract'); ?>" />
<input type="hidden" id="transliteration" value="<?php echo $transliteration?"true":"false"; ?>" />
<input type="hidden" id="convert_spaces" value="<?php echo $convert_spaces?"true":"false"; ?>" />
<input type="hidden" id="replace_with" value="<?php echo $convert_spaces? $replace_with : ""; ?>" />