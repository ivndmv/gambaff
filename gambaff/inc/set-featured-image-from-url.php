<?php
function set_featured_image_from_url($post_id, $image_url) {
    $image_name = basename($image_url);
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
    $filename = $upload_dir['path'] . '/' . $unique_file_name;

    file_put_contents($filename, $image_data);

    $filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $unique_file_name,
        'post_mime_type' => $filetype['type'],
        'post_title'     => sanitize_file_name($image_name),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $filename, $post_id);

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
    wp_update_attachment_metadata($attach_id, $attach_data);

    set_post_thumbnail($post_id, $attach_id);
}
?>