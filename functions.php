<?php
/*
 * Barcelona. Child Theme Function File
 * You can modify any function here. Simply copy any function from parent and paste here. It will override the parent's version.
 */

load_theme_textdomain( 'barcelona', get_stylesheet_directory() . '/languages' );

//Activar enlaces
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

add_action( 'after_setup_theme', 'barcelona_child_theme_scripts', 99 );

function barcelona_child_theme_scripts() {
	add_action( 'wp_enqueue_scripts', 'barcelona_enqueue_scripts_child', 99 );
}

/*
 * Enqueue Child Scripts & Styles
 */
function barcelona_enqueue_scripts_child() {
	if ( ! is_admin() ) {
		wp_register_style( 'barcelona-main-child', trailingslashit( get_stylesheet_directory_uri() ).'style.css', array(), BARCELONA_THEME_VERSION, 'all' );
		wp_enqueue_style( 'barcelona-main-child' );
	}
}


// Apply filter
add_filter('body_class','add_category_to_single');

function add_category_to_single($classes, $class) {
	if (is_single() ) {
		global $post;
		foreach((get_the_category($post->ID)) as $category) {
			// add category slug to the $classes array
			$classes[] = $category->category_nicename;
		}
	}
	// return the $classes array
	return $classes;
}

add_theme_support( 'post-formats', array( 'aside', 'quote' ) );

/*
 * Social Sharing
 */
if ( ! function_exists( 'barcelona_social_sharing' ) ) {
	function barcelona_social_sharing() {

		if ( barcelona_get_option( 'show_social_sharing' ) == 'on' ): ?>
		<div class="post-sharing">

			<ul class="list-inline text-center">
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_the_permalink() ); ?>" target="_blank" title="<?php printf( esc_html__( 'Share on %s', 'barcelona' ), 'Facebook' ); ?>"><span class="fa fa-facebook"></span></a></li>
				<li><a href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() .' - '. get_the_permalink() ); ?>" target="_blank" title="<?php printf( esc_html__( 'Share on %s', 'barcelona' ), 'Twitter' ); ?>"><span class="fa fa-twitter"></span></a></li>

			</ul>

		</div><!-- .post-sharing -->
		<?php endif;

	}
}


if ( ! function_exists( 'posts_ultima_hora' ) ) {
	/**
	 * Custom functionality: ultima hora
	 * 
	 * @author @pabagan
	 * @param 
	 * @return void 
	 */
	function posts_ultima_hora() {
		global $wp_query;
	   	
	   	$output = '';

		$args = array(
			'category_name'  	=> 'ultima-hora',
			'showposts'			=> 6,
			'post_type'        	=> 'post',
			'post_status'      	=> 'publish',
		);

		// Get the ID of a given category
	  	$category_id = get_cat_ID('Última hora');
	  	// Get the URL of this category
	  	$category_link = get_category_link($category_id);
	   	$query = new WP_Query($args);
	   	

	   	// Start output
		$output .='<div class="ultima-hora-box">';
		$output .='<h2 class="title"><a href="'. esc_url($category_link) .'" title="Ir a las noticias de Última hora">Última hora</a></h2>';
		
	   	if($query->have_posts()) :
			$output .='<div class="owl-carousel owl-theme owl-loaded" data-dots="false" data-items="1" data-center="false" data-nav="false">';
		      	while($query->have_posts()) : $query->the_post();		
			        $output .='<div class="item">';
						$output .='<a href="' . esc_url( get_permalink() ) . '">' . esc_html__(get_the_title()) . '</a>';
					$output .='</div>';
		      	endwhile;
			$output .='</div>';
	   	endif;

		$output .='</div>';

		echo $output;

		wp_reset_query();
	}
}


if ( ! function_exists( 'get_agenda_next_30' ) ) {
	/**
	 * Get post categoria agenda de hoy
	 * 
	 * @author @pabagan
	 * @param 
	 * @return void 
	 */
	function get_agenda_next_30() {
		// 
		// Dentro de query
		// 
		//$evento_fecha = get_post_meta( $post->ID, 'evento-fecha', true );


		// Checking if the date has passed
		// $date = new DateTime( ot_get_option( 'evento-fecha' ) );
		// $now  = new DateTime( "now" );

		$ultima_hora_id = 52;
	   	$output = '';
		
		$args = array(
		    'post_type' 	=> 'post', 
		    'cat'           => (integer) $ultima_hora_id,
		    'post_status'   => 'publish',
		    'date_query'    => array(
		        'column'  => 'post_date',
		        'after'   => '- 30 days'
		    )
		);
		$query = new WP_Query( $args );
		$output .='<div class="posts-wrapper row">';
		if($query->have_posts()) :
	      	while($query->have_posts()) : $query->the_post();		
					$output .='<div class="col col-md-3 col-sm-6 mas-item">';
						$output .='<article class="post-summary post-format-standard clearfix">';
							$output .='<div class="post-image">';
								$output .= the_post_thumbnail( 'barcelona-xs' );
							$output .='</div>';

							$output .='<div class="post-details">';
								$output .='<h2 class="post-title">';
									$output .='<a href="' . esc_url( get_permalink() ) . '">' . esc_html__(get_the_title()) . '</a>';
								$output .='</h2>';
								$output .= barcelona_post_meta(['date'], false, false);
							$output .='</div>';
						$output .='</article>';
					$output .='</div>';
				$output .='</div>';
	      	endwhile;
	   	endif;
		$output .='</div>';

		echo $output;

	}
}

if ( ! function_exists( 'get_agenda_dia' ) ) {
	/**
	 * Get post categoria agenda de hoy
	 * 
	 * @author @pabagan
	 * @param 
	 * @return void 
	 */
	function get_agenda_dia() {
		echo '<p>esta es la agenda de hoy...</p>';
	}
}

if ( ! function_exists( 'get_agenda_semana' ) ) {
	/**
	 * Get post categoria agenda de esta semana
	 * 
	 * @author @pabagan
	 * @param 
	 * @return void 
	 */
	function get_agenda_semana() {
		echo '<p>esta es la agenda semanal...</p>';
	}
}

if ( ! function_exists( 'get_agenda_mes' ) ) {
	/**
	 * Get post categoria agenda de esta mes
	 * 
	 * @author @pabagan
	 * @param 
	 * @return void 
	 */
	function get_agenda_mes() {
		echo '<p>esta es la agenda mensual...</p>';
	}
}


/**
 * Register Option Tree metaboxes.
 *
 * @author @pabagan
 * @since Galatea 1.0
 * @see ot_register_meta_box()
 */
function gx_add_OT_metaboxes() {

    // Post 
    $meta_post = array(
        'id'        => 'meta_post',
        'title'     => esc_html__( 'Fecha de evento', 'geniux_lang' ),
        //'desc'      => esc_html__( 'No description', 'geniux_lang' ),
        'pages'     => array( 'post' ),
        'context'   => 'normal',
        'priority'  => 'high',
        'fields'    => array(
            // Sound Cloud
            array(
                'id'          => 'evento-fecha',
				//'label'       => __( 'Fecha de evento', 'geniux_lang' ),
				//'desc'        => __( 'Your description', 'geniux_lang' ),
				//'type'        => 'date-picker',
				'type'        => 'date-time-picker',
            ),
        ),
    );

    if ( function_exists( 'ot_register_meta_box' ) ) {
        ot_register_meta_box( $meta_post );
    }
        
}
add_action( 'admin_init', 'gx_add_OT_metaboxes' );
