<?php
// single shortcodes
add_shortcode('get_operator_name', 'get_operator_name_function');
function get_operator_name_function() {
    $post_id = get_the_ID();
    $post_name = get_the_title($post_id);
    return $post_name;
}

add_shortcode('get_operator_slug', 'get_operator_slug_function');
function get_operator_slug_function() {
    $post_id = get_the_ID();
    $post_slug = get_post_field('post_name', $post_id);
    return $post_slug;
}

add_shortcode('get_operator_type', 'get_operator_type_function');
function get_operator_type_function() {
    $post_id = get_the_ID();
    $terms = wp_get_post_terms($post_id, 'operator-type');
    $term_names = '';
    foreach ($terms as $index => $term) {
        $term_names .= $term->name;
        if ($index < count($terms) - 1) { // if only 1 item no comma, if multiple items no comma after last item
            $term_names .= ', ';
        }
        $term_names = str_replace('Casino', 'Online Casino', $term_names);
        $term_names = str_replace('Bookmaker', 'Sports Betting', $term_names);
    }
    return __($term_names, 'gambaff');
}

add_shortcode('get_operator_logo', 'get_operator_logo_function');
function get_operator_logo_function() {
    $post_id = get_the_ID();
    $meta_field_value = get_post_meta($post_id, 'operator_logo', true);
    return '<img src="'.$meta_field_value.'" alt="'.do_shortcode('[get_operator_name]').'" loading="lazy" alt="'.do_shortcode('[get_operator_slug]').'" />';
}

add_shortcode('get_operator_license', 'get_operator_license_function');
function get_operator_license_function() {
    $post_id = get_the_ID();
    $terms = wp_get_post_terms($post_id, 'operator-license');
    $term_names = '';
    foreach ($terms as $index => $term) {
        $term_names .= $term->name;
        if ($index < count($terms) - 1) { // if only 1 item no comma, if multiple items no comma after last item
            $term_names .= ', ';
        }
    }
    $label = __('License', 'gambaff');
    return '<div style="font-size: 0.9rem;">'.$label.'</div><div class="view-more-expand-content">'.$term_names.'</div>';
}

add_shortcode('get_operator_deposit_methods', 'get_operator_deposit_methods_function');
function get_operator_deposit_methods_function() {
    $post_id = get_the_ID();
    $terms = wp_get_post_terms($post_id, 'operator-deposit-method');
    $term_names = '';
    foreach ($terms as $index => $term) {
        $term_names .= $term->name;
        if ($index < count($terms) - 1) { // if only 1 item no comma, if multiple items no comma after last item
            $term_names .= ', ';
        }
    }
    $label = __('Deposit methods', 'gambaff');
    return '<div style="font-size: 0.9rem;">'.$label.'</div><div class="view-more-expand-content">'.$term_names.'</div>';
    return $term_names;
}

add_shortcode('get_operator_withdrawal_methods', 'get_operator_withdrawal_methods_function');
function get_operator_withdrawal_methods_function() {
    $post_id = get_the_ID();
    $terms = wp_get_post_terms($post_id, 'operator-withdrawal-method');
    $term_names = '';
    foreach ($terms as $index => $term) {
        $term_names .= $term->name;
        if ($index < count($terms) - 1) { // if only 1 item no comma, if multiple items no comma after last item
            $term_names .= ', ';
        }
    }
    $label = __('Withdrawal methods', 'gambaff');
    return '<div style="font-size: 0.9rem;">'.$label.'</div><div class="view-more-expand-content">'.$term_names.'</div>';
    return $term_names;
}

add_shortcode('get_operator_software_provider', 'get_operator_software_provider_function');
function get_operator_software_provider_function() {
    $post_id = get_the_ID();
    $terms = wp_get_post_terms($post_id, 'operator-software-provider');
    $term_names = '';
    foreach ($terms as $index => $term) {
        $term_names .= $term->name;
        if ($index < count($terms) - 1) { // if only 1 item no comma, if multiple items no comma after last item
            $term_names .= ', ';
        }
    }
    $label = __('Software providers', 'gambaff');
    return '<div style="font-size: 0.9rem;">'.$label.'</div><div class="view-more-expand-content">'.$term_names.'</div>';
    return $term_names;
}

