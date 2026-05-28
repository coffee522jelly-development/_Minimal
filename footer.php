</main><!-- #primary -->

<footer class="footer p-6 md:p-10 bg-base-200 text-base-content border-t border-base-300">
  <aside>
    <div class="text-2xl font-bold mb-2"><?php bloginfo( 'name' ); ?></div>
    <p><?php bloginfo( 'description' ); ?></p>
    <p class="mt-4 opacity-70 text-sm">© <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
  </aside>

  <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
    <?php dynamic_sidebar( 'footer-1' ); ?>
  <?php endif; ?>

  <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
    <?php dynamic_sidebar( 'footer-2' ); ?>
  <?php endif; ?>

  <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
    <?php dynamic_sidebar( 'footer-3' ); ?>
  <?php endif; ?>
</footer>

<?php if ( get_theme_mod( 'daisy_corp_enable_fab', false ) ) : ?>
<div class="fab">
  <!-- Speed Dial Actions (Dynamic Page Links) -->
  <?php
    $fab_pages = get_pages( array(
        'parent'  => 0,
        'number'  => 5,
        'sort_column' => 'menu_order',
    ) );

    foreach ( $fab_pages as $fab_page ) :
        $page_icon = 'file-text';
        $page_title = strtolower($fab_page->post_title);

        if (strpos($page_title, 'contact') !== false) $page_icon = 'mail';
        elseif (strpos($page_title, 'about') !== false) $page_icon = 'info';
        elseif (strpos($page_title, 'service') !== false) $page_icon = 'briefcase';
        elseif (strpos($page_title, 'blog') !== false) $page_icon = 'edit-3';
  ?>
    <a href="<?php echo esc_url( get_permalink($fab_page->ID) ); ?>" class="flex items-center gap-3">
        <span class="fab-label"><?php echo esc_html( $fab_page->post_title ); ?></span>
        <button class="btn btn-circle btn-secondary shadow-md"><i data-feather="<?php echo esc_attr( $page_icon ); ?>"></i></button>
    </a>
  <?php endforeach; ?>

  <!-- Manual Customizer Actions -->
  <?php for ( $i = 3; $i >= 1; $i-- ) :
    $label = get_theme_mod( "daisy_corp_fab_label_$i" );
    $url   = get_theme_mod( "daisy_corp_fab_url_$i" );
    $icon  = get_theme_mod( "daisy_corp_fab_icon_$i", 'link' );
    if ( ! empty( $url ) ) :
  ?>
    <a href="<?php echo esc_url( $url ); ?>" class="flex items-center gap-3">
        <?php if ( ! empty( $label ) ) : ?>
            <span class="fab-label"><?php echo esc_html( $label ); ?></span>
        <?php endif; ?>
        <button class="btn btn-circle btn-secondary shadow-md"><i data-feather="<?php echo esc_attr( $icon ); ?>"></i></button>
    </a>
  <?php endif; endfor; ?>

  <!-- Trigger Button -->
  <div tabindex="0" role="button" class="btn btn-lg btn-circle btn-primary shadow-xl">
    <i data-feather="grid"></i>
  </div>

  <!-- Close Action -->
  <div class="fab-main-action">
    <button class="btn btn-circle btn-primary btn-lg shadow-xl">
        <i data-feather="x"></i>
    </button>
  </div>
</div>
<?php endif; ?>

<button
  onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
  class="btn btn-primary btn-circle fixed bottom-6 right-6 shadow-lg z-[100] md:hidden"
  aria-label="Back to Top"
>
  <i data-feather="chevron-up"></i>
</button>

<?php wp_footer(); ?>
<script>
  <?php $base_font_size = get_theme_mod( 'daisy_corp_base_font_size', '16' ); ?>
  feather.replace({
    width: <?php echo esc_js( $base_font_size ); ?>,
    height: <?php echo esc_js( $base_font_size ); ?>,
    'stroke-width': 2
  });
</script>
</body>
</html>
