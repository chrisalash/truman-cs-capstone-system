# Setup for CS Capstone Presentation Website

## Pre-Setup

Make sure to have NodeJS installed from the following link:  https://docs.npmjs.com/downloading-and-installing-node-js-and-npm.

## 1. Create .env File

Create a new .env file in the project root directory.

Copy this into the .env file:

`DATABASE_URL = "mysql://USERNAME:PASSWORD@DATABASELOCATION"`

Replace USERNAME with the database username.
Replace PASSWORD with the database password.
Replace DATABASELOCATION with the location of the database on the server:

ex. `localhost:3306/databasename`

Current .env text (username and password is obviously renamed):

`DATABASE_URL = "mysql://root:password@localhost:3306/capstone2"`

## 2. Install Node Modules

Run the following command in the project root directory: 

`npm install`

The `npm` package or application might not be installed on the required machine. If so, follow appropriate instructions on how to install npm using the following link: https://docs.npmjs.com/downloading-and-installing-node-js-and-npm.

## 3. Run Prisma

Run the following command in the project root directory:

`npx prisma generate`

## 4. Start databases

This is per system. One cannot explain here on all specific systems on how to start the database.
Some Linux systems require a user interface to start, while others the command line.

Here are some resources to start a database server:
https://www.mysqltutorial.org/mysql-adminsitration/start-mysql/
