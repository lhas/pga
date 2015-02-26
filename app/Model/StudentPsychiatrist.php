<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class StudentPsychiatrist extends AppModel {
	public $belongsTo = array("Student");

	public function beforeSave($options = array()) {

	    if (isset($this->data[$this->alias]['password'])) {
	        $passwordHasher = new BlowfishPasswordHasher();

	        $this->data[$this->alias]['password'] = $passwordHasher->hash(
	            $this->data[$this->alias]['password']
	        );
	    }

	    return true;
	}
}