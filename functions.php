<?php
/**
 * Daisy Corp functions and definitions
 */

if ( ! function_exists( 'daisy_corp_setup' ) ) :
	function daisy_corp_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'daisy-corp' ),
		) );
	}
endif;
add_action( 'after_setup_theme', 'daisy_corp_setup' );

/**
 * Custom Nav Walker for DaisyUI Dropdowns
 */
class Daisy_Corp_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $output .= '<a href="' . esc_url( $item->url ) . '" class="flex items-center justify-between">';
        $output .= esc_html( $item->title );
        if ( $has_children ) {
            $output .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>';
        }
        $output .= '</a>';
    }
}

function daisy_corp_scripts() {
	wp_enqueue_style( 'daisy-corp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'daisy-corp-tailwind', get_template_directory_uri() . '/dist/output.css', array(), '1.0.1' );

    // Code blocks enhancement script
    wp_enqueue_script( 'daisy-corp-code-blocks', get_template_directory_uri() . '/js/code-blocks.js', array(), '1.0.1', true );
}
add_action( 'wp_enqueue_scripts', 'daisy_corp_scripts' );

function daisy_corp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'daisy-corp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'daisy-corp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-8">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title text-xl font-bold mb-4">',
		'after_title'   => '</h2>',
	) );

    // Register footer sidebars
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer Column %d', 'daisy-corp' ), $i ),
            'id'            => "footer-$i",
            'description'   => sprintf( esc_html__( 'Add widgets here for footer column %d.', 'daisy-corp' ), $i ),
            'before_widget' => '<nav class="footer-widget-nav">',
            'after_widget'  => '</nav>',
            'before_title'  => '<h6 class="footer-title">',
            'after_title'   => '</h6>',
        ) );
    }
}
add_action( 'widgets_init', 'daisy_corp_widgets_init' );

/**
 * Layout helper to get grid configuration
 */
function daisy_corp_get_layout_config() {
    $sidebar_pos = get_theme_mod( 'daisy_corp_sidebar_position', 'right' );
    $hide_sidebar = false;

    if ( is_singular() ) {
        $hide_sidebar = get_theme_mod( 'daisy_corp_hide_sidebar_single', false );
    }

    $blog_cols = get_theme_mod( 'daisy_corp_blog_columns', '2' );
    $grid_cols_class = 'grid-cols-1';
    if ( '2' === $blog_cols ) {
        $grid_cols_class = 'grid-cols-1 sm:grid-cols-2';
    } elseif ( '4' === $blog_cols ) {
        $grid_cols_class = 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-4';
    }

    return array(
        'sidebar_pos'     => $sidebar_pos,
        'hide_sidebar'    => $hide_sidebar,
        'main_order'      => ( 'left' === $sidebar_pos ) ? 'order-2' : 'order-1',
        'sidebar_order'   => ( 'left' === $sidebar_pos ) ? 'order-1' : 'order-2',
        'main_cols_class' => $hide_sidebar ? 'lg:col-span-4' : 'lg:col-span-3',
        'grid_gap_class'  => $hide_sidebar ? '' : 'lg:gap-16',
        'blog_grid_class' => $grid_cols_class,
    );
}

/**
 * Recursive function to build category tree
 */
function daisy_corp_get_category_tree( $parent_id = 0, $depth = 1 ) {
    if ( $depth > 3 ) return '';

    $categories = get_categories( array(
        'parent' => $parent_id,
        'hide_empty' => false,
    ) );

    if ( empty( $categories ) ) return '';

    $output = '';
    foreach ( $categories as $category ) {
        $children = daisy_corp_get_category_tree( $category->term_id, $depth + 1 );
        $output .= '<li>';
        $count_badge = '<span class="badge badge-sm badge-outline opacity-50">' . $category->count . '</span>';

        if ( ! empty( $children ) ) {
            $output .= '<details open>';
            $output .= '<summary><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="flex justify-between items-center w-full gap-4">' . esc_html( $category->name ) . ' ' . $count_badge . '</a></summary>';
            $output .= '<ul>' . $children . '</ul>';
            $output .= '</details>';
        } else {
            $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="flex justify-between items-center gap-4">' . esc_html( $category->name ) . ' ' . $count_badge . '</a>';
        }
        $output .= '</li>';
    }
    return $output;
}

/**
 * Category Tree Widget
 */
