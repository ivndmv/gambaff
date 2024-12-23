<?php
//custom post types, taxonomies, meta boxes, etc.
//register custom post type 'operator'
add_action( 'init', function() {
	register_post_type( 'operator', array(
	'labels' => array(
		'name' => 'Operators',
		'singular_name' => 'Operator',
		'menu_name' => 'Operators',
		'all_items' => 'All Operators',
		'edit_item' => 'Edit Operator',
		'view_item' => 'View Operator',
		'view_items' => 'View Operators',
		'add_new_item' => 'Add New Operator',
		'add_new' => 'Add New Operator',
		'new_item' => 'New Operator',
		'parent_item_colon' => 'Parent Operator:',
		'search_items' => 'Search Operators',
		'not_found' => 'No operators found',
		'not_found_in_trash' => 'No operators found in Trash',
		'archives' => 'Operator Archives',
		'attributes' => 'Operator Attributes',
		'insert_into_item' => 'Insert into operator',
		'uploaded_to_this_item' => 'Uploaded to this operator',
		'filter_items_list' => 'Filter operators list',
		'filter_by_date' => 'Filter operators by date',
		'items_list_navigation' => 'Operators list navigation',
		'items_list' => 'Operators list',
		'item_published' => 'Operator published.',
		'item_published_privately' => 'Operator published privately.',
		'item_reverted_to_draft' => 'Operator reverted to draft.',
		'item_scheduled' => 'Operator scheduled.',
		'item_updated' => 'Operator updated.',
		'item_link' => 'Operator Link',
		'item_link_description' => 'A link to a operator.',
	),
	'public' => true,
	'show_in_rest' => true,
	'menu_icon' => 'dashicons-align-center',
	'supports' => array(
		0 => 'title',
		1 => 'editor',
		2 => 'revisions',
		3 => 'thumbnail',
		4 => 'custom-fields',
	),
	'rewrite' => array(
		'slug' => 'review',
		'with_front' => false,
	),
	'has_archive' => false,
	'delete_with_user' => false,
) );
} );

