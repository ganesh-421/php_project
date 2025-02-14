# php_project

### setup steps in linux
- install apache/nginx
- intall php, mysql, and enable pdo extension for php
- log into mysql shell `sudo mysql`
- create new user
`CREATE USER 'yout_username'@'localhost' IDENTIFIED BY 'your_password'`
- grant priveleges
`GRANT all on *.* TO 'your_username'@'localhost'`
- create database and import structure
`create database your database`
`mysqldump -u your_username -p your_database < ./database_structure.sql`
- run php server: `php -S localhost:8000 -t public`
- run `cp .env.example .env`
- Updte .env file for your database . 
- enjoy
### !! Note !!
- To change database credentials according to your wish, you must update connection configurations in /Core/Database.php
- (Please connect to internet as css, icons and avatars are loaded directly from official cdn.) 
