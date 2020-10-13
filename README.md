

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
```cp .env.example .env```    
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

Initialize the current directory to be a Vagrant environment by creating an initial Vagrantfile.
```vagrant init laravel/homestead```


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


### Tinker Factories
```
<?php
//Tinker away!
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Glossary;
use App\Models\Insight;
use App\Models\Inspiration;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Quote;
use App\Models\Role;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\EventVenue;
use App\Models\Mantra;
use App\Models\User;


Role::factory()->create([
    'name' => 'Administrator',
]);
Role::factory()->count(4)->create();

User::factory()->create([
    'name' => 'Davide',
    'email' => 'davide.casiraghi@gmail.com',
]);
User::factory()->count(4)->create();

Tag::factory()->count(4)->create();
Insight::factory()->count(4)->create()->each(function($insight) {
    $insight->tags()->sync(
        Tag::all()->random(2)
    );
});

PostCategory::factory()->count(4)->create();
Post::factory()->count(4)->create()->each(function($post) {
    $post->post_category()->associate(
        PostCategory::all()->random(1)
    );
    $post->tags()->sync(
        Tag::all()->random(2)
    );
    $post->insights()->sync(
        Insight::all()->random(1)
    );
});
Glossary::factory()->count(4)->create();

EventVenue::factory()->count(4)->create();
EventCategory::factory()->count(4)->create();
Event::factory()->count(4)->create();

Testimonial::factory()->count(4)->create();
Quote::factory()->count(4)->create();

Inspiration::factory()->count(4)->create();
Mantra::factory()->count(4)->create();
```