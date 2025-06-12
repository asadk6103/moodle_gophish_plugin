<?php

require_once($CFG->libdir.'/formslib.php');

class create_template_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // Template Name
        $mform->addElement('text', 'name', get_string('templatename', 'local_gophishintegration'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        // Subject
        $mform->addElement('text', 'subject', get_string('subject', 'local_gophishintegration'));
        $mform->setType('subject', PARAM_TEXT);
        $mform->addRule('subject', null, 'required');

        // Plain Text content
        $mform->addElement('textarea', 'text', get_string('textcontent', 'local_gophishintegration'), 'wrap="virtual" rows="5" cols="50"');
        $mform->setType('text', PARAM_RAW);

        // HTML content with CKEditor
        $mform->addElement('editor', 'html_editor', get_string('htmlcontent', 'local_gophishintegration'), null, ['maxfiles' => 0, 'trusttext' => true]);
        $mform->setType('html_editor', PARAM_RAW);

        $this->add_action_buttons(true, get_string('createtemplate', 'local_gophishintegration'));
    }
}
