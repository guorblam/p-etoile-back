A tout moment si vous rencontrez un problème, vous pouvez nous contacter par GitHub et nous
ferons en sorte de vous répondre rapidement.

Pour lancer le projet

 - Installer vagrant : https://www.vagrantup.com/
 - Installer git : https://git-for-windows.github.io/
 - Cloner le projet :
 	- git clone https://github.com/guorblam/p-etoile-back
  - cd p-etoile-back
 - Importer la box vagrant du projet
 	- vagrant box add guorblam/p-etoile-back
 - Démarrer la box vagrant
 	- vagrant up
 - Se connecter à vagrant
 	- vagrant ssh
 - Se positionner dans le répertoire partagé
 	- cd /vagrant
 - Installer le projet symfony par composer
 	- composer install
 	- Les paramètres qui ne sont pas spécifiés ici restent par défaut pour l'environnement de développement
	- dbname : petoileback
	- dbuser : postgres
	- dbpassword : postgres
 - Générer la base de données
 	- php bin/console doctrine:schema:update --dump-sql --force
 	- Il est possible que la base de données soient déjà générées sur vagrant en fonction de la version de la box.
 	Auquel cas, vous aurez une remontée d'erreur et il peut être nécessaire de raffraichir la base de données.
 	- Pour raffraichir la base de données :
 	    - Suppression :
 	        - psql -U postgres
 	        - DROP DATABASE petoileback;
        - Recréation :
            - CREATE DATABASE petoileback;
        - Regénération :
            - php bin/console doctrine:schema:update --dump-sql --force
 - l'API est accessible à l'adresse localhost:8080
    - Vous pouvez l'interroger avec des utilitaires tels que Postman de façon native
    - Vous pouvez aussi y brancher le front-end disponible au dépôt https://gihutb.com/guorblam/p-etoile-front


Notes

 - Si vous souhaiter tester le cycle de vie de création d'un utilisateur, il faut d'abord ajouter 
 le domaine de l'adresse mail de l'utilisateur que vous souhaiter dans la table domaine. Il faut spécifier que ce domaine est true.
    - Si vous ne le faites pas, vous aurez une erreur relative à la table "domaine" dans les logs
    - Exemple pour un domaine "test.fr" : 
    - INSERT INTO domaine VALUES (0, "test.fr", true);
 

 - De la documentation sur les points d'entrées est disponible avec swagger
    - cd /vagrant
    - php bin/console api:swagger:dump --pretty web/swagger
    - Se rendre à l'adresse localhost:8080/web/swagger-ui/dist/index.html


