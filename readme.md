CODEMED - Experience
=======================

Introdução
------------
Sistema de impressão de resultados online

Tecnologias utilizadas:
-----------------------
Backend:
--------
 * PHP 5.3+
 * Laravel framework 5.1

Frontend:
---------
 * Twitter Bootstrap 3.2
 * jQuery 1.11
 * Font Awesome 4.2.0

Instalação
------------

Usando composer (recomendado)
----------------------------
Clone o repositório e manualmente execute o 'composer' usando o arquivo 'composer.phar':

    cd /var/www/html
    git clone https://brunoaraujo@bitbucket.org/brunoaraujo/experience.git
    cd experience
    php composer.phar self-update
    php composer.phar install

Criando o virtual host
------------
        <VirtualHost *:80>
                ServerName experience.codemed.dev
                ServerAdmin webmaster@localhost
                DocumentRoot /home/bruno/projetos/codemed/experience/public
                SetEnv APPLICATION_ENV "production"
                SetEnv PROJECT_ROOT "/home/bruno/projetos/codemed/experience"
                <Directory /home/bruno/projetos/codemed/experience/public>
                        DirectoryIndex index.php
                        AllowOverride All
                        Order allow,deny
                        Allow from all
                        Require all granted
                </Directory>
        </VirtualHost>

Desenvolvedores
-------------
* ** Bruno Araujo **
* ** Vitor **