add_shortcode('get_operator_bonus_offer', 'get_operator_bonus_offer_function');
function get_operator_bonus_offer_function() {
    $post_id = get_the_ID();
    $meta_field_value = get_post_meta($post_id, 'operator_bonus_offer', true);
    return $meta_field_value;
}

add_shortcode('get_operator_tc_text', 'get_operator_tc_text_function');
function get_operator_tc_text_function() {
    $post_id = get_the_ID();
    $meta_field_value = get_post_meta($post_id, 'operator_terms_and_conditions_text', true);
    return $meta_field_value;
}

add_shortcode('get_operator_tc_link', 'get_operator_tc_link_function');
function get_operator_tc_link_function() {
    $post_id = get_the_ID();
    $meta_field_value = get_post_meta($post_id, 'operator_terms_and_conditions_link', true);
    return $meta_field_value;
}

add_shortcode('get_operator_aff_link', 'get_operator_aff_link_function');
function get_operator_aff_link_function() {
    $post_id = get_the_ID();
    $meta_field_value = get_post_meta($post_id, 'operator_affiliate_link', true);
    return $meta_field_value;
}

add_shortcode('get_operator_visit_button', 'get_operator_visit_button_function');
function get_operator_visit_button_function() {
    // $post_id = get_the_ID();
    $button_text = __('Visit', 'gambaff');
    $html = '<a class="cta-count cta-button" target="_blank" href="'.home_url().'/visit/site/'.do_shortcode('[get_operator_slug]').'"';
    $html .= 'target="_blank" aria-label="'.do_shortcode('[get_operator_slug]').'">';
    $html .= $button_text .' '. do_shortcode('[get_operator_name]');
    $html .= '</a>';
    return $html;
}


// Register shortcode
add_shortcode('get_operator_bonus_offer_box', 'get_operator_bonus_offer_box_function');
function get_operator_bonus_offer_box_function($atts) {

    // $operator_type = [];
    // foreach (explode(",", $_POST['operator_type']) as $item) {
    //     $operator_type[] = get_term_by('name', $item, 'operator-type')->term_id; // we get the term id
    // }
    // 'tax_input'     => array(
    //             'operator-type' => $operator_type,
    // ); // accepts only term IDs, no term name

    $atts = shortcode_atts(
        array(
            'count' => '', 
            'slug' => '', 
            'type' => '',     
        ), 
        $atts, 
        'get_operator_bonus_offer_box'
    );

    //no shortcode attributes used (to use only in operators single template query)
    if (empty($atts['count']) && empty($atts['slug'])) {
        $args = array(
            'post_type'      => 'operator',
            'p'              => get_the_ID(),
        );
    }

    //use both count and type atttributes - display operators of the type and count set by user (can be used in pages, posts)
    elseif (!empty($atts['count']) && !empty($atts['type']) && empty($atts['slug'])) { 
        foreach (explode(",", $atts['type']) as $item) {
            $operator_types[] = get_term_by('name', $item, 'operator-type')->term_id; // we get the term id
        }
        $args = array(
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'orderby'        => 'modified',
            'order'          => 'DESC',
            'posts_per_page' => intval($atts['count']),
            'tax_query' => array(array('taxonomy' => 'operator-type', 'field' => 'slug', 'terms' => explode(",", $atts['type'])))
        );
    }

    //use only type attribute - display all operators of the type set by user (can be used in pages, posts)
    // elseif (!empty($atts['type']) && empty($atts['count']) && empty($atts['slug'])) { 
    //     $args = array(
    //         'post_type'      => 'operator',
    //         'post_status'    => 'publish',
    //         'orderby'        => 'modified',
    //         'order'          => 'DESC',
    //         'tax_query' => array(array('taxonomy' => 'operator-type', 'field' => 'slug', 'terms' => explode(",", $atts['type']))),
    //         'posts_per_page' => -1,
    //     );
    // }

    //use only count attribute - display operators of all types and count set by user (can be used in pages, posts)
    elseif (!empty($atts['count']) && empty($atts['slug']) && empty($atts['type'])) {
        $args = array(
            'posts_per_page' => intval($atts['count']),
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'orderby'        => 'modified',
            'order'          => 'DESC',
        );
    }

    //use slug attribute - display operator of the slug set by user no matter their type (can be used in pages, posts)
    elseif (!empty($atts['slug']) && empty($atts['count']) && empty($atts['type'])) {
        $args = array(
            'name'           => sanitize_title($atts['slug']),
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        );
    } 

    $query = new WP_Query($args);

    $html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $featured_image_url = get_the_post_thumbnail_url($post_id);
            
            $label = __('Bonus', 'gambaff');
            $tc_link_text = __('T&Cs', 'gambaff');
            $button_text = __('Claim Offer', 'gambaff');

            $has_bonus_offer = do_shortcode('[get_operator_bonus_offer]');

            if ($has_bonus_offer) {
                $html .= '<div class="bonus-offer-box">';
                $html .= '<div class="bonus-offer-box--label">' . $label . '</div>';
                
                $html .= '<div class="bonus-offer-box--img">';
                $html .= '<a class="cta-count" href="' . home_url() . '/visit/site/' . do_shortcode('[get_operator_slug]') . '" target="_blank" aria-label="'.do_shortcode('[get_operator_slug]').'">';
                $html .= '<img src="' . esc_url($featured_image_url) . '" loading="lazy" width="100"/ alt="'.do_shortcode('[get_operator_slug]').'">';
                $html .= '</a>';
                $html .= do_shortcode('[get_operator_bonus_offer]');
                $html .= '</div>';
    
                $html .= '<div>';
                $html .= '<a class="bonus-offer-box--button cta-button cta-count" href="' . home_url() . '/visit/site/' . do_shortcode('[get_operator_slug]') . '" target="_blank" aria-label="'.do_shortcode('[get_operator_slug]').'">' . esc_html($button_text) . '</a>';
                $html .= '</div>';
    
                $html .= '<div class="bonus-offer-box--tc">';
                $html .= do_shortcode('[get_operator_tc_text]');
                $html .= ' <a class="cta-count" href="' . home_url() . '/visit/site/tc/' . do_shortcode('[get_operator_slug]') . '" target="_blank" aria-label="'.do_shortcode('[get_operator_slug]').'">' . esc_html($tc_link_text) . '</a>';
                $html .= '</div>';
    
                $html .= '</div>'; // Close bonus-offer-box
            } else {
                $html .= '';
            }
        }
        wp_reset_postdata();
    } else {
        $html .= '<p>' . __('No bonus offers available.', 'gambaff') . '</p>';
    }

    return $html;
}

