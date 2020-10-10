

## About the Movement Meets Life project

The project is developed using Laravel 8 PHP framework. 
  
The dev environment it's a Laravel Homestead virtual machine. (Vagrant)


## Contributing

### Development workflow
- The **master** branch represent the production environment.  
- The **dev** brench represent the developent environment.  

- To start a new feature, checkout a new git branch called **feature/*** from **dev**.
- To create a fix, checkout a new git branch called **fix/*** from **dev**.


### Setup the dev environment 

Clone this repo into a local folder:   
```git clone git@github.com:davide-casiraghi/movement_meets_life_nova
.git```


Copy & customize your .env config:   
```copy .env.example .env```    
```nano .env```

Config the .env like this:
```
DB_CONNECTION=mysql
DB_HOST=192.168.10.10
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

To start the virtual machine:    
```vagrant up```

Install vendor files:   
```composer install```   

Generate a unique app key by the following command:    
```php artisan key:generate ```  
The key will be added to your .env file:
```APP_KEY=```

Run the db migrations:    
```php artisan migrate```   

Clean the cache:  
```php artisan cache:clear```

Open the hosts file on your machine in your text editor and add this entry.  

 ```192.168.10.10 laravel_jetstream.test```

Install all npm modules:   
  ```npm install```
  
Create the file storage symbolic link from public/storage to storage/app/public
 
  ```php artisan storage:link```

Access the local website at:   
[https://laravel_jetstream.test/](https://laravel_jetstream.test/)


#### Access to the staging server with Mac + Chrome

In case of access to the staging server with this configuration, the following error is returned because of the untrusted certificate.    

```"Your connection is not private"```    

To bypass this error you can try typing “badidea” or “thisisunsafe” directly in chrome on the same page.    

(tested on Version 81.0.4044.138 - MacOs Catalina 14/5/2020)


### Access to the virtual machine database

You can access to the homestead database using **MySQLWorkbench** or **Sequel Ace**
(Sequel Ace is the "sequel" to longtime macOS tool Sequel Pro.)

I suggest to use **Sequel Ace** instead of **Sequel Pro** since **Sequel Pro** may have problems connecting to the Homestead database.

Connect using SSH and this parameters:

```
MySQL host: 127.0.0.1
Database user: homestead
Database password: secret
Database: homestead

SSH host: 192.168.33.10 (unless you changed it in Vagrantfile)
SSH user: vagrant
SSH password: vagrant
```

### Staging server

TBD