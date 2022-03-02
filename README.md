# VCS IMPORT PROJECT
Application gets data from Github API and imports to it's own database, then displays the imported data.

## How to run

1. You have to set parameter `'GITHUB_TOKEN'` in `.env file`. Program will not work without the token. You can obtain it from your `GitHub Account -> Settings -> Developer Settings -> Personal access tokens -> Generate New Token`. Why we need to do this? GitHub API allows unauthorised user to make 60 requests per hour. You can do 5000 requests per hour with Github Token included. 

2. Run command 
`composer install`

3. Build docker
`docker-compose up -d`

4. Enter into docker container bash
`docker-compose exec application bash`

5. Make migrations
`php bin/console doctrine:migrations:migrate`

6. Import repository via command

`php bin/console import:repository <name> <provider>`

6. Now check the website

`http://localhost:8888/<provider_name>`

7. If you want to add new provider, you have to create new Entity that will extend Abstract Class of Org. Then you have to create Service of that Provider which will extend DBService class and Interface DBInterface with needed methods. Implement parser of that provider, also you will have to add string array parameter with provider name in services.yaml. 

# API

`http://localhost:8888/api`

# App Preview

![preview.png](preview.png)

Author
* **Wiktor Korol** - [wkorol](https://github.com/wkorol)