add_shortcode('get_operator_review', 'get_operator_review_function');
function get_operator_review_function($atts) {
    $atts = shortcode_atts(
        array(
            'count' => '', 
            'slug' => '', 
            'type' => '',   
        ), 
        $atts, 
        'get_operator_review'
    );

    //no shortcode attributes used (to use only in operators single template query)
    if (empty($atts['count']) && empty($atts['slug'])) {
        $args = array(
            'post_type'      => 'operator',
            'p'              => get_the_ID(),
        );
    }

    //use both count and type atttributes - display operators of the type and count set by user (can be used in pages, posts)
    elseif (!empty($atts['count']) && !empty($atts['type']) && empty($atts['slug'])) { 
        $args = array(
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'orderby'        => 'modified',
            'order'          => 'DESC',
            'posts_per_page' => intval($atts['count']),
            'tax_query' => array(array('taxonomy' => 'operator-type', 'field' => 'slug', 'terms' => explode(",", $atts['type'])))
        );
    }

    //use only type attribute - display all operators of the type set by user (can be used in pages, posts)
    // elseif (!empty($atts['type']) && empty($atts['count']) && empty($atts['slug'])) { 
    //     $args = array(
    //         'post_type'      => 'operator',
    //         'post_status'    => 'publish',
    //         'orderby'        => 'modified',
    //         'order'          => 'DESC',
    //         'posts_per_page' => -1,
    //         'tax_query' => array(array('taxonomy' => 'operator-type', 'field' => 'slug', 'terms' => explode(",", $atts['type'])))
    //     );
    // }

    //use only count attribute - display operators of all types and count set by user (can be used in pages, posts)
    elseif (!empty($atts['count']) && empty($atts['slug']) && empty($atts['type'])) {
        $args = array(
            'posts_per_page' => intval($atts['count']),
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'orderby'        => 'modified',
            'order'          => 'DESC',
        );
    }

    //use slug attribute - display operator of the slug set by user no matter their type (can be used in pages, posts)
    elseif (!empty($atts['slug']) && empty($atts['count']) && empty($atts['type'])) {
        $args = array(
            'name'           => sanitize_title($atts['slug']),
            'post_type'      => 'operator',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
        );
    } 

    $query = new WP_Query($args);

    $html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $post_id = get_the_ID();
            $featured_image_url = get_the_post_thumbnail_url($post_id);
            
            //$label = __('Bonus', 'gambaff');
            //$tc_link_text = __('T&Cs', 'gambaff');
            $button_text_visit = __('Visit', 'gambaff');
            $button_text_read_review = __('Read review', 'gambaff');

            $html .= '<div class="operator-review">';

            $html .= '<a href="' . home_url() . '/' . do_shortcode('[get_operator_slug]') . '" aria-label="'.do_shortcode('[get_operator_slug]').'">';
            $html .= '<div class="operator-review--left">';
            $html .= '<div class="operator-review--img">';
            $html .= '<img src="' . esc_url($featured_image_url) . '" loading="lazy" width="75" alt="'.do_shortcode('[get_operator_slug]').'"/>';
            $html .= '</div>';
            $html .= '<div class="operator-review--details">';
            $html .= '<div class="operator-review--name">' . do_shortcode('[get_operator_name]') . '</div>';
            $html .= '<div class="operator-review--type">' . do_shortcode('[get_operator_type]') . '</div>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</a>';

            $html .= '<div class="operator-review--right">';
            // $html .= '<div class="operator-review--review-button">';
            // $html .= '<a href="' . home_url() . do_shortcode('[get_operator_slug]') . '">'.$button_text_read_review.'</a>';
            // $html .= '</div>';
            $html .= '<div class="operator-review--visit-button">';
            $html .= '<a class="cta-count" href="'.home_url().'/visit/site/'.do_shortcode('[get_operator_slug]').'" target="_blank" aria-label="'.do_shortcode('[get_operator_slug]').'">'.$button_text_visit.'</a>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '</div>';
        }
    }
    return $html;
}
add_shortcode('get_gambling_disclaimer', 'get_gambling_disclaimer_function');
function get_gambling_disclaimer_function() { 
    $html = '<p>';
    $html .= __('Contact: ', 'gambaff');
    $html .= '<a href="mailto:info@gambaff.online">info@gambaff.online</a>';
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('This website is intended for players aged 18 and over. Please gamble responsibly.', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('All gambling sites listed on this website are licensed and regulated by the relevant authorities in their jurisdiction. Please check the licensing details on the individual websites.', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('This website contains affiliate links. If you click on a link and sign up, we may receive a commission. This helps us maintain the site and provide useful content.', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('Online gambling may not be legal in all jurisdictions. It is the responsibility of the user to ensure they comply with local laws and regulations before engaging in gambling activities.', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('We do not guarantee any winnings or outcomes from gambling activities. All gambling activities are subject to the terms and conditions of the operator and your own risk.', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= __('Gambling should be a fun and enjoyable activity. If you feel that your gambling is becoming a problem, please seek help. Support:', 'gambaff');
    $html .= '</p>';

    $html .= '<p>';
    $html .= '<a href="https://www.gambleaware.org/" target="_blank" aria-label="GambleAware"><img src="'.get_stylesheet_directory_uri().'/images/gambleaware.webp" loading="lazy" width="100" alt="GambleAware"/></a>';
    $html .= '<a href="https://gordonmoody.org.uk/" target="_blank" aria-label="GordonMoody"><img src="'.get_stylesheet_directory_uri().'/images/gordonmoody.webp" loading="lazy" width="100" alt="GordonMoody"/></a>';
    $html .= '<a href="https://www.gamcare.org.uk/" target="_blank" aria-label="GamCare"><img src="'.get_stylesheet_directory_uri().'/images/gamcare.webp" loading="lazy" width="100" alt="GamCare"/></a>';

    $html .= '</p>';

    return $html;
}

add_shortcode('page_not_found', 'page_not_found_function');
function page_not_found_function() { 
    $html = '<h1>Oops! Page Not Found (404)</h1>';
    $html .= '<p>The page you are looking for does not exist or may have been moved.</p>';
    return $html;
}
?>