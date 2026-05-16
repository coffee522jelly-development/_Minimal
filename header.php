<!doctype html>
<html <?php language_attributes(); ?> data-theme="<?php echo esc_attr( get_theme_mod( 'daisy_corp_daisyui_theme', 'light' ) ); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
    <style>
        :root {
            --color-primary: <?php echo esc_html( get_theme_mod( 'daisy_corp_primary_color', '#3b82f6' ) ); ?> !important;
            --color-secondary: <?php echo esc_html( get_theme_mod( 'daisy_corp_secondary_color', '#64748b' ) ); ?> !important;
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
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
      </div>
      <?php
        wp_nav_menu( array(
          'theme_location' => 'menu-1',
          'menu_id'        => 'primary-menu-mobile',
          'container'      => false,
          'items_wrap'     => '<ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">%3$s</ul>',
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
    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-sm">Contact</a>
  </div>
</header>

<main id="primary" class="flex-grow container mx-auto px-4 md:px-8 py-8">
