<?php
function save_links_to_json($post_id) {
    $file_path = get_template_directory() . '/inc/aff-links.json';

    $operator_slug = get_post_field('post_name', $post_id);
    $operator_aff_link = get_post_meta($post_id, 'operator_affiliate_link', true);
    $operator_tc_link = get_post_meta($post_id, 'operator_terms_and_conditions_link', true);

    // Write some JSON data to the file
    $links_data = array(
        'slug' => $operator_slug,
        'aff_link' => $operator_aff_link,
        'tc_link' => $operator_tc_link
    );

    if (file_exists($file_path)) {
        $existing_data = json_decode(file_get_contents($file_path), true);
    }
    
    $updated = false;
    $updated_index = 0;
    foreach ($existing_data as $index => $existing_item) {
        if ($existing_item['slug'] === $operator_slug) {
            $existing_item['aff_link'] = $operator_aff_link;
            $existing_item['tc_link'] = $operator_tc_link;
            $updated_index = $index;
            $updated = true;
        }
    }
    if ($updated) {
        $existing_data[$updated_index]['aff_link'] = $operator_aff_link;
        $existing_data[$updated_index]['tc_link'] = $operator_tc_link;
    } else {
        $existing_data[] = $links_data;
    }    
    
    file_put_contents($file_path, json_encode($existing_data, JSON_PRETTY_PRINT), LOCK_EX);

    // return $this_index;
}

function redirect_aff_links() {
    $file_path = get_template_directory() . '/inc/aff-links.json';
    $requested_url = trim($_SERVER['REQUEST_URI'], '/');

    if (str_contains($requested_url, 'visit/site/tc')) {
        $cloaked_prefix = 'visit/site/tc';
    } else {
        $cloaked_prefix = 'visit/site';
    }

    if (!file_exists($file_path)) {
        return;
    }

    $aff_links_data = json_decode(file_get_contents($file_path), true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($aff_links_data)) {
        return;
    }

    $slug = str_replace($cloaked_prefix . '/', '', $requested_url);
    $aff_link = null;
    $tc_link = null;

    foreach ($aff_links_data as $link_data) {
        if (isset($link_data['slug']) && $slug === $link_data['slug']) {
            $aff_link = $link_data['aff_link']; 
            $tc_link = $link_data['tc_link']; 
            break;
        }
    }

    if ($cloaked_prefix === 'visit/site' && $aff_link) {
        wp_redirect($aff_link, 302);
        exit;
    }

    if ($cloaked_prefix === 'visit/site/tc' && $tc_link) {
        wp_redirect($tc_link, 302);
        exit;
    }
}
?>