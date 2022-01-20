# VCS IMPORT PROJECT
Application gets data from Github API and imports to it's own database, then displays the imported data.

## How to run
Required PHP version 8.x.x=> 

1. You have to set parameter `'GITHUB_TOKEN'` in `.env file`. Program will not work without the token. You can obtain it from your `GitHub Account -> Settings -> Developer Settings -> Personal access tokens -> Generate New Token`. Why we need to do this? GitHub API allows unauthorised user to make 60 requests per hour. You can do 5000 requests per hour with Github Token included. 

2. Run mysql server

3. Create Database named 'project'

-> You can do it by command

`php bin/console doctrine:database:create`

4. Start the Symfony server

`symfony server:start`

5. Import repository via command

`php bin/console import:repository <name> <provider>`

6. Now check the website

`http://localhost:8000/`

# App Preview

![preview.png](preview.png)

Author
* **Wiktor Korol** - [wkorol](https://github.com/wkorol)

