<?php

# Copyright (c) 2012 John Reese
# Licensed under the MIT license

access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );

$f_repo_id = gpc_get_int( 'id' );

$t_repo = SourceRepo::load( $f_repo_id );
$t_vcs = SourceVCS::repo( $t_repo );
$t_type = SourceType($t_repo->type);

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();
?>

<div class="col-md-12 col-xs-12">

	<div class="space-10"></div>
	<div class="form-container">
<form action="<?php echo plugin_page( 'repo_update.php' ) ?>" method="post">
<?php echo form_security_field( 'plugin_Source_repo_update' ) ?>
<input type="hidden" name="repo_id" value="<?php echo $t_repo->id ?>"/>

		<div class="widget-box widget-color-blue2">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title lighter">
					<?php echo plugin_lang_get( 'update_repository' ) ?>
				</h4>
				<div class="widget-toolbar"><?php print_bracket_link( plugin_page( 'repo_manage_page' ) . '&id=' . $t_repo->id, plugin_lang_get( 'back_repo' ) ) ?></div>
			</div>

			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'name' ) ?></td>
<td><input name="repo_name" maxlength="128" size="40" value="<?php echo string_attribute( $t_repo->name ) ?>"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'type' ) ?></td>
<td><?php echo string_display( $t_type ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'url' ) ?></td>
<td><input name="repo_url" maxlength="250" size="40" value="<?php echo string_attribute( $t_repo->url ) ?>"/></td>
</tr>

<?php $t_vcs->update_repo_form( $t_repo ) ?>

</table>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( "update_repository" ) ?>"/>
			</div>
		</div>
	</div>
</form>
	</div>
</div>

<?php
layout_page_end( __FILE__ );

