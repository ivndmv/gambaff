<?php
function send_prompt_to_chatgpt($prompt) {
    $openai_api_key = get_option('openai_api_key', '');
    // cURL setup
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer '.$openai_api_key.'',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'model' => 'gpt-4o', // Choose the model you prefer
        'messages' => [
            ['role' => 'developer', 'content' => $prompt]
        ],
        'max_tokens' => 4096,  // Set appropriate max_tokens
    ]));
    
    // Set cURL timeout to 300 seconds (5 minutes)
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);  // Timeout in seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);  // Connection timeout in seconds
    
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);  // Handle the error appropriately
    }
    
    curl_close($ch);
    
    // Parse and return the response if needed
    $response_data = json_decode($response, true);
    if (isset($response_data['choices'][0]['message']['content'])) {
        return $response_data['choices'][0]['message']['content'];
    }
    
    return 'No valid response';  // Return empty string if no valid response
}
?>