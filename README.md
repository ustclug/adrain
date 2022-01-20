# adrain
Admission Rain is the platform for USTC undergraduates and graduates students
to report their admissions and rejections notices from graduate schools.

The admission rain is maintained by LUG@USTC in the website adrain.ustclug.org

The author of the system is Tianyi Cui and Weikeng Chen.

The system does not save the personal identity information.

## local deploy/testing instructions

```bash
# change directory to repo root
cd adrain
# create docker network for server containers
docker network create adrain
# initiate these three docker containers
docker run --name adrain-db -e MYSQL_ROOT_PASSWORD=your_root_password -v db:/var/lib/mysql -d --network=adrain --restart=always mysql:8.0 --default-authentication-plugin=mysql_native_password
docker run --name adrain-php --network=adrain -v `pwd`/src:/srv/www/ -v `pwd`/src/private:/srv/priv/ --restart=always -d local/php:7-fpm-mysqli
docker run --name adrain-web --network=adrain -v `pwd`/src:/srv/www/ -v `pwd`/conf/etc/nginx:/etc/nginx -p 5006:80 --restart=always -d nginx
```

`local/php:7-fpm-mysqli` is built with following Dockerfile:

```Dockerfile
FROM php:7-fpm
RUN docker-php-ext-install mysqli
```
