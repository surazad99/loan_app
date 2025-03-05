## Read this file to setup backend in your local machine

1. First clone the project
    ```shell script
   git clone repository_link
   cd loan_app
    ```

2. Run the following command 
  -to install the dependencies via composer
  ```sh
  composer install
  ```

3. Create a database in your local server

4. Create a separate database file test.sqlite to run unit testing in your local server inside database folder

5. Copy `.env.example` file and paste it in same directory with name `.env`
    ```shell script
     cp .env.example .env
    ```

6. Open `.env` file and connect to your database by placing these credentials
    ```env
    DB_DATABASE=database_name 
    DB_USERNAME=your db_username 
    DB_PASSWORD=your db_password
    ```

7. After saving `.env` file  open terminal and run the following commands to set up server
  - to migrate all the tables to your database
    ```sh
    php artisan migrate
    ```
  - check your database if all the tables are there

  - to seed the user table run the following command this gives you super admin credentials
    ```sh
    php artisan db:seed
    ```
  - Login to the app as admin using credentials
    - Email: super.admin@gmail.com
    - Password: password
   
  - now start the laravel server using following command
    ```sh
    php artisan serve
    ```
8. For api document check api_doucment file which is written in swagger/openapi.

Boom server is started! You can now request for APIs provided to you.


Incase For Fresh Migration Run the following commands step by step

  - 
    ```sh
    php artisan migrate:fresh
    ```
  - 
    ```sh
    php artisan db:seed
    ```
  
Happy Coding!