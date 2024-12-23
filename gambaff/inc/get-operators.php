<?php 
use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;

add_shortcode('admin_get_operators', 'google_sheets');
function google_sheets($spreadsheetId, $range) {
    if(is_admin()) {
        ob_start();
        include plugin_dir_path( __FILE__ ) . '../vendor/autoload.php';
        $creds_file = plugin_dir_path( __FILE__ ).'/api/service-account-creds.json';

        if (file_exists($creds_file)) {
            putenv('GOOGLE_APPLICATION_CREDENTIALS='.plugin_dir_path( __FILE__ ).'/api/service-account-creds.json');
        } else {
            echo '<p>Upload your google credentials file in Manager -> API</p>';
            exit();
        }
    
        $client = new Google\Client();
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google\Service\Drive::DRIVE);
        $service = new Google_Service_Sheets($client);
    
        $google_sheets_id = get_option('google_sheets_id', '');
        $google_sheets_name = get_option('google_sheets_name', '');
        $google_sheets_range = get_option('google_sheets_range', '');
        $result = $service->spreadsheets_values->get($google_sheets_id, ''.$google_sheets_name.'!'.$google_sheets_range.''); //get($spreadsheetId, $range)
        $submit_button = '';

        try {
            $html = '<div id="admin-get-operators">';
            $options = '';
            $data = $result->getValues(); // array from google sheets

            foreach ($data as $operator) {
                $operator_name = $operator[0];
                $operator_slug = $operator[1];
                $operator_type = $operator[2];
                $operator_logo = $operator[3];
                $operator_license = $operator[4];
                $operator_deposit_methods = $operator[5];
                $operator_withdrawal_methods = $operator[6];
                $operator_software_provider = $operator[7];

                $operator_bonus_offer = $operator[8];
                $operator_tc_text = $operator[9];
                $operator_tc_link = $operator[10];
                $operator_aff_link = $operator[11];

                $query = new WP_Query(array('post_type' => 'operator', 'name' => $operator_slug));
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $existing_post_slug = get_post_field('post_name', get_the_ID());
                        if ($operator_slug === $existing_post_slug) {
                            $submit_button = '<p class="submit"><input type="submit" name="submit-operator" id="submit-operator" class="button button-primary" value="Update"></p>'; //'<input type="submit" value="Update"/>';
                        }
                    }
                    wp_reset_postdata();
                } else {
                        $submit_button = '<p class="submit"><input type="submit" name="submit-operator" id="submit-operator" class="button button-primary" value="Add"></p>'; //'<input type="submit" value="Post"/>';
                }                    


                $html .= '<form id="'.$operator_slug.'" action="" method="POST">';
                $html .= '<div class="operator-row card" data-op-name="'.$operator_name.'">';
                $html .= '<h2 class="operator-name title">'.$operator_name.'</h2>';
                $html .= '<div class="operator-hidden-details">';
                $html .= '<p class="operator-slug">'.$operator_slug.'</p>';
                $html .= '<p class="operator-logo">'.$operator_logo.'</p>';
                $html .= '<p class="operator-type">'.$operator_type.'</p>';
                $html .= '<p class="operator-license">'.$operator_license.'</p>';

                $html .= '<p class="operator-deposit-methods">'.$operator_deposit_methods.'</p>';
                $html .= '<p class="operator-withdrawal-methods">'.$operator_withdrawal_methods.'</p>';
                $html .= '<p class="operator-software-provider">'.$operator_software_provider.'</p>';

                $html .= '<p class="operator-bonus-offer">'.$operator_bonus_offer.'</p>';
                $html .= '<p class="operator-tc-text">'.$operator_tc_text.'</p>';
                $html .= '<p class="operator-tc-link">'.$operator_tc_link.'</p>';
                $html .= '<p class="operator-aff-link">'.$operator_aff_link.'</p>';
                $html .= '</div>';
                $html .= '<div class="operator-submit">'.$submit_button.'</div>';
                $html .= '</div>';
                $html .= '</form>';
            }

            $html .= '</div>';
            $html .= ob_get_clean();
            return $html;
            // return '<pre>' . var_export($data, true) . '</pre>';
        }
        catch(Exception $e) {
            return 'Message: ' .$e->getMessage();
        }
    } 
}