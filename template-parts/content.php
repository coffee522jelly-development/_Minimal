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
        <div class="text-xs opacity-50 mb-4 flex items-center gap-3">
            <span class="flex items-center gap-1">
                <i data-feather="calendar"></i>
                <?php echo get_the_date(); ?>
            </span>
            <span class="flex items-center gap-1">
                <i data-feather="clock"></i>
                <?php echo daisy_corp_get_reading_time(); ?>
            </span>
        </div>
        <div class="prose prose-sm max-w-none">
            <?php the_excerpt(); ?>
        </div>
        <div class="card-actions justify-end mt-4">
            <a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm">
                <?php echo esc_html( get_theme_mod( 'daisy_corp_read_more_text', 'Read More' ) ); ?>
            </a>
        </div>
    </div>
</article>
