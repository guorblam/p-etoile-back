P* - BackEnd
============

P* est une application facilitant la diffusion d’annonces dans la communauté des étudiants CS2i. Ces annonces peuvent provenir à la fois d’entreprises, d’élèves et de l’organisme de formation CS2i. Cette application intègre des fonctionnalités d’authentification et de filtres automatiques à l’inscription. Les personnes authentifiées ont accès à une liste d’annonces à leur intention. La publication d’annonce est accessible aux personnes non-authentifiées.
Il s’agit d’une application web décomposée en un client et un serveur. Les caractéristiques principales du client sont l’ergonomie et la simplicité. Les caractéristiques principales du serveur sont la sécurité et la maintenabilité.
Le client est mis à disposition sur un serveur mutualisé. Le serveur est installé dans un conteneur sur un serveur privé virtuel. Le conteneur est généré à chaque modification de code dans le dépôt central de code après une batterie de tests puis déployé. Les tests sont exécutés dans un service d’intégration continue en Saas.
Le cadrage et le suivi du projet sont effectués en suivant une méthodologie agile. Les actions sont reportées sur un tableau virtuel collaboratif. Toutes les informations utiles sont publiées sur ce tableau qui constitue le référentiel commun. Celui-ci est la référence qui permet d’arbitrer les décisions.


Procédure de lancement du projet
================================

Pour lancer le projet :
 - Installer vagrant : https://www.vagrantup.com/
 - Installer git : https://git-for-windows.github.io/
 - Installer virtual-box : https://www.virtualbox.org/
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
	- dbuser : postgres
	- dbpassword : postgres
	- dbname : petoileback
 - Générer la base de données
 	- php bin/console doctrine:schema:update --dump-sql --force
 - l'API est accessible à l'adresse localhost:8080
