<?php

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/forms/create_sending_profile_page.php');

require_login();
require_capability('local/gophishintegration:createsendingprofiles', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/sendingprofile.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('creategophishsendingprofile', 'local_gophishintegration'));
$PAGE->set_heading(get_string('creategophishsendingprofile', 'local_gophishintegration'));

echo $OUTPUT->header();

$form = new create_sending_profile_page_form();

if ($form->is_cancelled()) {
    redirect(new moodle_url('/local/gophishintegration/')); // adjust redirection
} else if ($data = $form->get_data()) {
    $client = new \local_gophishintegration\api_client();

    // HTML editor content is inside $data->html_editor['text']
    $result = $client->create_sending_profile(
        $data->name,
        $data->username,
        $data->password,
        $data->host,  
        "SMTP",  
        $data->from_address,  
        $data->ignore_cert_errors,  
    );

    if ($result) {
        echo $OUTPUT->notification(get_string('spcreatedsuccess', 'local_gophishintegration'), 'success');
    } else {
        echo $OUTPUT->notification(get_string('spcreatedfail', 'local_gophishintegration'), 'error');
    }
}

$form->display();

echo $OUTPUT->footer();
