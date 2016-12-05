<div class="container">
  <!-- Premier deck de Cards -->
  <div class="card-deck-wrapper">

    <!-- Wrapper première ligne -->
    <div class="card-deck">

      <!-- Deck première ligne -->
      <!-- Première Card "Bienvenue" -->
      <div class="card jumbotron">

        <h3 class="display-5">Bienvenue sur l'interface de votre personnage</h3>
        <p class="lead">C'est un véritable tableau de bord qui s'offre à vous.</p>
        <a class="btn btn-success" href="#" id="show_regles" role="button">Apprendre à jouer</a>

        <hr class="my-2">

        <p>Vous pouvez créer un nouveau personnage, le renommer à bon escient, et choisir d'intégrer une guilde.</p>
        <p class="lead">
          <a class="btn btn-primary btn-lg" href="../guilds/view" role="button">Voir les guildes</a>
        </p>
      </div>

      <!-- Deuxième Card "Ajouter un Combattant" -->
      <div class="card">
        <div class=card-block>
          <h3 class=card-title>Ajouter un combattant</h3>
          <?php
          // entrées : nom, id_portrait choisi, guilde
          echo $this->Form->create('CreateFighter',array(
            'url' => array(
              'controller' => 'players',
              'action' => 'createFighter'
            )
          ));
          echo $this->Form->input('name',array('type' => 'text','label' => 'Nom :'));
          echo $this->Form->input('add_portrait',array('type' => 'hidden'));
          ?>
          <label for="guild_id">Guilde :</label>

          <!-- Choix guilde -->
          <select name="guild_id">
            <?php foreach($guilds as $guild): ?>
              <option value=<?= $guild->id ?>><?= $guild->name ?></option>
            <?php endforeach; ?>
          </select>

          <br/>
          <br/>
          <br/>

          <!-- Choix avatar -->
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Choississez un avatar
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

              <!-- Utilisation d'un for pour une banque de 18 portraits. -->
              <?php for($i=1;$i<18;$i++){ ?>
                <a class="col-lg-4" href="#"><img alt="Portraits" src="../webroot/img/portrait_modele/portrait_<?php echo $i;?>.png"  id="<?php echo $i;?>"class="takePortrait"></a>
                <?php }?>
              </div>
            </div>
            <br/>

            <!-- Balise tampon en attente d'un portrait pour prouver la sélection -->
            <img src="" name="add_modele" alt="Votre portrait" class=col-lg-4>

            <br/>
            <br/>
            <br/>

            <?php
            // fin du formulaire d'ajout
            echo $this->Form->button(__("Ajouter un combattant"), array('class' => 'btn btn-success'));
            echo $this->Form->end();
            ?>
          </div>
        </div>

        <!-- Première Card "Top Ladder" -->
        <!-- Montre les joueurs les plus haut niveaux -->
        <div class=card>
          <div class="card-block">
            <h3 class=card-title>Top Ladder
              <small class="text-muted">
                <br/>Attention à ceux là.
              </small></h3>
            </div>
            <div class=card-block>
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

                <!-- Carousel qui classe les joueurs avec les plus LVL -->
                <div class="carousel-inner" role="listbox">
                  <?php
                  $i=0;
                  foreach($others_fighters as $fighter): ?>
                  <div class="carousel-item <?php if($i==0){echo "active";}?>">
                    <img class=image-center src="../webroot/img/portrait_fighters/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                    <p class=text-center><?= $fighter->name ?> - LVL <?= $fighter->level?></p>
                  </div>
                  <?php $i++;endforeach;?>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="icon-prev" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="icon-next" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>

            <!-- Affichage en liste des joueurs les plus hauts niveaux -->
            <ul class="list-group list-group-flush no-margin-left" >
              <?php
              $i=1;
              foreach($others_fighters as $fighter): ?>
              <li class="list-group-item">
                <img src="../webroot/img/ranks/PVPRank<?php echo 15-$i; ?>.png" class="carac-img" alt="Grade PVP"/>
                <?php echo $i ."."; ?>         <?= $fighter->name ?>
                - LVL    <?= $fighter->level ?>
              </li>
              <?php $i++; endforeach; ?>
            </ul>
          </div>

          <!-- Fermeture 1er Card Deck -->
      </div>
        <!-- Fermeture 1er Card Deck Wrapper -->
 </div>


