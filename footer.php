</main><!-- #primary -->

<footer class="footer p-10 bg-base-200 text-base-content border-t border-base-300">
  <aside>
    <div class="text-2xl font-bold mb-2"><?php bloginfo( 'name' ); ?></div>
    <p><?php bloginfo( 'description' ); ?></p>
    <p class="mt-4 opacity-70 text-sm">© <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
  </aside>

  <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
    <?php dynamic_sidebar( 'footer-1' ); ?>
  <?php else : ?>
    <nav>
      <h6 class="footer-title">Services</h6>
      <a class="link link-hover">Branding</a>
      <a class="link link-hover">Design</a>
      <a class="link link-hover">Marketing</a>
      <a class="link link-hover">Advertisement</a>
    </nav>
    <nav>
      <h6 class="footer-title">Company</h6>
      <a class="link link-hover">About us</a>
      <a class="link link-hover">Contact</a>
      <a class="link link-hover">Jobs</a>
      <a class="link link-hover">Press kit</a>
    </nav>
    <nav>
      <h6 class="footer-title">Legal</h6>
      <a class="link link-hover">Terms of use</a>
      <a class="link link-hover">Privacy policy</a>
      <a class="link link-hover">Cookie policy</a>
    </nav>
  <?php endif; ?>
</footer>

<?php wp_footer(); ?>
</body>
</html>
