# Mediatekformation
## Présentation
Ce site, développé avec Symfony 5.4, permet d'accéder aux vidéos d'auto-formation proposées par une chaîne de médiathèques et qui sont aussi accessibles sur YouTube.<br> 
Actuellement, seule la partie front office a été développée.
voici le lien vers le depot d'oriigine de l'application 
https://github.com/CNED-SLAM/mediatekformation

## foctionnalité ajoutées
Dans la page des playlists, nous avons ajouter une colonne pour afficher le nombre de formations par playlist et permettre le tri croissant et décroissant sur cette colonne. Cette information doit aussi s'afficher dans la page d'une playlist.
![ajoue de fonctionnalité ](https://github.com/Doryansio/mediatekformation/assets/91891883/c62abcb7-e34c-4f62-875c-09909dd79963)
![ajoue de fonctionnalité 2](https://github.com/Doryansio/mediatekformation/assets/91891883/8599e0aa-b22e-458f-b542-a70aa4e750bf)

## Partie Back-office
la partie back-office presente les mêmes fonctionnalités que la partie front a l'exception que nous pouvons directement interagir sur la gestions des elements de l'application et de se fait sur la BDD.

### Pages des formations 
![maquette page admin](https://github.com/Doryansio/mediatekformation/assets/91891883/76ea3e34-7f20-431d-b560-8fddafd7d476)

Sur la pages de gestions des formations il nous ait possible d'ajouter de modifier ou de supprimer une formations et donc de modifier la base de données.<br>
Cependant il n'est pas possible d'ajouter une formations sans remplir certains champs. ajouter une formations sans titre ne sera pas possible.
![maquette page admin_ajout](https://github.com/Doryansio/mediatekformation/assets/91891883/f916df20-d82a-4e4b-99a7-159267cd57bb)

lors de l'edition d'une formation nous sommes rediriger vers un formulaire comprennant les informations de la formation et apres sa validation nous somme rediriger vers cette meme page cette fois ci avec les informations mise a jour.
la suppression d'une formation sous entends qu'elle sera aussi supprimé de la playlist dans laquelle elle se trouvait. de plus une validation est demandé a l'utilisateur avant d'effectuer la suppression.
![suppr ](https://github.com/Doryansio/mediatekformation/assets/91891883/d0eeeed1-56ad-4c86-9ff7-e786de0eaa8d)

### pages des playlists
![page admin playlist](https://github.com/Doryansio/mediatekformation/assets/91891883/019aaf4f-efda-4c4c-9475-72b1db1ff15a)

pour les playlist l'ajout la modification et la suppression sont aussi possible. Cependant la supression d'une playlist ne sera pas possible si elle contient des formations, si une tentative de suppression est faite alors que la playlist n'est pas vide nous aurons un message de type alert qui nous informera que la playlist ne peut pas etre supprimé
![suppr playlist message](https://github.com/Doryansio/mediatekformation/assets/91891883/512fe10e-21ca-4c4b-a4b9-ffde42afa8ac)
lors de l'ajout d'une playlist seulement le nom de cette derniere sera obligatoire afin de valider la creation.
la modification de la playlist nous renvoie sur une formulaire avec les champs possible de modifier et la liste des formations que cette playlist contient cependant il n'est pas possible d'ajouter une formation au sein de cette page
![Capture d'écran 2024-01-21 042744](https://github.com/Doryansio/mediatekformation/assets/91891883/e18c6dc7-90f1-4d9d-9ec6-a614411b05c0)

### page des categories
![Capture d'écran 2024-01-21 223348](https://github.com/Doryansio/mediatekformation/assets/91891883/24214794-12ca-44c9-93d6-74aa54cad453)

cette page nous donne juste la possibilité de suprimmer et d'ajouter une categories. il n'est pas possible d'ajouter une categorie qui existe deja et une nom est obligatoire pour créer une nouvelle categories
![Capture d'écran 2024-01-21 223314](https://github.com/Doryansio/mediatekformation/assets/91891883/0323ba0e-58d1-4f59-940a-88f18fe2901f)
![Capture d'écran 2024-01-21 223643](https://github.com/Doryansio/mediatekformation/assets/91891883/08815d9d-012b-4391-b8c7-9075bbb0e331)
<br>

### Acces authentifié

La partie back-office est accessible via une authentification avec keycloak. lors que nous tappons l'url de la partie administrateur nous sommmes rediriger vers la page de connection keycloak ou nous devons entrer nos informations avant d'acceder a la page administrateur.
![Capture d'écran 2024-01-24 051738](https://github.com/Doryansio/mediatekformation/assets/91891883/cbdc87d9-6212-41c5-aeb0-08c045c54dd7)
une fois dans la partie administrateur nous avons un lien de deconnexion qui nous redirige vers la partie front office de l'application
![Capture d'écran 2024-01-24 051846](https://github.com/Doryansio/mediatekformation/assets/91891883/b3f74bc4-59f4-4915-9fd4-f99c69953bf7)

## Installation de l'application en local
afin de pouvoir utiliser l'application en local, il faut telecharger le ficher .zip de l'application et l'extraire dans le dossier www de wamp64 de votre machine il faut ensuite recuperer le script de la base de donnees et l'importer dansvotre phpMyAdmin.

## installation de l'application et exploitation en ligne
pour tester l'application en ligne, vous aurez besoin de configurer keycloak sur une machine virtuelle azure qui fera office de serveur pour les identifaint d'acces a la page administrateur. la configuration est presente dans le wiki du depot d'origine de l'application. 





