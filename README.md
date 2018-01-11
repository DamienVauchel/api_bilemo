# Bilemo API

Welcome on the Bilemo API GitHub. A **Symfony 3.4** project.

## General context

This project is linked to the OpenClassRooms DA PHP/Symfony's studies. It is the 7th project in which it is asked to create an API for a mobile phones seller. This is the first API REST project.

## Prerequisite

* PHP 7
* MySQL
* Apache or IIS depend of your OS

Easier: You can download MAMP, WAMP or XAMPP depend of your OS
* Composer for **Symfony 3.4** and bundles installations

## Add-ons

* Bootstrap
* jQuery
* Font Awesome
* Google Fonts: *Source Code Pro*, *Titillium Web* and *Rubik*

## ORM
Doctrine

## Bundles

* Twig
* FOSRestBundle
* JMSSerializerBundle
* BazingaHateoasBundle
* CsaGuzzleBundle
* NelmioApiDocBundle

## Installation

Download project or clone it in the htdocs or www depend of your OS

* If you are using LAMPP on Linux, check your permissions: Go to /opt/lampp/htdocs/ open a bash and type:

        $  sudo ls -l
    Change permissions for everybody to be able to update informations in every repository's folders.

1. **Symfony 3.4 and bundles installations** Open bash in folder and type:

        composer install
        
2. **Database creation** Type:

        php bin/console doctrine:database:create
        
    Then
    
        php bin/console doctrine:schema:update --force
        
3. **First user creation** Go on the URL:
[http://localhost/api_bilemo/web](http://localhost/api_bilemo/web) (if you put the folder on your apache root)
Then Click on the "Connexion via Facebook" button.
Accept the Facebook permissions.
Your user is created.
        
4. **Copy the access token** which is provided by the Facebook connection page to paste it on step 6.

5. **Example Datas in database** Type:

        php bin/console bilemo:fixtures

6. **Now, you can use the API on Postman**
To access the API pages, add to the HTTP header the parameters:

        Content-Type: application/json
        Authorization: Bearer your_access_token

7. **For other informations, see the local documentation** by going on the URL:
[http://localhost/api_bilemo/web/api/doc](http://localhost/snow_tricks/web/api/doc) (if you put the folder on your apache root)

And enjoy :)

If you have any question, you can contact me

Thanks!
