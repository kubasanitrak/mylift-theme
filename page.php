<?php
/**
 * Template Name: PAGE
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage mylift-theme
 * @since 1.0
 * * @version 1.0
 */

get_header(); ?>

 


<!-- PAGE CONTENT -->

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php if(!is_front_page()) : ?>
			<div class="page-title-container">
				<h1 class="page-title caps"><?php the_title(); ?></h1>
			</div> <!-- END PAGE TITLE CONTAINER -->
		<?php endif; ?>

		<!-- <div class="section section-content"> -->
			<?php the_content(); ?>
		<!-- </div> -->
		<!-- END SECTION CONTENT -->
		
	<?php endwhile; endif; ?>


	<?php get_footer(); ?>