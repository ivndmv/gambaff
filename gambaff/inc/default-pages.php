<?php
add_action('after_switch_theme', 'default_pages');
function default_pages() {
    $pages = [
        'Home' => [
            'slug' => 'home',
            // 'template' => '', // No custom template for Home
        ],
        'Online Casino Reviews' => [
            'slug' => 'reviews',
            // 'template' => 'templates/page-reviews.html', // Custom template for Reviews
        ],
        'Terms and Conditions' => [
            'slug' => 'terms-and-conditions',
            // 'template' => '', // No custom template
        ],
        'Privacy Policy' => [
            'slug' => 'privacy-policy',
            // 'template' => '', // No custom template
        ],
        'Blog' => [
            'slug' => 'blog',
            // 'template' => '', // No custom template for Blog
        ],
        'Online Casino Bonuses' => [
            'slug' => 'bonuses',
            // 'template' => 'templates/page-bonuses.html', // Custom template for Bonuses
        ],
    ];

    foreach ($pages as $title => $data) {
        if (!get_page_by_path($data['slug'])) {
            $page_id = wp_insert_post([
                'post_title' => $title,
                'post_name' => $slug,
                'post_status' => 'publish',
                'post_type' => 'page',
                // 'page_template' => $data['template'],
            ]);


            if ($slug === 'home') {
                // set_featured_image_from_url($page_id, get_stylesheet_directory() . '/images/homepage.webp');
            }
        }
    }
}
add_action('after_switch_theme', 'set_homepage_and_blogpage');
function set_homepage_and_blogpage() {
    update_option('show_on_front', 'page');
    $homepage = get_posts(array('name' => 'home', 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1));
    $blogpage = get_posts(array('name' => 'blog', 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1));
    
    if($homepage) {
        update_option('page_on_front', $homepage[0]->ID);
        if (!has_post_thumbnail($homepage[0]->ID)) {
            set_featured_image_from_url($homepage[0]->ID, get_stylesheet_directory() . '/images/homepage.webp');
        }
    }
    if($blogpage) {
        update_option('page_for_posts', $blogpage[0]->ID);
    }

}
?>