class Daisy_Corp_Category_Tree_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct( 'daisy_corp_category_tree', __( 'Daisy Corp Category Tree', 'daisy-corp' ) );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        $tree = daisy_corp_get_category_tree();
        if ( ! empty( $tree ) ) {
            echo '<ul class="menu bg-base-200 w-full rounded-box">' . $tree . '</ul>';
        } else {
            echo '<p>' . esc_html__( 'No categories found.', 'daisy-corp' ) . '</p>';
        }
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categories', 'daisy-corp' );
        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title:' ) . '</label>';
        echo '<input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( $title ) . '"></p>';
    }

    public function update( $new_instance, $old_instance ) {
        return array( 'title' => ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '' );
    }
}
add_action( 'widgets_init', function() { register_widget( 'Daisy_Corp_Category_Tree_Widget' ); } );

function daisy_corp_category_tree_shortcode() {
    $tree = daisy_corp_get_category_tree();
    if ( empty( $tree ) ) return '<p>' . esc_html__( 'No categories found.', 'daisy-corp' ) . '</p>';
    return '<div class="daisy-corp-category-tree"><ul class="menu bg-base-200 w-full rounded-box">' . $tree . '</ul></div>';
}
add_shortcode( 'category_tree', 'daisy_corp_category_tree_shortcode' );

/**
 * Filter comment form fields
 */
function daisy_corp_comment_form_fields( $fields ) {
    foreach( $fields as $key => $field ) {
        $fields[$key] = str_replace( array('<input', '<textarea'), array('<input class="input input-bordered w-full"', '<textarea class="textarea textarea-bordered w-full"'), $field );
    }
    return $fields;
}
add_filter( 'comment_form_default_fields', 'daisy_corp_comment_form_fields' );

add_filter( 'comment_form_field_comment', function( $field ) {
    return str_replace( '<textarea', '<textarea class="textarea textarea-bordered w-full"', $field );
} );

add_filter( 'comment_form_submit_button', function( $submit_button ) {
    return str_replace( 'class="submit"', 'class="submit btn btn-primary"', $submit_button );
} );

/**
 * Customizer settings
 */
