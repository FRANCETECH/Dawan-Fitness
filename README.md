# Application web Salle de sport - STUDI

## Description du projet

Evaluation en cours de formation pour l'école STUDI. Une grande salle de sport souhaite gérer des droits d'accès à une application web pour ses entreprises franchisées qui possèdent des salles de sport. Vous pouvez accéder au site web à cette [adresse][1], mais vous aurez besoin d'un identifiant et d'un mot de passe que vous trouverez dans le "manuel d'utilisaton" qui est dans le dossier "documentation".

### Utilisateur non connecté :
* Accès à la page login

### Manager connecté :
* Voir ses informations personnelles
* Voir les permissions globales
* Voir les informations de sa structure et les permissions liées
* Recherchez un utilisateur ou une structure

### Partenaire connecté :
* Voir ses informations personnelles
* Voir les permissions globales
* Voir les informations de sa (ses) structure(s) et les permissions liées
* Recherchez un utilisateur ou une structure

### Equipe technique de la marque connecté (administrateur) :
* Création :
    * Utilisateur
        * Manager
        * Partenaire
        * Equipe technique
    * Structure
    * Permission
    * Ajout d'une permission à un utilisateur
    * Ajout d'une permission à une structure

* Gestion : 
    * Utilisateur
        * Modifier
        * Supprimer
        * Désactiver/activer
    * Structure
        * Modifier
        * Supprimer
        * Désactiver/activer
    * Permission
        * Modifier
        * Supprimer
        * Désactiver/activer

* Recherchez un utilisateur ou une structure
## Les langages utilisés
| BACK | FRONT |
|:-:|:-:|
| Symfony 6.1 | html5 |
| php 8.1 | css3 |
| twig | sass |
| MySql | javaScript |

## Lancer le projet localement

Si vous souhaitez installer le projet sur votre ordinateur pour le tester en local, il faudra :

### Vérifier que vous avez bien les pré-requis ou les installer
* Vérifier que PHP est bien installé sur votre ordinateur. Pour vérfier cela, il suffit de taper cette commande dans le terminal et de lire le résultat.
    ```bash
        php -v
    ```
    Sinon vous pouvez l'installer à partir de [cette page][6].

* Vérifier que composer est bien installé.
    ```bash
        composer -v
    ```
    Sinon vous pouvez l'installer en allant sur [cette page][7].

* [Installer Symfony CLI][2].
* Enfin, vous aurez besoin d'installer une base de données (j'ai utilisé [mysql][3] dans ce projet).

### Récupérer le projet et le copier sur votre ordinateur
* Cloner le projet
    ```bash
        git clone https://github.com/LoicAvelin/l_orange_bleue_directory.git
    ```
* Aller dans le dossier l_orange_bleue_directory
    ```bash
        cd l_orange_bleue_directory
    ```
* Installer les dépendances avec la commande suivante :
    ```bash
        composer install
    ``` 
* Copier la base de données pour tester l'application avec la commande suivante si vous avez installer mysql :
    ```bash
        mysql -u [NOM_UTILISATEUR] -p [NOM_DE_LA_BASE] < base_de_données.sql
    ```
### Variables d'environnements

Pour que le projet fonctionne vous aurez besoin de renseigner deux variables d'environnnements dans le fichier .env.

`DATABASE_URL`

afin que le projet puisse être lié à votre base de données.

`MAILER_DSN` 

pour l'envoi automatique des mails via l'application. Vous pouvez utiliser [mailtrap][4] qui vous permettra de vérifier si l'envoi des mails se fait correctement (il existe d'autres services identiques si vous souhaitez en utiliser un autre). 

### Lancer l'application avec le serveur local
Vous êtes enfin prêt à voir ce que l'application donne :-). 

Pour vérifier que tout est bon, vous pouvez écrire cette commande :
```bash
    symfony check:requirements
````
Si tout est bon, vous pouvez lancer votre serveur local avec la commande :
```bash
    symfony serve
```
Et rendez-vous sur le lien qui est écrit dans le terminal. L'adresse est du type : https://127.0.0.1:8000 Vous serez alors sur la page d'accueil de l'application. Pour vous connecter, vous pouvez utiliser le "manuel d'utilisation" qui se trouve dans le dossier "documentation".
## Déploiement avec Héroku

Pour déployer ce projet avec Héroku, il faut avoir un compte sur Héroku suivre les étapes suivantes. Vous pouvez également regardez cette [documentation][9] pour le déployement d'une application symfony.
1) Installer [Héroku CLI][8]
2) Vérifier que l'installation s'est bien faîte
    ```bash
        heroku --version
    ```
3) S'authentifier via le terminal à Héroku
    ```bash
        heroku login -i
    ```
4) Initialiser un dépôt git
    ```bash
        git init
        git add .
        git commit -m "initial import"
    ```
5) Aller dans le dossier du projet, et si c'est déjà fait entrer la commande :
    ```bash
     heroku create
    ```
6) Créer un fichier procfile et le rajouter au dépôt distant :
    ```bash
        echo 'web: heroku-php-apache2 public/' > Procfile
        git add Procfile
        git commit -m "Heroku Procfile"
    ```
7) Pour rajouter une base de données, vous devez passer par le site web. Je vous conseille d'installer [JawsDB][10] et importer le fichier base_de_données.sql qui est présent dans le dépôt que vous avez récupéré.
8) Ensuite, installer [mailtrap][11] pour l'envoi automatique de mail.
9) Renseigner les variables d'environnements afin que l'application fonctionne sur le serveur distant via l'application web Héroku. Vous pouvez les renseigner directement depuis le terminal avec cette commande : 
    ```bash
        heroku config:set APP_ENV=prod
    ```
    Ou alors, vous pouvez les renseigner depuis le site web.

10) Enfin pour lancer le déployement, il faut écrire cette commande :

    ```bash
        git push heroku master
    ```
Et voilà ! 

S'il vous manque quelque chose, ou que tout ne s'est pas bien passé, vous allez recevoir un message d'erreur avec ce qu'il faut corriger. 

Si tout s'est bien passé, vous pouvez alors aller sur l'adresse du site web et tester l'application. 
## Auteur

[Loïc AVELIN][5]

[1]: https://lorange-bleue.herokuapp.com
[2]: https://symfony.com/download
[3]: https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/
[4]: https://mailtrap.io/
[5]: https://github.com/LoicAvelin
[6]: https://www.php.net/manual/fr/install.php
[7]: https://getcomposer.org/download/
[8]: https://devcenter.heroku.com/articles/heroku-cli
[9]: https://devcenter.heroku.com/articles/deploying-symfony4
[10]: https://devcenter.heroku.com/articles/jawsdb
[11]: https://devcenter.heroku.com/articles/mailtrap