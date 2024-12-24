<?php
add_action('after_switch_theme', 'create_gambaff_htaccess');
function create_gambaff_htaccess() {
    $upload_dir = wp_upload_dir();
    $upload_path = $upload_dir['basedir'] . '/gambaff-json/';
    
    if (!file_exists($upload_path)) {
        wp_mkdir_p($upload_path); 
    }

    $htaccess_path = $upload_path . '.htaccess';

    $htaccess_rules = <<<HTACCESS
# Deny access to all files in this directory
<Files "*">
    Require all denied
</Files>
HTACCESS;

    if (file_put_contents($htaccess_path, $htaccess_rules) === false) {
        error_log('Failed to create .htaccess file in ' . $upload_path);
    } else {
        error_log('.htaccess file created successfully in ' . $upload_path);
    }
}
?>