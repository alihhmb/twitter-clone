Hello, this is my first Laravel Project, I created a new laravel 5.6 project via this command:

composer create-project laravel/laravel="5.6.*" twitter-clone

- I learnt that laravel provides built-in Authentication (login page, registration, forgot password...etc) all these could be created via this command :

php artisan make:auth

- According to the requirements, I should've use "Socialite" to allow users login by facebook & google+, So I followed this tutorial and everything went smoothly.

https://www.youtube.com/playlist?list=PLNZnEi5-EJZut91zYFv5PrMlZLzS4A9t9

IMPORTANT: 
the credentials of facebook and google applications that are necessary to login are set in this file:

twitter-clone\config\services.php

    'google' => [
        'client_id' => 'xxxxxxxxxxxxx',
        'client_secret' => 'xxxxxxxxxxxxx',
        'redirect' => 'https://lsapp.com/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => 'xxxxxxxxxxxxx',
        'client_secret' => 'xxxxxxxxxxxxx',
        'redirect' => 'https://lsapp.com/auth/facebook/callback',
    ],


- I used jQuery for Javascript work, and I used this package 

https://github.com/tightenco/ziggy

to be able to access some named routes in Javascript.


- In the DOCUMENTATION folder, I included MySql workbench file "db_diagram.mwb" and another image file "db_diagram.png" contain the DB Diagram

I included also two sql files "sql_structure_only.sql" and "sql_structure_and_data.sql"


- I followed this tutorial to know how to create repositories:

https://itsolutionstuff.com/post/laravel-5-repository-pattern-tutorial-from-scratchexample.html


- I followed this tutorial as well to change the user avatar:

https://devdojo.com/episode/laravel-user-image

and I used this package to resize the avatar image:

http://image.intervention.io/getting_started/introduction


- I created a command to generate dummy data using "Faker" which is located in:

twitter-clone\app\Console\Commands\GenerateData.php


- I always follow PSR in my PHP code:

https://www.php-fig.org/psr/psr-2/


- The file .gitignore prevent Git from uploading some files and folder, so I notify that it is necessary to run the command "composet install" anfter cloning the project.


Finally I prepared this Video to demonistrate how the application works and in this video I explain everything in details:

https://drive.google.com/file/d/10efxX0cC6k99akWdMOcAuv1kjuR5_gqU/view?usp=sharing


I you have any question don't hisitate to phone me.

Thank you & Best regards
Ali Hassan
