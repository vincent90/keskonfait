## Projet keskonfait

[![Build Status](https://travis-ci.org/vincent90/keskonfait.svg?branch=master)](https://travis-ci.org/vincent90/keskonfait)

### Setup local de Laravel

Dépendances: docker, docker-compose, Git, Vagrant, Homestead, Virtualbox, vim

Bon, vim n'est pas tant nécessaire, surtout sur Windows. En fait, utilisez l'éditeur de texte que vous voulez. Mais, je le met là parce que je suis un fan!

# Methode Docker

1. Installer docker et docker-compose pour votre système d'exploitation
2. Cloner le projet keskonfait
3. Aller dans le dossier du projet
4. Ensuite aller à l'intérieur du dossier laradock
5. lancer la commande:
~~~
$ docker-compose up -d nginx mysql
~~~
6. Done. Dans un browser entrer http://127.0.0.1



---

# Methode Vagrant


1. Installer [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

2. Installer [Vagrant](https://www.vagrantup.com/downloads.html) pour votre système d'exploitation.
Une fois installé, lancer la commande suivante:
~~~
$ vagrant box add laravel/homestead --box-version 1.1.0
~~~

3. Par la suite, il faut installer et configurer Homestead. Pour Windows, je ne peux pas tester alors je vous laisse ce lien là [Install Homestead on Windows](http://blog.teamtreehouse.com/laravel-homestead-on-windows), mais ça devrait être assez straight forward.

~~~
$ cd </folder/where/you/put/all/your/repos>
$ git clone https://github.com/laravel/homestead.git Homestead
$ cd Homestead
$ bash init.sh
$ cd ~/.homestead
$ vim Homestead.yaml
~~~

Voici le fichier *Homestead.yaml* de base.

~~~
---
ip: "192.168.10.10"
memory: 2048
cpus: 1
provider: virtualbox

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: ~/Code                       # À modifier pour votre path local sur votre ordi vers le projet Keskonfait
      to: /home/vagrant/Code

sites:
    - map: homestead.app
      to: /home/vagrant/Code/public   # ***** à modifier !!! Il faut le mettre comme ça, il n'est pas comme ça par defaut

databases:
    - homestead

# blackfire:
#     - id: foo
#       token: bar
#       client-id: foo
#       client-token: bar

# ports:
#     - send: 50000
#       to: 5000
#     - send: 7777
#       to: 777
#       protocol: udp
~~~

En gros, ce que ça fait c'est mapper notre code (~/Code dans le fichier ci-dessus) dans la machine virtuelle Vagrant dans le path /home/vagrant. Alors, faite juste changer ~/Code pour le path où vous avez cloner le projet keskonfait de Github dans votre ordi.

Finalement, retournez dans </folder/where/you/put/all/your/repos>/Homestead/, puis tapez:
~~~
$ vagrant up
~~~

That's it, le code va rouler dans la machine Vagrant et vous avez juste à ouvrir un browser et entrer http://192.168.10.10
