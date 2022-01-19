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
docker run --name adrain-db -e MYSQL_RANDOM_ROOT_PASSWORD -v db:/var/lib/mysql -d --network=adrain --restart=always mysql
docker run --name adrain-php --network=adrain -v src:/srv/www/ -v private:/srv/priv/ --restart=always -d php:fpm 
docker run --name adrain-web --network=adrain -v src:/srv/www/ -v conf/etc/nginx:/etc/nginx -p 5006:80 --restart=always -d nginx
```