function daisy_corp_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'daisy_corp_theme_settings', array( 'title' => __( 'Theme Settings', 'daisy-corp' ), 'priority' => 30 ) );

    $settings = array(
        'daisy_corp_menu_position'      => array( 'default' => 'center', 'type' => 'radio', 'choices' => array( 'center' => 'Center', 'right' => 'Right' ) ),
        'daisy_corp_sidebar_position'   => array( 'default' => 'right',  'type' => 'radio', 'choices' => array( 'left' => 'Left', 'right' => 'Right' ) ),
        'daisy_corp_blog_columns'       => array( 'default' => '2',      'type' => 'select', 'choices' => array( '1' => '1 Column', '2' => '2 Columns', '4' => '4 Columns' ) ),
        'daisy_corp_daisyui_theme'      => array( 'default' => 'light',  'type' => 'select', 'choices' => array_combine(array('light','dark','cupcake','bumblebee','emerald','corporate','synthwave','retro','cyberpunk','valentine','halloween','garden','forest','aqua','lofi','pastel','fantasy','wireframe','black','luxury','dracula','cmyk','autumn','business','acid','lemonade','night','coffee','winter','dim','nord','sunset'), array_map('ucfirst', array('light','dark','cupcake','bumblebee','emerald','corporate','synthwave','retro','cyberpunk','valentine','halloween','garden','forest','aqua','lofi','pastel','fantasy','wireframe','black','luxury','dracula','cmyk','autumn','business','acid','lemonade','night','coffee','winter','dim','nord','sunset'))) ),
        'daisy_corp_hide_sidebar_single'=> array( 'default' => false,    'type' => 'checkbox' ),
    );

    foreach ( $settings as $id => $args ) {
        $wp_customize->add_setting( $id, array( 'default' => $args['default'], 'sanitize_callback' => (is_bool($args['default']) ? 'daisy_corp_sanitize_checkbox' : 'sanitize_text_field') ) );
        $wp_customize->add_control( $id, array( 'label' => ucwords(str_replace('_', ' ', str_replace('daisy_corp_', '', $id))), 'section' => 'daisy_corp_theme_settings', 'type' => $args['type'], 'choices' => isset($args['choices']) ? $args['choices'] : null ) );
    }

    // Colors
    $colors = array(
        'daisy_corp_primary_color'   => '#3b82f6',
        'daisy_corp_secondary_color' => '#64748b',
        'daisy_corp_code_bg_color'   => '#1f2937',
        'daisy_corp_code_text_color' => '#e5e7eb',
    );
    foreach ( $colors as $id => $default ) {
        $wp_customize->add_setting( $id, array( 'default' => $default, 'sanitize_callback' => 'sanitize_hex_color' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => ucwords(str_replace('_', ' ', str_replace('daisy_corp_', '', $id))), 'section' => 'daisy_corp_theme_settings' ) ) );
    }

    // Other inputs
    $wp_customize->add_setting( 'daisy_corp_excerpt_length', array( 'default' => 40, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'daisy_corp_excerpt_length', array( 'label' => 'Excerpt Length', 'section' => 'daisy_corp_theme_settings', 'type' => 'number' ) );

    $wp_customize->add_setting( 'daisy_corp_base_font_size', array( 'default' => 16, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'daisy_corp_base_font_size', array( 'label' => 'Base Font Size', 'section' => 'daisy_corp_theme_settings', 'type' => 'number' ) );

    $wp_customize->add_setting( 'daisy_corp_web_font', array( 'default' => 'sans-serif', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'daisy_corp_web_font', array( 'label' => 'Font Family', 'section' => 'daisy_corp_theme_settings', 'type' => 'select', 'choices' => array( 'sans-serif' => 'System', 'inter' => 'Inter', 'noto-sans' => 'Noto Sans JP', 'noto-serif' => 'Noto Serif JP', 'roboto' => 'Roboto', 'merriweather' => 'Merriweather', 'oswald' => 'Oswald' ) ) );
}
add_action( 'customize_register', 'daisy_corp_customize_register' );

function daisy_corp_sanitize_checkbox( $input ) { return ( isset( $input ) && true === $input ) ? true : false; }

add_filter( 'excerpt_length', function( $length ) { return get_theme_mod( 'daisy_corp_excerpt_length', 40 ); }, 999 );

/**
 * Generate TOC with robust regex and ID injection
 */
function daisy_corp_get_toc( $content ) {
    $pattern = '/<h([2-3])(.*?)>(.*?)<\/h\1>/i';
    if ( ! preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER ) ) return array( 'toc' => '', 'content' => $content );

    $toc = '<div class="daisy-corp-toc mb-0 bg-base-200 p-6 rounded-t-2xl border-t border-x border-base-300 animate-subtle-fade">';
    $toc .= '<h6 class="text-sm font-bold mb-4 opacity-70 uppercase tracking-wider flex items-center gap-2"><i data-feather="list" class="w-4 h-4"></i> ' . esc_html( get_theme_mod( 'daisy_corp_toc_title', 'Table of Contents' ) ) . '</h6><ul class="menu menu-sm p-0 opacity-80">';

    $modified_content = $content;
    foreach ( $matches as $match ) {
        $id = sanitize_title( strip_tags( $match[3] ) );
        $modified_content = str_replace( $match[0], "<h{$match[1]} id=\"$id\"{$match[2]}>{$match[3]}</h{$match[1]}>", $modified_content );
        $toc .= '<li class="' . ($match[1] == '3' ? 'ml-4' : '') . '"><a href="#' . $id . '">' . strip_tags( $match[3] ) . '</a></li>';
    }
    return array( 'toc' => $toc . '</ul></div>', 'content' => $modified_content );
}

function daisy_corp_get_reading_time() {
    $char_count = mb_strlen( preg_replace( '/\s+/', '', strip_tags( get_post_field( 'post_content', get_the_ID() ) ) ) );
    return sprintf( esc_html__( '%d min read', 'daisy-corp' ), max( 1, ceil( $char_count / 500 ) ) );
}

function daisy_corp_get_breadcrumbs() {
    if ( is_front_page() ) return '';
    $breadcrumbs = '<div class="text-xs breadcrumbs mb-6 opacity-60"><ul><li><a href="' . esc_url( home_url( '/' ) ) . '"><i data-feather="home" class="mr-1"></i> Home</a></li>';
    if ( is_single() ) {
        if ( $cats = get_the_category() ) $breadcrumbs .= '<li><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a></li>';
        $breadcrumbs .= '<li>' . get_the_title() . '</li>';
    } else { $breadcrumbs .= '<li>' . get_the_title() . '</li>'; }
    return $breadcrumbs . '</ul></div>';
}

function daisy_corp_pagination() {
    if ( $links = paginate_links( array( 'type' => 'array', 'prev_text' => '&laquo;', 'next_text' => '&raquo;' ) ) ) {
        echo '<div class="join flex justify-center mt-12">';
        foreach ( $links as $link ) echo str_replace( array('page-numbers current', 'page-numbers'), array('join-item btn btn-active', 'join-item btn'), $link );
        echo '</div>';
    }
}
