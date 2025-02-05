# php_project

### setup steps in linux
- install apache/nginx
- intall php, mysql, and enable pdo extension for php
- log into mysql shell `sudo mysql`
- create new user
`CREATE USER 'ganesh'@'localhost' IDENTIFIED BY 'gnsgnss'`
- grant priveleges
`GRANT all on *.* TO 'ganesh'@'localhost'`
- run php server: `php -S localhost:8000 -t public`
- enjoy