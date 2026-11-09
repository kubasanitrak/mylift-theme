<?php
/**
 * Block Name: BLOCK-custom-section
 * Section Content Block Template.
 * 
 * @param   array $block The block settings and attributes.
 */

?>



<?php
    if( have_rows('about_row') ) :
        $TEMP_MARKUP = '';
        /* REPEATER RELATED CODE */
        while ( have_rows('about_row') ) : the_row();
            
            $FAQ_TYPE =  get_sub_field('faq_item_type');
            $CLAIM_CONTENT = get_sub_field( 'claim_content');
            $FAQ_ITEM_ROW_NUM = get_sub_field( 'faq_item_row_num');
            $FAQ_ITEM_HEADLINE = get_sub_field( 'faq_item_headline');
            $FAQ_ITEM_SUBHEADLINE = get_sub_field( 'faq_item_subheadline');

            $TEMP_MARKUP .= '<div class="faq-item ';
            if ($FAQ_TYPE === 'text') : 
                $TEMP_MARKUP .= ' faq-item--claim';
                $TEMP_MARKUP .= '">';
                $TEMP_MARKUP .= '<h3 class="faq-item--caption">';
                $TEMP_MARKUP .= $CLAIM_CONTENT;
            else :
                $TEMP_MARKUP .= ' faq-item--headline scroll-trigger scroll-trigger--faq';
                $TEMP_MARKUP .= '" style="--grid-row: ';
                $TEMP_MARKUP .= $FAQ_ITEM_ROW_NUM;
                $TEMP_MARKUP .= '">';
                $TEMP_MARKUP .= '<h1 class="faq-item--headline_title">';
                $TEMP_MARKUP .= $FAQ_ITEM_HEADLINE;
                $TEMP_MARKUP .= '</h1>';
                $TEMP_MARKUP .= '<h3 class="faq-item--headline_caption caps strong">';
                $TEMP_MARKUP .= $FAQ_ITEM_SUBHEADLINE;
            endif;

            $TEMP_MARKUP .= '</h3>';
            $TEMP_MARKUP .= '</div>';
                
        endwhile;
        /* END REPEATER LOOP */
    endif;
    
    print $TEMP_MARKUP;

?>