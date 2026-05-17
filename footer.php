</main><!-- #primary -->

<footer class="footer p-10 bg-base-200 text-base-content border-t border-base-300">
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
