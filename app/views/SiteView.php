<?php

class SiteView extends DefaultView {

  public function __construct($title = "Site map") {
    parent::setTitle($title);
  }

 
  
  public function renderView() {
    $this->addCSS(WEB_ROOT.'/res/css/map.css');
    parent::showHeader();
    echo "<h2>".$this->title."</h2>"; ?>
    <div class="sitemap">
    <ul id="primaryNav" class="col">
      <li id="home"><a href="/nf17/">Accueil</a></li>
      <li><a href="#">Création de projet</a>
                  <ul>
                <li><a href="<?= WEB_ROOT ?>/projets/appels">Appels à projets</a>
                  <ul>
                    <li><a href="<?= WEB_ROOT ?>/projets/appels/new">Création d'un appel</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/appels">Listing des appels</a></li>
                  </ul>
                </li>
                <li><a href="<?= WEB_ROOT ?>/projets/propositions">Propositions de projet</a></li>
              </ul>
            </li>
            <li><a href="<?= WEB_ROOT ?>/projets">Projets</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/projets">Listing des projets</a></li>
                <li><a href="<?= WEB_ROOT ?>/projets/users">Gestion des membres</a>
                  <ul>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/new">Ajout</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/delete">Retrait</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/users/edit">Modification des droits</a></li>
                  </ul>
                </li>
                <li><a href="<?= WEB_ROOT ?>/projets/depenses">Dépenses</a>
                  <ul>
                    <li><a href="<?= WEB_ROOT ?>/projets/depenses/new">Formulaire de demande</a></li>
                    <li><a href="<?= WEB_ROOT ?>/projets/depenses/history">Historique des dépenses</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#">Statistiques</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/stats/projets/depenses?interval=monthly&amp;stats=1">Dépenses de projet par mois</a></li>
                <li><a href="<?= WEB_ROOT ?>/stats/laborantins?interval=monthly&amp;stats=1">Meilleurs laborantins du mois</a></li>
                <li><a href="<?= WEB_ROOT ?>/stats/projets">Projets</a></li>
              </ul>
            </li>
            <li><a href="<?= WEB_ROOT ?>/search">Recherche</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/site">Plan du site</a></li>
                <li><a href="<?= WEB_ROOT ?>/search">Recherche par mots-clés</a></li>
                <li><a href="<?= WEB_ROOT ?>/search?option=advanced">Recherche avancée par thème</a></li>
              </ul>
            </li>
            <li><a href="<?= WEB_ROOT ?>/search">Maintenance</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/laboratoires/new">Ajouter un laboratoire</a></li>
                <li><a href="<?= WEB_ROOT ?>/financeurs/organismes/new">Ajouter un organisme de projet</a></li>
                <li><a href="<?= WEB_ROOT ?>/financeurs/new">Ajouter des financeurs</a></li>
              </ul>
            </li>
             <li><a href="<?= WEB_ROOT ?>/search">Gérer le personnel</a>
              <ul>
                <li><a href="<?= WEB_ROOT ?>/site">Ajouter un membre de laboratoire</a>
                 <ul>
                   <li><a href="<?= WEB_ROOT ?>/membre_labo/users/new">Ajouter un Doctorant</a></li>
                   <li><a href="<?= WEB_ROOT ?>/membre_labo/users/new">Ajouter un Ingenieur</a></li>
                   <li><a href="<?= WEB_ROOT ?>/membre_labo/new?type=enseignant">Ajouter un enseignant</a></li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
    </div>
    <?php
    parent::showFooter();
  }
}