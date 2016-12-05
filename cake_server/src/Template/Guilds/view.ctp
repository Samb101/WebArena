<h1>
  Guildes
  <!-- Bouton scrollTo jquery jusqu'au jumbotran Ajouter une guilde -->
  <button  class="btn btn-outline-success" id="show_add"> + </button>
</h1>

<div class=container>
<?php
  foreach($guilds as $guild) {
   if($guild->name!=""){ ?>
    <!-- pour chaque guilde on généré un Card Columns -->
    <div class="row">
      <ol class="breadcrumb no-margin-left" >
        <li class=breadcrumb-item><?= $guild->name ?></h2></li>
      </ol>
    </div>
    <div class=card-columns>

      <!-- Première card avec le logo et les options pour la guilde -->
      <div class="card jumbotron">
        <h3 class="display-5 text-center"><?= $guild->name ?></h3>
        <img  name="guild_<?= $guild->name?>" src="../webroot/img/tabard_guilde/guild_<?= $guild->id ?>.png" alt="<?= $guild->name ?>" class="image-center">
        <hr class="my-2">
        <p class="lead">
        
        </p>
        <p class="lead">
        <?php
          echo $this->Html->link(__("Supprimer"), ['controller' => 'guilds', 'action' => 'removeGuild', $guild->id], array('class' => 'btn btn-danger col-lg-6'));
          ?>
      </p>
    </div>

      <!-- Card des personnages de la guilde -->
      <?php foreach($guild->fighters as $fighter){ ?>
        <div class=card>

          <!-- Le nom du personnage et son niveau -->
          <div class=card-block>
            <div class=card-title>
              <h3 class=""><img class="" src="../webroot/img/portrait_fighters/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                <?= $fighter->name ?>
              </h3>
            </div>
            <p class="text-center font-weight-bold"> LVL  <?= $fighter->level?></p>
          </div>

          <!-- Liste des caractéristiques du personnage -->
              <ul class="list-group list-group-flush no-margin-left">
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_sight ?></span>
                  <img src="../webroot/img/caracteristiques/view.png" class=""/>
                  Distance de vue
                </li>
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
                  <img src="../webroot/img/caracteristiques/health.png" class=""/>
                  Santé
                </li>
                <li class="list-group-item">
                  <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
                  <img src="../webroot/img/caracteristiques/attack.png" class=""/>
                  Attaque
                </li>
              </ul>
              <!-- Fermeture Card -->
            </div>
      <?php }?>
    </div><!-- Fermeture Card Columns -->
<?php  } }?>
<hr  id="add_g">
<div class="col-lg-12 jumbotron">
  <?php echo $this->Form->create('CreateFighter',array(
    'url' => array(
      'controller' => 'guilds',
      'action' => 'createGuild'
    )
  ));
  ?>
      <h3 class="display-5">Ajouter une guilde</h3>
      <p class="lead">Choississez votre tabard et créez votre guilde pour pouvoir jouer entre amis !</p>
      <p class=text-muted>Elle ne sera pas affichée tant qu'aucun Fighter ne l'aura rejoint depuis le Tableau de bord. </p>
      <hr class="my-2">

      <!-- Input du formulaire d'ajout de guilde -->
      <?php
      echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :'));
      echo $this->Form->input('add_portrait',array('type' => 'hidden'));
      ?>

      <!-- DropUp Bouton pour choisir un nouveau tabard -->
      <div class="btn-group dropup">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Choisir un tabard</button>
          <div class="dropdown-menu">
            <?php for($i=1;$i<11;$i++){ ?>
              <a class="col-lg-5" href="#"><img alt="Tabard de Guilde"  id="<?php echo $i;?>" class="takeTabard" src="../webroot/img/tabard_modele/guild_<?php echo $i;?>.png" ></a>
              <?php }?>
          </div>
      </div>
      <br/>
      <br/>

      <!-- Balise tampon en attente d'un portrait pour prouver la sélection -->
      <p class=lead>
        <img src="" name="add_modele" alt="Votre tabard" style="display:block;">
      </p>

      <!-- Fin formulaire ajout de guilde -->
      <p class=lead>
          <?php
          echo $this->Form->button(__("Ajouter une guilde"), array('class' => 'btn btn-success'));
          echo $this->Form->end();
          ?>
      </p>

    </div><!-- Fin du jumbotron d'ajout de guilde -->

</div><!-- Fermeture Container -->

<script>
$(document).ready(function() {
  $("img[name=add_modele").hide();

  //effet jquery scroll to sur le bouton "Apprendre à jouer"
  $("#show_add").click(function() {
    $('html, body').animate({
      scrollTop: $("#add_g").offset().top
    }, 1000);
  });

  //choix du tabard pour une nouvelle ligne
  $(".takeTabard").click(function() {
    event.preventDefault();
    var $this = $(this);
    var id_img = $this.attr('id');
    var src = $this.attr('src');
    console.log(id_img);
    console.log(src);
    $("input[name=add_portrait]").attr("value", id_img);
    $("img[name=add_modele").attr("src", src);
    $("img[name=add_modele").show();
    return;
  });


});

</script>
