<div class=container>
<div class=card>
  <div class=card-block>
    <h1 class=card-title>Modifier le compte</h1>
    <?php echo $this->Form->create('BoostCake', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>
	<fieldset>
		<legend>Legend</legend>
		<?php echo $this->Form->input('text', array(
			'label' => 'Label name',
			'placeholder' => 'Type something…',
			'after' => '<span class="help-block">Example block-level help text here.</span>'
		)); ?>
		<?php echo $this->Form->input('checkbox', array(
			'label' => 'Check me out',
			'class' => false
		)); ?>
		<?php echo $this->Form->submit('Submit', array(
			'div' => 'form-group',
			'class' => 'btn btn-default'
		)); ?>
	</fieldset>
<?php echo $this->Form->end(); ?>
      <?php
          echo $this->Form->create($player);
          echo $this->Form->input('email', ['class'=>'form-group']);
          echo $this->Form->input('password');
          echo $this->Form->button(__('Sauvegarder les informations'), array('class' => 'btn btn-success'));
          echo $this->Form->end();
      ?>
  </div>
</div>
</div>
