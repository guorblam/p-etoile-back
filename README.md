P* - BackEnd
============
Prérequis
---------
 - Installer vagrant : https://www.vagrantup.com/
 - Installer git : https://git-for-windows.github.io/
 - Installer virtual-box : https://www.virtualbox.org/
 
Mise en place
-------------
 - Cloner le projet :
 	- git clone https://github.com/guorblam/p-etoile-back
  - cd p-etoile-back
 - Importer la box vagrant du projet
 	- vagrant box add guorblam/p-etoile-back
 	
Démarrage
---------
 - Démarrer la box vagrant
 	- vagrant up
 - Se connecter à vagrant
 	- vagrant ssh
 - Opérations de mise à jour en attente de persistence sur la box vagrant.
    - Paquets à installer :
        - apt-get install php7.0-mbstring
    - Supprimer PHPUnit (utilisation de l'exécutable dans les vendors)
        - apt-get remove phpunit
 - Se positionner dans le répertoire partagé
 	- cd /vagrant
 - Installer le projet symfony par composer
 	- composer install
	- dbuser : postgres
	- dbpassword : postgres
	- dbname : petoileback
 - Générer la base de données
 	- php bin/console doctrine:schema:update --dump-sql --force
 - l'API est accessible à l'adresse localhost:8080
 
 Lancement des tests
 -------------------
 
Utilisation de PHPUnit en tant que vendor de l'application. Les tests utilisent une surcouche pour factoriser certains éléments tels que la connection ou l'envoi d'une requête.

- S'assurer que l'on est bien dans la machine vagrant
    - Sinon : 
        - vagrant ssh
        - cd /vagrant
- Lancer l'exécutable phpunit
    - phpunit --bootstrap tests/AppBundle/Controller/MasterControllerTests.php
  
