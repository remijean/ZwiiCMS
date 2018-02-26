# Zwii 8

Zwii est un CMS sans base de données (Flat-File) qui permet à ses utilisateurs de créer et gérer facilement un site web sans aucune connaissance en programmation.

[Site](http://zwiicms.com/) - [Forum](http://forum.zwiicms.com/) - [GitHub](https://github.com/remijean/ZwiiCMS/)

## Configuration recommandée

* PHP 5.6 ou plus
* Support du .htaccess

## Installation

Décompressez l'archive de Zwii sur votre serveur et c'est tout !

## Procédure de mise à jour de Zwii

**Note : La réécriture des URLS est automatiquement désactivée après une mise à jour. À vous de la réactiver depuis l'interface de configuration du site.**

### Mise à jour automatique

* Connectez vous à votre site,
* Allez dans l'interface de configuration,
* Cliquez sur le bouton "Mettre à jour".

### Mise à jour manuelle

* Sauvegardez le dossier "site" de votre serveur,
* Décompressez la nouvelle version sur votre serveur,
* Remplacez le dossier "site" de la nouvelle version par le votre.

## Arborescence générale

*Légende : [D] Dossier ; [F] Fichier*

```text
[D] core                   Contient le coeur de Zwii
  [D] layout               Contient les différentes structure de thème
  [D] module               Contient les modules du coeur
  [D] vendor               Contient les librairies
  [F] core.js.php          Coeur JavaScript de Zwii
  [F] core.php             Coeur PHP de Zwii
[D] module                 Contient les modules de page
[D] site                   Contient les données du site
  [D] backup               Contient les 30 dernière sauvegardes automatiques du fichier data.json
  [D] data                 Contient les fichiers de données
    [F] data.json          Fichier de données
    [F] custom.css         Feuille de style de la personnalisation avancée
    [F] theme.css          Thème stocké dans le fichier data.json compilé en CSS
  [D] file                 Contient les fichiers envoyés sur le serveur depuis le gestionnaire de fichiers
    [D] source             Contient les fichiers
    [D] thumb              Contient les miniatures des fichiers de type image
  [D] tmp                  Contient les fichiers temporaire
[F] index.php              Fichier d'initialisation de Zwii
```