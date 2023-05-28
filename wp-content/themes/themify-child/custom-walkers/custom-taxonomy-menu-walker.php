<?php
class Custom_Taxonomy_Menu_Walker extends Walker_Nav_Menu {

    /**
     * Display children elements.
     *
     * @param array $elements
     * @param int $depth
     * @param array $args
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];
        $id = $element->$id_field;
        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

        if (isset($children_elements[$id])) {
            $sub_depth = $depth + 1;
            $sub_menu = '';

            foreach ($children_elements[$id] as $child) {
                if (!isset($new_children_elements)) {
                    $new_children_elements = array();
                }

                $new_children_elements[$child->$id_field] = $child;
            }

            unset($children_elements[$id]);

            if ($sub_items = $this->walk($new_children_elements, $max_depth, $sub_depth, $args)) {
                $sub_menu = '<ul class="sub-menu">' . $sub_items . '</ul>';
            }

            $output = str_replace('</a>', '</a>' . $sub_menu, $output);
        }
    }

    /**
     * Display element.
     *
     * @param object $element
     * @param array $children_elements
     * @param int $max_depth
     * @param int $depth
     * @param array $args
     * @param string $output
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $taxonomy = 'subjects';

        if ($item->object !== 'taxonomy' || $item->object !== $taxonomy) {
            parent::start_el($output, $item, $depth, $args);
            return;
        }

        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ));

        if (empty($terms)) {
            parent::start_el($output, $item, $depth, $args);
            return;
        }

        $terms_html = '';

        foreach ($terms as $term) {
            $url = get_term_link($term, $taxonomy);
            $terms_html .= '<li class="menu-item menu-item-type-taxonomy"><a href="' . $url . '">' . $term->name . '</a></li>';
        }

        $item_output = sprintf(
            '%1$s<a%2$s>%3$s%4$s</a>%5$s',
            $args->before,
            $this->attributes_to_string($item->attr_title),
            $args->link_before,
            $item->title,
            $args->link_after
        );

        $item_output .= '<ul class="sub-menu">' . $terms_html . '</ul>';
        $output .= sprintf(
            '%1$s<li%2$s>%3$s</li>%4$s',
            $args->before,
            $this->attributes_to_string($item->attr),
            $item_output,
            $args->after
        );
    }
}
