<?php

# Copyright (c) 2012 John Reese
# Licensed under the MIT license

access_ensure_global_level( plugin_config_get( 'manage_threshold' ) );

$f_repo_id = gpc_get_int( 'id' );

$t_repo = SourceRepo::load( $f_repo_id );
$t_type = SourceType($t_repo->type);

$t_mappings = $t_repo->load_mappings();

function display_strategies( $p_type=null ) {
	if ( is_null( $p_type ) ) {
		echo '<option value="0">', plugin_lang_get( 'select_one' ), '</option>';
	}

	echo '<option value="', SOURCE_EXPLICIT, '"', ( $p_type == SOURCE_EXPLICIT ? ' selected="selected"' : '' ),
		'>', plugin_lang_get( 'mapping_explicit' ), '</option>';
	if ( !Source_PVM() ) {
	echo '<option value="', SOURCE_NEAR, '"', ( $p_type == SOURCE_NEAR ? ' selected="selected"' : '' ),
		'>', plugin_lang_get( 'mapping_near' ), '</option>',
		'<option value="', SOURCE_FAR, '"', ( $p_type == SOURCE_FAR ? ' selected="selected"' : '' ),
		'>', plugin_lang_get( 'mapping_far' ), '</option>';
	echo '<option value="', SOURCE_FIRST, '"', ( $p_type == SOURCE_FIRST ? ' selected="selected"' : '' ),
		'>', plugin_lang_get( 'mapping_first' ), '</option>',
		'<option value="', SOURCE_LAST, '"', ( $p_type == SOURCE_LAST ? ' selected="selected"' : '' ),
		'>', plugin_lang_get( 'mapping_last' ), '</option>';
	}
}

function display_pvm_versions($t_version_id=null) {
	static $s_products = null;

	if ( is_null( $s_products ) ) {
		$s_products = PVMProduct::load_all( true );
	}

	if ( is_null( $t_version_id ) ) {
		echo "<option value=\"\"></option>";
	}

	foreach( $s_products as $t_product ) {
		foreach( $t_product->versions as $t_version ) {
			echo "<option value=\"{$t_version->id}\"", $t_version->id == $t_version_id ? ' selected="selected"' : '',
				">{$t_product->name} {$t_version->name}</option>";
		}
	}
}

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();
?>

<div class="col-md-12 col-xs-12">
<div class="space-10"></div>

	<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-file-o"></i>
				<?php echo plugin_lang_get( 'manage_repository' ) ?>
			</h4>
			<div class="widget-toolbar">
<?php
	print_bracket_link( plugin_page( 'list' ) . "&id=$f_repo_id", plugin_lang_get( 'browse' ) );
	print_bracket_link( plugin_page( 'index' ), plugin_lang_get( 'back' ) );
?>
			</div>
		</div>

		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'name' ) ?></td>
<td colspan="2"><?php echo string_display( $t_repo->name ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'type' ) ?></td>
<td colspan="2"><?php echo string_display( $t_type ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'url' ) ?></td>
<td colspan="2"><?php echo string_display( $t_repo->url ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'info' ) ?></td>
<td colspan="2"><pre><?php var_dump($t_repo->info) ?></pre></td>
</tr>

<tr>
<td width="30%"></td>
<td width="20%"></td>
<td width="50%"></td>
</tr>

</table>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<div class="btn-toolbar pull-left">
					<div class="btn-group">
<form class="form-inline pull-left" action="<?php echo plugin_page( 'repo_update_page' ) . '&amp;id=' . $t_repo->id ?>" method="post">
	<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( 'update_repository' ) ?>"/>
</form>
<form class="form-inline pull-left" action="<?php echo plugin_page( 'repo_delete' ) . '&amp;id=' . $t_repo->id ?>" method="post">
	<?php echo form_security_field( 'plugin_Source_repo_delete' ) ?>
	<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( 'delete_repository' ) ?>"/>
