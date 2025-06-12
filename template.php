<?php

require_once(__DIR__.'/../../config.php');
require_once(__DIR__.'/forms/create_template_form.php');

require_login();
require_capability('local/gophishintegration:createemailtemplate', context_system::instance());

$PAGE->set_url(new moodle_url('/local/gophishintegration/template.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('creategophishtemplate', 'local_gophishintegration'));
$PAGE->set_heading(get_string('creategophishtemplate', 'local_gophishintegration'));

echo $OUTPUT->header();

$form = new create_template_form();

if ($form->is_cancelled()) {
    redirect(new moodle_url('/local/gophishintegration/')); // adjust redirection
} else if ($data = $form->get_data()) {
    $client = new \local_gophishintegration\api_client();

    // HTML editor content is inside $data->html_editor['text']
    $result = $client->create_template(
        $data->name,
        $data->subject,
        $data->html_editor['text'],
        $data->text
    );

    if ($result) {
        echo $OUTPUT->notification(get_string('templatecreatedsuccess', 'local_gophishintegration'), 'success');
    } else {
        echo $OUTPUT->notification(get_string('templatecreatedfail', 'local_gophishintegration'), 'error');
    }
}

$form->display();

echo $OUTPUT->footer();
