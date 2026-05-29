<?php get_header();
$config = daisy_corp_get_layout_config(); ?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 <?php echo esc_attr( $config['grid_gap_class'] ); ?> items-start">
    <div class="<?php echo esc_attr( $config['main_cols_class'] ); ?> <?php echo esc_attr( $config['main_order'] ); ?>">
        <?php if ( have_posts() ) : ?>
            <div class="grid <?php echo esc_attr( $config['blog_grid_class'] ); ?> gap-6">
                <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
            </div>
            <?php daisy_corp_pagination(); ?>
        <?php else : ?>
            <div class="alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>No posts found.</span>
            </div>
        <?php endif; ?>
    </div>

    <?php if ( ! $config['hide_sidebar'] ) : ?>
    <aside class="lg:col-span-1 <?php echo esc_attr( $config['sidebar_order'] ); ?>">
        <?php get_sidebar(); ?>
    </aside>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
