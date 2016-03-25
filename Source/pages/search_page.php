<?php

# Copyright (c) 2012 John Reese
# Licensed under the MIT license

access_ensure_global_level( plugin_config_get( 'view_threshold' ) );

require_once( config_get( 'plugin_path' ) . 'Source' . DIRECTORY_SEPARATOR . 'Source.FilterAPI.php' );

list( $t_filter, $t_permalink ) = Source_Generate_Filter();

$t_date_start = ( is_null( $t_filter->filters['date_start']->value ) ? 'start' : $t_filter->filters['date_start']->value );
$t_date_end = ( is_null( $t_filter->filters['date_end']->value ) ? 'now' : $t_filter->filters['date_end']->value );

layout_page_header( plugin_lang_get( 'title' ) );
layout_page_begin();

?>

<?php if ( plugin_is_loaded( 'jQuery' ) ) { ?>
<script src="<?php echo plugin_file( 'search.js' ) ?>"></script>
<?php } ?>

<div class="col-md-12 col-xs-12">

	<div class="space-10"></div>
	<div class="form-container">
<form action="<?php echo helper_mantis_url( 'plugin.php' ) ?>" method="get">
<input type="hidden" name="page" value="Source/search"/>

		<div class="widget-box widget-color-blue2">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-file-o"></i>
					<?php echo plugin_lang_get( 'search_changesets' ) ?>
				</h4>
				
				<div class="widget-toolbar">
				<?php
print_bracket_link( plugin_page( 'search_page' ), plugin_lang_get( 'new_search' ) );
print_bracket_link( plugin_page( 'index' ), plugin_lang_get( 'back' ) );
?>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main no-padding">
					<div class="table-responsive">

<table class="table table-striped table-bordered table-condensed table-hover">

<tr class="row-category">
<td><?php echo plugin_lang_get( 'type' ) ?></td>
<td><?php echo plugin_lang_get( 'repository' ) ?></td>
<td><?php echo plugin_lang_get( 'branch' ) ?></td>
<td><?php echo plugin_lang_get( 'action' ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="center"><?php Source_Type_Select( $t_filter->filters['r.type']->value ) ?></td>
<td class="center"><?php Source_Repo_Select( $t_filter->filters['r.id']->value ) ?></td>
<td class="center"><?php Source_Branch_Select( $t_filter->filters['c.branch']->value ) ?></td>
<td class="center"><?php Source_Action_Select( $t_filter->filters['f.action']->value ) ?></td>
</tr>

<tr class="spacer"><td></td></tr>

<tr class="row-category">
<td><?php echo plugin_lang_get( 'username' ) ?></td>
<td><?php echo plugin_lang_get( 'author' ) ?></td>
<td><?php echo plugin_lang_get( 'revision' ) ?></td>
<td><?php echo plugin_lang_get( 'issue' ) ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="center"><?php Source_Username_Select( $t_filter->filters['c.user_id']->value ) ?></td>
<td class="center"><?php Source_Author_Select( $t_filter->filters['c.author']->value ) ?></td>
<td class="center"><input name="revision" size="10" value="<?php echo string_attribute( $t_filter->filters['f.revision']->value ) ?>"/></td>
<td class="center"><input name="bug_id" size="10" value="<?php echo string_attribute( join( ',', $t_filter->filters['b.bug_id']->value ) ) ?>"/></td>
</tr>

<tr class="spacer"><td></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'date_begin' ) ?></td>
<td colspan="3"><?php Source_Date_Select( 'date_start', $t_date_start ); ?></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'date_end' ) ?></td>
<td colspan="3"><?php Source_Date_Select( 'date_end', $t_date_end ); ?></td>
</tr>

<?php if ( plugin_config_get( 'enable_porting' ) ): ?>
<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'enable_porting' ) ?></td>
<td colspan="3"><?php Source_Ported_Select( $t_filter->filters['c.ported']->value ); ?></td>
</tr>
<?php endif ?>

<tr class="spacer"><td></td></tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'message' ) ?></td>
<td colspan="6"><input name="message" size="40" value="<?php echo string_attribute( $t_filter->filters['c.message']->value ) ?>"/></td>
</tr>

<tr <?php echo helper_alternate_class() ?>>
<td class="category"><?php echo plugin_lang_get( 'filename' ) ?></td>
<td colspan="6"><input name="filename" size="40" value="<?php echo string_attribute( $t_filter->filters['f.filename']->value ) ?>"/></td>
</tr>

</table>
					</div>
				</div>
				<div class="widget-toolbox padding-8 clearfix">
					<input class="btn btn-primary btn-white btn-sm btn-round" type="submit" value="<?php echo plugin_lang_get( "search" ) ?>"/>
				</div>
			</div>
		</div>
</form>
	</div>
</div>

<?php
layout_page_end( __FILE__ );

