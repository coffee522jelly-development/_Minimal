<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area sticky top-24 border border-base-200 rounded-box p-6 bg-base-100 shadow-sm">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
