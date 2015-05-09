<?php
/**
 * Páginas envolvendo evolução encontram-se aqui.
 */
class EvolutionController extends AppController {
    public $uses = array("Chart", "Student");

    public function index() {
        $this->layout = "ajax";
        $this->set("title_for_layout", "Evolução do Aluno");

        $student_id = AuthComponent::user("Student.Student.id");

        $date_start = $this->Session->read("date_start");
        $date_finish = $this->Session->read("date_finish");

        $conditions = array(
            "StudentInputValue.student_id" => $student_id
        );

        if(!empty($date_start) && !empty($date_finish)) {
            $conditions['StudentInputValue.date BETWEEN ? AND ?'] = array($date_start->format("Y-m-d"), $date_finish->format("Y-m-d"));

            $tem_busca = true;
            $busca_de_data = true;

            $this->Session->delete("date_start");
            $this->Session->delete("date_finish");
        } else {
            $tem_busca = false;
            $dateTime = new DateTime();

            $date_start     =  new DateTime($dateTime->format("Y-m-") . "01");
            $date_finish    = $dateTime;

            $date_finish = new DateTime($date_finish->format("Y-m-t"));
        }

        $this->set(compact("date_start", "date_finish"));
        $conditions = array(
            'StudentInputValue.date BETWEEN ? AND ?' => array($date_start->format("Y-m-d"), $date_finish->format("Y-m-d")),
        );

        $options = array(
            'conditions' => array(
                'Chart.student_id'  => $student_id
            ),
            'contain' => array(
                'ChartStudentInput' => array(
                    'StudentInput' => array(
                        'StudentInputValue' => array(
                            'conditions' => $conditions
                        ),
                        'Input'
                    )
                )
            ),
            'order' => array(
                'Chart.order DESC'
            )
        );
        $charts = $this->Chart->find("all", $options);

        // itera os gráficos existentes
        foreach($charts as $x => $c) {

            // configura os dataPoints

            // SE FOR PIZZA, DATAPOINT DE PIZZA
            if($c['Chart']['type'] == 'pie') {
                $tmp = $this->Chart->datapointPie($c);

                $data = $tmp['data'];
                $dataPoints = $tmp['dataPoints'];
            }

            // SE FOR DONUT, DATAPOINT DE DONUT
            if($c['Chart']['type'] == 'doughnut') {
                $tmp = $this->Chart->datapointPie($c);

                $data = $tmp['data'];
                $dataPoints = $tmp['dataPoints'];
            }

            // SE FOR LINHA, DATAPOINT DE LINHA
            if($c['Chart']['type'] == 'line') {
                $tmp = $this->Chart->datapointLine($c);

                $dataPoints = $tmp['dataPoints'];
            }
            
            // SE FOR BARRA, DATAPOINT DE BARRA
            if($c['Chart']['type'] == 'bar') {
                $tmp = $this->Chart->datapointBar($c);

                $dataPoints = $tmp['dataPoints'];
            }

            // SE FOR COLUNA, DATAPOINT DE COLUNA
            if($c['Chart']['type'] == 'column') {
                $tmp = $this->Chart->datapointColumn($c);

                $dataPoints = $tmp['dataPoints'];
            }

            // SE FOR NÚMERO ABSOLUTO, DATAPOINT DE NÚMERO ABSOLUTO
            if($c['Chart']['type'] == 'num_absoluto') {
                $tmp = $this->Chart->datapointNumAbsoluto($c);

                $dataPoints = $tmp['dataPoints'];

                if($c['Chart']['sub_type'] == "nota") {
                            $materias = array(
                                array(
                                    'nome' => 'Biologia',
                                    'notas' => array(
                                        array(
                                            'esperado' => 7,
                                            'alcancado' => 9,
                                            'label' => '1ª Prova',
                                        ),
                                        array(
                                            'esperado' => 3,
                                            'alcancado' => 6,
                                            'label' => '2ª Prova',
                                        ),
                                    )
                                )
                            );

                            // Buscar todas as matérias do estudante
                            $options = array(
                                'conditions' => array(
                                    'StudentLesson.student_id' => $student_id
                                )
                            );

                            $materias = array();
                            $student_lessons = $this->Student->StudentLesson->find("all", $options);

                            foreach($student_lessons as $sl) {
                                $materia_nome = $sl['StudentLesson']['name'];

                                if(!in_array($materia_nome, $materias)) {
                                    $materias[$materia_nome] = array(
                                        'nome' => $sl['StudentLesson']['name'],
                                        'notas' => array()
                                    );

                                    $options = array(
                                        'conditions' => array(
                                            'StudentInputValue.student_id' => $student_id,
                                            'StudentInputValue.student_lesson_id' => $sl['StudentLesson']['id'],
                                        ),
                                        'fields' => array(
                                            'StudentInputValue.id',
                                            'StudentInputValue.nota_1',
                                            'StudentInputValue.nota_2',
                                            'StudentInputValue.nota_3',
                                            'StudentInputValue.nota_4',
                                            'StudentInputValue.nota_6',
                                            'StudentInputValue.nota_7',
                                            'StudentInputValue.nota_8',
                                        )
                                    );
                                    $aulas = $this->Student->StudentInput->StudentInputValue->find("all", $options);

                                    $tmp2 = array(
                                        array(1, 2),
                                        array(3, 4),
                                        array(5, 6),
                                        array(7, 8),
                                    );

                                    foreach($tmp2 as $t2) {

                                        if($t2 == array(1, 2)) {
                                            $label = "Teste";
                                        }

                                        if($t2 == array(3, 4)) {
                                            $label = "Prova";
                                        }

                                        if($t2 == array(5, 6)) {
                                            $label = "Trabalho";
                                        }

                                        if($t2 == array(7, 8)) {
                                            $label = "Nota Bimestral";
                                        }

                                        $tmp = array(
                                            'esperado' => 0,
                                            'alcancado' => 0,
                                            'label' => $label
                                        );

                                        $materias[$materia_nome]['notas'][$t2[0] . "_" . $t2[1]] = $tmp;
                                    }
                                }
                            }

                            var_dump($materias);

                }
            }

            // gera o array de configurações do CanvasJS
            $config = array(
                'backgroundColor' => 'transparent',
                'height' => $c['Chart']['height'],
                'toolTip' => array('enabled' => true),
                'title'                      => array(
                    'text'                  => $c['Chart']['name']
                ),
                'data'                      => array(
                    0 => array(
                        'type' => $c['Chart']['type'],
                        'dataPoints'    => $dataPoints
                    )
                )
            );

            // inclui as configs em JSON de cada gráfico
            if(!empty($dataPoints)) {
                $charts[$x]['config'] = json_encode($config);
            }
        }

        // envia os gráficos pra view
        $this->set(compact("charts", "tem_busca", "s", "busca_de_data", "materias"));
    }
}