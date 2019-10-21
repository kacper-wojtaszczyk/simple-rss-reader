# simple-rss-reader

Yet another web RSS reader

A simple Symfony application to read your rss/atom feeds

## quickstart

To run the application with default configuration:

clone the repository
````
git clone https://github.com/kacper-wojtaszczyk/simple-rss-reader.git
````
then install the dependecies
````
composer install
````
and once everything is installed run the app with
````
./quickstart.sh
````

I will use sqlite as a default DB driver for portability, make necessary migrations,
add `https://www.theregister.co.uk/software/headlines.atom` feed and initialize a built in Symfony Web Server.

Your application will be available at: http://127.0.0.1:8000