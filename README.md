# AASAAM Application Docker Image

Docker image for PHP and JavaScript applications.

[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)
![MIT License](https://img.shields.io/badge/license-MIT-ff9900.svg "MIT License")

![ubuntu](https://img.shields.io/badge/ubuntu-18.04-blue.svg "ubuntu")
![dnsmasq](https://img.shields.io/badge/dnsmasq-2.7-blue.svg "dnsmasq")
![nginx](https://img.shields.io/badge/nginx-1.14.0-blue.svg "nginx")
![nghttpd](https://img.shields.io/badge/nghttpd-1.30.0-blue.svg "nghttpd")
![certbot](https://img.shields.io/badge/certbot-0.23.0-blue.svg "certbot")
![php](https://img.shields.io/badge/php-7.2.5-blue.svg "php")
![composer](https://img.shields.io/badge/composer-1.6.5-blue.svg "composer")
![nodejs](https://img.shields.io/badge/nodejs-8.11.2-blue.svg "nodejs")
![npm](https://img.shields.io/badge/npm-5.10.0-blue.svg "npm")
![yarn](https://img.shields.io/badge/yarn-1.7.0-blue.svg "yarn")
![immortal](https://img.shields.io/badge/immortal-0.19.0-blue.svg "immortal")
![jobber](https://img.shields.io/badge/jobber-1.3.2-blue.svg "jobber")
![fluentbit](https://img.shields.io/badge/fluentbit-0.13.2-blue.svg "fluentbit")
![chromium](https://img.shields.io/badge/chromium-66.0-blue.svg "chromium")

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

#### Compiled extensions list

**amqp** *(1.9.3)*,
**apcu** *(5.1.11)*,
**ast** *(0.1.6)*,
**base58** *(0.1.2)*,
**bcmath**,
**bz2**,
**calendar**,
**Core**,
**ctype**,
**curl**,
**date**,
**dba**,
**dom**,
**ds** *(1.2.6)*,
**enchant**,
**ev** *(1.0.4)*,
**event** *(2.4.0)*,
**exif**,
**fann** *(1.1.1)*,
**fileinfo** *(1.0.5)*,
**filter**,
**ftp**,
**gd**,
**geoip** *(1.1.1)*,
**geospatial** *(0.2.1)*,
**gettext**,
**gmp**,
**gnupg** *(1.4.0)*,
**grpc** *(1.12.0)*,
**hash**,
**hashids** *(0.1.0)*,
**hprose** *(1.6.6)*,
**hrtime** *(0.6.0)*,
**iconv**,
**igbinary** *(2.0.6)*,
**imagick** *(3.4.3)*,
**imap**,
**interbase**,
**intl** *(1.1.0)*,
**json** *(1.6.0)*,
**jsond** *(1.4.0)*,
**jwt** *(0.2.1)*,
**ldap**,
**libevent** *(0.2.0)*,
**libxml**,
**mbstring**,
**memcached** *(3.0.4)*,
**mongodb** *(1.4.3)*,
**msgpack** *(2.0.2)*,
**mysqli**,
**mysqlnd**,
**odbc**,
**opencensus** *(0.2.2)*,
**openssl**,
**pcntl**,
**pcre**,
**PDO**,
**PDO_Firebird**,
**pdo_mysql**,
**PDO_ODBC**,
**pdo_pgsql**,
**pdo_sqlite**,
**pgsql**,
**Phar** *(2.0.2)*,
**posix**,
**pspell**,
**psr** *(0.4.0)*,
**raphf** *(2.0.0)*,
**rar** *(4.0.0)*,
**readline**,
**recode**,
**redis** *(4.0.2)*,
**Reflection**,
**request** *(1.0.0)*,
**rrd** *(2.0.1)*,
**SeasLog** *(1.8.4)*,
**session**,
**sha3** *(0.2.0)*,
**shmop**,
**SimpleXML**,
**soap**,
**sockets**,
**sodium**,
**SPL**,
**SPX** *(0.2.4)*,
**sqlite3**,
**ssh2** *(1.1.2)*,
**standard**,
**swoole** *(2.2.0)*,
**sync** *(1.1.1)*,
**sysvmsg**,
**sysvsem**,
**sysvshm**,
**tidy**,
**tokenizer**,
**uopz** *(5.0.2)*,
**uv** *(0.2.2)*,
**varnish** *(1.2.3)*,
**vcollect** *(1.0.0)*,
**vips** *(1.0.8)*,
**wddx**,
**xdebug** *(2.7.0)*,
**xhprof** *(0.9.5)*,
**xml**,
**xmlreader**,
**xmlrpc**,
**xmlwriter**,
**xsl**,
**yac** *(2.0.2)*,
**yaf** *(3.0.7)*,
**yaml** *(2.0.2)*,
**Zend OPcache**,
**Zephir Parser** *(1.1.2)*,
**zip** *(1.15.2)*,
**zlib**,
**zmq** *(1.1.3)*

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

### Chromium

  Chromium is an open-source Web browser project started by Google, to provide the source code for the proprietary Google Chrome browser.
  [Read more...](https://chromium.org/)

  **Why?** Because we need puppeter for testing, pdf and image generation.
  [Read more about puppeteer](https://github.com/GoogleChrome/puppeteer)

### Beanstalkd

  Beanstalk is a simple, fast work queue.
  [Read more...](http://kr.github.io/beanstalkd/)

### Dnsmasq

  Dns/cache server for improve dns lookup inside container.
  [Read more...](http://www.thekelleys.org.uk/dnsmasq/doc.html)

### Certbot

  Automatically enable HTTPS on your website with EFF's Certbot, deploying Let's Encrypt certificates.
  [Read more...](https://certbot.eff.org/)

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
docker run --name sampleapp -h sampleapp -it \
  -v $(pwd)/app:/app \
  -v $(pwd)/.jobber:/root/.jobber \
  -v $(pwd)/var/tmp:/tmp \
  -v $(pwd)/var/letsencrypt:/etc/letsencrypt \
  # -e CONTAINER_ENV='dev' \ # container in development mode
  -e CONTAINER_NAME='sampleapp' \ # container name
  -e CONTAINER_DATACENTER='dc1' \ # datacenter name
  -e CONTAINER_COUNTRY='IR' \ # country code
  --cap-add SYS_PTRACE \ # for phpfpm slow logs
  --tmpfs /tmpfs:rw,size=2048m,noatime,mode=1777 \ # !!! required
  --publish=80:80 \
  --publish=443:443 \
  --dns=127.0.0.1 \ # for force dns inside container
  -d quay.io/aasaam/aasaam-app:stable entrypoint
```

#### Container helper

  You can use `container-helper` command to configure container on the fly.
  It's change configuration of nginx, php in several profiles.
