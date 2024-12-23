<?php 
add_action('admin_footer', 'handle_generate_blog_content_forms_js');
function handle_generate_blog_content_forms_js() {
    ?>
    <script>
    if (window.location.href.includes('operators-manager-generate-content')) {
        const suggestBlogTopicsForm = document.querySelector('#suggest-blog-topics')
        const generateBlogPostsForm = document.querySelector('#generate-blog-posts')

        forms = [suggestBlogTopicsForm, generateBlogPostsForm]
        
        forms.forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault()

                const submitButton = form.querySelector('input[type="submit"]')
                //submitButton.classList.add('loading')
                submitButtonOriginalValue = submitButton.getAttribute('value')
                submitButton.setAttribute('value', 'Loading...')
                submitButton.setAttribute('disabled', 'disabled')
                if(form.querySelector('#submit-message')) {
                    form.querySelector('#submit-message').remove()
                }

                let data = new FormData(form)
                data.append('form_id', form.id)

                //suggest
                if (form.id == 'suggest-blog-topics') {
                    const suggestBlogTopicsDefaultPrompt = form.querySelector('#suggest-blog-topics-default-prompt').value
                    const suggestBlogPostInput = form.querySelector('#suggest-blog-post-input').value
                    data.append('action', 'handle_generate_blog_content_suggest_forms')
                    data.append('suggest_blog_topics_default_prompt', suggestBlogTopicsDefaultPrompt)
                    data.append('suggest_blog_post_input', suggestBlogPostInput)
                }

                if (form.id == 'generate-blog-posts') {
                    const suggestedTopics = form.querySelector('#suggested-topics').getAttribute('data-topics')
                    const generateBlogPostDefaultPrompt = form.querySelector('#generate-blog-post-default-prompt').value
                    data.append('action', 'handle_generate_blog_content_publish_forms')
                    data.append('suggested_topics', suggestedTopics)
                    data.append('generate_blog_post_default_prompt', generateBlogPostDefaultPrompt)

                }

                let ajaxScript = { ajaxUrl : window.location.origin + '/wp-admin/admin-ajax.php' } // !!!the url must be changed
                fetch( ajaxScript.ajaxUrl, { method: 'POST', body: data } )
                .then( response => response.json())
                .then( (data) => {
                    console.log(data)
                    //submitButton.classList.remove('loading')
                    submitButton.setAttribute('value', submitButtonOriginalValue)
                    submitButton.removeAttribute('disabled')
                    submitButton.insertAdjacentHTML('afterend', '<span id="submit-message">Done!</span>');
                    if (form.id == 'suggest-blog-topics') { 
                        let suggestedTopics = document.querySelector('#suggested-topics')
                        suggestedTopics.textContent = data.topics
                        suggestedTopics.setAttribute('data-topics', data.topics)
                        // suggestedTopics.innerHTML = suggestedTopics.textContent.replace(/,/g, '<br>');
                        suggestedTopics.innerHTML = suggestedTopics.textContent.split(',') .map(topic => `<div data-topic="${topic.trim()}">${topic.trim()}</div>`) .join('');
                        document.querySelector('.admin-generate-blog-posts').style.display = 'flex'
                    }
                })
                .catch(err => {
                    console.error(err);
                    // submitButton.classList.remove('loading')
                    // submitButton.classList.add('loading-error')
                    submitButton.setAttribute('value', 'Error')
                    submitButton.setAttribute('disabled', 'disabled')
                    submitButton.insertAdjacentHTML('afterend', '<span id="submit-message">'+err+'</span>');

                })
            })
        })
    }
    </script>
    <?php
}

add_action( 'wp_ajax_handle_generate_blog_content_suggest_forms', 'handle_generate_blog_content_suggest_forms' );
function handle_generate_blog_content_suggest_forms() {
    $result = [];

    $form_id = $_POST['form_id'];
    $suggest_blog_topics_default_prompt = $_POST['suggest_blog_topics_default_prompt'];
    $suggest_blog_post_input = $_POST['suggest_blog_post_input'];

    $language = get_locale();
    $site_name = get_bloginfo( 'name' );
    $prompt = $suggest_blog_topics_default_prompt . $suggest_blog_post_input;
    $prompt_edited = str_replace('{{language}}', $language, $prompt);
    $prompt_edited = str_replace('{{site_name}}', $site_name, $prompt_edited);
    $topics = send_prompt_to_chatgpt($prompt_edited);


    $result['form_id'] = $form_id;
    $result['suggest_blog_topics_default_prompt'] = $suggest_blog_topics_default_prompt;
    $result['suggest_blog_post_input'] = $suggest_blog_post_input;
    $result['topics'] = $topics;

    echo json_encode($result);
    wp_die();
}

add_action( 'wp_ajax_handle_generate_blog_content_publish_forms', 'handle_generate_blog_content_publish_forms' );
function handle_generate_blog_content_publish_forms() {
    $result = [];
    $post_created = '';
    $form_id = $_POST['form_id'];
    $suggested_topics = $_POST['suggested_topics'];
    $generate_blog_post_default_prompt = $_POST['generate_blog_post_default_prompt'];
    $suggested_topics_array = explode(', ', $suggested_topics);

    $language = get_locale();
    $site_name = get_bloginfo( 'name' );
    $generate_blog_post_default_prompt_edited = str_replace('{{language}}', $language, $generate_blog_post_default_prompt);
    $generate_blog_post_default_prompt_edited = str_replace('{{site_name}}', $site_name, $generate_blog_post_default_prompt_edited);


    //check for the endmost future post
    $base_date = strtotime('now');
    $future_post = get_posts([
        'post_status'    => 'future',   
        'post_type'      => 'post',       
        'orderby'        => 'post_date',   
        'order'          => 'DESC',         
        'numberposts'    => 1,              
    ]);

    if (!empty($future_post)) { 
        $endmost_post_date = $future_post[0]->post_date;
        $base_date = strtotime($endmost_post_date);
    }

    foreach($suggested_topics_array as $index => $topic) {
        $scheduled_date = date('Y-m-d H:i:s', strtotime("+$index day", $base_date)); // 1 day after
        $prompt = $generate_blog_post_default_prompt_edited . $topic;
        $content = send_prompt_to_chatgpt($prompt);
        $post_array = array(
            'post_title'    => $topic,
            'post_content'  => $content,
            'post_status'   => 'future',
            'post_author'   => 1,
            'post_type'     => 'post',
            'post_date'     => $scheduled_date,
        );
        $post_id = wp_insert_post($post_array);
        if (!is_wp_error($post_id)) { 
            $post_created = 'Post created '.$post_id.'';
            // $result['post_created'][] = $topic; // ??????????????
        } else {
            $post_created = 'Error creating post';
        }
    }

    $result['suggested_topics'] = $suggested_topics;
    $result['suggested_topics_array'] = $suggested_topic_array;
    // $result['post_created'] = $post_created;

    echo json_encode($result);
    wp_die();
}
?>