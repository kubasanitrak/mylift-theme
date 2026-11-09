<?php
/**
 * Block Name: BLOCK-news-list
 *
 * This is the template that displays News in list.
 * @param   array $block The block settings and attributes.
 */
?>
<?php
    // $IS_LINKS_GRID = get_field('is_links_grid');

    $CLS_W = ' split-screen--col split-screen--col_news news-list news-list--anim';

    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

    // Support custom id values.
    $block_id = '';
    if ( ! empty( $block['anchor'] ) ) :
        $block_id = esc_attr( $block['anchor'] );
    endif;
?>

<?php
    $argType = get_field( 'loop_argument_type' );

    if( $argType == "count" ) :
      $args = array(
        // AN ARRAY OF CATEGORY IDS A POST SHOULD HAVE.
        // 'category__and' => $CAT_IDS, // array(5,1))) 
        'post_type' => 'post',
        'post_status' => 'publish',
        'category_name' => 'novinky, news, notizia',
        'order' => 'ASC',
        'posts_per_page' => get_field( 'news_count' )
      );
    else:
      $todisplay = get_field( 'select_news' );
      $args = array( 
        'post_type' => 'post',
        'post_status' => 'publish',
        'order' => 'ASC',
        'post__in' => $todisplay
      );
    endif;


    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) : 

        ?>
    <div data-theme="default"
        <?php
        echo wp_kses_data(
            get_block_wrapper_attributes(
                array(
                    'id'    => $block_id,
                    'class' => esc_attr( $classes ),
                )
            )
        );
        ?>
    >
                        
        <?php 
            while ( $the_query->have_posts() ) : $the_query->the_post();
            $POST_ID = get_the_ID();
            $POST_TITLE = get_the_title();
            $DATE = get_the_date();
        ?>
            <div class="news-list--item accord-item">

                <input type="checkbox" id="accord-switch-<?php echo $POST_ID; ?>_ID" class="accord-item--input">
                <label for="accord-switch-<?php echo $POST_ID; ?>_ID" class="accord-item--switch">
                    <span class=""></span>
                </label>
                <div class="news-list--item_header accord-item--header">
                    <h5 class="news-list--item_title caps accord-item--title strong"><?php echo $POST_TITLE; ?></h5>
                    <div class="news-list--item_row accord-item--header_row">
                        <p class="news-list--item_info"><?php echo $DATE; ?></p>
                        <p class="news-list--item_readmore strong"><?php _e('read more', 'mylift-theme'); ?></p>
                    </div>
                </div>
                <div class="news-list--item_content accord-item--content">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php
            endwhile;
        ?>
        </div>

        <div class="split-screen--col split-screen--col_news shape-3D split-screen--col_scroll-anim split-screen--col_FULL" data-theme="dark">
            <h1 class="section-title caps"><?php echo get_field( 'news_list_title' ); ?></h1>
        </div>

<?php else: __( 'Sorry, there are no items to display', 'mylift-theme' ); ?>
<?php endif;  ?>
                    