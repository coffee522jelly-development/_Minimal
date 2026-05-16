<?php
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area sticky top-24">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->
