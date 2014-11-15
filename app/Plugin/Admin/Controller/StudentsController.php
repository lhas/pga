<?php
class StudentsController extends AdminAppController {
	public $uses = array("Student", "Input");

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Student->recursive = 0;
		$this->set('students', $this->Paginator->paginate());
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Student->create();
			if ($this->Student->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The student has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Student->exists($id)) {
			throw new NotFoundException(__('Invalid student'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Student->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The student has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The student could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Student.' . $this->Student->primaryKey => $id));
			$this->request->data = $this->Student->find('first', $options);
		}

		$atores = array(
			"Tutor",
			"Psico",
			"Escola",
			"Pais",
			"Aluno"
		);

		$inputs = $this->Input->find("all");

		$student_inputs = $this->Student->StudentInput->find("all", array(
			"conditions" => array(
				"StudentInput.student_id" => $id
			),
			"contain" => array(
				"Input"
			)
		) );

		$student_lessons = $this->Student->StudentLesson->find("all", array(
			"conditions" => array(
				"StudentLesson.student_id" => $id
			),
		) );

		$student_exercises = $this->Student->StudentExercise->find("all", array(
			"conditions" => array(
				"StudentExercise.student_id" => $id
			),
		) );

		$aulas = $this->Student->StudentInput->StudentInputValue->findGroup($id);

		$o_student_lessons = $this->Student->StudentLesson->find("list");

		$this->set(compact("atores", "inputs", "student_inputs", "aulas", "student_lessons", "o_student_lessons", "student_exercises"));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Student->id = $id;
		if (!$this->Student->exists()) {
			throw new NotFoundException(__('Invalid student'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Student->delete()) {
			$this->Session->setFlash(__('The student has been deleted.'));
		} else {
			$this->Session->setFlash(__('The student could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function add_student_exercise() {

		if($this->request->is("post")) {

			$this->Student->StudentExercise->create();

			$this->Student->StudentExercise->save($this->request->data);

			$this->Session->setFlash(__('O novo exercício foi salvo.'));

			return $this->redirect( array("action" => "edit", $this->request->data["StudentExercise"]["student_id"], "#" => "exercicios") );

		} // - post

	}

	public function add_input($input_id, $student_id, $actor) {

		if($this->request->is("post")) {

			$this->Student->StudentInput->create();

			// limpa o array de config
			// apenas por organização
			if(!empty($this->request->data["StudentInput"]["config"])) {
				foreach($this->request->data["StudentInput"]["config"] as $k => $i) {
					if(is_int($k)) {
						if(empty($i["name"])) {
							unset($this->request->data["StudentInput"]["config"][$k]);
						}
					}
				}
			}

			$dados = array(
				"student_id" => $student_id,
				"input_id" => $input_id,
				"actor" => strtolower($actor),
				"config" => $this->request->data["StudentInput"]["config"],
				"name" => $this->request->data["StudentInput"]["name"]
			);

			$this->Student->StudentInput->save($dados);

			$this->Session->setFlash(__('O novo input foi salvo.'));

			return $this->redirect( array("action" => "edit", $student_id, "#" => "conteudo") );

		} // - post

		$input = $this->Input->findById($input_id);
		$student = $this->Student->findById($student_id);

		$this->set(compact("input", "student"));
	}

	public function add_student_lesson() {

		if($this->request->is("post")) {

			$this->Student->StudentLesson->create();

			$this->Student->StudentLesson->save($this->request->data);

			$this->Session->setFlash(__('A nova matéria foi salva.'));

			return $this->redirect( array("action" => "edit", $this->request->data["StudentLesson"]["student_id"], "#" => "materias") );

		} // - post

		$input = $this->Input->findById($input_id);
		$student = $this->Student->findById($student_id);

		$this->set(compact("input", "student"));
	}

	public function delete_student_input($student_input_id, $student_id) {
		$this->Student->StudentInput->delete($student_input_id);

		$this->Session->setFlash(__('O input foi deletado.'));

		return $this->redirect( array("action" => "edit", $student_id, "#" => "conteudo") );
	}

	public function delete_student_lesson($student_lesson_id, $student_id) {
		$this->Student->StudentLesson->delete($student_lesson_id);

		$this->Session->setFlash(__('A matéria foi deletada.'));

		return $this->redirect( array("action" => "edit", $student_id, "#" => "materias") );
	}

	public function add_student_input_value() {

		if($this->request->is("post")) {

			$input_date = null;

			// adiciona os inputs
			foreach($this->request->data["StudentInputValue"] as $input_value) {

				if(!empty($input_value["value"]) && !empty($input_value["student_input_id"])) {

					$input_value["date"] = $this->request->data["StudentInputValue"]["date"];

					$input_date = $input_value["date"];

					$this->Student->StudentInput->StudentInputValue->create();

					$this->Student->StudentInput->StudentInputValue->save($input_value);

				}

			}

			// limpa o array de matérias
			// apenas por organização
			foreach($this->request->data["StudentInputValue"] as $k => $input_value) {
				if(empty($input_value["value"])) {
					unset($this->request->data["StudentInputValue"][$k]);
				}
			}

			// adiciona as matérias
			foreach($this->request->data["StudentInputValue"] as $input_value) {

				if(!empty($input_value["value"]) && !empty($input_value["student_lesson_id"])) {

					$input_value["date"] = $input_date;

					$this->Student->StudentInput->StudentInputValue->create();

					$this->Student->StudentInput->StudentInputValue->save($input_value);

				}

			}
		}

		$this->Session->setFlash(__('O novo registro de input foi salvo.'));

		return $this->redirect( array("controller" => "students", "action" => "edit", $this->request->data["StudentInputValue"][0]["student_id"], "#" => "conteudo") );
	}

	public function delete_student_exercise($student_exercise_id, $student_id) {
		$this->Student->StudentExercise->delete($student_exercise_id);

		$this->Session->setFlash(__('O exercício foi deletado.'));

		return $this->redirect( array("action" => "edit", $student_id, "#" => "exercicios") );
	}
}