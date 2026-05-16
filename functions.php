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

/**
 * Custom Nav Walker for DaisyUI Dropdowns
 */
class Daisy_Corp_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="p-2 bg-base-100 rounded-t-none shadow-lg z-[1]">';
    }

    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        $output .= '<li>';

        if ( $has_children && $depth === 0 ) {
            $output .= '<details>';
            $output .= '<summary>' . esc_html( $item->title ) . '</summary>';
        } else {
            $output .= '<a href="' . esc_url( $item->url ) . '">' . esc_html( $item->title ) . '</a>';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = null ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        if ( $has_children && $depth === 0 ) {
            $output .= '</details>';
        }
        $output .= '</li>';
    }
}
add_action( 'after_setup_theme', 'daisy_corp_setup' );

function daisy_corp_scripts() {
	wp_enqueue_style( 'daisy-corp-style', get_stylesheet_uri() );
	wp_enqueue_style( 'daisy-corp-tailwind', get_template_directory_uri() . '/dist/output.css', array(), '1.0.0' );
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

    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'daisy-corp' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here for the first footer column.', 'daisy-corp' ),
		'before_widget' => '<nav>',
		'after_widget'  => '</nav>',
		'before_title'  => '<h6 class="footer-title">',
		'after_title'   => '</h6>',
	) );

    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'daisy-corp' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here for the second footer column.', 'daisy-corp' ),
		'before_widget' => '<nav>',
		'after_widget'  => '</nav>',
		'before_title'  => '<h6 class="footer-title">',
		'after_title'   => '</h6>',
	) );

    register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'daisy-corp' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here for the third footer column.', 'daisy-corp' ),
		'before_widget' => '<nav>',
		'after_widget'  => '</nav>',
		'before_title'  => '<h6 class="footer-title">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'daisy_corp_widgets_init' );

/**
 * Recursive function to build category tree with DaisyUI menu classes
 * Specifically limited to 3 levels of depth.
 */
function daisy_corp_get_category_tree( $parent_id = 0, $depth = 1 ) {
    if ( $depth > 3 ) {
        return '';
    }

    $categories = get_categories( array(
        'parent' => $parent_id,
        'hide_empty' => false,
    ) );

    if ( empty( $categories ) ) {
        return '';
    }

    $output = '';
    foreach ( $categories as $category ) {
        $children = daisy_corp_get_category_tree( $category->term_id, $depth + 1 );
        $output .= '<li>';
        $count = $category->count;
        $count_badge = '<span class="badge badge-sm badge-outline opacity-50">' . $count . '</span>';

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
 * Category Tree Widget Class
 */
class Daisy_Corp_Category_Tree_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'daisy_corp_category_tree',
            __( 'Daisy Corp Category Tree', 'daisy-corp' ),
            array( 'description' => __( 'Displays a 3-level hierarchical category tree.', 'daisy-corp' ) )
        );
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
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}

function daisy_corp_register_widgets() {
    register_widget( 'Daisy_Corp_Category_Tree_Widget' );
}
add_action( 'widgets_init', 'daisy_corp_register_widgets' );

/**
 * Category Tree Shortcode
 */
function daisy_corp_category_tree_shortcode() {
    $tree = daisy_corp_get_category_tree();
    if ( empty( $tree ) ) {
        return '<p>' . esc_html__( 'No categories found.', 'daisy-corp' ) . '</p>';
    }
    return '<div class="daisy-corp-category-tree"><ul class="menu bg-base-200 w-full rounded-box">' . $tree . '</ul></div>';
}
add_shortcode( 'category_tree', 'daisy_corp_category_tree_shortcode' );

/**
 * Filter comment form fields to add DaisyUI classes
 */
function daisy_corp_comment_form_fields( $fields ) {
    foreach( $fields as $key => $field ) {
        $fields[$key] = str_replace( '<input', '<input class="input input-bordered w-full"', $field );
        $fields[$key] = str_replace( '<textarea', '<textarea class="textarea textarea-bordered w-full"', $field );
    }
    return $fields;
}
add_filter( 'comment_form_default_fields', 'daisy_corp_comment_form_fields' );

function daisy_corp_comment_form_textarea( $field ) {
    return str_replace( '<textarea', '<textarea class="textarea textarea-bordered w-full"', $field );
}
add_filter( 'comment_form_field_comment', 'daisy_corp_comment_form_textarea' );

function daisy_corp_comment_form_submit_button( $submit_button ) {
    return str_replace( 'class="submit"', 'class="submit btn btn-primary"', $submit_button );
}
add_filter( 'comment_form_submit_button', 'daisy_corp_comment_form_submit_button' );

/**
 * Theme Customizer settings
 */
