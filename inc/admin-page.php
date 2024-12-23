<?php
// Manager page
add_action( 'admin_menu', 'operators_manager_admin_page' );
function operators_manager_admin_page() {
    add_menu_page(
        __( 'Operators Manager', 'gambaff' ), // Page title
        __( 'Manager', 'gambaff' ),        // Menu title
        'manage_options',                            // Capability
        'operators-manager-settings',                 // Menu slug
        'operators_manager_settings_page',           // Function to display page content
        'dashicons-admin-generic',                   // Icon
        60                                          // Position
    );
    add_submenu_page(
        'operators-manager-settings',     // Parent slug
        __('API', 'gambaff'), // Page title
        __('API', 'gambaff'),          // Submenu title
        'manage_options',                 // Capability
        'operators-manager-api',      // Submenu slug
        'operators_manager_api_callback' // Function to display subpage content
    );
    add_submenu_page(
        'operators-manager-settings',     // Parent slug
        __('Generate content', 'gambaff'), // Page title
        __('Generate content', 'gambaff'),          // Submenu title
        'manage_options',                 // Capability
        'operators-manager-generate-content',      // Submenu slug
        'operators_manager_generate_content_callback' // Function to display subpage content
    );
}

function operators_manager_settings_page() {
    $admin_html = '<div class="wrap">';
    $admin_html .= '<h1>Operators Manager</h1>';
    $admin_html .= do_shortcode('[admin_get_operators]'); //shortcode in get-operators.php
    $admin_html .= '</div>';
    echo $admin_html;
}

function operators_manager_api_callback() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save form data if submitted
    if (isset($_POST['submit'])) {
        // Handle textarea data
        if (!empty($_POST['google_sheets_id'])) {
            update_option('google_sheets_id', sanitize_textarea_field($_POST['google_sheets_id']));
        }

        if (!empty($_POST['google_sheets_name'])) {
            update_option('google_sheets_name', sanitize_textarea_field($_POST['google_sheets_name']));
        }

        if (!empty($_POST['google_sheets_range'])) {
            update_option('google_sheets_range', sanitize_textarea_field($_POST['google_sheets_range']));
        }

        if (!empty($_POST['openai_api_key'])) {
            update_option('openai_api_key', sanitize_textarea_field($_POST['openai_api_key']));
        }

        // Handle file upload
        if (!empty($_FILES['google_sheets_api_credentials']['name'])) {
            $uploaded_file = $_FILES['google_sheets_api_credentials'];

            // Check file extension
            $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
            if ($file_extension !== 'json') {
                echo '<div class="notice notice-error"><p>Only JSON files are allowed!</p></div>';
            } else {
                // Define the target filename
                $upload_dir = get_template_directory() . '/inc/api'; // Theme directory path
                $target_file = $upload_dir . '/service-account-creds.json';

                // Move the uploaded file
                if (move_uploaded_file($uploaded_file['tmp_name'], $target_file)) {
                    update_option('google_sheets_api_credentials_name', 'service-account-creds.json');
                    echo '<div class="notice notice-success"><p>File uploaded successfully as service-account-creds.json!</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>File upload failed!</p></div>';
                }
            }
        }
    }

    // Retrieve saved data
    $google_sheets_id = get_option('google_sheets_id', '');
    $google_sheets_name = get_option('google_sheets_name', '');
    $google_sheets_range = get_option('google_sheets_range', '');
    $google_sheets_api_credentials_name = get_option('google_sheets_api_credentials_name', '');
    $openai_api_key = get_option('openai_api_key', '');

    $file_exists = get_template_directory() . '/inc/api/service-account-creds.json';
    $file_exists_message = 'No file uploaded';
    if (file_exists($file_exists)) {
        $file_exists_message = 'Uploaded File: wp-content/gambaff/inc/api/<strong>'.esc_html($google_sheets_api_credentials_name).'</strong>';
    }


    ?>
    <div class="wrap">
        <h1>API Settings</h1>
        <form method="post" enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="google_sheets_id">Google Sheets ID</label></th>
                    <td>
                        <textarea name="google_sheets_id" id="google_sheets_id" rows="5" cols="50"><?php echo esc_textarea($google_sheets_id); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="google_sheets_name">Google Sheets Name</label></th>
                    <td>
                        <textarea name="google_sheets_name" id="google_sheets_name" rows="2" cols="50"><?php echo esc_textarea($google_sheets_name); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="google_sheets_range">Google Sheets Range</label></th>
                    <td>
                        <textarea name="google_sheets_range" id="google_sheets_range" rows="2" cols="50"><?php echo esc_textarea($google_sheets_range); ?></textarea>
                        <p>(Example: A2:L10)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="openai_api_key">OpenAI API Key</label></th>
                    <td>
                        <textarea name="openai_api_key" id="openai_api_key" rows="5" cols="50"><?php echo esc_textarea($openai_api_key); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="google_sheets_api_credentials">Upload Google Drive API Service Account Credentials in JSON format</label></th>
                    <td>
                        <input type="file" name="google_sheets_api_credentials" id="google_sheets_api_credentials" />
                        <?php if ($google_sheets_api_credentials_name) : ?>
                            <p><?php echo $file_exists_message; ?></p>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Changes'); ?>
        </form>
    </div>