<!-- Début Second Deck "Vos personnages" -->
  <ol class="breadcrumb no-margin-left">
    <li class="breadcrumb-item active">Vos personnages</li>
  </ol>

      <!-- Second Deck "Vos personnages"-->
  <div class=card-deck-wrapper>
      <div class=card-deck>
          <?php foreach($fighters as $fighter):
            // input de la modification du personnage : nom, id_portrait, guild_id
            echo $this->Form->create('UpdateName',array(
              'url' => array(
                'controller' => 'players',
                'action' => 'editFighter'
              ),
              'class' => ['']
            ));?>
            <!-- Card Personnage générée -->
            <div class="card">
              <div class="card-block">
                <div class=card-title>

                  <!-- Titre : nom du personnage-->
                  <h3 class=""><img class="" src="../webroot/img/portrait_fighters/portrait_<?= $fighter->id ?>.png" alt="Icône de personnage" />
                    <?= $fighter->name ?>
                    <small class="text-muted">
                      - LVL <?= $fighter->level ?>
                    </small>
                  </h3>
                </div>

                <!-- Barre d'XP -->
                <div class="text-xs-center" id="example-caption-1">XP <?= $fighter->xp ?></div>
                <progress class="progress" value="<?= $fighter->xp%4?>" max="4" aria-describedby="example-caption-1"></progress>
                <?php
                echo $this->Form->input('name',array('type' => 'text', 'label' => false , 'class' => 'form-control','value' => $fighter->name, 'aria-describedby'=>'basic-addon1'));
                echo $this->Form->input('fighterId',array('type' => 'hidden','value' => $fighter->id));
                echo $this->Form->input('id_portrait', array( 'type' => 'hidden','id' => $fighter->name));
                ?>
              </div>

              <!-- Liste des caractéristiques -->
              <ul class="list-group list-group-flush no-margin-left">
                <li class="list-group-item">
                  <img alt="Portraits" src="../webroot/img/portrait_modele/portrait_example.png" class="" id="change_modele_<?= $fighter->name ?>"/>
                  <a class="dropdown-toggle" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Changer d'avatar
                  </a>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <!-- Le dropdown contient les 18 portraits sélectionnables -->
                    <?php for($i=1;$i<18;$i++){ ?>
                      <a class="col-lg-3" href="#"><img alt="Portraits" src="../webroot/img/portrait_modele/portrait_<?php echo $i;?>.png"  class="changePortrait" name="<?= $fighter->name?>"id="<?php echo $i;?>" ></a>
                      <?php }?>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_sight ?></span>
                    <img alt="Vue" src="../webroot/img/caracteristiques/view.png" class=""/>
                    Distance de vue
                  </li>
                  <li class="list-group-item">
                    <span class="tag tag-default tag-pill float-xs-right"><?= $fighter->skill_strength ?></span>
                    <img alt="Santé" src="../webroot/img/caracteristiques/health.png" class=""/>
                    Santé
                  </li>
                  <li class="list-group-item">
                    <span class="tag tag-default tag-pill float-xs-right"> <?= $fighter->skill_health ?></span>
                    <img alt="Force" src="../webroot/img/caracteristiques/attack.png" class=""/>
                    Force
                  </li>
                  <li class="list-group-item">
                    <img alt="Guilde" class=image-center src="../webroot/img/tabard_guilde/guild_<?php foreach($guilds as $guild):?><?php if($guild->id==$fighter->guild_id){echo $guild->id;}endforeach;?>.png">
                      <div class=text-center><?php foreach($guilds as $guild):?>
                        <?php if($guild->id==$fighter->guild_id){
                          echo $guild->name;
                        }
                      endforeach;?>
                    </div>
                  </li>
                </ul>

                <!-- Guilde du personnage -->
                <div class=card-block>
                  <div class="form-group">
                    <select name="guildId" class="form-control">
                      <?php foreach($guilds as $guild): ?>
                        <option value=<?= $guild->id ?> <?php if($guild->id==$fighter->guild_id){ echo 'selected'; }?>><?= $guild->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <!-- Boutons d'envoi et de fin du formulaire de modifcation de personnage -->
                  <div class="card-link">
                    <div class="btn-group" role="group" aria-label="Basic example">

                      <?php
                      echo $this->Form->button(__("Sauvegarder"), array('class' => 'btn btn-success col-lg-6'));
                      echo $this->Html->link(__("Supprimer"), ['controller' => 'players', 'action' => 'removeFighter', $fighter->id], array('class' => 'btn btn-danger col-lg-6'));
                      echo $this->Form->end();
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <!-- Fin 2nd Card Deck -->
      </div>
          <!-- Fin du deuxième Deck des personnages -->
 </div>

<hr>


        <!-- Dernière partie Les Règles -->
  <ol class="breadcrumb no-margin-left">
    <li class="breadcrumb-item active">Rappel des règles</li>
  </ol>

        <!-- Navbar du scrollspy -->
  <div id="regles">
   <nav id="mytarget" class="navbar navbar-light bg-faded">
      <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="#deroulement">Déroulement de la partie</a></li>
        <li class="nav-item"><a class="nav-link" href="#deplacements">Déplacements et raccourcis</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Règles de combat et Bugs</a>
          <div class="dropdown-menu">
            <a class="dropdown-item active" href="#attaquer">Attaquer</a>
            <a class="dropdown-item" href="#two">Défendre</a>
            <div role="separator" class="dropdown-divider"></div>
            <a class="dropdown-item" href="#probleme">Un problème ?</a>
          </div>
        </li>
      </ul>
    </nav>
    </div>

