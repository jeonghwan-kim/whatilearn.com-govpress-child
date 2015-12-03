<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}


if ( ! function_exists( 'govpress_child_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function govpress_posted_on() {
		$time_string = '<i class="fa fa-clock-o"></i><time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
		);

		printf( __( '<span class="posted-on">%1$s</span>', 'govpress' ),
				sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
						esc_url( get_permalink() ),
						$time_string
				)
		);
	}
endif;

if ( ! function_exists( 'govpress_category' ) ) :
	function govpress_category () {
	?>
		<i class="fa fa-folder-o"></i>
		<?php
		$categories =  wp_get_post_categories( get_the_ID() );
		foreach ( $categories as $category ) {
			$cat = get_category( $category );
			echo '<li class="category-link"><a href="' . get_category_link( $cat->cat_ID ) . '">' . $cat->name . '</a></li>';
		}
		?>
	<?php
	}
endif;

if ( ! function_exists( 'govpress_tags' ) ) :
	function govpress_tags() {
	?>
		<i class="fa fa-tags"></i>
		<?php echo get_the_tag_list('<li class="tag-link">','</li><li>','</li>'); ?>
	<?php
	}
endif;

function govpress_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'govpress' ); ?></h1>
		<div class="nav-links">

			<?php if ( function_exists( 'wp_pagenavi' ) ) {

				wp_pagenavi();

			} else { ?>

				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'govpress' ) ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'govpress' ) ); ?></div>
				<?php endif; ?>

			<?php } ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
} ?>

<?php
add_action('wp_footer', 'add_googleanalytics');
function add_googleanalytics() {?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-31588166-2', 'auto');
      ga('send', 'pageview');
    </script>
<?php }?>

<?php
function wpsites_home_page_limit( $query ) {
    if ( $query->is_home() && $query->is_main_query() && !is_admin() ) {
        $query->set( 'posts_per_page', '1' );
    }
}
add_action( 'pre_get_posts', 'wpsites_home_page_limit' );
?>
