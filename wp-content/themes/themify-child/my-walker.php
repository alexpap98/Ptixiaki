<?php 
    class WPSE_Custom_Nav_Walker extends Walker_Nav_Menu {
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    
        function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent</ul>\n";
        }
    
        function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
    
            // Output subject dropdown menu
            if ( in_array( 'menu-item-has-children', $item->classes ) && $depth == 0 ) {
                $item_output .= '<select class="subject-menu">';
                $item_output .= '<option value="">' . __( 'Select a Subject', 'textdomain' ) . '</option>';
                $subject_terms = get_terms( 'lesson_subject', array( 'hide_empty' => false ) );
                foreach ( $subject_terms as $subject_term ) {
                    $item_output .= '<option value="' . get_term_link( $subject_term ) . '">' . $subject_term->name . '</option>';
    
                    // Output lessons as options for current subject
                    $lesson_args = array(
                        'post_type' => 'lesson',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'lesson_subject',
                                'field' => 'slug',
                                'terms' => $subject_term->slug,
                            ),
                        ),
                    );
                    $lesson_query = new WP_Query( $lesson_args );
                    while ( $lesson_query->have_posts() ) {
                        $lesson_query->the_post();
                        $item_output .= '<option value="' . get_permalink() . '">- ' . get_the_title() . '</option>';
                    }
                    wp_reset_postdata();
                }
                $item_output .= '</select>';
            } else {
                $item_output .= $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
            }
    
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
    
?>