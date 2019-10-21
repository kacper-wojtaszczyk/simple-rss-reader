# simple-rss-reader

Yet another web RSS reader

a simple Symfony application to read your rss/atom feeds. After reading a feed it automatically
updates it using Symfony Messenger component

## requirements

- PHP >= 7.3

the rest is defined in composer.json

## quickstart

to run the application with default configuration:

clone the repository
````
git clone https://github.com/kacper-wojtaszczyk/simple-rss-reader.git
````
````
cd simple-rss-reader
````
then install the dependecies
````
composer install
````
and once everything is installed run the app with
````
./quickstart.sh
````

it will use sqlite as a default DB driver for portability, make necessary migrations,
add `https://www.theregister.co.uk/software/headlines.atom` feed and initialize a built in Symfony Web Server.

Your application will be available at: http://127.0.0.1:8000

## prod notes
when deploying to production you'll probably want to tweak a few things. you should switch to some other db system
(no problems switching to MySQL or PostgreSQL by changing Doctrine config). There should also be Supervisor running
to make sure the consumer for feed updates is always running. The queing mechanism can be switched from Doctrine
to some AMQP server (e.g. RabbitMQ) for performance.