<?php    
}

function operators_manager_generate_content_callback() {
    $json_prompts = file_get_contents( plugin_dir_path(__FILE__) . '/chatgpt-operator-review-prompt.json');
    $prompts_array = json_decode($json_prompts, true);

    //generate page content
    $page_content_default_prompt = $prompts_array['page_content'];
    $query = new WP_Query(array('post_type' => 'page', 'posts_per_page' => -1, 'post_status' => 'publish'));
    $submit_button = '<p class="submit"><input type="submit" name="submit-generate-page" id="submit-generate-page" class="button button-primary" value="Generate Content"></p>'; //'<input class="admin-submit-button" type="submit" value="Generate"/>';
    $html = '<div class="wrap">';
    $html .= '<h1>Generate Content</h1>';
    $html .= '<h2 class="title">Pages</h2>';
    if ($query->have_posts()) {
        $html .= '<div class="generate-content-table">';
        while ($query->have_posts()) {
            $query->the_post();
            $page_title = get_the_title();
            $page_permalink = get_permalink();
            $page_slug = get_post_field('post_name', get_the_ID());
            $html .= '<div class="card admin-generate-page-content">';
            $html .= '<form id="'.$page_slug.'">';
            $html .= '<div><h2 class="title"><a class="page-name" href="' . $page_permalink . '">' . $page_title . '</a><h2></div>';
            $html .= '<label for="'.$page_slug.'-textarea">Prompt</label>';
            $html .= '<p>You will see the default prompt. Place your topic after the default prompt. You can edit or remove the default prompt, but it is not recommended.</p>';
            $html .= '<div class="page-slug" style="display:none;">'.$page_slug.'</div>';
            $html .= '<div><textarea class="page-content-prompt" name="'.$page_slug.'-textarea" id="'.$page_slug.'-textarea" rows="5" cols="50" required>'.$page_content_default_prompt.'</textarea></div>';
            $html .= '<div>'.$submit_button.'</div>';
            $html .= '</form>';
            $html .= '</div>';
        }
        $html .= '</div>';
        // wp_reset_postdata();
    } else {
        $html .= 'No pages found. Add pages and they will appear here.';
    }

    //generate blog posts content
    $suggest_blog_topics_default_prompt = $prompts_array['suggest_blog_topics'];
    $generate_blog_post_default_prompt = $prompts_array['generate_blog_post'];

    $submit_button = '<p class="submit"><input type="submit" name="submit-suggest-posts" id="submit-suggest-posts" class="button button-primary" value="Suggest Topics"></p>'; //'<input class="admin-submit-button" type="submit" value="Generate"/>';
    $html .= '<h2 class="title" style="margin-top: 40px;">Blog Posts</h2>';
    $html .= '<div class="blogs-flexbox">';
    $html .= '<div class="card admin-suggest-blog-topics">';
    $html .= '<form id="suggest-blog-topics">';
    $html .= '<h2 class="title">Generate Blog Post Toppics</h2>';
    $html .= '<input id="suggest-blog-topics-default-prompt" type="hidden" value="'.$suggest_blog_topics_default_prompt.'"/>';
    $html .= '<label for="suggest-blog-post-input">Prompt</label>';
    $html .= '<p>Write a topic. 10 subtopics will be suggested.</p>';
    $html .= '<textarea id="suggest-blog-post-input" name="suggest-blog-post-input" type="text" rows="3" cols="50" required></textarea>';
    $html .= $submit_button;
    $html .= '</form>';
    $html .= '</div>';

    $submit_button = '<p class="submit"><input type="submit" name="submit-generate-blog-posts" id="submit-generate-blog-posts" class="button button-primary" value="Generate Blog Posts"></p>'; //'<input class="admin-submit-button" type="submit" value="Generate"/>';
    $html .= '<div class="card admin-generate-blog-posts">';
    $html .= '<form id="generate-blog-posts">';
    $html .= '<h2 class="title">Generate 10 Blog Posts</h2>';
    $html .= '<input id="generate-blog-post-default-prompt" type="hidden" value="'.$generate_blog_post_default_prompt.'"/>';
    $html .= '<label>Your suggested topics</label>';
    $html .= '<p>Each topics is in a new line. Posts will be scheduled for the future.</p>';
    $html .= '<div id="suggested-topics"></div>';
    $html .= $submit_button;
    $html .= '</form>';
    $html .= '</div>';
    $html .= '</div>';


    $html .= '</div>';
    echo $html;   
}

?>