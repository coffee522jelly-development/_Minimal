<?php get_header(); ?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="mb-8">
                    <h1 class="text-4xl font-extrabold mb-4"><?php the_title(); ?></h1>
                    <div class="flex items-center gap-4 text-sm opacity-60">
                        <span><?php echo get_the_date(); ?></span>
                        <span><?php the_category(', '); ?></span>
                    </div>
                </header>

                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto')); ?>
                    </figure>
                <?php endif; ?>

                <div class="prose prose-lg max-w-none">
                    <?php the_content(); ?>
                </div>

                <footer class="mt-12 pt-8 border-t border-base-200">
                    <div class="flex flex-wrap gap-2">
                        <?php the_tags('<span class="badge badge-outline">', '</span> <span class="badge badge-outline">', '</span>'); ?>
                    </div>
                </footer>

                <?php
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;
                ?>
            </article>
        <?php endwhile; ?>
    </div>

    <aside class="lg:col-span-1">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
