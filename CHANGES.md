ZwiiCMS 7
=========

## 7.3.1
* Correction d'une duplication de champ dans le générateur de formulaires
* Correction d'une URL incorrecte pour importer le JS des modules lorsque l'URL Rewriting est activée
* Correction de plusieurs messages d'erreur apparaissant en tant que messages de succès
* Correction du disfonctionnement de l'aperçu en direct de l'image dans la bannière
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