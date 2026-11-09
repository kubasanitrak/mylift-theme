<?php
/**
 * Block Name: BLOCK-gallery-column
 *
 * This is the template that displays gallery column item.
 * @param   array $block The block settings and attributes.
 */
?>
<?php
    $CLS_W = 'gallery-grid--col ';
    
    $HAS_ROWS = get_field('has_rows');
        
    // Create class attribute allowing for custom "className" values.
    $classes = ( ! empty( $block['className'] ) ) ? sprintf( $CLS_W . ' %s', $block['className'] ) : $CLS_W;

    // Support custom id values.
    $block_id = '';
    if ( ! empty( $block['anchor'] ) ) :
        $block_id = esc_attr( $block['anchor'] );
    endif;

    $size = 'large';
?>
    
<div
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

        if($HAS_ROWS) :
    ?>
        
    <?php
            /* REPEATER RELATED CODE */
            if( have_rows('gallery_row') ) :
                while ( have_rows('gallery_row') ) : the_row();
                    if( have_rows('gallery_row_item') ) :
    ?>
                <div class="gallery-grid--row">
    <?php
                        while ( have_rows('gallery_row_item') ) : the_row();
                                $imgOBJ = get_sub_field( 'gallery_row_img' );
                                // $size = 'large';
                                $img_W = $imgOBJ['sizes'][ $size . '-width' ];
                                $img_H = $imgOBJ['sizes'][ $size . '-height' ];
                                $style = "--ratio: " . $img_W . "/" . $img_H;
                                
                                // $IMG_ID = get_sub_field('gallery_img');
                                $IMG_ID = $imgOBJ['ID'];
                                $img_src = wp_get_attachment_image_url( $IMG_ID, 'medium' );
                                $img_lightbox_src = wp_get_attachment_image_url( $IMG_ID, 'full' );
                                $img_srcset = wp_get_attachment_image_srcset( $IMG_ID, 'full' );
                                

    ?>
                                <!-- GALLERY IMG ITEM -->
                                <div class="gallery-grid--item " style="<?php echo esc_attr( $style ); ?>">         
                                    <img class="lazyload lightbox" data-gallery="<?php echo esc_attr( $img_lightbox_src ); ?>" data-sizes="auto" data-srcset="<?php echo esc_attr( $img_srcset ); ?>" data-src="<?php echo esc_url( $img_src ); ?>" alt="">
                                </div>
                                <!-- END GALLERY IMG ITEM -->
    <?php
                        endwhile;
    ?>
            </div>
    <?php
                    endif;
                endwhile;
            endif;
    ?>
    <?php
        else :
            $imgOBJ_Single = get_field( 'gallery_single_img' );
            
            $img_W = $imgOBJ_Single['sizes'][ $size . '-width' ];
            $img_H = $imgOBJ_Single['sizes'][ $size . '-height' ];
            $style = "--ratio: " . $img_W . "/" . $img_H;

            $IMG_ID_Single = $imgOBJ_Single['ID'];
            $img_src = wp_get_attachment_image_url( $IMG_ID_Single, 'medium' );
            $img_lightbox_src = wp_get_attachment_image_url( $IMG_ID_Single, 'full' );
            $img_srcset = wp_get_attachment_image_srcset( $IMG_ID_Single, 'full' );
    ?>
            
            <div class="gallery-grid--item " style="<?php echo esc_attr( $style ); ?>">         
                <img class="lazyload lightbox" data-gallery="<?php echo esc_attr( $img_lightbox_src ); ?>" data-sizes="auto" data-srcset="<?php echo esc_attr( $img_srcset ); ?>" data-src="<?php echo esc_url( $img_src ); ?>" alt="">
            </div>

    <?php
        endif;
    ?>
</div><!-- END GALLERY GRID-COL CONTAINER -->