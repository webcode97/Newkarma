<?php
/**
 * A WordPress template to list page titles by first letter.
 *
 * You should modify the CSS to suit your theme and place it in its proper file.
 *
 * @package Newkarma
 **/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'amp' );

?>

<div id="primary" class="content-area col-md-content">

	<main id="main" class="site-main site-main-single" role="main">

	<?php

	if ( have_posts() ) {

		echo '<div class="gmr-single gmr-box-content-single">';

		echo '<header class="entry-header">';
			the_title( '<h1 class="title" ' . newkarma_itemprop_schema( 'headline' ) . '>', '</h1>' );
			echo '<div class="screen-reader-text">';
				gmr_posted_on();
			echo '</div>';
		echo '</header><!-- .entry-header -->';

		$arg = array(
			'post_type' => array( 'post' ),
		);

		$categories = get_categories( $arg );

		/* Start the Loop */
		foreach ( $categories as $categ ) {
			echo '<div class="gmr-az-list">';

			$pageds = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			// get term by id custom taxonomy.
			$categ_id = $categ->term_id;

			echo '<div class="az-list-header">';

			echo '<h2><a href="' . esc_url( get_category_link( $categ->term_id ) ) . '" title="' . esc_html( $categ->name ) . '">' . esc_html( $categ->name ) . '</a> <span class="gmr-litle-title pull-right">' . intval( $categ->count ) . ' ' . esc_html__( 'news', 'newkarma' ) . '</span></h2>';

			echo '</div>';

			// create a custom WordPress query.
			$args = array(
				'post_type'      => array( 'post' ),
				'post_status'    => 'publish',
				'cat'            => $categ_id,
				'posts_per_page' => 5,
				'paged'          => $pageds,
			);

			echo '<ul>';
			$recent = new WP_Query( $args );
			/* Start the Loop */
			while ( $recent->have_posts() ) :
				$recent->the_post();
				?>
				<li>
					<div class="entry-meta">
						<?php gmr_posted_on(); ?>
					</div><!-- .entry-meta -->
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_html_e( 'Permanent Link to', 'newkarma' ); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</li>
				<?php
			endwhile;
			echo '</ul>';
			echo '</div>';
		}
		echo '</div>';

	} else {
		echo '<h2>' . esc_html__( 'Sorry, no posts were found!', 'newkarma' ) . '</h2>';
	}
	?>
	</main><!-- #main -->

</div><!-- #primary -->

<aside id="secondary" class="widget-area col-md-sb-r" role="complementary" <?php newkarma_itemtype_schema( 'WPSideBar' ); ?>>
	<h3 class="widget-title"><span><?php esc_html_e( 'Category', 'newkarma' ); ?></span></h3>
	<?php
	echo '<ul class="index-page-numbers">';
	wp_list_categories(
		array(
			'title_li' => '',
		)
	);
	echo '</ul>';
	?>
</aside><!-- #secondary -->

<?php

get_footer( 'amp' );
