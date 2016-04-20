ZwiiCMS 7
=========

## 7.6.1
* Correction d'un bug bloquant l'enregistrement de la configuration
* Correction d'un bug bloquant l'édition du nom des pages

## 7.6.0
* Ajout de la génération automatique du fichier data.json pour faciliter les mises à jour
* Ajout d'un champ favicon
* Ajout d'un champ afficher/cacher le titre des pages
* Ajout d'une case à cocher "champ obligatoire" dans le générateur de formulaires
* Ajout d'une capcha dans le générateur de formulaires
* Ajout de boutons réseaux sociaux
* Ajout d'un champ pour personnaliser le meta title des pages
* Ajout d'un champ pour ajouter une image de fond
* Ajout d'un champ pour choisir de la police de caractères
* Ajout de commentaires dans le fichier core/layout.html
* Amélioration des colorPickers
* Amélioration de l'interface d'administration
* Amélioration du design des tableaux
* Amélioration de l'affichage des données enregistrées dans le générateur de formulaires
* Amélioration de l'export avec la prise en compte du dossier data/upload
* Amélioration de l'image de la bannière en mode responsive
* Amélioration du design de l'input d'upload
* Correction d'un bug avec les images responsives
* Correction d'un bug bloquant l'enregistrement de la configuration du site
* Correction d'un bug supprimant les pages enfants lorsque la page parente était renommée
* Correction d'une dizaine de bugs mineurs
* Optimisation du coeur
* Optimisation de l'ajout de champ dans le gestionnaire de formulaires
* Réorganisation de l'interface d'édition du thème
* Suppression de la partie "edit/" de l'URL lors de l'édition d'une page

## 7.5.1
* Ajustement de l'espacement des items dans le petit menu
* Correction de bugs mineurs
* Correction d'un bug qui bloquait l'affichage de la bannière en mode édition
* Correction d'un problème d'affichage de l'éditeur de texte dans le gestionnaire de news
* Correction d'un bug d'URL rewriting lorsque l'URL est égale au nom d'un dossier

## 7.5.0
### Attention, data.json et uploads se placent dorénavant dans le nouveau dossier data, par la même occasion uploads est renommé upload (sans le "s").
* Amélioration de la présentation des mails
* Ajout de la notion de pages parentes
* Ajout d'un système de gestion des fichiers temporaires
* Ajout d'un bouton de back to top
* Ajout d'un champ pour modifier le texte du bas de page
* Ajout des balises HTML5 dans le layout
* Optimisation des scripts JS
* Optimisation du chargement des librairies
* Correction d'un problème lors de l'ajout d'une image depuis TinyMCE
* Réorganisation de l'architecture de ZwiiCMS
* Mise à jour de Normalize.css
* Mise à jour de jQuery

## 7.4.4
* Correction d'un bug lors du choix de l'alignement du contenu de la bannière
* Intégration de TinyMCE
* Refonte du système de détection de l'URL rewriting pour corriger des problèmes d'incompatibilités

## 7.4.3
* Suppression des onglets dans le gestionnaire de fichiers
* Correction de la non détection du module d'URL rewriting
* Correction d'une faute d'orthographe et ajout de la page Facebook
* Ajout d'une feuille de style vierge pour la personnalisation avancée
* Ajout de Google Analytics (Merci Yoan Malié)
* Mise à jour et optimisation de la traduction en anglais (Merci Yoan Malié)

## 7.4.2
* Ajout du blanc pour la couleur de fond
* Correction d'un bug qui ne cachait pas le titre du site lorsqu'une image était appliquée à la bannière
* Diminution des px des coins arrondis
* Correction de plusieurs bugs avec l'ajout d'une marge à la bannière et au menu
* Correction d'un problème à l'affichage de l'image de la bannière

## 7.4.1
### Attention, à cause de l'amélioration du thème votre ancienne personnalisation n'est plus compatible, vous devrez simplement la recréer depuis l'administration.
* Ajout d'onglets pour améliorer la navigation
* Amélioration de la personnalisation du thème
* Correction d'une dizaine de bugs mineurs
* Correction d'un problème d'affichage de l'image de la bannière
* Correction d'un bug avec le filtre d'URL
* Correction d'une mauvaise réaction du titre en responsive
* Correction de divers problèmes avec la pagination
* Correction d'un bug lors de l'ajout d'un champ dans le générateur de formulaires

