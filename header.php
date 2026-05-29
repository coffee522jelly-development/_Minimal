<!doctype html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr( get_theme_mod( 'daisy_corp_daisyui_theme', 'light' ) ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <?php
    $selected_font = get_theme_mod( 'daisy_corp_web_font', 'sans-serif' );
    $fonts = array(
        'inter'        => array( 'url' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap', 'stack' => '"Inter", sans-serif' ),
        'noto-sans'    => array( 'url' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap', 'stack' => '"Noto Sans JP", sans-serif' ),
        'noto-serif'   => array( 'url' => 'https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;700&display=swap', 'stack' => '"Noto Serif JP", serif' ),
        'roboto'       => array( 'url' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap', 'stack' => '"Roboto", sans-serif' ),
        'merriweather' => array( 'url' => 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap', 'stack' => '"Merriweather", serif' ),
        'oswald'       => array( 'url' => 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap', 'stack' => '"Oswald", sans-serif' ),
    );
    $font_stack = 'system-ui, -apple-system, sans-serif';
    if ( isset( $fonts[$selected_font] ) ) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="' . esc_url( $fonts[$selected_font]['url'] ) . '" rel="stylesheet">';
        $font_stack = $fonts[$selected_font]['stack'];
    }
    ?>
	<?php wp_head(); ?>
    <script src="https://unpkg.com/feather-icons"></script>
    <script type="module">import { codeToHtml } from 'https://esm.sh/shiki@1.0.0'; window.shiki = { codeToHtml };</script>
    <style>
        :root {
            <?php
            $primary = get_theme_mod( 'daisy_corp_primary_color', '#3b82f6' );
            $secondary = get_theme_mod( 'daisy_corp_secondary_color', '#64748b' );
            if ($primary !== '#3b82f6') echo "--color-primary: $primary !important;";
            if ($secondary !== '#64748b') echo "--color-secondary: $secondary !important;";
            ?>
            font-size: <?php echo esc_html( get_theme_mod( 'daisy_corp_base_font_size', '16' ) ); ?>px !important;
        }
        body { font-family: <?php echo $font_stack; ?> !important; }
        pre, code, .prose pre, .prose code, .prose .wp-block-code pre, .mockup-code {
            background-color: <?php echo esc_html( get_theme_mod( 'daisy_corp_code_bg_color', '#1f2937' ) ); ?> !important;
            color: <?php echo esc_html( get_theme_mod( 'daisy_corp_code_text_color', '#e5e7eb' ) ); ?>;
        }
        .mockup-code::before { opacity: 0.8 !important; }
    </style>
</head>

<body <?php body_class('bg-base-100 text-base-content min-h-screen flex flex-col'); ?>>
<?php wp_body_open(); $menu_pos = get_theme_mod( 'daisy_corp_menu_position', 'center' ); ?>

<header class="navbar bg-base-100 border-b border-base-200 sticky top-0 z-50 px-4 md:px-8 overflow-visible">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle lg:hidden"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg></div>
      <?php wp_nav_menu( array('theme_location' => 'menu-1', 'container' => false, 'items_wrap' => '<ul tabindex="0" class="menu menu-md dropdown-content mt-3 z-[1] p-3 shadow bg-base-100 rounded-box w-[80vw] max-w-sm">%3$s</ul>', 'fallback_cb' => false, 'walker' => new Daisy_Corp_Walker_Nav_Menu())); ?>
    </div>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-ghost text-xl font-bold tracking-tight"><?php bloginfo( 'name' ); ?></a>
  </div>

  <?php if ( 'center' === $menu_pos ) : ?>
  <div class="navbar-center hidden lg:flex">
    <?php wp_nav_menu( array('theme_location' => 'menu-1', 'container' => false, 'items_wrap' => '<ul class="menu menu-horizontal px-1 font-medium gap-1">%3$s</ul>', 'fallback_cb' => false, 'walker' => new Daisy_Corp_Walker_Nav_Menu())); ?>
  </div>
  <?php endif; ?>

  <div class="navbar-end">
    <?php if ( 'right' === $menu_pos ) : ?>
    <div class="hidden lg:flex mr-4"><?php wp_nav_menu( array('theme_location' => 'menu-1', 'container' => false, 'items_wrap' => '<ul class="menu menu-horizontal px-1 font-medium gap-1">%3$s</ul>', 'fallback_cb' => false, 'walker' => new Daisy_Corp_Walker_Nav_Menu())); ?></div>
    <?php endif; ?>
    <a href="<?php echo esc_url( get_theme_mod( 'daisy_corp_contact_url', '/contact' ) ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html( get_theme_mod( 'daisy_corp_contact_text', 'Contact' ) ); ?></a>
  </div>
</header>

<main id="primary" class="flex-grow container mx-auto px-4 md:px-8 py-8 animate-subtle-fade">
