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
		'name'          => esc_html__( 'Footer Widget Area', 'daisy-corp' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here for the footer.', 'daisy-corp' ),
		'before_widget' => '<nav>',
		'after_widget'  => '</nav>',
		'before_title'  => '<h6 class="footer-title">',
		'after_title'   => '</h6>',
	) );
}
add_action( 'widgets_init', 'daisy_corp_widgets_init' );

/**
 * Recursive function to build category tree with DaisyUI menu classes
 */
function daisy_corp_get_category_tree( $parent_id = 0 ) {
    $categories = get_categories( array(
        'parent' => $parent_id,
        'hide_empty' => false,
    ) );

    if ( empty( $categories ) ) {
        return '';
    }

    $output = '';
    foreach ( $categories as $category ) {
        $children = daisy_corp_get_category_tree( $category->term_id );
        $output .= '<li>';
        if ( ! empty( $children ) ) {
            $output .= '<details open>';
            $output .= '<summary><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></summary>';
            $output .= '<ul>' . $children . '</ul>';
            $output .= '</details>';
        } else {
            $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
        }
        $output .= '</li>';
    }

    return $output;
}

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
