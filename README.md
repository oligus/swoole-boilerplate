# Swoole boilerplate
Swoole boilerplate

## Requirements

[Docker](https://www.docker.com/)

[GNU Make](https://www.gnu.org/software/make/)

## Install

Clone the repository:
```bash
$ git clone https://github.com/oligus/swoole-bolierplate.git
```

Initialize the docker containers, in total there are 4 containers: nginx, mysql, http and cli.
```bash
$ make build
```

Get the IP number of the http instance:
```bash
$ docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' swoole_http
```

Setup MYSQL:
```bash
$ make mysql-bash
$ mysql -uroot -pswoole_root
```

Create database and add users from http and cli
```sql
create database swoole;

CREATE USER 'swoole'@'172.30.0.%' IDENTIFIED WITH mysql_native_password BY 'swoole';
GRANT ALL PRIVILEGES ON swoole.* TO 'swoole'@'172.30.0.%';
```

Check your database access:
```bash
$ make http-bash
$ mysql -u swoole -pswoole -h mysql -D swoole
```

```bash
$ make bash
$ mysql -u swoole -pswoole -h mysql -D swoole
```

Create database (CLI):
```bash
$ vendor/bin/doctrine orm:schema-tool:create
```

Put in sample data (CLI):
```bash
$ mysql -uswoole -pswoole -h mysql -D swoole < data/sample.sql 
```
## GraphQL

Nginx will be serving from port `8085` 

Access GraphQL end point from `http://localhost:8085`

