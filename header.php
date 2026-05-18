<!doctype html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr( get_theme_mod( 'daisy_corp_daisyui_theme', 'light' ) ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <?php
    $selected_font = get_theme_mod( 'daisy_corp_web_font', 'sans-serif' );
    $font_stack = '';
    $google_font_url = '';

    switch ( $selected_font ) {
        case 'inter':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap';
            $font_stack = '"Inter", sans-serif';
            break;
        case 'noto-sans':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap';
            $font_stack = '"Noto Sans JP", sans-serif';
            break;
        case 'noto-serif':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;700&display=swap';
            $font_stack = '"Noto Serif JP", serif';
            break;
        case 'roboto':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap';
            $font_stack = '"Roboto", sans-serif';
            break;
        case 'merriweather':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap';
            $font_stack = '"Merriweather", serif';
            break;
        case 'oswald':
            $google_font_url = 'https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&display=swap';
            $font_stack = '"Oswald", sans-serif';
            break;
        default:
            $font_stack = 'system-ui, -apple-system, sans-serif';
    }

    if ( ! empty( $google_font_url ) ) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link href="' . esc_url( $google_font_url ) . '" rel="stylesheet">' . "\n";
    }
    ?>
	<?php wp_head(); ?>
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --color-primary: <?php echo esc_html( get_theme_mod( 'daisy_corp_primary_color', '#3b82f6' ) ); ?> !important;
            --color-secondary: <?php echo esc_html( get_theme_mod( 'daisy_corp_secondary_color', '#64748b' ) ); ?> !important;
            font-size: <?php echo esc_html( get_theme_mod( 'daisy_corp_base_font_size', '16' ) ); ?>px !important;
        }
        body {
            <?php if ( ! empty( $font_stack ) ) : ?>
            font-family: <?php echo $font_stack; ?> !important;
            <?php endif; ?>
        }
    </style>
</head>

<body <?php body_class('bg-base-100 text-base-content min-h-screen flex flex-col'); ?>>
<?php wp_body_open(); ?>

<?php
  $menu_position = get_theme_mod( 'daisy_corp_menu_position', 'center' );
?>

<header class="navbar bg-base-100 border-b border-base-200 sticky top-0 z-50 px-4 md:px-8">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
      </div>
      <?php
        wp_nav_menu( array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu-mobile',
          'container'      => false,
          'items_wrap'     => '<ul tabindex="0" class="menu menu-md dropdown-content mt-3 z-[1] p-3 shadow bg-base-100 rounded-box w-[80vw] max-w-sm">%3$s</ul>',
          'fallback_cb'    => false,
        ) );
      ?>
    </div>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-ghost text-xl font-bold tracking-tight"><?php bloginfo( 'name' ); ?></a>
  </div>

  <?php if ( 'center' === $menu_position ) : ?>
  <div class="navbar-center hidden lg:flex">
    <?php
      wp_nav_menu( array(
        'theme_location' => 'menu-1',
        'menu_id'        => 'primary-menu-desktop-center',
        'container'      => false,
        'items_wrap'     => '<ul class="menu menu-horizontal px-1 font-medium gap-1">%3$s</ul>',
        'fallback_cb'    => false,
        'walker'         => new Daisy_Corp_Walker_Nav_Menu(),
      ) );
    ?>
  </div>
  <?php endif; ?>

  <div class="navbar-end">
    <?php if ( 'right' === $menu_position ) : ?>
    <div class="hidden lg:flex mr-4">
      <?php
        wp_nav_menu( array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu-desktop-right',
          'container'      => false,
          'items_wrap'     => '<ul class="menu menu-horizontal px-1 font-medium gap-1">%3$s</ul>',
          'fallback_cb'    => false,
          'walker'         => new Daisy_Corp_Walker_Nav_Menu(),
        ) );
      ?>
    </div>
    <?php endif; ?>
    <a href="<?php echo esc_url( get_theme_mod( 'daisy_corp_contact_url', '/contact' ) ); ?>" class="btn btn-primary btn-sm">
        <?php echo esc_html( get_theme_mod( 'daisy_corp_contact_text', 'Contact' ) ); ?>
    </a>
  </div>
</header>

<main id="primary" class="flex-grow container mx-auto px-4 md:px-8 py-8 animate-subtle-fade">
