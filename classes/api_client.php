<?php

namespace local_gophishintegration;

defined('MOODLE_INTERNAL') || die();

class api_client
{

    private $apiurl;
    private $apikey;

    public function __construct()
    {
        $this->apiurl = rtrim(get_config('local_gophishintegration', 'apiurl'), '/');
        $this->apikey = get_config('local_gophishintegration', 'apikey');
    }

    private function request($endpoint)
    {

        $ch = curl_init();

        // Prepare the URL
        $url = $this->apiurl . $endpoint;

        // Set the headers
        $headers = [
            'Authorization: ' . $this->apikey
        ];

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        return $response;
    }

    private function postData($endpoint, $payload)
    {
        $ch = curl_init();

        $url = $endpoint;

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $this->apikey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        // (Optional) Disable SSL verification if you're testing with self-signed certs
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }

    public function get_campaigns()
    {
        return $this->request('/campaigns/');
    }

    public function create_group($name, $users)
    {
        $recipients = [];
        foreach ($users as $user) {
            if (empty($user->email)) {
                continue;
            }
            $recipients[] = [
                'first_name' => $user->firstname,
                'last_name' => $user->lastname,
                'email' => $user->email,
                "position" => ""
            ];
        }

        $payload = [
            'name' => $name,
            'targets' => $recipients
        ];


        // $curl = new \curl();
        // $headers = [
        //     'Authorization: ' . $this->apikey,
        //     'Content-Type: application/json'
        // ];
        // $response = $curl->post($this->apiurl . '/api/groups/', json_encode($payload), $headers);

        $url = $this->apiurl . '/api/groups/';
        $response = $this->postData($url, $payload);

        $result = json_decode($response);
        return isset($result->id) ? $result : false;
    }

    public function get_groups()
    {
        return $this->request('/api/groups/');
    }

    public function create_campaign($name, $groupid, $templateid, $url)
    {
        $payload = [
            'name' => $name,
            'template' => [
                'id' => $templateid
            ],
            'groups' => [
                ['id' => $groupid]
            ],
            'url' => $url,
            'launch_date' => date('Y-m-d\TH:i:s\Z') // ISO format for immediate launch
        ];

        $url = $this->apiurl . '/api/campaigns/';
        $response = $this->postData($url, $payload);
        $result = json_decode($response);
        echo $result;
        die();
        return isset($result->id) ? $result : false;
    }


    public function create_template($name, $subject, $html, $text)
    {
        $payload = [
            'name' => $name,
            'subject' => $subject,
            'html' => $html,
            'text' => $text
        ];

        $url = $this->apiurl . '/api/templates/';
        $response = $this->postData($url, $payload);

        $result = json_decode($response, true);
        return isset($result['id']) ? $result : false;
    }

    public function create_landing_page($name, $html, $capture_credentials, $capture_passwords, $redirect_url)
    {
        $payload = [
            'name' => $name,
            'html' => $html,
            'capture_credentials' => (bool)$capture_credentials,
            'capture_passwords' => (bool)$capture_passwords,
            'enable_reporting' => true,
            'redirect_url' => $redirect_url,
        ];

        $url = $this->apiurl . '/api/pages/';
        $response = $this->postData($url, $payload);

        $result = json_decode($response, true);
        return isset($result['id']) ? $result : false;
    }

    public function create_sending_profile($name, $username, $password, $host, $interface_type, $from_address, $ignore_cert_errors)
    {
        $payload = [
            'name' => $name,
            'username' => $username,
            'password' => $password,
            'host' => $host,
            'interface_type' => $interface_type,
            'from_address' => $from_address,
            'ignore_cert_errors' => (bool)$ignore_cert_errors,
            'headers' => []
        ];


        $url = $this->apiurl . '/api/smtp/';
        $response = $this->postData($url, $payload);
        $result = json_decode($response, true);
        return isset($result['id']) ? $result : false;
    }
}
