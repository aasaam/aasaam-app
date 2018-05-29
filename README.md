[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)

![ubuntu](https://img.shields.io/badge/ubuntu-18.04-blue.svg "ubuntu")
![nginx](https://img.shields.io/badge/nginx-1.14.0-blue.svg "nginx")
![nghttpd](https://img.shields.io/badge/nghttpd-1.30.0-blue.svg "nghttpd")
![php](https://img.shields.io/badge/php-7.2-blue.svg "php")
![composer](https://img.shields.io/badge/composer-1.6.5-blue.svg "composer")
![nodejs](https://img.shields.io/badge/nodejs-8.11.2-blue.svg "nodejs")
![npm](https://img.shields.io/badge/npm-5.10.0-blue.svg "npm")
![yarn](https://img.shields.io/badge/yarn-1.7.0-blue.svg "yarn")
![immortal](https://img.shields.io/badge/immortal-0.18.0-blue.svg "immortal")
![jobber](https://img.shields.io/badge/jobber-1.3.2-blue.svg "jobber")
![fluentbit](https://img.shields.io/badge/fluentbit-0.13.2-blue.svg "fluentbit")
![chromium](https://img.shields.io/badge/chromium-66.0-blue.svg "chromium")

# AASAAM Application Docker Image

Docker image for PHP and JavaScript applications.

## Ubuntu 18.04 LTS (Bionic Beaver)

  Docker image based on latest LTS version of popular linux distro.
  [Read more...](https://wiki.ubuntu.com/BionicBeaver/ReleaseNotes)

### nghttp2

  This is an implementation of Hypertext Transfer Protocol version 2.
  [Read more...](https://nghttp2.org/)

### Nginx

  Latest stable version of nginx with http2 support also additional modules.
  [Read more...](https://nginx.org/)

### PHP

  Latest stable version **7.2** of PHP with many extension that could be enabled by entrypoint file in `app/entrypoint`

#### Extensions

Extension | Version | Dependency | Info
 ---  |  ---  |  ---  |  ---
**amqp** | 1.9.3 |  | [:mag:](http://www.google.com/search?q=php+amqp)
**apcu** | 5.1.11 |  | [:mag:](http://www.google.com/search?q=php+apcu)
**ast** | 0.1.6 |  | [:mag:](http://www.google.com/search?q=php+ast)
**bcmath** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+bcmath)
**bz2** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+bz2)
**calendar** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+calendar)
**Core** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+Core)
**ctype** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+ctype)
**curl** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+curl)
**date** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+date)
**dba** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+dba)
**dom** |   | *Required*: libxml | [:mag:](http://www.google.com/search?q=php+dom)
**ds** | 1.2.6 | *Required*: json, spl | [:mag:](http://www.google.com/search?q=php+ds)
**enchant** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+enchant)
**ev** | 1.0.4 | *Optional*: sockets | [:mag:](http://www.google.com/search?q=php+ev)
**event** | 2.4.0 | *Required*: sockets | [:mag:](http://www.google.com/search?q=php+event)
**exif** | 7.2.5 | *Required*: standard | [:mag:](http://www.google.com/search?q=php+exif)
**fann** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+fann)
**fileinfo** | 1.0.5 |  | [:mag:](http://www.google.com/search?q=php+fileinfo)
**filter** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+filter)
**ftp** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+ftp)
**gd** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+gd)
**geoip** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+geoip)
**geospatial** | 0.2.1 |  | [:mag:](http://www.google.com/search?q=php+geospatial)
**gettext** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+gettext)
**gmp** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+gmp)
**gnupg** | 1.4.0 |  | [:mag:](http://www.google.com/search?q=php+gnupg)
**grpc** | 1.12.0 |  | [:mag:](http://www.google.com/search?q=php+grpc)
**hash** |   |  | [:mag:](http://www.google.com/search?q=php+hash)
**hprose** | 1.6.6 |  | [:mag:](http://www.google.com/search?q=php+hprose)
**hrtime** | 0.6.0 |  | [:mag:](http://www.google.com/search?q=php+hrtime)
**iconv** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+iconv)
**igbinary** | 2.0.6 | *Required*: standard, session | [:mag:](http://www.google.com/search?q=php+igbinary)
**imagick** | 3.4.3 | *Required*: spl | [:mag:](http://www.google.com/search?q=php+imagick)
**imap** | 7.2.5 | *Required*: standard | [:mag:](http://www.google.com/search?q=php+imap)
**interbase** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+interbase)
**intl** | 1.1.0 |  | [:mag:](http://www.google.com/search?q=php+intl)
**json** | 1.6.0 |  | [:mag:](http://www.google.com/search?q=php+json)
**jsond** | 1.4.0 |  | [:mag:](http://www.google.com/search?q=php+jsond)
**ldap** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+ldap)
**libevent** | 0.2.0 | *Optional*: sockets | [:mag:](http://www.google.com/search?q=php+libevent)
**libxml** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+libxml)
**mbstring** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+mbstring)
**memcached** | 3.0.4 | *Required*: session, igbinary, msgpack, spl | [:mag:](http://www.google.com/search?q=php+memcached)
**mongodb** | 1.4.3 | *Required*: date, json, spl, standard | [:mag:](http://www.google.com/search?q=php+mongodb)
**msgpack** | 2.0.2 |  | [:mag:](http://www.google.com/search?q=php+msgpack)
**mysqli** | 7.2.5 | *Required*: spl, mysqlnd | [:mag:](http://www.google.com/search?q=php+mysqli)
**mysqlnd** |   | *Required*: standard | [:mag:](http://www.google.com/search?q=php+mysqlnd)
**odbc** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+odbc)
**opencensus** | 0.2.2 |  | [:mag:](http://www.google.com/search?q=php+opencensus)
**openssl** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+openssl)
**pcntl** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+pcntl)
**pcre** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+pcre)
**PDO** | 7.2.5 | *Required*: spl | [:mag:](http://www.google.com/search?q=php+PDO)
**PDO_Firebird** | 7.2.5 | *Required*: pdo | [:mag:](http://www.google.com/search?q=php+PDO_Firebird)
**pdo_mysql** | 7.2.5 | *Required*: pdo, mysqlnd | [:mag:](http://www.google.com/search?q=php+pdo_mysql)
**PDO_ODBC** | 7.2.5 | *Required*: pdo | [:mag:](http://www.google.com/search?q=php+PDO_ODBC)
**pdo_pgsql** | 7.2.5 | *Required*: pdo | [:mag:](http://www.google.com/search?q=php+pdo_pgsql)
**pdo_sqlite** | 7.2.5 | *Required*: pdo | [:mag:](http://www.google.com/search?q=php+pdo_sqlite)
**pgsql** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+pgsql)
**Phar** | 2.0.2 | *Optional*: apc, bz2, openssl, zlib, standard | [:mag:](http://www.google.com/search?q=php+Phar)
**posix** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+posix)
**pspell** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+pspell)
**psr** | 0.4.0 | *Required*: spl | [:mag:](http://www.google.com/search?q=php+psr)
**raphf** | 2.0.0 |  | [:mag:](http://www.google.com/search?q=php+raphf)
**rar** | 4.0.0 |  | [:mag:](http://www.google.com/search?q=php+rar)
**readline** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+readline)
**recode** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+recode)
**redis** | 4.0.2 | *Required*: igbinary | [:mag:](http://www.google.com/search?q=php+redis)
**Reflection** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+Reflection)
**request** | 1.0.0 | *Required*: spl, date | [:mag:](http://www.google.com/search?q=php+request)
**rrd** | 2.0.1 |  | [:mag:](http://www.google.com/search?q=php+rrd)
**SeasLog** | 1.8.4 |  | [:mag:](http://www.google.com/search?q=php+SeasLog)
**session** | 7.2.5 | *Optional*: hash | [:mag:](http://www.google.com/search?q=php+session)
**shmop** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+shmop)
**SimpleXML** | 7.2.5 | *Required*: libxml, spl | [:mag:](http://www.google.com/search?q=php+SimpleXML)
**soap** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+soap)
**sockets** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sockets)
**sodium** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sodium)
**SPL** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+SPL)
**SPX** | 0.2.4 |  | [:mag:](http://www.google.com/search?q=php+SPX)
**sqlite3** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sqlite3)
**ssh2** | 1.1.2 |  | [:mag:](http://www.google.com/search?q=php+ssh2)
**standard** | 7.2.5 | *Optional*: session | [:mag:](http://www.google.com/search?q=php+standard)
**swoole** | 2.2.0 |  | [:mag:](http://www.google.com/search?q=php+swoole)
**sync** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+sync)
**sysvmsg** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sysvmsg)
**sysvsem** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sysvsem)
**sysvshm** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+sysvshm)
**tidy** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+tidy)
**tokenizer** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+tokenizer)
**uopz** | 5.0.2 |  | [:mag:](http://www.google.com/search?q=php+uopz)
**uv** | 0.2.2 |  | [:mag:](http://www.google.com/search?q=php+uv)
**varnish** | 1.2.3 | *Required*: hash | [:mag:](http://www.google.com/search?q=php+varnish)
**vcollect** | 1.0.0 |  | [:mag:](http://www.google.com/search?q=php+vcollect)
**vips** | 1.0.8 |  | [:mag:](http://www.google.com/search?q=php+vips)
**wddx** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+wddx)
**xdebug** | 2.7.0 |  | [:mag:](http://www.google.com/search?q=php+xdebug)
**xhprof** | 0.9.5 |  | [:mag:](http://www.google.com/search?q=php+xhprof)
**xml** | 7.2.5 | *Required*: libxml | [:mag:](http://www.google.com/search?q=php+xml)
**xmlreader** | 7.2.5 | *Required*: libxml | [:mag:](http://www.google.com/search?q=php+xmlreader)
**xmlrpc** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+xmlrpc)
**xmlwriter** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+xmlwriter)
**xsl** | 7.2.5 | *Required*: libxml | [:mag:](http://www.google.com/search?q=php+xsl)
**yac** | 2.0.2 |  | [:mag:](http://www.google.com/search?q=php+yac)
**yaf** | 3.0.7 | *Required*: spl, pcre | [:mag:](http://www.google.com/search?q=php+yaf)
**yaml** | 2.0.2 | *Optional*: date | [:mag:](http://www.google.com/search?q=php+yaml)
**Zend OPcache** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+Zend+OPcache)
**Zephir Parser** | 1.1.2 |  | [:mag:](http://www.google.com/search?q=php+Zephir+Parser)
**zip** | 1.15.2 |  | [:mag:](http://www.google.com/search?q=php+zip)
**zlib** | 7.2.5 |  | [:mag:](http://www.google.com/search?q=php+zlib)
**zmq** | 1.1.3 |  | [:mag:](http://www.google.com/search?q=php+zmq)

#### Zephir installation

  Use `install-zephir` and it's installed globaly for compile zehpir codes.

#### Composer

  Latest version of php package manager also installed globaly. [Read more...](https://getcomposer.org/)

### Node.js

  Latest 8 version. [Read more...](https://nodejs.org/en/)

  Latest version of [npm](http://npmjs.org/) and [yarn](https://yarnpkg.com/) also installed.

### immortal

  A *nix cross-platform (OS agnostic) supervisor.
  [Read more...](https://immortal.run/)

### Jobber

  Jobber is a utility for Unix-like systems that can run arbitrary commands, or “jobs”, according to a schedule. It is meant to be a better alternative to the classic Unix utility cron.
  [Read more...](https://dshearer.github.io/jobber/)

### Fluentbit

  Fluent Bit is an open source and multi-platform Log Processor and Forwarder which allows you to collect data/logs from different sources, unify and send them to multiple destinations.
  [Read more...](https://fluentbit.io/)

  All logs store in json format in `/tmpfs/fluentbit/logs.log`.

## Usage

### Pull docker image

```bash
docker pull quay.io/aasaam/aasaam-app:stable
```

### Clone application structure

```bash
git clone --depth=1 -b stable https://github.com/AASAAM/aasaam-app example-app
```

  Remove `.git`, `Dockerfile`, `README.md` and `conf`. You dont need them for your app.

### Configure

#### Modify initialize container

  Modify `app/entrypoint`

#### Modify your nginx configuration `app/etc/nginx`

  Copy `default.conf-sample` to `default.conf` and modify it.

#### Start container

```bash
docker run --name aasaam-testapp -h aasaam-testapp \
  -it -v $(pwd)/app:/app  \
  --cap-add SYS_PTRACE \ # for phpfpm slow logs
  --tmpfs /tmpfs:rw,size=2048m,noatime,mode=1777 \
  --publish=80:80 \
  -d quay.io/aasaam/aasaam-app:stable entrypoint
```
