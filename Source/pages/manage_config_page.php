<?php

# Copyright (c) 2012 John Reese
# Licensed under the MIT license

auth_reauthenticate();
access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();

print_manage_menu();

$t_remote_checkin = plugin_config_get( 'remote_checkin' );
$t_checkin_urls = unserialize( plugin_config_get( 'checkin_urls' ) );

$t_remote_imports = plugin_config_get( 'remote_imports' );
$t_import_urls = unserialize( plugin_config_get( 'import_urls' ) );

?>

<div class="col-md-12 col-xs-12">

	<div class="space-10"></div>
	
	<div class="form-container">
	
<form action="<?php echo plugin_page( 'manage_config' ) ?>" method="post">
<?php echo form_security_field( 'plugin_Source_manage_config' ) ?>

<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-file-o"></i>
			<?php echo plugin_lang_get( 'title' ), ': ', plugin_lang_get( 'configuration' ) ?>
		</h4>
	</div>
	
	<div class="widget-body">
		<div class="widget-main no-padding">
			<div class="table-responsive">


<table class="table table-striped table-bordered table-condensed table-hover">

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'view_threshold' ) ?></td>
<td><select name="view_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'view_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'update_threshold' ) ?></td>
<td><select name="update_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'update_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'manage_threshold' ) ?></td>
<td><select name="manage_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'manage_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'username_threshold' ) ?></td>
<td><select name="username_threshold"><?php print_enum_string_option_list( 'access_levels', plugin_config_get( 'username_threshold' ) ) ?></select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'menu_links' ) ?></td>
<td>
	<label><input type="checkbox" name="show_repo_link" <?php echo ( plugin_config_get( 'show_repo_link' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'show_repo_link' ) ?></label><br/>
	<label><input type="checkbox" name="show_search_link" <?php echo ( plugin_config_get( 'show_search_link' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'show_search_link' ) ?></label><br/>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'enabled_features' ) ?></td>
<td>
	<label><input type="checkbox" name="show_repo_stats" <?php echo ( plugin_config_get( 'show_repo_stats' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'show_repo_stats' ) ?></label><br/>
	<label><input type="checkbox" name="enable_linking" <?php echo ( plugin_config_get( 'enable_linking' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_linking' ) ?></label><br/>
	<label><input type="checkbox" name="enable_mapping" <?php echo ( plugin_config_get( 'enable_mapping' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_mapping' ) ?></label><br/>
	<label><input type="checkbox" name="enable_resolving" <?php echo ( plugin_config_get( 'enable_resolving' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_resolving' ) ?></label><br/>
	<label><input type="checkbox" name="enable_message" <?php echo ( plugin_config_get( 'enable_message' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_message' ) ?></label><br/>
	<label><input type="checkbox" name="enable_porting" <?php echo ( plugin_config_get( 'enable_porting' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_porting' ) ?></label><br/>
<?php if ( plugin_is_installed( 'ProductMatrix' ) || plugin_config_get( 'enable_product_matrix' ) ) { ?>
	<label><input type="checkbox" name="enable_product_matrix" <?php echo ( plugin_config_get( 'enable_product_matrix' ) ? 'checked="checked" ' : '' ) ?>/>
	<?php echo plugin_lang_get( 'enable_product_matrix' ) ?></label><br/>
<?php } ?>
</td>
</tr>

<tr><td class="spacer"></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'buglink_regex_1' ) ?></td>
<td>
	<input name="buglink_regex_1" size="50" maxlength="500" value="<?php echo string_attribute( plugin_config_get( 'buglink_regex_1' ) ) ?>"/>
	<br/><label><input name="buglink_reset_1" type="checkbox"/><span class="small"><?php echo plugin_lang_get( 'reset' ) ?></span></label>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'buglink_regex_2' ) ?></td>
<td>
	<input name="buglink_regex_2" size="50" maxlength="500" value="<?php echo string_attribute( plugin_config_get( 'buglink_regex_2' ) ) ?>"/>
	<br/><label><input name="buglink_reset_2" type="checkbox"/><span class="small"><?php echo plugin_lang_get( 'reset' ) ?></span></label>
</td>
</tr>

<tr><td class="spacer"></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_regex_1' ) ?></td>
<td>
	<input name="bugfix_regex_1" size="50" maxlength="500" value="<?php echo string_attribute( plugin_config_get( 'bugfix_regex_1' ) ) ?>"/>
	<br/><label><input name="bugfix_reset_1" type="checkbox"/><span class="small"><?php echo plugin_lang_get( 'reset' ) ?></span></label>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_regex_2' ) ?></td>
<td>
	<input name="bugfix_regex_2" size="50" maxlength="500" value="<?php echo string_attribute( plugin_config_get( 'bugfix_regex_2' ) ) ?>"/>
	<br/><label><input name="bugfix_reset_2" type="checkbox"/><span class="small"><?php echo plugin_lang_get( 'reset' ) ?></span></label>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_status' ) ?></td>
<td><select name="bugfix_status">
<option value="0" <?php echo check_selected( 0, plugin_config_get( 'bugfix_status' ) ) ?>><?php echo plugin_lang_get( 'bugfix_status_off' ) ?></option>
<option value="-1" <?php echo check_selected( -1, plugin_config_get( 'bugfix_status' ) ) ?>><?php echo plugin_lang_get( 'bugfix_status_default' ) ?></option>
<?php print_enum_string_option_list( 'status', plugin_config_get( 'bugfix_status' ) ) ?>
</select></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_resolution' ) ?></td>
<td><select name="bugfix_resolution"><?php print_enum_string_option_list( 'resolution', plugin_config_get( 'bugfix_resolution' ) ) ?></select></td>
</tr>

<?php if ( plugin_is_installed( 'ProductMatrix' ) || plugin_config_get( 'enable_product_matrix' ) ) { ?>
<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_status_pvm' ) ?></td>
<td><select name="bugfix_status_pvm">
<option value="0" <?php echo check_selected( 0, plugin_config_get( 'bugfix_status_pvm' ) ) ?>><?php echo plugin_lang_get( 'bugfix_status_off' ) ?></option>
<?php foreach( config_get( 'plugin_ProductMatrix_status' ) as $t_status => $t_name ) { ?>
<option value="<?php echo string_attribute( $t_status ) ?>" <?php echo check_selected( $t_status, plugin_config_get( 'bugfix_status_pvm' ) ) ?>><?php echo string_display_line( $t_name ) ?></option>
<?php } ?>
</select></td>
</tr>
<?php } ?>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_message' ) ?></td>
<td>
	<input name="bugfix_message" size="50" value="<?php echo string_attribute( plugin_config_get( 'bugfix_message' ) ) ?>"/><br/>
	<span class="small"><?php echo plugin_lang_get( 'bugfix_message_info' ) ?></span><br/>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_message_view_status' ) ?></td>
<td>
	<select name="bugfix_message_view_status">
		<?php print_enum_string_option_list( 'view_state', plugin_config_get( 'bugfix_message_view_status' ) ) ?>
	</select><br />
	<span class="small"><?php echo plugin_lang_get( 'bugfix_message_view_status_info' ) ?></span><br/>
</td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'bugfix_handler' ) ?></td>
<td><input name="bugfix_handler" type="checkbox" <?php echo (ON == plugin_config_get( 'bugfix_handler' ) ? 'checked="checked"' : '') ?>/></td>
</tr>

<tr><td class="spacer"></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'api_key' ) ?></td>
<td>
	<input name="api_key" size="50" value="<?php echo string_attribute( plugin_config_get( 'api_key' ) ) ?>"/><br/>
	<span class="small"><?php echo plugin_lang_get( 'api_key_info' ) ?></span>
</td>
</tr>

<tr><td class="spacer"></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'allow_remote_checkin' ) ?></td>
<td><input name="remote_checkin" type="checkbox" <?php echo (ON == $t_remote_checkin ? 'checked="checked"' : '') ?>/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'remote_checkin_urls' ) ?></td>
<td><textarea name="checkin_urls" rows="8" cols="50"><?php
foreach( $t_checkin_urls as $t_ip ) {
	echo string_textarea( $t_ip ),"\n";
}
?></textarea></td>
</tr>

<tr><td class="spacer"></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'allow_remote_import' ) ?></td>
<td><input name="remote_imports" type="checkbox" <?php echo (ON == $t_remote_imports ? 'checked="checked"' : '') ?>/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'remote_import_urls' ) ?></td>
<td><textarea name="import_urls" rows="8" cols="50"><?php
foreach( $t_import_urls as $t_ip ) {
	echo string_textarea( $t_ip ),"\n";
}
?></textarea></td>
</tr>

<?php
foreach( SourceVCS::all() as $t_type => $t_vcs ) {
var_dump($t_vcs);
echo '<br/><br/>';
	if ( $t_vcs->configuration ) {
		echo '<tr><td class="spacer"></td></tr>';
		$t_vcs->update_config_form();
	}
}
?>

</table>

			</div>
		</div>
		
		<div class="widget-toolbox padding-8 clearfix">
			<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( "update_configuration" ) ?>"/>
		</div>
	</div>
</div>

</form>

	</div>
</div>

<?php
layout_page_end( __FILE__ );

