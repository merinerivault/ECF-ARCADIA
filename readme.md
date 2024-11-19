Malheureusement je n'est pas reussi à finir mon projet dans les temps, j'ai eu beaucoup de mal avec la partie Back du projet. Je suis désolé de devoir vous l'envoyer en l'etat.

# Maquettes
https://www.figma.com/design/XkauNVIWS3p0QWiQB7Eiby/Arcadia-maquettes?node-id=0-1&t=AY0GzUoJHjdWHDSm-1

# Arcadia
Site pour un parc zoologique

# Technologies Utilisées

Front-End :
- HTML5 / CSS3
- Bootstrap 5 pour une interface utilisateur responsive et accessible.
- Figma pour le design des maquettes.
Back-End :
- Symfony CLI version 5.10.4 comme framework principal pour le développement du back-end.
- Doctrine ORM pour la gestion des données et des relations dans la base de données.
- Base de Données sur PhpMyAdmin
- MySQL pour stocker les données sur les animaux, les habitats, les utilisateurs, etc.

# Installation

Prérequis : 
- VsCode
- PHP 8.2.12
- Composer
- Symfony CLI (optionnel mais recommandé)
- MySQL ou un autre système compatible avec Doctrine ORM.(Xammpp)

Apres avoir cloner le projet https://github.com/merinerivault/ECF-ARCADIA 

Pour le Front:
Sur VsCode installer les extentions PHP Server et Live Sass Compiler

Activer Watch Sass
Ouvrir index.html avec Php Server

Pour le Back :
- composer require symfony/orm-pack
- composer require --dev symfony/maker-bundle

Lancez en ligne de commande Symfony server:start ou php -S 127.0.0.1:8000 -t public/





