<?php 
add_action('admin_footer', 'handle_generate_page_content_forms_js');
function handle_generate_page_content_forms_js() {
    ?>
    <script>
    if (window.location.href.includes('operators-manager-generate-content')) {
        const forms = document.querySelectorAll('.admin-generate-page-content form')
        
        //generate page content
        forms.forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault()

                const submitButton = form.querySelector('input[type="submit"]')
                // submitButton.classList.add('loading')
                submitButtonOriginalValue = submitButton.getAttribute('value')
                submitButton.setAttribute('value', 'Loading...')
                submitButton.setAttribute('disabled', 'disabled')
                if(form.querySelector('#submit-message')) {
                    form.querySelector('#submit-message').remove()
                }
                const pageName = form.querySelector('.page-name').textContent
                const pageSlug = form.querySelector('.page-slug').textContent
                const pageContentPrompt = form.querySelector('.page-content-prompt').value


                let data = new FormData(form)
                data.append('action', 'handle_generate_page_content_forms')
                data.append('form_id', form.id)
                data.append('page_name', pageName)
                data.append('page_slug', pageSlug)
                data.append('page_content_prompt', pageContentPrompt)


                let ajaxScript = { ajaxUrl : window.location.origin + '/wp-admin/admin-ajax.php' } // !!!the url must be changed
                fetch( ajaxScript.ajaxUrl, { method: 'POST', body: data } )
                .then( response => response.json())
                .then( (data) => {
                    console.log(data)
                    // submitButton.classList.remove('loading')
                    // submitButton.classList.add('loading-success')
                    submitButton.setAttribute('value', submitButtonOriginalValue)
                    submitButton.removeAttribute('disabled')
                    submitButton.insertAdjacentHTML('afterend', '<span id="submit-message">Done!</span>');
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

add_action( 'wp_ajax_handle_generate_page_content_forms', 'handle_generate_page_content_forms' );
function handle_generate_page_content_forms() {
    $result = [];

    $form_id = $_POST['form_id'];
    $page_name = $_POST['page_name'];
    $page_slug = $_POST['page_slug'];
    $page_content_prompt = $_POST['page_content_prompt'];

    $language = get_locale();
    $site_name = get_bloginfo( 'name' );

    $page_content_prompt_edited = str_replace('{{language}}', $language, $page_content_prompt);
    $page_content_prompt_edited = str_replace('{{site_name}}', $site_name, $page_content_prompt_edited);

    $page_content = send_prompt_to_chatgpt($page_content_prompt_edited);


    $result['form_id'] = $form_id;
    $result['page_name'] = $page_name;
    $result['page_slug'] = $page_slug;
    $result['page_content_prompt'] = $page_content_prompt;
    $result['page_content_prompt_edited'] = $page_content_prompt_edited;
    $result['page_content'] = $page_content;

    $post_id = post_exists($page_name, '', '', 'page');

    if ($post_id) {
        // If post exists, update it
        $post_array = array(
            'ID'            => $post_id,
            'post_content'  => $page_content,            

        );
        wp_update_post($post_array);

    }

    echo json_encode($result);
    wp_die();
}
?>