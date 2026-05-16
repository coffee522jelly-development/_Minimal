<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="join w-full">
		<input type="search" class="input input-bordered join-item w-full" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'daisy-corp' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="btn btn-primary join-item"><?php echo esc_html_x( 'Search', 'submit button', 'daisy-corp' ); ?></button>
	</div>
</form>
