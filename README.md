# Colloquium

Web application created during the final checkpoint in the [Wild Code School](https://www.wildcodeschool.com/) in Bordeaux.
There was no precise theme, so I decided to make something I had in mind for a few weeks before - an application of debates, where users can post their questions on any subject, put them into categories and answer "for" or "against", depending on their opinions.
There is a vote system that ranks questions and answers by popularity and an admin panel to administer all the CRUD needed.

# How to run
- clone the repo
- run ```composer install```
- run ```yarn install```
- run ```yarn encore dev```

- create an .env.local file,  uncomment the ```DATABASE_URL="mysql``` line and comment the postgre one, set db_name to any of your liking and replace db_user and db_password with your creditentials
- run ```symfony console d:d:c``` to create this database
- run ```symfony console d:m:m``` to execute migrations and create tables
- run ```symfony console d:f:l``` to load the fixtures

- run ```symfony server:start```
You're in !


## Acknoledgment
Many thanks to [Guillaume Harari](https://github.com/guillaumebdx), my teacher at the Wild Code School for all the knowledge he passed on to me.


## To do list for future improvements
- Re-make the front vote system with Ajax
- Add possibility to put question in favorites to find them easily in personal user page
- Add a search bar on main page or navbar
- Add security on routes and vote system (right now anyone can vote any number of times)
- Deploy

