<?php

/**
* Code HTML de base, propre à l'ensemble du site
**/
class DefaultView extends View {
  protected $title;
  protected $JSscripts = array();
  protected $CSSs = array();
  protected $body = '<p>THIS PAGE HAS NOT BEEN IMPLEMENTED YET</p>';
  private $message;
  private $error;

  public function __construct($title = "Projet NF17") {
    $this->title = $title;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function addJSscript($script) {
    array_push($this->JSscripts, $script);
  }

  public function addCSS($css) {
    array_push($this->CSSs, $css);
  }

  public function renderView() {
    $this->showHeader();
    echo $this->body;
    $this->showFooter();
  }

  public function setBody($text) {
    $this->body = $text;
  }

  public function setMessage($message) {
    $this->message = $message;
  }

  public function getMessage() {
    return $this->message;
  }

  public function setError($error) {
    $this->error = $error;
  }

  protected function showHeader() {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0" />
        <link rel="stylesheet" media="all" href="<?= WEB_ROOT ?>/res/css/style.css" />
        <link rel="shortcut icon" href="<?= WEB_ROOT ?>/favicon.ico" />
        <?php
        foreach ($this->JSscripts as $script) {
          echo '<script type="text/javascript" src="'.$script.'" ></script>';
        }
        foreach ($this->CSSs as $css) {
          echo '<link rel="stylesheet" media="all" href="'.$css.'" />';
        }
        ?>
        <title><?= $this->title ?></title>
        <style>
          .root {
            <?php echo $_SESSION['login'] === 'root'?"":"display: none"; ?>
          }
          .employe-contact {
            <?php echo ($_SESSION['login'] instanceof Employe_contact OR $_SESSION['login'] === 'root') ?"":"display: none"; ?>
          }
          .membre-labo {
            <?php echo ($_SESSION['login'] instanceof Membre_labo OR $_SESSION['login'] === 'root') ?"":"display: none"; ?>
          }
        </style>
    </head>
    <body>
      <span id="logout"><a class="must-be-connected" href="<?= WEB_ROOT ?>/logout" title="Se déconnecter">Déconnexion</a><br /><em><?php echo $_SESSION['login']; ?></em></span>
      <header class="center">
        <h1><img src="<?= WEB_ROOT ?>/res/img/pharmacie.gif" /><span>HeudiasX<br /><span>Laboratoire pharmaceutique</span></span></h1>
        <nav>
          <ul>
            <li><a href="<?= WEB_ROOT ?>/">Accueil</a></li>
            <li class="must-be-connected"><a href="#">Création de projet</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/projets/appels">Appels à projets</a>
                  <ul>
                    <li><a class="employe-contact" href="<?= WEB_ROOT ?>/projets/appels/new">Création d'un appel</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/appels">Listing des appels</a></li>
                  </ul>
                </li>
                <li><a href="<?= WEB_ROOT ?>/projets/propositions">Propositions de projet</a></li>
              </ul>
            </li>
            <li class="must-be-connected"><a href="<?= WEB_ROOT ?>/projets">Projets</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/projets">Listing des projets</a></li>
                <li class="membre-labo"><a href="<?= WEB_ROOT ?>/projets/users">Gestion des membres</a>
                  <ul>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/new">Ajout</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/delete">Retrait</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/edit">Modification des droits</a></li>
                  </ul>
                </li>
                <li><a  class="membre-labo" href="<?= WEB_ROOT ?>/projets/depenses">Dépenses</a>
                  <ul>
                    <li><a href="<?= WEB_ROOT ?>/projets/depenses/new">Formulaire de demande</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/depenses">Historique des dépenses</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="must-be-connected"><a href="#">Statistiques</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/stats/projets/depenses?interval=monthly&amp;stats=1">Dépenses de projet</a></li>
                <li><a href="<?= WEB_ROOT ?>/stats/laborantins?interval=monthly&amp;stats=1">Laborantins</a></li>
                <li><a href="<?= WEB_ROOT ?>/stats/projets">Projets</a></li>
              </ul>
            </li>
            <li class="must-be-connected"><a href="<?= WEB_ROOT ?>/search">Recherche</a>
              <ul>
                <li class="root" ><a href="<?= WEB_ROOT ?>/site">Plan du site</a></li>
                <li><a href="<?= WEB_ROOT ?>/search">Recherche par mots-clés</a></li>
                <li><a href="<?= WEB_ROOT ?>/search?option=advanced">Recherche avancée par thème</a></li>
              </ul>
            </li>
            <li class="employe-contact"><a href="#">Maintenance</a>
              <ul>
                <li class="must-be-connected root"><a href="<?= WEB_ROOT ?>/laboratoires/new">Ajouter un laboratoire</a></li>
                <li><a href="<?= WEB_ROOT ?>/financeurs/organismes/new">Ajouter un organisme de projet</a></li>
                <li class="must-be-connected root"><a href="<?= WEB_ROOT ?>/financeurs/new">Ajouter des financeurs</a></li>
              </ul>
            </li>
             <li class="must-be-connected root"><a href="#">Gérer le personnel</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/laboratoires/membres/new">Ajouter un membre de laboratoire</a></li>
        					<ul>
        						<li><a href="<?= WEB_ROOT ?>/membre_labo/users/new">Ajouter un Doctorant</a></li>
        						<li><a href="<?= WEB_ROOT ?>/membre_labo/users/new">Ajouter un Ingenieur</a></li>
        						<li><a href="<?= WEB_ROOT ?>/membre_labo/new?type=enseignant">Ajouter un enseignant</a></li>
        					</ul>
        				</li>
              </ul>
            </li>
          </ul>
        </nav>
      </header>
      <div id="wrapper">
    <?php
    if ($this->message !== NULL) {
      echo "<h3 class='message center'>".$this->message."</h3>";
    }
    if ($this->error !== NULL) {
      echo "<h3 class='error center'>".$this->error."</h3>";
    }

  }

  protected function showFooter() {
    ?>
      </div>
      <footer class="center">
Projet réalisé dans le cadre de l'UV NF17 à l'Université de Technologie de Compiègne - P2015<br />Xuner Huang, Romain Pellerin, Kyâne Pichou, Antoine Rondelet
      </footer>
    </body>
</html>
    <?php
  }

}
