<?php get_header(); ?>

<?php
$sidebar_pos = get_theme_mod( 'daisy_corp_sidebar_position', 'right' );
$hide_sidebar = get_theme_mod( 'daisy_corp_hide_sidebar_single', false );

$main_order = ( 'left' === $sidebar_pos ) ? 'order-2' : 'order-1';
$sidebar_order = ( 'left' === $sidebar_pos ) ? 'order-1' : 'order-2';

$main_cols_class = $hide_sidebar ? 'lg:col-span-4' : 'lg:col-span-3';
$grid_gap_class = $hide_sidebar ? '' : 'lg:gap-16';
?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 <?php echo esc_attr( $grid_gap_class ); ?> items-start">
    <div class="<?php echo esc_attr( $main_cols_class ); ?> <?php echo esc_attr( $main_order ); ?> w-full">
        <div class="max-w-4xl mx-auto px-4 lg:px-8">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="mb-10">
                        <h1 class="text-4xl font-extrabold mb-4 leading-tight"><?php the_title(); ?></h1>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <figure class="mb-10 rounded-3xl overflow-hidden shadow-xl">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                        </figure>
                    <?php endif; ?>

                    <div class="prose prose-lg max-w-none leading-relaxed">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    if ( comments_open() || get_comments_number() ) :
                        echo '<div class="mt-16">';
                        comments_template();
                        echo '</div>';
                    endif;
                    ?>
                </article>
            <?php endwhile; ?>
        </div>
    </div>

    <?php if ( ! $hide_sidebar ) : ?>
    <aside class="lg:col-span-1 <?php echo esc_attr( $sidebar_order ); ?> w-full">
        <?php get_sidebar(); ?>
    </aside>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
