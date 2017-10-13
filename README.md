[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)

# AASAAM Application Docker Image
Docker image for PHP and JavaScript applications.

### Ubuntu Xenial
  Docker image based on latest LTS version of popular linux distro.
  [Read more...](https://wiki.ubuntu.com/XenialXerus/ReleaseNotes)
### Nginx

  Latest stable version of nginx with http2 support also additional modules.

  [Read more...](https://nginx.org/)

###### Modules:
  [headers-more](https://github.com/openresty/headers-more-nginx-module), [rtmp](https://github.com/arut/nginx-rtmp-module), [vod](https://github.com/kaltura/nginx-vod-module), [redis2](https://github.com/kaltura/nginx-vod-module), [http-concat](https://github.com/alibaba/nginx-http-concat), [srcache](https://github.com/openresty/srcache-nginx-module)

### PHP
  Latest stable version **7.1** of PHP with many extension that could be enabled by entrypoint file in `app/entrypoint`

###### Extensions:
[apcu](http://php.net/apcu),
[amqp](https://github.com/php-amqplib/php-amqplib),
[ast](https://github.com/nikic/php-ast),
[bcmath](http://php.net/bcmath),
[bz2](http://php.net/manual/en/book.bzip2.php),
[calendar](http://php.net/calendar),
Core,
[couchbase](https://github.com/couchbase/php-couchbase),
[ctype](http://php.net/ctype),
[curl](http://php.net/curl),
[date](http://php.net/manual/en/book.datetime.php),
[dba](http://php.net/dba),
[dom](http://php.net/dom),
[ds](http://php.net/ds),
[enchant](http://php.net/enchant),
[ev](http://php.net/ev),
[exif](http://php.net/exif),
[fann](http://php.net/fann),
[fileinfo](http://php.net/fileinfo),
[filter](http://php.net/filter),
[ftp](http://php.net/ftp),
[gd](http://php.net/manual/en/book.image.php),
[geohash](https://github.com/emirb/php-geohash-ext),
[geoip](http://php.net/geoip),
[geospatial](https://github.com/php-geospatial/geospatial),
[gettext](http://php.net/gettext),
[gmp](http://php.net/gmp),
[gnupg](http://php.net/gnupg),
[grpc](https://github.com/grpc/grpc/tree/master/src/php),
[hash](http://php.net/hash),
[hprose](https://github.com/hprose/hprose-php),
[hrtime](http://php.net/hrtime),
[iconv](http://php.net/iconv),
[igbinary](https://github.com/igbinary/igbinary),
[imagick](http://php.net/imagick),
[intl](http://php.net/intl),
[json](http://php.net/json),
[libevent](http://php.net/libevent),
[libxml](http://php.net/libxml),
[mbstring](http://php.net/mbstring),
[memcached](http://php.net/memcached),
[molten](https://github.com/chuan-yun/Molten),
[mongodb](http://php.net/mongodb),
[msgpack](https://github.com/msgpack/msgpack-php),
[mysqli](http://php.net/mysqli),
[mysqlnd](http://php.net/mysqlnd),
[opencensus](https://github.com/census-instrumentation/opencensus-php),
[openssl](http://php.net/openssl),
[pcntl](http://php.net/pcntl),
[pcre](http://php.net/pcre),
[PDO](http://php.net/PDO),
[pdo_mysql](http://php.net/pdo_mysql),
[pdo_pgsql](http://php.net/pdo_pgsql),
[pdo_sqlite](http://php.net/pdo_sqlite),
[pgsql](http://php.net/pgsql),
[Phar](http://php.net/Phar),
[posix](http://php.net/posix),
[raphf](https://mdref.m6w6.name/raphf),
[rar](http://php.net/rar),
[readline](http://php.net/readline),
[redis](https://github.com/phpredis/phpredis),
[Reflection](http://php.net/Reflection),
[request](https://github.com/pmjones/ext-request/blob/master/README.md),
[rrd](http://php.net/rrd),
[SeasLog](https://github.com/Neeke/SeasLog),
[session](http://php.net/manual/en/book.session.php),
[shmop](http://php.net/shmop),
[SimpleXML](http://php.net/SimpleXML),
[soap](http://php.net/soap),
[sockets](http://php.net/sockets),
[SPL](http://php.net/SPL),
[SPX](https://github.com/NoiseByNorthwest/php-spx),
[sqlite3](http://php.net/sqlite3),
[ssh2](http://php.net/ssh2),
standard,
[swoole](http://www.swoole.com/),
[sync](http://php.net/sync),
sysvmsg,
sysvsem,
sysvshm,
[tidy](http://php.net/tidy),
[tokenizer](http://php.net/tokenizer),
[uv](https://github.com/chobie/php-uv),
[v8](https://github.com/pinepain/php-v8),
[v8js](http://php.net/v8js),
[varnish](http://php.net/varnish),
[vcollect](https://github.com/viest/v-collect),
[wddx](http://php.net/wddx),
[xdebug](https://xdebug.org/),
[xhprof](http://php.net/xhprof),
[xml](http://php.net/xml),
[xmlreader](http://php.net/xmlreader),
[xmlrpc](http://php.net/xmlrpc),
[xmlwriter](http://php.net/xmlwriter),
[xsl](http://php.net/xsl),
[yac](https://github.com/laruence/yac),
[yaf](http://php.net/yaf),
[yaml](http://php.net/yaml),
[yar](http://php.net/yar),
[Zend OPcache](http://php.net/manual/en/book.opcache.php),
[zip](http://php.net/zip),
[zlib](http://php.net/zlib),
[zmq](http://php.net/zmq)

###### Composer
  Latest version of php package manager also installed globaly. [Read more...](https://getcomposer.org/)

### Node.js
  Latest 8 version compiled with embedded icu. [Read more...](https://nodejs.org/en/)

  Latest version of [npm](http://npmjs.org/) and [yarn](https://yarnpkg.com/) also installed.


### Supervisor
  Supervisor is a client/server system that allows its users to monitor and control a number of processes on UNIX-like operating systems.
  [Read more...](http://supervisord.org/)

### Beanstalk
  Beanstalk is a simple, fast work queue.
  [Read more...](http://kr.github.io/beanstalkd/)

## Usage
### Pull docker image

  ```docker pull quay.io/aasaam/aasaam-app```

### Configure:
1. Initialize container
  `app/entrypoint`
2. Nginx configuration
  `app/etc/nginx`
3. Supervisor configuration
  `app/etc/supervisor/supervisor.ini`

### Start container
```
docker run --restart=always --name example-app -h example-app \
  -it -v $(pwd)/app:/app -v $(pwd)/tmp:/tmp -v $(pwd)/files:/files \
  --publish=443:443 --publish=80:80 \
  -d quay.io/aasaam/aasaam-app:latest entrypoint
```
