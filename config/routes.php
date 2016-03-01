<?php

/**
 * Used to define the routes in the system.
 *
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 *
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */

// ROUTES DE BASES DISPONIBLES POUR TOUT LE MONDE
$base_routes = array(
  '/'                             => 'application#index',
  '/tests'                        => 'tests#all',
  '/login'                        => 'application#login',
  '/logout'                       => 'application#logout',

  // Onglet 'Création de projet'
  '/projets/appels'               => 'appelProjet#index', // Listing des appels à projet
  '/projets/propositions'         => 'propositionProjet#index', // Listing des propositions

  // Onglet 'Projet'
  '/projets'                      => 'projet#index', // Listing des projets
  '/projets/depenses'             => 'depenses#index', // Listing des dépenses

  // Onglet 'Recherche'
  '/search'                       => 'application#search',

  // Onglet 'Statistiques'
  '/stats/projets/depenses'       => 'stats#depenses',
  '/stats/laborantins'            => 'stats#participants',
  '/stats/projets'                => 'stats#projets'
);

if (isset($_SESSION['login'])) {
  if ($_SESSION['login'] instanceof Employe_contact) {
    $specific_routes = array(
      // Onglet 'Création de projet'
      '/projets/appels/new'           => 'appelProjet#new', // Créer un appel à projet
      '/projets/appels/delete'        => 'appelProjet#delete', // Supprimer un appel à projet,
      '/projets/new'                  => 'projet#new', // Création d'un projet à partir d'une proposition

      // Onglet 'Projet'
      '/projets/delete'               => 'projet#delete', // Suppression d'un projet

      // Onglet 'Maintenance'
      '/financeurs/organismes/new'    => 'organismeProjet#new'
    );
  } else if ($_SESSION['login'] instanceof Membre_labo) {
    $specific_routes = array(
      // Onglet 'Création de projet'
      '/projets/propositions/new'     => 'propositionProjet#new', // Faire une proposition sur un appel
      '/projets/propositions/delete'  => 'propositionProjet#delete', // Supprimer une proposition sur un appel

      // Onglet 'Projet'
      '/projets/delete'               => 'projet#delete', // Suppression d'un projet
      '/projets/depenses/new'         => 'depenses#new', //Formulaire d'ajout d'une dépense
      '/projets/users'                => 'user#index',
      '/projets/users/new'            => 'user#new',
      '/projets/users/delete'         => 'user#delete',
      '/projets/users/edit'           => 'user#edit'
    );
  } else if ($_SESSION['login'] === 'root') {
    $specific_routes = array(
      // Onglet 'Création de projet'
      '/projets/appels/new'           => 'appelProjet#new', // Créer un appel à projet
      '/projets/appels/delete'        => 'appelProjet#delete', // Supprimer un appel à projet,
      '/projets/propositions/new'     => 'propositionProjet#new', // Faire une proposition sur un appel
      '/projets/propositions/delete'  => 'propositionProjet#delete', // Supprimer une proposition sur un appel
      '/projets/new'                  => 'projet#new', // Création d'un projet à partir d'une proposition

      // Onglet 'Projet'
      '/projets/delete'               => 'projet#delete', // Suppression d'un projet
      '/projets/depenses/new'         => 'depenses#new', //Formulaire d'ajout d'une dépense
      '/projets/users'                => 'user#index',
      '/projets/users/new'            => 'user#new',
      '/projets/users/delete'         => 'user#delete',
      '/projets/users/edit'           => 'user#edit',

      // Onglet 'Recherche'
      '/site'                         => 'application#planSite',

      // Onglet 'Maintenance'
      '/laboratoires'                 => 'laboratoire#index',
      '/laboratoires/new'             => 'laboratoire#new',
      '/financeurs'                   => 'financeur#index',
      '/financeurs/new'               => 'financeur#new',
      '/entites_juridiques/delete'    => 'entite_juridique#delete',
      '/financeurs/organismes'        => 'organismeProjet#index',
      '/financeurs/organismes/new'    => 'organismeProjet#new',
      '/financeurs/organismes/delete' => 'organismeProjet#delete',

      //Onglet Gerer le personnel
      '/laboratoires/membres'         => 'membre_labo#index',
      '/laboratoires/membres/new'     => 'membre_labo#new',
      '/laboratoires/membres/delete'  => 'membre_labo#delete'
    );
  } else {
    $specific_routes = array();
  }
}
else {
  $_SESSION['login'] = NULL;
  $specific_routes = array();
}

$routes = array_merge($base_routes,$specific_routes);
