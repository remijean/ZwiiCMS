# Zwii 8

Zwii est un CMS sans base de données (Flat-File) qui permet à ses utilisateurs de créer et gérer facilement un site web sans aucune connaissance en programmation.

[Site](http://zwiicms.com/) - [Forum](http://forum.zwiicms.com/) - [GitHub](https://github.com/remijean/ZwiiCMS/)

## Configuration recommandée

* PHP 5.5 ou plus
* Support du .htaccess

## Installation

Décompressez l'archive de Zwii sur votre serveur et c'est tout !

## Procédure de mise à jour de Zwii

* Sauvegardez le dossier "site" de votre serveur
* Supprimez les dossiers et fichiers restants sur votre serveur
* Décompressez la nouvelle version sur votre serveur
* Écrasez le dossier "site" de la nouvelle version celui sauvegardé

**Note : La réécriture des URLS est automatiquement désactivée après une mise à jour. À vous de la réactiver depuis l'interface de configuration du site.**

## Arborescence générale

*Légende : [D] Dossier ; [F] Fichier*

```text
[D] core                   Contient le coeur de Zwii
  [D] layout               Contient les différentes structure de thème
  [D] module               Contient les modules du coeur
  [D] tmp                  Contient les fichiers temporaire
  [D] vendor               Contient les librairies
  [F] core.js.php          Coeur JavaScript de Zwii
  [F] core.php             Coeur PHP de Zwii
[D] module                 Contient les modules de page
[D] site                   Contient données du site
  [D] backup               Contient les 30 dernière sauvegardes automatiques du fichier data.json
  [D] data                 Contient les fichiers de données
    [F] data.json          Fichier de données
    [F] custom.css         Feuille de style de la personnalisation avancée
    [F] theme.css          Thème stocké dans le fichier data.json compilé en CSS
    [D] file               Contient les fichiers envoyés sur le serveur depuis le gestionnaire de fichiers
      [D] source           Contient les fichiers
      [D] thumb            Contient les miniatures des fichiers de type image
[F] index.php              Fichier d'initialisation de Zwii
```

## Structure du fichier de données
```text
{
  "config": {                   // Contient la configuration du site
    "analyticsId": "",          // Id Google Analytics
    "autoBackup": true,         // Sauvegarde automatique des données
    "cookieConsent": true,      // Message de consentement pour les cookies
    "favicon": "",              // Favicon
    "homePageId": "",           // ID de la page d'acceuil
    "metaDescription": "",      // Méta-description
    "social": {                 // Contient les IDs des réseaux sociaux
      "facebookId": "",         // ID Facebook
      "googleplusId": "",       // ID Google+
      "instagramId": "",        // ID Instagram
      "pinterestId": "",        // ID Pinterest
      "twitterId": "",          // ID Twitter
      "youtubeId": ""           // ID Youtube
    },
    "timezone": "",             // Fuseau horaire de l'horodatage
    "title": ""                 // Titre du site
  },
  "core": {                     // Contient des informations utiles au coeur
    "dataVersion": 0,           // Version des données (permet de mettre à jour le fichier de données à chaque nouvelle version de Zwii)
    "lastBackup": 0,            // Horodatage de la dernière sauvegarde
    "lastClearTmp": 0           // Horodatage du dernier nettoyage du dossier temporaire
  },
  "page": {                     // Contient les pages du site
    "example": {                // ID de la page, contient les données de la page
      "content": "",            // Contenu
      "hideTitle": true,        // Cache ou non le titre
      "metaDescription": "",    // Méta-description
      "metaTitle": "",          // Méta-titre
      "moduleId": "",           // ID du module de la page
      "parentPageId": "",       // ID de la page parente
      "position": 1,            // Position de la page dans le menu
      "group": 0,               // Groupe minimum pour accéder à la page
      "targetBlank": true,      // Ouvre ou non la page dans un nouvel onglet
      "title": ""               // Titre
    }
  },
  "module": {                   // Contient les données des modules de page
    "example": {}               // ID de la page, contient les données du module de la page "example"
  },
  "user": {                     // Contient les utilisateurs
    "a": {                      // ID de l'utilisateur, contient les données de l'utilisateur
      "firstname": "",          // Prénom
      "forgot": 0,              // Horodatage de la dernière demande de récupération de mot de passe
      "group": 1,               // Groupe
      "lastname": "",           // Nom
      "mail": "",               // Mail
      "password": ""            // Mot de passe hashé
    }
  },
  "theme": {                    // Contient le thème
    "body": {                   // Thème du fond
      "backgroundColor": "",    // Couleur
      "image": "",              // Image
      "imageAttachment": "",    // Fixation de l'image
      "imageRepeat": "",        // Répétition de l'image
      "imagePosition": "",      // Position de l'image
      "imageSize": ""           // Taille de l'image
    },
    "button": {                 // Thème des boutons
      "backgroundColor": ""     // Couleur
    },
    "footer": {                 // Thème du bas de page
      "backgroundColor": "",    // Couleur
      "copyrightAlign": "",     // Alignement du copyright
      "height": "",             // Hauteur
      "loginLink": true,        // Affichage lien de connexion
      "margin": true,           // Espacement
      "position": "",           // Position
      "socialsAlign": "",       // Alignement des réseaux sociaux
      "text": "",               // Texte
      "textAlign": ""           // Alignement du texte
    },
    "header": {                 // Thème de la bannière
      "backgroundColor": "",    // Couleur du fond
      "font": "",               // Police du texte
      "fontWeight": "",         // Style du texte
      "height": "",             // Hauteur
      "image": "",              // Image de fond
      "imagePosition": "",      // Position de l'image
      "imageRepeat": "",        // Répétition de l'image
      "margin": true,           // Espacement
      "position": "",           // Position
      "textAlign": "",          // Alignement du texte
      "textColor": "",          // Couleur du texte
      "textHide": true,         // Cache ou non le texte
      "textTransform": ""       // Caractère du texte
    },
    "link": {                   // Thème des liens
      "textColor": ""           // Couleur
    },
    "menu": {                   // Thème du menu
      "backgroundColor": "",    // Couleur
      "fontWeight": "",         // Style du texte
      "height": "",             // Hauteur
      "loginLink": true,        // Affiche ou non le lien de connexion
      "margin": true,           // Espacement
      "position": "",           // Position
      "textAlign": "",          // Alignement du texte
      "textTransform": ""       // Caractère du texte
    },
    "site": {                   // Thème du site
      "width": ""               // Largeur
    },
    "text": {                   // Thème du texte
      "font": ""                // Police
    },
    "title": {                  // Thème des titres
      "font": "",               // Police
      "fontWeight": "",         // Style
      "textColor": "",          // Couleur
      "textTransform": ""       // Caractère
    }
  }
}
```