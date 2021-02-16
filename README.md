<a href="https://travis-ci.com/davide-casiraghi/movement_meets_life_nova"><img src="https://travis-ci.org/davide-casiraghi/movement_meets_life_nova.svg" alt="Build Status"></a>   

[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/movement_meets_life_nova.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova)   

[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/davide-casiraghi/movement_meets_life_nova/)

<a href="https://codeclimate.com/github/davide-casiraghi/movement_meets_life_nova/maintainability"><img src="https://api.codeclimate.com/v1/badges/0d0b577b4f4ca8dd9a18/maintainability" /></a>   

## About the Movement Meets Life project

The project is developed using Laravel 8 PHP framework. 
  
The dev environment it's a Laravel Homestead virtual machine. (Vagrant)


## Contributing

### Development workflow
- The **master** branch represent the production environment.  
- The **dev** brench represent the developent environment.  

- To start a new feature, checkout a new git branch called **feature/*** from **dev**.
- To create a fix, checkout a new git branch called **fix/*** from **dev**.


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

SSH host: 192.168.10.10 (unless you changed it in Vagrantfile)
SSH user: vagrant
SSH password: vagrant
```

Then create the database **movement_meets_life**

### Setup the dev environment 

Clone this repo into a local folder:   
```
git clone git@github.com:davide-casiraghi/movement_meets_life_nova.git
```

Copy & customize your .env config:   
```cp .env.example .env```    
```nano .env```


Config the .env like this:
```
DB_CONNECTION=mysql
DB_HOST=192.168.10.10
DB_PORT=3306
DB_DATABASE=movement_meets_life
DB_USERNAME=homestead
DB_PASSWORD=secret
```


Add configuration to the Homestead.yaml file:
```
cd ~/Homestead  
sudo nano Homestead.yaml  

```
And here add:
```yaml
folders:
    - map: .... absolute path of the local folder related to your git repo...
      to: /home/vagrant/code/movement_meets_life_nova
      
sites:
    - map: movement_meets_life_nova.local
      to: /home/vagrant/code/movement_meets_life_nova/public
      php: "7.4"
```

To start the virtual machine:    
```
cd ~/Homestead  
vagrant up
```

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

 ```192.168.10.10 movement_meets_life_nova.local```

Install all npm modules:   
  ```npm install```
  
Create the file storage symbolic link from public/storage to storage/app/public
 
  ```php artisan storage:link```

Access the local website at:   
[https://movement_meets_life_nova.local/](https://movement_meets_life_nova.local/)

### Testing

```php artisan test```

To check the code coverage:
1) Connect to the vagrant machine with `vagrant ssh`
2) Enable Xdebug with `xon` (Homestead by default have Xdebug off)
3) Generate the code coverage report: `./vendor/bin/phpunit --coverage-html=html`
4) Disable Xdebug with `xoff`

You can find now the code coverage in the /html directory.

If you have the error:
- change the xdebug config on Homestead:   
```sudo nano /etc/php/7.4/fpm/conf.d/20-xdebug.ini```
add
```
xdebug.remote_host = 192.168.10.1
xdebug.remote_autostart = 1
```
- then start Xdebug:  
```
sudo phpenmod xdebug
sudo service php7.4-fpm restart
```

### Testing emails
- Create an account on Mailtrap
- Add the data to the .env file

## Code Static Analisys
Code static Analysys is provided by PHPStan.
Run using:
```./vendor/bin/phpstan analyse```

### Staging server

TBD


### Tinker Factories
```php
<?php
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRepetition;
use App\Models\Glossary;
use App\Models\Insight;
use App\Models\Inspiration;
use App\Models\Organizer;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Quote;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\Testimonial;
use App\Models\Mantra;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Sequence;

$user = User::factory()->create([
    'email' => 'davide.casiraghi@gmail.com',
]);
$details = UserProfile::factory()->create([
    'user_id' => $user->id,
    'name' => 'Davide',
    'surname' => 'Casiraghi',
    'country_id' => 214,
]);
$user->profile()->save($details);
$user->assignRole('Super Admin');
$user->setStatus('enabled');


User::factory()->count(4)->create()->each(function($user) {
    $details = UserProfile::factory()->create([
        'user_id' => $user->id,
        'country_id' => rand(1,240),
    ]);
    $user->assignRole('Registered');
    
    $statuses = ['enabled','disabled'];
    $random_status = array_rand($statuses, 1);
    $status = $statuses[$random_status];
    $user->setStatus($status);
});


Tag::factory()->count(20)->create();
Insight::factory()->count(40)->create()->each(function($insight) {
    $insight->tags()->sync(
        Tag::all()->random(2)
    );
});

PostCategory::factory()->count(10)->create();
Post::factory()->count(40)->create()->each(function($post) {
    $post->category()->associate(
        PostCategory::all()->random(1)
    );
    $post->tags()->sync(
        Tag::all()->random(2)
    );
    $post->insights()->sync(
        Insight::all()->random(1)
    );
    
    $statuses = ['published','unpublished'];
    $random_status = array_rand($statuses, 1);
    $status = $statuses[$random_status];
    $post->setStatus($status);
});
Glossary::factory()->count(40)->create()->each(function($glossary) {
    $statuses = ['published','unpublished'];
    $random_status = array_rand($statuses, 1);
    $status = $statuses[$random_status];
    $glossary->setStatus($status);
});

Testimonial::factory()->count(40)->create()->each(function($testimonial) {
    $statuses = ['published','unpublished'];
    $random_status = array_rand($statuses, 1);
    $status = $statuses[$random_status];
    $testimonial->setStatus($status);
});
Quote::factory()->count(40)->create();

Inspiration::factory()->count(40)->create();
Mantra::factory()->count(40)->create();

Venue::factory()->count(40)->create();
Organizer::factory()->count(40)->create();
Teacher::factory()->count(40)->create();

Event::factory()
    ->count(40)
    ->state(new Sequence(
        ['repeat_type' => '1'],
        //['repeat_type' => '2'],
        //['repeat_type' => '3'],
        //['repeat_type' => '4'],
    ))
    ->create()->each(function($event) {
        $event->venue()->associate(
            Venue::all()->random(1)
        );
        $event->organizers()->sync(
            Organizer::all()->random(1)
        );
        $event->teachers()->sync(
            Teacher::all()->random(1)
        );
        
        switch($event->repeat_type){
            case 1:
                EventRepetition::factory()->create([
                    'event_id' => $event->id,
                ]);
            break;
        }
        
        $statuses = ['published','unpublished'];
        $random_status = array_rand($statuses, 1);
        $status = $statuses[$random_status];
        $event->setStatus($status);
    });
```
