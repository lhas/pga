<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

	/**
	 * Dicionário dos inputs.
	 *
	 * @return ID do Input no banco de dados.
	 */
	public function getInputId($name = null) {
		switch($name) {
			case "Calendário":
				return 1;
			break;
			case "Intervalo de Tempo":
				return 2;
			break;
			case "Texto":
				return 3;
			break;
			case "Escala Numérica":
				return 4;
			break;
			case "Escala Texto":
				return 5;
			break;
			case "Número":
				return 6;
			break;
			case "Texto Privativo":
				return 7;
			break;
			default:
				return 0;
			break;
		}
	}

	/**
	 * Função de atalho para a action set_student.
	 */
	function dados($a, $campo, $subcampo = null) {
		
		if($campo == "id")
			$a["prefix"] = null;

		if($campo == "Student")
			return $a[$a["model"]]["Student"][$subcampo];

		return $a[$a["model"]][$a["prefix"] . $campo];
	}
}
