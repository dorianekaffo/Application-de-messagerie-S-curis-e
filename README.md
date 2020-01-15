# Application-de-messagerie-Securisee
Sécuriser l'application de messagerie développée lors du premier projet.


## Introduction
Dans la première partie du projet, il s’agissait de concevoir et réaliser une application web offrant un service de messagerie basique en ligne entre divers collaborateurs. De plus, cette application devait offrir des fonctionnalités de gestion afin que des administrateurs puissent performer des actions telles que l’ajout/suppression des utilisateurs ou encore la modification de leurs informations (rôle,mot de passe). L’application a été réalisée en PHP et utilise une base de données SQLite.
Dans cette deuxième partie, il est cette fois ci question de l’amélioration de la sécurité de l’application étant donné que cet aspect n’avait pas été pris à compte jusqu’ici. Nous allons donc présenter dans ce document les différentes vulnérabilités que présentent l’application puis les contre-mesures que nous aurons mises en place.

## Déployer l'application

Cloner le repo
	
Ouvrir le terminal docker dans le répertoire contenant le dossier "site"
Puis taper la commande:

1. Sur les systèmes Windows:

```bash
docker run -ti -v "%CD%/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018
```

2. Sur les systèmes Linux:

```bash
docker run -ti -v "$PWD/site":/usr/share/nginx/ -d -p 8080:80 --name sti_project --hostname sti arubinst/sti:project2018
```

Ensuite taper:

```bash
docker exec -u root sti_project service nginx start 
```

Puis:
	
```bash
docker exec -u root sti_project service php5-fpm start
```

Le container est opérationnel, allez sur votre navigateur et entrez l'adresse : [localhost:8080](http://localhost:8080) (ou [192.168.99.100:8080](http://192.168.99.100:8080) pour les systèmes windows)
pour utiliser l'application. Les identifiants sont: pseudo:root, mot de passe:root
	
Pour arrêter le container:

```bash
docker stop sti_project
```

[Lien vers le repo de l'application non sécurisée](https://github.com/dorianekaffo/Application-de-messagerie)

#### Auteurs
Doriane Kaffo
Baptiste Hardrick