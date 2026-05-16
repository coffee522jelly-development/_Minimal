<?php get_header(); ?>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3">
        <?php if ( have_posts() ) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card bg-base-100 shadow-sm border border-base-200'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <figure>
                                <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover')); ?>
                            </figure>
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="card-title text-xl font-bold mb-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="text-sm opacity-60 mb-4">
                                <?php echo get_the_date(); ?>
                            </div>
                            <div class="prose prose-sm max-w-none">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <a href="<?php the_permalink(); ?>" class="btn btn-ghost btn-sm">Read More</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="mt-12 join flex justify-center">
                <?php
                echo paginate_links( array(
                    'type'      => 'list',
                    'prev_text' => '<button class="join-item btn">«</button>',
                    'next_text' => '<button class="join-item btn">»</button>',
                    'before_page_number' => '<span class="join-item btn">',
                    'after_page_number'  => '</span>',
                ) );
                ?>
            </div>

        <?php else : ?>
            <div class="alert">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-info shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>No posts found.</span>
            </div>
        <?php endif; ?>
    </div>

    <aside class="lg:col-span-1">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>
