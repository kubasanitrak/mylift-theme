<?php the_post_thumbnail( 'full', array( 'class' => 'alignleft' ) ); ?>


<!-- EVEN / ODD POSTS TARGETING: -->
<?php
//I will use WP_Query class instance
$args( 'post_type' => 'recipe', 'posts_per_page' => 5 );

//Set up a counter
$counter = 0;

//Preparing the Loop
$query = new WP_Query( $args );

//In while loop counter increments by one $counter++
if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); $counter++;

    //We are in loop so we can check if counter is odd or even
    if( $counter % 2 == 0 ) : //It's even

        the_title(); //Echo the title of post
        the_content(); //Echo the content of the post

    else: //It's odd

        if( has_post_thumbnail() ) : //If the post has the post thumbnail, show it
            the_post_thumbnail();
        endif;

    endif;
endwhile; wp_reset_postdata(); endif;
 ?>

<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
<div id="post" class"your-class" style="background-image: url('<?php echo $thumb['0'];?>')">
<p>text demo</p>
</div>