## 7.4.0
### Attention, cette version est incompatible avec les précédentes à cause de la refonte du système de thème !
* Ajout du choix de la largeur du site et refonte du système de thème
* Correction d'un bug bloquant la suppression des pages (merci Zyellyss)
* Mise à jour du copyright
* Ajout de tableaux dans le gestionnaire de fichiers et de news
* Mise à jour de jQuery et jQuery-UI

## 7.3.2
* Correction de la traduction du texte "Mode édition" qui ne fonctionnait pas
* Correction du titre du site qui disparaissait après le changement de couleur de la bannière
* Correction du problème d'affichage des coins arrondis du site

## 7.3.1
* Correction d'une duplication de champ dans le générateur de formulaires
* Correction d'une URL incorrecte pour importer le JS des modules lorsque l'URL Rewriting est activée
* Correction de plusieurs messages d'erreur apparaissant en tant que messages de succès
* Correction du dysfonctionnement de l'aperçu en direct de l'image dans la bannière
* Correction d'un bug empêchant l'ajout de module avec l'URL Rewriting
* Mise à jour du readme

## 7.3.0
* Correction d'un bug du générateur de formulaires avec certains navigateurs
* Amélioration du switch entre le mode édition/public
* Suppression des thèmes
* Ajout d'options de configuration du design (choix des couleurs, image & co)
* Mise à jour de Trumbowyg
* Ajout d'un gestionnaire de fichiers

## 7.2.0
* Correction de plusieurs bugs
* Correction d'un bug de redirections infinies au changement de mode
* Correction d'un bug au changement de mode
* Correction d'un bug qui bloquait le css au survole des checkboxs sous Chrome
* Correction d'erreurs dans les PHPDoc
* Ajout d'un message de confirmation après la suppression du cache
* Ajout d'une page d'exemple de formulaire
* Ajout de l'URL rewriting
* Ajout du support d'autres langues et de la traduction en anglais
* Ajout du module de génération de formulaire et suppression du module de contact
* Ajout de jQuery-UI
* Ajout d'un import de css/js pour les modules
* Ajout d'un aperçu du thème lors de sa sélection
* Ajout du choix du layout à l'affichage des données
* Enregistrement du module des pages en AJAX pour éviter de recharger la page
* Amélioration de la pagination
* Amélioration de champ pour choisir la position de la page dans le menu
* Réécriture du code

## 7.1.6
* Correction du mail de l'expéditeur qui n'était pas utilisé dans le module de contact
* Correction d'un texte
* Correction du mail qui ne s'affiche pas dans le module contact

## 7.1.5
* Correction du bug à la modification du titre d'une news
* Nouveau thème dark_image
* Ajout d'une sauvegarde des données des formulaires en cas d'erreur
* Optimisation de la création des vues
* Administration du module impossible en cas de changement
* Ajout de commentaires dans le .gitignore
* Optimisation des scripts
* Ajustement de la hauteur des textareas
* Ajout des aides au survole
* Ajout d'un helper pour envoyer les mails
* Ajout d'une fonction dans core pour l'auto-chargement des classes
* Mise à jour de Normalize en version 3.0.3
* Nouvelle adresse email de contact
* DocBlock manquante pour la méthode setNotification()

## 7.1.4
* Suppression du PHPSESSID de l'url
* Suppression des mots-clés
* Ajout d'une description par page
* Correction d'une erreur dans le thème vide
* Simplification de l'icône du menu responsive
* Correction d'un bug dans Normalize (merci à Philippe de Boisriou)

## 7.1.3
* Correction de commentaires erronés dans les thèmes
* Nouveau thème "dark"
* Ajout d'un header 404 en cas d'erreur 404
* Mise à jour du PHPDoc des méthodes getRequired() et setRequired()
* Blocage du choix du mode d'affichage dans le module de configuration
* Correction d'un bug bloquant l'ouverture du menu en mode responsive

## 7.1.2
* Correction du bug du double id menu
* Correction d'un bug critique bloquant l'enregistrement des données
* Optimisation du css et du js

## 7.1.1
* Optimisation du css
* Correction du bug de champ requis pour le nouveau mot de passe du module de configuration

## 7.1.0

* Correction d'un bug à la création d'une news sans titre
* Ajout des notifications d'erreur en plus des notifications de succès
* Ajout de notices aux champs des formulaires
* Modification des réactions du responsive
* Correction d'un problème au filtrage de l'id d'une page
* Modification des champs "Nouveau mot de passe" afin de cacher leur contenu
* Ajout du thème "zwii"
* Modification de la page "Exemple de redirection"
* Ajout d'un cache HTML des pages publiques
* Correction du nom du fichier de l'export des données