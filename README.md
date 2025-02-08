# php_project

### setup steps in linux
- install apache/nginx
- intall php, mysql, and enable pdo extension for php
- log into mysql shell `sudo mysql`
- create new user
`CREATE USER 'ganesh'@'localhost' IDENTIFIED BY 'gnsgnss'`
- grant priveleges
`GRANT all on *.* TO 'ganesh'@'localhost'`
- create database and import structure
`create database cms_project`
`mysqldump -u ganesh -p cms_project < ./structure.sql`
- run php server: `php -S localhost:8000 -t public`
- enjoy
### !! Note !!
- To change database credentials according to your wish, you must update connection configurations in /Core/Database.php
- - (Please connect to internet as css, icons and avatars are loaded directly from official cdn.) 
