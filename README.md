
# Pelatihan DINAS oleh BLK WONOSOBO

Pelatihan yang diadakan Dinas di kabupaten wonosobo terangkum dalam web


## Installation

Make sure your php version is compatible with this project

Developing ini menggunakan php versi 7.4.1

    


# Management Pelatihan BLK Wonosobo


> ### Repository LMS BLK Wonosobo untuk dinas yang ada di Wonosobo. Detail selengkapnya ada di [SRS](https://github.com/gothinkster/realworld-example-apps)

This repo is functionality complete — PRs and issues welcome!

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://drive.google.com/file/d/1HypbonZOn9Pf1tn4OP7mzdWISv_-BmCo/view?usp=sharing)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git clone https://github.com/Wesclic/BLKWonosobo.git


Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Impor database courselmsdemo.sql (**Set the database connection in .env before migrating**)

Import on your sql (phpmyadmin)

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

