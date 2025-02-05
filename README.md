# php_project

### setup steps in linux
- install apache/nginx
- move this root folder (php_project) to /var/www/html/
- intall php, mysql, and enable pdo extension for php
- log into mysql shell `sudo mysql`
- create new user
`CREATE USER 'ganesh'@'localhost' IDENTIFIED BY 'gnsgnss'`
- grant priveleges
`GRANT all on *.* TO 'ganesh'@'localhost'`
- now navigate to `localhost/php_project/public/`
- enjoy