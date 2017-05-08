# Сalendar 

This demo was built with [Laravel](https://laravel.com/) as a backend framework, [Vue.js](https://vuejs.org/) as a frontend framework and
[FullCalendar](https://fullcalendar.io/) as a library for displaying events.    

### Demo

**Demo page**: 
[calendar.app](http://51.15.68.138/)


**Admin credentials**:

```
login - admin@calendar.app
password - 123456
```

### Installation

**Requirements:**
* PHP >= 7
* MySQL >= 5.7
* NodeJS >= 7.10

**Installation steps:**
* Clone the repository: `git clone https://github.com/babenkoivan/calendar.git`
* Configure the web server site root to the `public` directory
* Install the Composer dependencies: `composer install`
* Install the Node dependencies: `npm install`
* Configure the environment variables: create the `.env` file (you can use the `.env.example` as a pattern) and set an application name, the database settings and the mail server settings.
* Build an app key: `php artisan key:generate`
* Run the migrations: `php artisan migrate`
* Seed a database with the default user group and the default user: `php artisan db:seed`
* Build the assets `npm run production`