function daisy_corp_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'daisy_corp_theme_settings', array(
        'title'    => __( 'Theme Settings', 'daisy-corp' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'daisy_corp_menu_position', array(
        'default'   => 'center',
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_menu_position',
    ) );

    $wp_customize->add_control( 'daisy_corp_menu_position', array(
        'label'      => __( 'Menu Position', 'daisy-corp' ),
        'section'    => 'daisy_corp_theme_settings',
        'settings'   => 'daisy_corp_menu_position',
        'type'       => 'radio',
        'choices'    => array(
            'center' => __( 'Center', 'daisy-corp' ),
            'right'  => __( 'Right', 'daisy-corp' ),
        ),
    ) );

    // Sidebar Position
    $wp_customize->add_setting( 'daisy_corp_sidebar_position', array(
        'default'   => 'right',
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_sidebar_position',
    ) );

    $wp_customize->add_control( 'daisy_corp_sidebar_position', array(
        'label'      => __( 'Sidebar Position', 'daisy-corp' ),
        'section'    => 'daisy_corp_theme_settings',
        'settings'   => 'daisy_corp_sidebar_position',
        'type'       => 'radio',
        'choices'    => array(
            'left'  => __( 'Left', 'daisy-corp' ),
            'right' => __( 'Right', 'daisy-corp' ),
        ),
    ) );

    // Blog Columns
    $wp_customize->add_setting( 'daisy_corp_blog_columns', array(
        'default'   => '2',
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_blog_columns',
    ) );

    $wp_customize->add_control( 'daisy_corp_blog_columns', array(
        'label'      => __( 'Blog Grid Columns', 'daisy-corp' ),
        'section'    => 'daisy_corp_theme_settings',
        'settings'   => 'daisy_corp_blog_columns',
        'type'       => 'select',
        'choices'    => array(
            '1' => __( '1 Column', 'daisy-corp' ),
            '2' => __( '2 Columns', 'daisy-corp' ),
            '4' => __( '4 Columns', 'daisy-corp' ),
        ),
    ) );

    // Primary Color
    $wp_customize->add_setting( 'daisy_corp_primary_color', array(
        'default'   => '#3b82f6', // Default primary color
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'daisy_corp_primary_color', array(
        'label'    => __( 'Primary Color', 'daisy-corp' ),
        'section'  => 'daisy_corp_theme_settings',
        'settings' => 'daisy_corp_primary_color',
    ) ) );

    // Secondary Color
    $wp_customize->add_setting( 'daisy_corp_secondary_color', array(
        'default'   => '#64748b', // Default secondary color
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'daisy_corp_secondary_color', array(
        'label'    => __( 'Secondary Color', 'daisy-corp' ),
        'section'  => 'daisy_corp_theme_settings',
        'settings' => 'daisy_corp_secondary_color',
    ) ) );

    // Excerpt Length
    $wp_customize->add_setting( 'daisy_corp_excerpt_length', array(
        'default'   => '40',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'daisy_corp_excerpt_length', array(
        'label'      => __( 'Excerpt Length (Words)', 'daisy-corp' ),
        'section'    => 'daisy_corp_theme_settings',
        'settings'   => 'daisy_corp_excerpt_length',
        'type'       => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 200,
            'step' => 5,
        ),
    ) );

    // DaisyUI Theme Selector
    $wp_customize->add_setting( 'daisy_corp_daisyui_theme', array(
        'default'   => 'light',
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_daisyui_theme',
    ) );

    $wp_customize->add_control( 'daisy_corp_daisyui_theme', array(
        'label'    => __( 'DaisyUI Theme', 'daisy-corp' ),
        'section'  => 'daisy_corp_theme_settings',
        'settings' => 'daisy_corp_daisyui_theme',
        'type'     => 'select',
        'choices'  => array(
            'light' => 'Light',
            'dark' => 'Dark',
            'cupcake' => 'Cupcake',
            'bumblebee' => 'Bumblebee',
            'emerald' => 'Emerald',
            'corporate' => 'Corporate',
            'synthwave' => 'Synthwave',
            'retro' => 'Retro',
            'cyberpunk' => 'Cyberpunk',
            'valentine' => 'Valentine',
            'halloween' => 'Halloween',
            'garden' => 'Garden',
            'forest' => 'Forest',
            'aqua' => 'Aqua',
            'lofi' => 'Lo-fi',
            'pastel' => 'Pastel',
            'fantasy' => 'Fantasy',
            'wireframe' => 'Wireframe',
            'black' => 'Black',
            'luxury' => 'Luxury',
            'dracula' => 'Dracula',
            'cmyk' => 'CMYK',
            'autumn' => 'Autumn',
            'business' => 'Business',
            'acid' => 'Acid',
            'lemonade' => 'Lemonade',
            'night' => 'Night',
            'coffee' => 'Coffee',
            'winter' => 'Winter',
            'dim' => 'Dim',
            'nord' => 'Nord',
            'sunset' => 'Sunset',
        ),
    ) );

    // Hide Sidebar on Single/Page
    $wp_customize->add_setting( 'daisy_corp_hide_sidebar_single', array(
        'default'   => false,
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'daisy_corp_hide_sidebar_single', array(
        'label'    => __( 'Hide Sidebar on Single Posts & Pages', 'daisy-corp' ),
        'section'  => 'daisy_corp_theme_settings',
        'settings' => 'daisy_corp_hide_sidebar_single',
        'type'     => 'checkbox',
    ) );

    // Base Font Size
    $wp_customize->add_setting( 'daisy_corp_base_font_size', array(
        'default'   => '16',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ) );

    $wp_customize->add_control( 'daisy_corp_base_font_size', array(
        'label'      => __( 'Base Font Size (px)', 'daisy-corp' ),
        'section'    => 'daisy_corp_theme_settings',
        'settings'   => 'daisy_corp_base_font_size',
        'type'       => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ) );

    // Web Font
    $wp_customize->add_setting( 'daisy_corp_web_font', array(
        'default'   => 'sans-serif',
        'transport' => 'refresh',
        'sanitize_callback' => 'daisy_corp_sanitize_web_font',
    ) );

    $wp_customize->add_control( 'daisy_corp_web_font', array(
        'label'    => __( 'Theme Font Family', 'daisy-corp' ),
        'section'  => 'daisy_corp_theme_settings',
        'settings' => 'daisy_corp_web_font',
        'type'     => 'select',
        'choices'  => array(
            'sans-serif' => 'System Sans-Serif',
            'inter'      => 'Inter (Sans-Serif)',
            'noto-sans'  => 'Noto Sans JP (Japanese Sans-Serif)',
            'noto-serif' => 'Noto Serif JP (Japanese Serif)',
            'roboto'     => 'Roboto',
            'merriweather' => 'Merriweather (Serif)',
            'oswald'     => 'Oswald (Display)',
        ),
    ) );
}
add_action( 'customize_register', 'daisy_corp_customize_register' );

function daisy_corp_sanitize_menu_position( $input ) {
    $valid = array( 'center', 'right' );
    if ( in_array( $input, $valid ) ) {
        return $input;
    }
    return 'center';
}

function daisy_corp_sanitize_sidebar_position( $input ) {
    $valid = array( 'left', 'right' );
    if ( in_array( $input, $valid ) ) {
        return $input;
    }
    return 'right';
}

function daisy_corp_sanitize_blog_columns( $input ) {
    $valid = array( '1', '2', '4' );
    if ( in_array( $input, $valid ) ) {
        return $input;
    }
    return '2';
}

function daisy_corp_sanitize_daisyui_theme( $input ) {
    $valid = array(
        'light', 'dark', 'cupcake', 'bumblebee', 'emerald', 'corporate', 'synthwave', 'retro',
        'cyberpunk', 'valentine', 'halloween', 'garden', 'forest', 'aqua', 'lofi', 'pastel',
        'fantasy', 'wireframe', 'black', 'luxury', 'dracula', 'cmyk', 'autumn', 'business',
        'acid', 'lemonade', 'night', 'coffee', 'winter', 'dim', 'nord', 'sunset'
    );
    if ( in_array( $input, $valid ) ) {
        return $input;
    }
    return 'light';
}

function daisy_corp_sanitize_checkbox( $input ) {
    return ( isset( $input ) && true === $input ) ? true : false;
}

function daisy_corp_sanitize_web_font( $input ) {
    $valid = array( 'sans-serif', 'inter', 'noto-sans', 'noto-serif', 'roboto', 'merriweather', 'oswald' );
    if ( in_array( $input, $valid ) ) {
        return $input;
    }
    return 'sans-serif';
}

/**
 * Filter excerpt length
 */
function daisy_corp_custom_excerpt_length( $length ) {
    return get_theme_mod( 'daisy_corp_excerpt_length', 40 );
}
add_filter( 'excerpt_length', 'daisy_corp_custom_excerpt_length', 999 );

/**
 * Filter pagination links to add DaisyUI classes and ensure horizontal layout
 */
function daisy_corp_pagination() {
    $links = paginate_links( array(
        'type'      => 'array',
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
    ) );

    if ( is_array( $links ) ) {
        echo '<div class="join flex justify-center mt-12">';
        foreach ( $links as $link ) {
            if ( strpos( $link, 'current' ) !== false ) {
                echo str_replace( 'page-numbers current', 'join-item btn btn-active', $link );
            } else {
                echo str_replace( 'page-numbers', 'join-item btn', $link );
            }
        }
        echo '</div>';
    }
}
