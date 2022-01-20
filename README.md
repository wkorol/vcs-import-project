# VCS IMPORT PROJECT
Application gets data from Github API and imports to it's own database, then displays the imported data.

## How to run
Required PHP version 8.x.x=> 

You have to run mysql server

Create Database named 'project'

You can do it by command

`php bin/console doctrine:database:create`

Start the Symfony server

`symfony server:start`

Import repository via command

`php bin/console import:repository <name> <provider>`

Now check the website

`http://localhost:8000/`

Author
* **Wiktor Korol** - [wkorol](https://github.com/wkorol)

