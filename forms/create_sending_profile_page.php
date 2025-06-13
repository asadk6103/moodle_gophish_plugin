<?php

require_once($CFG->libdir . '/formslib.php');

class create_sending_profile_page_form extends moodleform
{
    public function definition()
    {
        $mform = $this->_form;

        // Template Name
        $mform->addElement('text', 'name', get_string('name', 'local_gophishintegration'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        $mform->addElement('text', 'interface_type', get_string('interface_type', 'local_gophishintegration'));
        $mform->setType('interface_type', PARAM_TEXT);
        $mform->freeze('interface_type');
        $mform->setDefault('interface_type', 'SMTP');

        $mform->addElement('text', 'from_address', get_string('from_address', 'local_gophishintegration'));
        $mform->setType('from_address', PARAM_TEXT);
        $mform->addRule('from_address', null, 'required');
        $mform->addHelpButton('from_address', 'from_address_helperText', 'local_gophishintegration');

        $mform->addElement('text', 'host', get_string('host', 'local_gophishintegration'));
        $mform->setType('host', PARAM_TEXT);
        $mform->addRule('host', null, 'required');
        $mform->addElement('static', 'host_hint', '', 'If you are using some different ports please append it at the end. e.g. smtp.example.com:25');


        $mform->addElement('text', 'username', get_string('username', 'local_gophishintegration'));
        $mform->setType('username', PARAM_TEXT);
        $mform->addRule('username', null, 'required');

        $mform->addElement('password', 'password', get_string('password', 'local_gophishintegration'));
        $mform->setType('password', PARAM_TEXT);
        $mform->addRule('password', null, 'required');

        $mform->addElement('advcheckbox', 'ignore_cert_errors', get_string('ignore_cert_errors', 'local_gophishintegration'));
        $mform->setType('ignore_cert_errors', PARAM_BOOL);
        $mform->addHelpButton('ignore_cert_errors', 'ignore_cert_errors_helpertext', 'local_gophishintegration');

        $this->add_action_buttons(true, get_string('createprofile', 'local_gophishintegration'));
    }
}