</form>
					</div>
				</div>
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
<form class="form-inline pull-left" action="<?php echo plugin_page( 'repo_import_latest' ) . '&amp;id=' . $t_repo->id ?>" method="post">
	<?php echo form_security_field( 'plugin_Source_repo_import_latest' ) ?>
	<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( 'import_latest' ) ?>"/>
</form>
<form class="form-inline pull-left" action="<?php echo plugin_page( 'repo_import_full' ) . '&amp;id=' . $t_repo->id ?>" method="post">
	<?php echo form_security_field( 'plugin_Source_repo_import_full' ) ?>
	<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( 'import_full' ) ?>"/>
</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php if ( plugin_config_get( 'enable_mapping' ) ) { ?>
	<div class="space-10"></div>
	<div class="form-container">
<form action="<?php echo plugin_page( 'repo_update_mappings' ) . '&id=' . $t_repo->id ?>" method="post">
<?php echo form_security_field( 'plugin_Source_repo_update_mappings' ) ?>

	<div class="widget-box widget-color-blue2">
		<div class="widget-header widget-header-small">
			<h4 class="widget-title lighter">
				<i class="ace-icon fa fa-file-o"></i>
				<?php echo plugin_lang_get( 'branch_mapping' ) ?>
			</h4>
		</div>

		<div class="widget-body">
			<div class="widget-main no-padding">
				<div class="table-responsive">
<table class="table table-striped table-bordered table-condensed table-hover">

<tr class="row-category">
<td><?php echo plugin_lang_get( 'branch' ) ?></td>
<td><?php echo plugin_lang_get( 'mapping_strategy' ) ?></td>
<td><?php echo plugin_lang_get( 'mapping_version' ), ' ', plugin_lang_get( 'mapping_version_info' ) ?></td>
<td><?php echo plugin_lang_get( 'mapping_regex' ), ' ', plugin_lang_get( 'mapping_regex_info' ) ?></td>
<td><?php echo plugin_lang_get( 'delete' ) ?></td>
</tr>

<?php foreach( $t_mappings as $t_mapping ) { $t_branch = str_replace( '.', '_', $t_mapping->branch ); ?>

<tr <?php echo helper_alternate_class() ?>>
<td><input name="<?php echo $t_branch ?>_branch" value="<?php echo string_attribute( $t_mapping->branch ) ?>" size="12" maxlength="128"/></td>
<td><select name="<?php echo $t_branch ?>_type"><?php display_strategies( $t_mapping->type ) ?></select></td>
<?php if ( Source_PVM() ) { ?>
<td><select name="<?php echo $t_branch ?>_pvm_version_id"><?php display_pvm_versions( $t_mapping->pvm_version_id ) ?></select></td>
<?php } else { ?>
<td><select name="<?php echo $t_branch ?>_version"><?php print_version_option_list( $t_mapping->version, ALL_PROJECTS, false, true, true ) ?></select></td>
<?php } ?>
<td><input name="<?php echo $t_branch ?>_regex" value="<?php echo string_attribute( $t_mapping->regex ) ?>" size="18" maxlength="128"/></td>
<td><input name="<?php echo $t_branch ?>_delete" type="checkbox" value="1"/></td>
</tr>
<?php } ?>

<tr><td></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td><input name="_branch" size="12" maxlength="128"/></td>
<td><select name="_type"><?php display_strategies(); ?></select></td>
<?php if ( Source_PVM() ) { ?>
<td><select name="_pvm_version_id"><?php display_pvm_versions() ?></select></td>
<?php } else { ?>
<td><select name="_version"><?php print_version_option_list( '', ALL_PROJECTS, false, true, true ) ?></td>
<?php } ?>
<td><input name="_regex" size="18" maxlength="128"/></td>
<td></td>
</tr>

</table>
				</div>
			</div>
			<div class="widget-toolbox padding-8 clearfix">
				<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( "mapping_update" ) ?>"/>
			</div>
		</div>
	</div>

</form>
	</div>

<?php } ?>
</div>
<?php
layout_page_end( __FILE__ );

