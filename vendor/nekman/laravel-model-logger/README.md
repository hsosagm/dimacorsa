# Laravel-Model-Logger

This laravel package will create a log entry every time a model has been inserted, updated or deleted. It is up to you to create an interface to view the log messages (if you want to). This package will only add the logic to automatically log actions on models.

## Installation

Run the following composer command:

    composer require nekman/laravel-model-logger 1.*
    
Register the service provider by adding the following to your `config/app.php`:

```php
'providers' => array(
    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    'NEkman\ModelLogger\ModelLoggerServiceProvider',

),
```

The package needs to create a couple of tables in the database. Run this command to create a migrations file:

    php artisan model-logger:migrate
    
Followed by:

    php artisan migrate
    
Installation done!
    
## How to use

Lets say you want to log the model called `User`. Add the following code:

```php
User::observe(new \NEkman\ModelLogger\Observer\Logger);
```
    
`User` _must_ also implement the `Logable` interface:
    
```php
use \NEkman\ModelLogger\Contract\Logable;

class User extends Eloquent implements Logable {

  public function getLogName() {
    return $this->email;
  }
```
  
Voilà! Anytime `User` is inserted, updated or deleted a log entry will be produced in the database.

### What is the Logable interface?

Lets say a model was deleted and the package would automatically log the `model_id`. Knowing that model 2 was deleted will not say very much about the deletion. With the `Logable` interface you can specify how to recognize the model when logged.

## Database

This package adds 3 models as described in the table below.

| Model | Table |
| ----- | ----- |
| Action | model_log_action |
| Message | model_log |
| UpdateData | model_log_update |

All models resides in the namespace `\NEkman\ModelLogger\Model`.

### Action

Actions describe what happend on the module. Included actions are:

* insert
* delete
* update

Add an entry to the action able to add more.

### Message

These are the actual "messages". If you want to create an interface for the log entries, this is the model to loop through.

### UpdateData

The package will log what has been updated when a model is updated. The key, old value and new value are logged.
