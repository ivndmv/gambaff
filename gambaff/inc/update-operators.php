<?php 
add_action('admin_footer', 'handle_forms_js');
function handle_forms_js() {
    ?>
    <script>
    if (window.location.href.includes('operators-manager-settings')) {
        const forms = document.querySelectorAll('#admin-get-operators form')
        
        forms.forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault()

                const submitButton = form.querySelector('input[type="submit"]')
                console.log(submitButton.textContent)
                submitButton.setAttribute('value', 'Loading...')
                submitButton.setAttribute('disabled', 'disabled')
                if(form.querySelector('#submit-message')) {
                    form.querySelector('#submit-message').remove()
                }

                const operatorName = form.querySelector('.operator-name').textContent
                const operatorSlug = form.querySelector('.operator-slug').textContent
                const operatorType = form.querySelector('.operator-type').textContent.split(',') // array
                const operatorLogo = form.querySelector('.operator-logo').textContent

                const operatorLicense = form.querySelector('.operator-license').textContent.split(',') // array

                const operatorDepositMethods = form.querySelector('.operator-deposit-methods').textContent.split(',') // array
                const operatorWithdrawalMethods = form.querySelector('.operator-withdrawal-methods').textContent.split(',') // array
                const operatorSoftwareProvider = form.querySelector('.operator-software-provider').textContent.split(',') // array

                const operatorBonusOffer = form.querySelector('.operator-bonus-offer').textContent
                const operatorTcText = form.querySelector('.operator-tc-text').textContent
                const operatorTcLink = form.querySelector('.operator-tc-link').textContent
                const operatorAffLink = form.querySelector('.operator-aff-link').textContent

                let data = new FormData(form)
                data.append('action', 'handle_forms')
                data.append('form_id', form.id)
                data.append('operator_name', operatorName)
                data.append('operator_slug', operatorSlug)
                data.append('operator_type', operatorType)
                data.append('operator_logo', operatorLogo)
                data.append('operator_license', operatorLicense)

                data.append('operator_deposit_methods', operatorDepositMethods)
                data.append('operator_withdrawal_methods', operatorWithdrawalMethods)
                data.append('operator_software_provider', operatorSoftwareProvider)

                data.append('operator_bonus_offer', operatorBonusOffer)
                data.append('operator_tc_text', operatorTcText)
                data.append('operator_tc_link', operatorTcLink)
                data.append('operator_aff_link', operatorAffLink)


                let ajaxScript = { ajaxUrl : window.location.origin + '/wp-admin/admin-ajax.php' } // !!!the url must be changed
                fetch( ajaxScript.ajaxUrl, { method: 'POST', body: data } )
                .then( response => response.json())
                .then( (data) => {
                    console.log(data)
                    submitButton.removeAttribute('disabled')
                    submitButton.setAttribute('value', 'Update')
                    submitButton.insertAdjacentHTML('afterend', '<span id="submit-message">Done!</span>');
                })
                .catch(err => {
                    console.error(err);
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

add_action( 'wp_ajax_handle_forms', 'handle_forms' );
function handle_forms() {
    $result = [];

    $form_id = $_POST['form_id'];
    $operator_name = $_POST['operator_name'];
    $operator_slug = $_POST['operator_slug'];
    $operator_logo = $_POST['operator_logo']; // url

    $operator_type = [];
    foreach (explode(",", $_POST['operator_type']) as $item) {
        $operator_type[] = get_term_by('name', $item, 'operator-type')->term_id; // we get the term id
    }

    $operator_license = [];
    foreach (explode(",", $_POST['operator_license']) as $item) {
        if (get_term_by('name', $item, 'operator-license')->term_id == NULL) {
            $new_term = wp_insert_term(
                $item,  // The name of the term
                'operator-license'   // The taxonomy slug
            );
            $operator_license[] = $new_term;
        }
        $operator_license[] = get_term_by('name', $item, 'operator-license')->term_id; // we get the term id
    }

    $operator_deposit_methods = [];
    foreach (explode(",", $_POST['operator_deposit_methods']) as $item) {
        if (get_term_by('name', $item, 'operator-deposit-method')->term_id == NULL) {
            $new_term = wp_insert_term(
                $item,  // The name of the term
                'operator-deposit-method'   // The taxonomy slug
            );
            $operator_deposit_methods[] = $new_term;
        }
        $operator_deposit_methods[] = get_term_by('name', $item, 'operator-deposit-method')->term_id; // we get the term id
    }

    $operator_withdrawal_methods = [];
    foreach (explode(",", $_POST['operator_withdrawal_methods']) as $item) {
        if (get_term_by('name', $item, 'operator-withdrawal-method')->term_id == NULL) {
            $new_term = wp_insert_term(
                $item,  // The name of the term
                'operator-withdrawal-method'   // The taxonomy slug
            );
            $operator_withdrawal_methods[] = $new_term;
        }
        $operator_withdrawal_methods[] = get_term_by('name', $item, 'operator-withdrawal-method')->term_id; // we get the term id
    }

    $operator_software_provider = [];
    foreach (explode(",", $_POST['operator_software_provider']) as $item) {
        if (get_term_by('name', $item, 'operator-software-provider')->term_id == NULL) {
            $new_term = wp_insert_term(
                $item,  // The name of the term
                'operator-software-provider'   // The taxonomy slug
            );
            $operator_software_provider[] = $new_term;
        }
        $operator_software_provider[] = get_term_by('name', $item, 'operator-software-provider')->term_id; // we get the term id
    }

    $operator_bonus_offer = $_POST['operator_bonus_offer'];
    $operator_tc_text = $_POST['operator_tc_text'];
    $operator_tc_link = $_POST['operator_tc_link'];
    $operator_aff_link = $_POST['operator_aff_link'];

    $result['form_id'] = $form_id;
    $result['operator_name'] = $operator_name;
    $result['operator_slug'] = $operator_slug;
    $result['operator_logo'] = $operator_logo;

    $result['operator_type'] = $operator_type;
    $result['operator_license'] = $operator_license;

    $result['operator_deposit_methods'] = $operator_deposit_methods;
    $result['operator_withdrawal_methods'] = $operator_withdrawal_methods;
    $result['operator_software_provider'] = $operator_software_provider;

    $result['operator_bonus_offer'] = $operator_bonus_offer;
    $result['operator_tc_text'] = $operator_tc_text;
    $result['operator_tc_link'] = $operator_tc_link;
    $result['operator_aff_link'] = $operator_aff_link;

    $result['error_inserting_post'] = 'no error';
    $result['error_uploading_image'] = 'no error';

    $language = get_locale();
    $site_name = get_bloginfo( 'name' );
    $json_prompts = file_get_contents( plugin_dir_path(__FILE__) . '/chatgpt-operator-review-prompt.json');
    $prompts_array = json_decode($json_prompts, true);
    $operator_review_prompt = $prompts_array['operator_review'];
    $operator_review_prompt = str_replace('{{operator_name}}', $operator_name, $operator_review_prompt);
    $operator_review_prompt = str_replace('{{language}}', $language, $operator_review_prompt);
    $operator_review_prompt = str_replace('{{site_name}}', $site_name, $operator_review_prompt);
    $operator_review_content = send_prompt_to_chatgpt($operator_review_prompt);

    // $result['operator_review_prompt'] = $operator_review_prompt;
    // $result['language'] = $language;

    $post_id = post_exists($operator_name, '', '', 'operator');

    if ($post_id) {
        // If post exists, update it
        $post_array = array(
            'ID'            => $post_id,
            'post_title'    => $operator_name,
            // 'post_content'  => $operator_review_content,            
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'operator',
            'tax_input'     => array(
                'operator-type' => $operator_type, // accepts only term IDs, no term name
                'operator-license' => $operator_license, // accepts only term IDs, no term name
                'operator-deposit-method' => $operator_deposit_methods, // accepts only term IDs, no term name
                'operator-withdrawal-method' => $operator_withdrawal_methods, // accepts only term IDs, no term name
                'operator-software-provider' => $operator_software_provider, // accepts only term IDs, no term name
            ),
            'meta_input'    => array(
                'operator_logo' => $operator_logo,
                'operator_bonus_offer' => $operator_bonus_offer, // Add custom fields if needed
                'operator_terms_and_conditions_text' => $operator_tc_text, // Add custom fields if needed
                'operator_terms_and_conditions_link' => $operator_tc_link, // Add custom fields if needed
                'operator_affiliate_link' => $operator_aff_link, // Add custom fields if needed
            ),
        );
        wp_update_post($post_array);
        save_links_to_json($post_id);
        set_featured_image_from_url($post_id, $operator_logo);

    } else {
        // Insert new post if it doesn't exist
        $post_array = array(
            'post_title'    => $operator_name,
            'post_name'     => $operator_slug,
            'post_content'  => $operator_review_content,
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'operator',
            'tax_input'     => array(
                'operator-type' => $operator_type, // accepts only term IDs, no term name
                'operator-license' => $operator_license, // accepts only term IDs, no term name
                'operator-deposit-method' => $operator_deposit_methods, // accepts only term IDs, no term name
                'operator-withdrawal-method' => $operator_withdrawal_methods, // accepts only term IDs, no term name
                'operator-software-provider' => $operator_software_provider, // accepts only term IDs, no term name
            ),
            'meta_input'    => array(
                'operator_logo' => $operator_logo,
                'operator_bonus_offer' => $operator_bonus_offer, // Add custom fields if needed
                'operator_terms_and_conditions_text' => $operator_tc_text, // Add custom fields if needed
                'operator_terms_and_conditions_link' => $operator_tc_link, // Add custom fields if needed
                'operator_affiliate_link' => $operator_aff_link, // Add custom fields if needed
            ),
        );
        $post_id = wp_insert_post($post_array);
        save_links_to_json($post_id);
        set_featured_image_from_url($post_id, $operator_logo);
    }


    echo json_encode($result);
    wp_die();
}
?>
