## PHP Challenge
Challenge for PHP Developers
Original instructions: https://git.jobsity.com/jobsity/php-challenge/-/wikis/PHP%20Challenge%20instructions
The objective of this challenge is to create a REST API application that the user can use to track the value of stocks in the stock market. 


### Instalation
1. Install the database sql/php-challenge.sql
2. Install the project in a LAMP/WAMP/MAMP/XAMP server
    PHP 7.1 or higher
3. Set the database configuration in config/db.php

### Endpoints

POST /users (Register a new user)
raw-JSON:
{
    "name" : ""
    ,"email" : ""
    ,"pass" : ""
}

POST /login (login an existent user)
raw-JSON:
{
    "email" : ""
    ,"pass" : ""
}

GET /logout (logout the current session)

GET /stock?q=code (Search the current values for the code. Only allowed for logged users)

GET /history (Query the historic searches for the current user. Only allowed for logged users)


### Instructions
1. Create a new user (/users)
2. Login user
3. Make a query of the stock
4. Review the history
5. Logout the session