<!-- Le texte qui est Scrollspy -->
<div data-spy="scroll" data-target="#mytarget" data-offset="0" class="scrollspy-example">
  <div class=container>
    <h2> Scénario que l'on vous propose </h2>
    <p> Créer un ou des joueurs sur cette page. </p>
    <p> Créer une ou des guildes dans l'onglet Guildes. </p>
    <p> Revenir sur cette page et attribuez une guilde à chacun de vos personnages </p>
    <p> Allez sur le jeu et suivre ce texte. </p>
    <h2 id="deroulement">Déroulement de la partie</h2>
    <p>Vous pouvez créez des personnages sur cette page et ainsi composer une Armée.</p>
    <p>La puissance des personnages est définie par trois caractéristiques :</p>
    <ul>
      <li>
        <img alt="Force" src="../webroot/img/caracteristiques/attack.png" class=""/>
        Force : le nombre de vie que vous enlevez à l'adversaire en cas d'attaque réussie.</li>
        <li>
          <img alt="Force" src="../webroot/img/caracteristiques/health.png" class=""/>
          Santé : PV que vous possédez. Lorque qu'ils tombent à 0, votre Fighter est mort et...</li>
          <li>
            <img alt="Force" src="../webroot/img/caracteristiques/view.png" class=""/>
            Distance de vue : c'est la portée en case que votre boule de feu possède.</li>
          </ul>
          <p>Au début de la partie un de vos personnage vous est attribué.
          <p>Vous pouvez sélectionner à tout moment le personnage que vous souhaitez jouer sur le damier dans la colonne "Armée".</p>
          <p>Vous commencez à une position X Y sur le plateau, et la partie commence.</p>
          <p>Le but du jeu est d'éliminer les autres ennemis du plateau, joués par d'autres utilisateurs du site.</p>
          <p>A chaque niveau vous gagnez 1 point pour améliorer l'une de vos tros caractéristiques.
          </p>
          <h2 id="deplacements">Déplacements et raccourcis</h2>
          <p>Z pour avancer.</p>
          <p>E pour pivoter vers la droite.</p>
          <p>A pour pivoter vers la gauche.</p>
          <p>K et L pour pivoter la caméra et ainsi mieux voir vos tirs</p>
          <p>I dézoomer, O zoomer</p>
          <p>P monter la caméra, M baisser la caméra </p>
          <p>Des pièges sont sur la carte il y en a trois types</p>
          <ul>
            <li>Piège visible : constitue uniquement un obstacle</li>
            <li>Piège invisible : il avertit par un message textuel</li>
            <li>Piège invisible détruisable avec un tir : vous pouvez le détruire.</li>
          </ul>
          <h2>Règles de comnbat</h2>
          <h4 id="attaquer">Attaquer</h4>
          <p>Appuyez sur S pour tirer des boules de feu.</p>
          <h4 id="defendre">Défendre</h4>
          <p>Avec un peu de chance, l'adversaire ratera son coup.</p>
          <h2 id="probleme">Bugs</h2>
          <h4>Refresh parfois nécessaire </h2>
          <p>  Lors de la modification de l'image de portrait un refresh de la page est parfois nécessaire. </p>
          <h4>Après la suppression de guilde </h4>
          <p>Les fighters de la guilde supprimée ne retrouvent sans guilde.</p>
          <h4>L'attribution d'une guilde à un personnage peut faire "sauter" son image de portrait</h4>
          <p> Bug étonnant ... </p>
          <h2 id="probleme">Un problème ?</h2>
          <p>N'hésitez pas à contacter e.maincourt@gmail.com il vous répondra dans les plus brefs délais.</p>
    </div>
</div>

              <!-- Fermeture container -->
            </div>

            <!-- Fonctions JS -->
            <script>
            $(document).ready(function() {
              //effet jquery scroll to sur le bouton "Apprendre à jouer"
              $("#show_regles").click(function() {
                $('html, body').animate({
                  scrollTop: $("#regles").offset().top
                }, 2000);
              });

              //masque la balise image tampon lors de la sélection de portrait pour un nouveau personnage
              $("img[name=add_modele]").hide();


              //traitement du portrait pris pour le mettre dans un input du formulaire généré en cakePHP
              $(".takePortrait").click(function() {
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

              //pareil mais pour la modification
              $(".changePortrait").click(function() {
                event.preventDefault();
                var $this = $(this);
                var id_img = $this.attr('id');
                var name = $this.attr('name');
                var src = $this.attr('src');
                console.log(id_img);
                console.log(name);
                console.log(src);
                $("input[id="+name+"]").attr("value", id_img);
                $("img[id=change_modele_"+name+"]").attr("src", src);
                return;
              });
            });

            </script>
