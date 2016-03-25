<?php

# Copyright (c) 2012 John Reese
# Licensed under the MIT license

access_ensure_global_level( plugin_config_get( 'view_threshold' ) );
$t_can_manage = access_has_global_level( plugin_config_get( 'manage_threshold' ) );

$t_show_stats = plugin_config_get( 'show_repo_stats' );
$t_class = $t_show_stats ? 'width75' : 'width60';
$t_title_span = $t_show_stats ? 2 : 1;
$t_links_span = $t_show_stats ? 4 : 2;

$t_repos = SourceRepo::load_all();

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();
?>

<div class="col-md-12 col-xs-12">

	<div class="space-10"></div>
	
<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-file-o"></i>
			<?php echo plugin_lang_get( 'repositories' ) ?>
			
		</h4>
		<div class="widget-toolbar">
			<?php
print_bracket_link( plugin_page( 'search_page' ), plugin_lang_get( 'search' ) );
if ( $t_can_manage ) { print_bracket_link( plugin_page( 'manage_config_page' ), plugin_lang_get( 'configuration' ) ); }
?>
		</div>
	</div>
	<div class="widget-body">
		<div class="widget-main no-padding">
			<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">

<tr class="row-category">
<td width="30%"><?php echo plugin_lang_get( 'repository' ) ?></td>
<td width="15%"><?php echo plugin_lang_get( 'type' ) ?></td>
<?php if ( $t_show_stats ) { ?>
<td width="10%"><?php echo plugin_lang_get( 'changesets' ) ?></td>
<td width="10%"><?php echo plugin_lang_get( 'files' ) ?></td>
<td width="10%"><?php echo plugin_lang_get( 'issues' ) ?></td>
<?php } ?>
<td width="25%"><?php echo plugin_lang_get( 'actions' ) ?></td>
</tr>

<?php foreach( $t_repos as $t_repo ) { ?>
<tr <?php echo helper_alternate_class() ?>>
<td><?php echo string_display( $t_repo->name ) ?></td>
<td class="center"><?php echo string_display( SourceType( $t_repo->type ) ) ?></td>
<?php if ( $t_show_stats ) { $t_stats = $t_repo->stats(); ?>
<td class="right"><?php echo $t_stats['changesets'] ?></td>
<td class="right"><?php echo $t_stats['files'] ?></td>
<td class="right"><?php echo $t_stats['bugs'] ?></td>
<?php } ?>
<td class="center">
<?php 
	print_bracket_link( plugin_page( 'list' ) . '&id=' . $t_repo->id, plugin_lang_get( 'changesets' ) );
	if ( $t_can_manage ) {
		if ( preg_match( '/^Import \d+-\d+\d+/', $t_repo->name ) ) {
			print_bracket_link( plugin_page( 'repo_delete' ) . '&id=' . $t_repo->id . form_security_param( 'plugin_Source_repo_delete' ), plugin_lang_get( 'delete' ) );
		}
		print_bracket_link( plugin_page( 'repo_manage_page' ) . '&id=' . $t_repo->id, plugin_lang_get( 'manage' ) );
	}
?>
</td>
</tr>
<?php } ?>

</table>
			</div>
		</div>
	</div>
</div>
	

<?php if ( $t_can_manage ) { ?>
	<div class="space-10"></div>
	
	<div class="form-container">

<form action="<?php echo plugin_page( 'repo_create' ) ?>" method="post">
<?php echo form_security_field( 'plugin_Source_repo_create' ) ?>
	
<div class="widget-box widget-color-blue2">
	<div class="widget-header widget-header-small">
		<h4 class="widget-title lighter">
			<i class="ace-icon fa fa-file-o"></i>
			<?php echo plugin_lang_get( 'create_repository' ) ?>
		</h4>
	</div>
	
	<div class="widget-body">
		<div class="widget-main no-padding">
			<div class="table-responsive">

<table class="table table-striped table-bordered table-condensed table-hover">

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'name' ) ?></td>
<td><input name="repo_name" maxlength="128" size="40"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'type' ) ?></td>
<td>
<select name="repo_type">
	<option value=""><?php echo plugin_lang_get( 'select_one' ) ?></option>
<?php foreach( SourceTypes() as $t_type => $t_type_name ) { ?>
	<option value="<?php echo $t_type ?>"><?php echo string_display( $t_type_name ) ?></option>
<?php } ?>
</select>
</td>
</tr>

</table>
			</div>
		</div>
		<div class="widget-toolbox padding-8 clearfix">
			<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( "create_repository" ) ?>"/>
		</div>
	</div>
</div>
</form>
</div>
<?php } ?>

</div>

<?php
layout_page_end( __FILE__ );

