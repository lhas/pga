<div role="tabpanel" class="tab-pane" id="outputs">
    <div class="tab-content">


          <div class="row">

                <div class="col-md-3">

                    <?php echo $this->Form->create("Chart", array('url' => array('controller' => 'charts', 'action' => 'add') ) ); ?>

                    <?php echo $this->Form->input("name", array('label' => 'Nome') ); ?>
                    <?php echo $this->Form->input('input_id', array('label' => 'Tipo de Input', 'options' => $inputs_o, 'empty' => 'Selecionar', 'data-disable-select' => 'true', 'class' => 'form-control select-tipo-de-input') ); ?>
                    <?php
                        $options = array(
                            'bar' => 'Barra',
                            'column' => 'Coluna',
                            'line' => 'Linha',
                            'pie' => 'Pizza',
                            'donut' => 'Donut',
                        );
                        echo $this->Form->input('type', array('label' => 'Gráfico', 'options' => $options, 'empty' => 'Selecionar', 'data-disable-select' => 'true', 'class' => 'form-control select-tipo-grafico') ); ?>
                      <?php echo $this->Form->input("student_id", array('type' => 'hidden', 'value' => $this->request->data['Student']['id']) ); ?>

                          <button type="submit" class="btn btn-default btn-incluir-input btn-block" style="margin-top: 20px;">
                            <i class="fa fa-plus-square"></i> Criar Gráfico
                          </button>

                        <?php echo $this->Form->end(); ?>

                </div>

              <div class="col-md-9">

                <table class="table table-datatable">
                        <thead>
                        <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th>Data de Inserção</th>
                                <th class="actions"><?php echo __('Ações'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($charts as $chart): ?>
                        <tr>
                            <td><?php echo h($chart['Chart']['id']); ?>&nbsp;</td>
                            <td><?php echo h($chart['Chart']['name']); ?>&nbsp;</td>
                            <td><?php echo $this->Html->formatChartType($chart['Chart']['type']); ?>&nbsp;</td>
                            <td><?php $datetime = new DateTime($chart['Chart']['created']); echo $datetime->format("d/m/Y"); ?>&nbsp;</td>
                            <td class="actions">
                                <a href="<?php echo $this->Html->url(array('controller' => 'charts', 'action' => 'edit', $chart['Chart']['id'] )); ?>" class="btn btn-default fancybox">
                                    <i class="fa fa-pencil"></i> Editar
                                </a>
                                <a href="<?php echo $this->Html->url(array('controller' => 'charts', 'action' => 'view', $chart['Chart']['id'] )); ?>" class="btn btn-primary fancybox">
                                    <i class="fa fa-eye"></i> Visualizar
                                </a>
                                <a href="<?php echo $this->Html->url(array('controller' => 'charts', 'action' => 'delete', $chart['Chart']['id'] )); ?>" onclick="if(!confirm('Você tem certeza disto? Esta ação é PERMANENTE!')){ return false; }" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Deletar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                        </tbody>
                        </table>

              </div>
          </div>

    </div>
</div>