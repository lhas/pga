<?php
/**
 * Páginas envolvendo input encontram-se aqui.
 */
class InputController extends AppController {
	public $uses = array("Student", "Feed");

	/**
	 * Página Inicial.
	 */
	public function index() {
		$this->layout = "ajax";
		$this->set("title_for_layout", "Inputs");	
	}

	/**
	 * Página de Criar Novo Registro.
	 */
	public function create() {
		$this->layout = "ajax";
		$this->set("title_for_layout", "Criar Novo Input");

		$actor = $this->getActor(AuthComponent::user("Actor"));
		$student_id = AuthComponent::user("Student.Student.id");

		// Busca todos os inputs para o estudante
		$student_inputs = $this->Student->StudentInput->find("all", array(
			"conditions" => array(
				"StudentInput.student_id" => AuthComponent::user("Student.Student.id"),
				"StudentInput.actor" => $actor
			),
			"contain" => array(
				"Input"
			)
		) );

		// busca todas as matérias do estudante
		$student_lessons = $this->Student->StudentLesson->find("all", array(
			"conditions" => array(
				"StudentLesson.student_id" => AuthComponent::user("Student.Student.id")
			),
		) );

		$last_entry = $this->Student->StudentInput->StudentInputValue->find("first", array(
			"conditions" => array(
				"StudentInputValue.date" => date("d/m/Y"),
				"StudentInputValue.actor" => $actor
			),
			"order" => array(
				"StudentInputValue.id DESC"
			)
		) );

		if(!empty($last_entry)) {
			$has_input = true;
		} else {
			$has_input = false;
		}

		$this->set(compact("student_id", "student_inputs", "student_lessons", "actor", "has_input"));
	}

	/**
	 * Página de Arquivo.
	 */
	public function archive() {
		$this->layout = "ajax";
		$this->set("title_for_layout", "Arquivo de Inputs");

		$aulas = $this->Student->StudentInput->StudentInputValue->findGroup(AuthComponent::user("Student.Student.id"));

		$this->set(compact("aulas"));
	}

	/**
	 * Action de requisição POST da criação de input.
	 */
	public function add_student_input_value() {
		$this->layout = "ajax";

		if($this->request->is("post")) {

			$input_date = $this->request->data["StudentInputValue"]["date"];
			unset($this->request->data["StudentInputValue"]["date"]);

			// adiciona os inputs
			foreach($this->request->data["StudentInputValue"] as $k => $input_value) {

				if(!empty($input_value["value"]) && !empty($input_value["student_input_id"])) {

					$input_value["date"] = $input_date;

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
			foreach($this->request->data["StudentInputValue"] as $k => $input_value) {

				if(!empty($input_value["value"]) && !empty($input_value["student_lesson_id"])) {

					$input_value["date"] = $input_date;

					$this->Student->StudentInput->StudentInputValue->create();

					$this->Student->StudentInput->StudentInputValue->save($input_value);

				}

			}

			// joga o input para o feed
			$this->Feed->generate($input_date, $this->request->data["StudentInputValue"]);
		}

		$this->Session->setFlash(__('O novo registro de input foi salvo.'));

		return $this->redirect( array("controller" => "input", "action" => "archive") );
	}
}