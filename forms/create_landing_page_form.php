<?php

require_once($CFG->libdir . '/formslib.php');

class create_landing_page_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        // Template Name
        $mform->addElement('text', 'name', get_string('lpname', 'local_gophishintegration'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        // HTML content with CKEditor
        $mform->addElement('editor', 'html_editor', get_string('lphtmlcontent', 'local_gophishintegration'), null, ['maxfiles' => 0, 'trusttext' => true]);
        $mform->setType('html_editor', PARAM_RAW);

        $mform->addElement('advcheckbox', 'lpcapturedata', '', get_string('lpcapturedata', 'local_gophishintegration'));
        $mform->setType('lpcapturedata', PARAM_BOOL);
        $mform->addHelpButton('lpcapturedata', 'lpcapturedatahelpertext', 'local_gophishintegration');

        $mform->addElement('advcheckbox', 'lpcapturepassword', get_string('lpcapturepassword', 'local_gophishintegration'));
        $mform->setType('lpcapturepassword', PARAM_BOOL);


        $mform->addElement('text', 'lpurl', get_string('lpurl', 'local_gophishintegration'));
        $mform->setType('lpurl', PARAM_URL);
        $mform->addHelpButton('lpurl', 'lpurlhelpertext', 'local_gophishintegration');

        $this->add_action_buttons(true, get_string('createlp', 'local_gophishintegration'));
    }
}
