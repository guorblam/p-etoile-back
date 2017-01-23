P* - BackEnd
============

Pour lancer le projet :

 - Installer vagrant : https://www.vagrantup.com/
 - Installer git : https://git-for-windows.github.io/
 - Cloner le projet :
 	- git clone https://github.com/guorblam/p-etoile-back
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
	- dbuser : postgres
	- dbpassword : postgres
	- dbname : petoileback
 - Générer la base de données
 	- doctrine generate:schema
