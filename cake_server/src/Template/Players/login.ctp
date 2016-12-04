<!-- File: src/Template/Articles/connect.ctp -->
<div class=container>
  <div class=row>
    <div class=col-lg-6>
      <h2>Connexion</h2>
      <div class=card>
        <div class=card-block>
          <div class=input-group>
            <?php
            echo $this->Form->create('Login',array(
              'url' => array(
                'controller' => 'players',
                'action' => 'login'
              )
            ));
            echo $this->Form->input('email',array('class' => 'form-control','type' => 'email','label' => 'Adresse email :'));
            echo $this->Form->input('password', array('type' => 'password', 'label' => 'Mot de passe :'));
            echo $this->Form->button(__("Connexion"), array('class'=>'btn btn-primary'));
            echo $this->Form->end();
            ?>
          </div>
        </div>
      </div>
    </div>

    <div class=col-lg-6>
      <h2>S'inscrire</h2>
      <div class=card>
        <div class=card-block>
          <?php
          echo $this->Form->create('Registration',array(
            'url' => array(
              'controller' => 'players',
              'action' => 'add'
            )
          ));
          echo $this->Form->input('email',array('type' => 'email','label' => 'Adresse email :'));
          echo $this->Form->input('password', array('type' => 'password', 'label' => 'Mot de passe :'));
          echo $this->Form->input('password', array('type' => 'password', 'label' => 'Confirmez le mot de passe :'));
          echo $this->Form->button(__("Créer le compte"),array('class'=>'btn btn-success'));
          echo $this->Form->end();
          ?>

        </div>
      </div>
    </div>

  </div>
</div>
