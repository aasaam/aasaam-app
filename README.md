[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)

![ubuntu](https://img.shields.io/badge/ubuntu-18.04-blue.svg "ubuntu")
![nginx](https://img.shields.io/badge/nginx-1.14.0-blue.svg "nginx")
![nghttpd](https://img.shields.io/badge/nghttpd-1.30.0-blue.svg "nghttpd")
![php](https://img.shields.io/badge/php-7.2.5-blue.svg "php")
![composer](https://img.shields.io/badge/composer-1.6.5-blue.svg "composer")
![nodejs](https://img.shields.io/badge/nodejs-8.11.2-blue.svg "nodejs")
![npm](https://img.shields.io/badge/npm-5.10.0-blue.svg "npm")
![yarn](https://img.shields.io/badge/yarn-1.7.0-blue.svg "yarn")
![immortal](https://img.shields.io/badge/immortal-0.19.0-blue.svg "immortal")
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

#### Compiled extensions list

Extension | Version | Dependency | Info
 ---  |  ---  |  ---  |  ---
**amqp** | 1.9.3 |  | [:mag:](http://www.google.com/search?q=php+amqp+extension)
**apcu** | 5.1.11 |  | [:mag:](http://www.google.com/search?q=php+apcu+extension)
**ast** | 0.1.6 |  | [:mag:](http://www.google.com/search?q=php+ast+extension)
**ds** | 1.2.6 | *Required*: json, spl | [:mag:](http://www.google.com/search?q=php+ds+extension)
**ev** | 1.0.4 | *Optional*: sockets | [:mag:](http://www.google.com/search?q=php+ev+extension)
**event** | 2.4.0 | *Required*: sockets | [:mag:](http://www.google.com/search?q=php+event+extension)
**fann** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+fann+extension)
**fileinfo** | 1.0.5 |  | [:mag:](http://www.google.com/search?q=php+fileinfo+extension)
**geoip** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+geoip+extension)
**geospatial** | 0.2.1 |  | [:mag:](http://www.google.com/search?q=php+geospatial+extension)
**gnupg** | 1.4.0 |  | [:mag:](http://www.google.com/search?q=php+gnupg+extension)
**grpc** | 1.12.0 |  | [:mag:](http://www.google.com/search?q=php+grpc+extension)
**hprose** | 1.6.6 |  | [:mag:](http://www.google.com/search?q=php+hprose+extension)
**hrtime** | 0.6.0 |  | [:mag:](http://www.google.com/search?q=php+hrtime+extension)
**igbinary** | 2.0.6 | *Required*: standard, session | [:mag:](http://www.google.com/search?q=php+igbinary+extension)
**imagick** | 3.4.3 | *Required*: spl | [:mag:](http://www.google.com/search?q=php+imagick+extension)
**intl** | 1.1.0 |  | [:mag:](http://www.google.com/search?q=php+intl+extension)
**json** | 1.6.0 |  | [:mag:](http://www.google.com/search?q=php+json+extension)
**jsond** | 1.4.0 |  | [:mag:](http://www.google.com/search?q=php+jsond+extension)
**libevent** | 0.2.0 | *Optional*: sockets | [:mag:](http://www.google.com/search?q=php+libevent+extension)
**memcached** | 3.0.4 | *Required*: session, igbinary, msgpack, spl | [:mag:](http://www.google.com/search?q=php+memcached+extension)
**mongodb** | 1.4.3 | *Required*: date, json, spl, standard | [:mag:](http://www.google.com/search?q=php+mongodb+extension)
**msgpack** | 2.0.2 |  | [:mag:](http://www.google.com/search?q=php+msgpack+extension)
**opencensus** | 0.2.2 |  | [:mag:](http://www.google.com/search?q=php+opencensus+extension)
**Phar** | 2.0.2 | *Optional*: apc, bz2, openssl, zlib, standard | [:mag:](http://www.google.com/search?q=php+Phar+extension)
**psr** | 0.4.0 | *Required*: spl | [:mag:](http://www.google.com/search?q=php+psr+extension)
**raphf** | 2.0.0 |  | [:mag:](http://www.google.com/search?q=php+raphf+extension)
**rar** | 4.0.0 |  | [:mag:](http://www.google.com/search?q=php+rar+extension)
**redis** | 4.0.2 | *Required*: igbinary | [:mag:](http://www.google.com/search?q=php+redis+extension)
**request** | 1.0.0 | *Required*: spl, date | [:mag:](http://www.google.com/search?q=php+request+extension)
**rrd** | 2.0.1 |  | [:mag:](http://www.google.com/search?q=php+rrd+extension)
**SeasLog** | 1.8.4 |  | [:mag:](http://www.google.com/search?q=php+SeasLog+extension)
**SPX** | 0.2.4 |  | [:mag:](http://www.google.com/search?q=php+SPX+extension)
**ssh2** | 1.1.2 |  | [:mag:](http://www.google.com/search?q=php+ssh2+extension)
**swoole** | 2.2.0 |  | [:mag:](http://www.google.com/search?q=php+swoole+extension)
**sync** | 1.1.1 |  | [:mag:](http://www.google.com/search?q=php+sync+extension)
**uopz** | 5.0.2 |  | [:mag:](http://www.google.com/search?q=php+uopz+extension)
**uv** | 0.2.2 |  | [:mag:](http://www.google.com/search?q=php+uv+extension)
**varnish** | 1.2.3 | *Required*: hash | [:mag:](http://www.google.com/search?q=php+varnish+extension)
**vcollect** | 1.0.0 |  | [:mag:](http://www.google.com/search?q=php+vcollect+extension)
**vips** | 1.0.8 |  | [:mag:](http://www.google.com/search?q=php+vips+extension)
**xdebug** | 2.7.0 |  | [:mag:](http://www.google.com/search?q=php+xdebug+extension)
**xhprof** | 0.9.5 |  | [:mag:](http://www.google.com/search?q=php+xhprof+extension)
**yac** | 2.0.2 |  | [:mag:](http://www.google.com/search?q=php+yac+extension)
**yaf** | 3.0.7 | *Required*: spl, pcre | [:mag:](http://www.google.com/search?q=php+yaf+extension)
**yaml** | 2.0.2 | *Optional*: date | [:mag:](http://www.google.com/search?q=php+yaml+extension)
**zip** | 1.15.2 |  | [:mag:](http://www.google.com/search?q=php+zip+extension)
**zmq** | 1.1.3 |  | [:mag:](http://www.google.com/search?q=php+zmq+extension)

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
