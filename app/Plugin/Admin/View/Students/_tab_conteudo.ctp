<div role="tabpanel" class="tab-pane" id="conteudo">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<?php foreach($atores as $a) : ?>
	  	<li><a href="#<?php echo strtolower($a); ?>" role="tab" data-toggle="tab"><?php echo $a; ?></a></li>
		<?php endforeach; ?>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php foreach($atores as $a) : ?>
		<div role="tabpanel" class="tab-pane" id="<?php echo strtolower($a); ?>">

      <table class="table">
          <thead>
            <tr>
              <th>
                Input
              </th>
              <th>
                Ações
              </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($inputs as $i) : ?>
            <tr>
              <td>
                <?php echo $i["Input"]["name"]; ?>
              </td>
              <td>
                <a href="<?php echo $this->Html->url( array("controller" => "students", "action" => "add_input", $i["Input"]["id"], $this->request->data["Student"]["id"], strtolower($a) ) ); ?>" class="btn btn-default">
                  Adicionar
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

			<?php foreach($student_inputs as $si) : ?>

				<ul class="list-group">
				<?php if($si["StudentInput"]["actor"] == strtolower($a)) : ?>
					<li class="list-group-item">
						<strong><?php echo $si["StudentInput"]["name"]; ?> <small style="color: #999;"><?php echo $si["Input"]["name"]; ?></small></strong>

            <?php if($si["Input"]["id"] == $this->Html->getInputId("Escala Numérica") ) : ?>
                <span class="label label-default" style="margin-right: 4px;">
                  De <?php echo $si["StudentInput"]["config"]["range_start"]; ?> 
                  a <?php echo $si["StudentInput"]["config"]["range_end"]; ?> 
                </span>
            <?php endif; ?>

            <?php if(!empty($si["StudentInput"]["config"]) && $si["Input"]["id"] == $this->Html->getInputId("Escala Texto") ) : ?>
                <?php foreach($si["StudentInput"]["config"] as $c) : ?>
                <span class="label label-default" style="margin-right: 4px;">
                  <?php echo $c["name"]; ?> 
                </span>
                <?php endforeach; ?>
            <?php endif; ?>

						<a href="<?php echo $this->Html->url( array("controller" => "students", "action" => "delete_student_input", $si["StudentInput"]["id"], $this->request->data["Student"]["id"]) ); ?>" class="btn btn-danger pull-right">
							<i class="fa fa-trash"></i>
						</a>

						<div class="clearfix"></div>
					</li>
				<?php endif; ?>
				</ul>

			<?php endforeach; ?>
		</div>
		<?php endforeach; ?>
	</div>

</div>