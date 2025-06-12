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
        $curl = new \curl();
        $headers = [
            'Authorization: ' . $this->apikey
        ];
        $response = $curl->get($this->apiurl . $endpoint, [], $headers);
        return json_decode($response);
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

        $ch = curl_init();

        $url = $this->apiurl . '/api/groups/';

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

        $result = json_decode($response);
        return isset($result->id) ? $result : false;
    }
}
