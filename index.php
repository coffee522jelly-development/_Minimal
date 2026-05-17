<?php get_header(); ?>

<?php
$sidebar_pos = get_theme_mod( 'daisy_corp_sidebar_position', 'right' );
$blog_cols = get_theme_mod( 'daisy_corp_blog_columns', '2' );

$grid_cols_class = 'grid-cols-1';
if ( '2' === $blog_cols ) {
    $grid_cols_class = 'grid-cols-1 sm:grid-cols-2';
} elseif ( '4' === $blog_cols ) {
    $grid_cols_class = 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-4';
}

$main_order = ( 'left' === $sidebar_pos ) ? 'order-2' : 'order-1';
$sidebar_order = ( 'left' === $sidebar_pos ) ? 'order-1' : 'order-2';
?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
    <div class="lg:col-span-3 <?php echo esc_attr( $main_order ); ?>">
        <?php if ( have_posts() ) : ?>
            <div class="grid <?php echo esc_attr( $grid_cols_class ); ?> gap-6">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card bg-base-100 shadow-sm border border-base-200 overflow-hidden'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <figure class="aspect-video lg:aspect-auto">
                                <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-full lg:h-48 object-cover')); ?>
                            </figure>
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="card-title text-xl font-bold mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="text-xs opacity-50 mb-4 flex items-center gap-1">
                                <i data-feather="calendar"></i>
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="prose prose-sm max-w-none">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm">
                                    <?php echo esc_html( get_theme_mod( 'daisy_corp_read_more_text', __( 'Read More', 'daisy-corp' ) ) ); ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <?php daisy_corp_pagination(); ?>

        <?php else : ?>
            <div class="alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>No posts found.</span>
            </div>
        <?php endif; ?>
    </div>

    <aside class="lg:col-span-1 <?php echo esc_attr( $sidebar_order ); ?>">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