//register taxonomy for custom post type 'operator' named 'operator-type'
add_action( 'init', function() {
	register_taxonomy( 'operator-type', array(
	0 => 'operator',
), array(
	'labels' => array(
		'name' => 'Operator Types',
		'singular_name' => 'Operator Type',
		'menu_name' => 'Operator Types',
		'all_items' => 'All Operator Types',
		'edit_item' => 'Edit Operator Type',
		'view_item' => 'View Operator Type',
		'update_item' => 'Update Operator Type',
		'add_new_item' => 'Add New Operator Type',
		'new_item_name' => 'New Operator Type Name',
		'parent_item' => 'Parent Operator Type',
		'parent_item_colon' => 'Parent Operator Type:',
		'search_items' => 'Search Operator Types',
		'not_found' => 'No operator types found',
		'no_terms' => 'No operator types',
		'filter_by_item' => 'Filter by operator type',
		'items_list_navigation' => 'Operator Types list navigation',
		'items_list' => 'Operator Types list',
		'back_to_items' => '← Go to operator types',
		'item_link' => 'Operator Type Link',
		'item_link_description' => 'A link to a operator type',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );
} );

add_action( 'init', function() {
	register_taxonomy( 'operator-deposit-method', array(
	0 => 'operator',
), array(
	'labels' => array(
		'name' => 'Operator Deposit Methods',
		'singular_name' => 'Operator Deposit Method',
		'menu_name' => 'Operator Deposit Methods',
		'all_items' => 'All Operator Deposit Methods',
		'edit_item' => 'Edit Operator Deposit Method',
		'view_item' => 'View Operator Deposit Method',
		'update_item' => 'Update Operator Deposit Method',
		'add_new_item' => 'Add New Operator Deposit Method',
		'new_item_name' => 'New Operator Deposit Method Name',
		'search_items' => 'Search Operator Deposit Methods',
		'popular_items' => 'Popular Operator Deposit Methods',
		'separate_items_with_commas' => 'Separate operator deposit methods with commas',
		'add_or_remove_items' => 'Add or remove operator deposit methods',
		'choose_from_most_used' => 'Choose from the most used operator deposit methods',
		'not_found' => 'No operator deposit methods found',
		'no_terms' => 'No operator deposit methods',
		'items_list_navigation' => 'Operator Deposit Methods list navigation',
		'items_list' => 'Operator Deposit Methods list',
		'back_to_items' => '← Go to operator deposit methods',
		'item_link' => 'Operator Deposit Method Link',
		'item_link_description' => 'A link to a operator deposit method',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );

	register_taxonomy( 'operator-license', array(
	0 => 'operator',
), array(
	'labels' => array(
		'name' => 'Operator Licenses',
		'singular_name' => 'Operator License',
		'menu_name' => 'Operator Licenses',
		'all_items' => 'All Operator Licenses',
		'edit_item' => 'Edit Operator License',
		'view_item' => 'View Operator License',
		'update_item' => 'Update Operator License',
		'add_new_item' => 'Add New Operator License',
		'new_item_name' => 'New Operator License Name',
		'search_items' => 'Search Operator Licenses',
		'popular_items' => 'Popular Operator Licenses',
		'separate_items_with_commas' => 'Separate operator licenses with commas',
		'add_or_remove_items' => 'Add or remove operator licenses',
		'choose_from_most_used' => 'Choose from the most used operator licenses',
		'not_found' => 'No operator licenses found',
		'no_terms' => 'No operator licenses',
		'items_list_navigation' => 'Operator Licenses list navigation',
		'items_list' => 'Operator Licenses list',
		'back_to_items' => '← Go to operator licenses',
		'item_link' => 'Operator License Link',
		'item_link_description' => 'A link to a operator license',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );

	register_taxonomy( 'operator-software-provider', array(
	0 => 'operator',
), array(
	'labels' => array(
		'name' => 'Operator Software Providers',
		'singular_name' => 'Operator Software Provider',
		'menu_name' => 'Operator Software',
		'all_items' => 'All Operator Software',
		'edit_item' => 'Edit Operator Software Provider',
		'view_item' => 'View Operator Software Provider',
		'update_item' => 'Update Operator Software Provider',
		'add_new_item' => 'Add New Operator Software Provider',
		'new_item_name' => 'New Operator Software Provider Name',
		'search_items' => 'Search Operator Software',
		'popular_items' => 'Popular Operator Software',
		'separate_items_with_commas' => 'Separate operator software with commas',
		'add_or_remove_items' => 'Add or remove operator software',
		'choose_from_most_used' => 'Choose from the most used operator software',
		'not_found' => 'No operator software found',
		'no_terms' => 'No operator software',
		'items_list_navigation' => 'Operator Software list navigation',
		'items_list' => 'Operator Software list',
		'back_to_items' => '← Go to operator software',
		'item_link' => 'Operator Software Provider Link',
		'item_link_description' => 'A link to a operator software provider',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );

	register_taxonomy( 'operator-withdrawal-method', array(
	0 => 'operator',
), array(
	'labels' => array(
		'name' => 'Operator Withdrawal Methods',
		'singular_name' => 'Operator Withdrawal Method',
		'menu_name' => 'Operator Withdrawal Methods',
		'all_items' => 'All Operator Withdrawal Methods',
		'edit_item' => 'Edit Operator Withdrawal Method',
		'view_item' => 'View Operator Withdrawal Method',
		'update_item' => 'Update Operator Withdrawal Method',
		'add_new_item' => 'Add New Operator Withdrawal Method',
		'new_item_name' => 'New Operator Withdrawal Method Name',
		'search_items' => 'Search Operator Withdrawal Methods',
		'popular_items' => 'Popular Operator Withdrawal Methods',
		'separate_items_with_commas' => 'Separate operator withdrawal methods with commas',
		'add_or_remove_items' => 'Add or remove operator withdrawal methods',
		'choose_from_most_used' => 'Choose from the most used operator withdrawal methods',
		'not_found' => 'No operator withdrawal methods found',
		'no_terms' => 'No operator withdrawal methods',
		'items_list_navigation' => 'Operator Withdrawal Methods list navigation',
		'items_list' => 'Operator Withdrawal Methods list',
		'back_to_items' => '← Go to operator withdrawal methods',
		'item_link' => 'Operator Withdrawal Method Link',
		'item_link_description' => 'A link to a operator withdrawal method',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
) );
} );

//meta boxes
function register_operator_meta_box() {
    add_meta_box(
        'operator_meta_box',
        __('Operator Meta Box', 'textdomain'),
        'render_operator_meta_box',
        'operator',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'register_operator_meta_box');

function render_operator_meta_box($post) {
    wp_nonce_field('save_operator_meta_box_data', 'operator_meta_box_nonce');

    $fields = [
		'operator_logo' => 'Operator Logo',
        'operator_bonus_offer' => 'Operator Bonus Offer',
        'operator_terms_and_conditions_text' => 'Operator Terms and Conditions Text',
        'operator_terms_and_conditions_link' => 'Operator Terms and Conditions Link',
        'operator_affiliate_link' => 'Operator Affiliate Link'
    ];

    foreach ($fields as $field => $label) {
        $value = get_post_meta($post->ID, $field, true);
        echo '<label for="' . $field . '">' . $label . '</label><br />';
        
        if ($field === 'operator_logo' || 'operator_terms_and_conditions_link' || $field === 'operator_affiliate_link') {
            echo '<input type="url" id="' . $field . '" name="' . $field . '" value="' . esc_attr($value) . '" size="25" /><br /><br />';
        } else {
            echo '<textarea id="' . $field . '" name="' . $field . '" rows="4" cols="50">' . esc_textarea($value) . '</textarea><br /><br />';
        }
    }
}

function save_operator_meta_box_data($post_id) {
    if (!isset($_POST['operator_meta_box_nonce']) || !wp_verify_nonce($_POST['operator_meta_box_nonce'], 'save_operator_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
		'operator_logo',
        'operator_bonus_offer',
        'operator_terms_and_conditions_text',
        'operator_terms_and_conditions_link',
        'operator_affiliate_link'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            if ($field === 'operator_logo' || 'operator_terms_and_conditions_link' || $field === 'operator_affiliate_link') {
                update_post_meta($post_id, $field, esc_url_raw($_POST[$field]));
            } else {
                update_post_meta($post_id, $field, sanitize_textarea_field($_POST[$field]));
            }
        }
    }
}
add_action('save_post', 'save_operator_meta_box_data');

?>