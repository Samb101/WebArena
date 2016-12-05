<div class=container>
<div class=card>
  <div class=card-block>
    <h1 class=card-title>Modifier le compte</h1>
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
