# LOG515

## Projet keskonfait

### Setup local de Laravel

Dépendances: Git, Vagrant, Homestead, Virtualbox, vim, Php 7.1, composer

Bon, vim n'est pas tant nécessaire, surtout sur Windows. En fait, utilisez l'éditeur de texte que vous voulez. Mais, je le met là parce que je suis un fan!

1. Installer [VirtualBox](https://www.virtualbox.org/wiki/Downloads)

2. Installer [Vagrant](https://www.vagrantup.com/downloads.html) pour votre système d'exploitation.
Une fois installé, lancer la commande suivante:
~~~
$ vagrant box add laravel/homestead
~~~

3. Installer [Php 7.1](http://php.net/downloads.php), pour Windows (http://windows.php.net/download/)

4. Par la suite, il faut installer et configurer Homestead. Pour Windows, je ne peux pas tester alors je vous laisse ce lien là [Install Homestead on Windows](http://blog.teamtreehouse.com/laravel-homestead-on-windows)

~~~
$ cd /folder/where/you/put/your/repos>
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
    - map: ~/Code
      to: /home/vagrant/Code

sites:
    - map: homestead.app
      to: /home/vagrant/Code/Laravel/public

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

En gros, ce que ça fait c'est mapper notre code (~/Code dans le fichier ci-dessus) dans la machine virtuelle Vagrant dans le path /home/vagrant. Alors, faite juste changer ~/Code pour le path où vous avez cloner le code dans votre ordi.

Une fois terminé, lancer la machine virutelle avec la commande dans le repo du projet:

~~~
[/path/to/keskonfait] $ vagrant up
~~~