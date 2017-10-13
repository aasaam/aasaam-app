[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)

# AASAAM Application Docker Image
Docker image for PHP and JavaScript applications.

### Ubuntu Xenial
  Docker image based on latest LTS version of popular linux distro.
  [Read more...](https://wiki.ubuntu.com/XenialXerus/ReleaseNotes)
### Nginx

  Latest version of nginx with http2 support also additional modules.

  [Read more...](https://nginx.org/)

###### New modules:
  [headers-more](https://github.com/openresty/headers-more-nginx-module), [rtmp](https://github.com/arut/nginx-rtmp-module), [vod](https://github.com/kaltura/nginx-vod-module), [redis2](https://github.com/kaltura/nginx-vod-module), [http-concat](https://github.com/alibaba/nginx-http-concat), [srcache](https://github.com/openresty/srcache-nginx-module)

### PHP
  Latest stable version **7.1** of PHP with many extension that could be enabled by entrypoint file in `app/entrypoint`

###### Extensions:
  amqp, apcu, ast, bcmath, bz2, calendar, Core, couchbase, ctype, curl, date, dba, dom, ds, enchant, ev, exif, fann, fileinfo, filter, ftp, gd, geohash, geoip, geospatial, gettext, gmp, gnupg, grpc, hash, hprose, hrtime, iconv, igbinary, imagick, intl, json, libevent, libxml, mbstring, memcached, molten, mongodb, msgpack, mysqli, mysqlnd, opencensus, openssl, pcntl, pcre, PDO, pdo_mysql, pdo_pgsql, pdo_sqlite, pgsql, Phar, posix, raphf, rar, readline, redis, Reflection, request, rrd, SeasLog, session, shmop, SimpleXML, soap, sockets, SPL, SPX, sqlite3, ssh2, standard, swoole, sync, sysvmsg, sysvsem, sysvshm, tidy, tokenizer, uv, v8, v8js, varnish, vcollect, wddx, xdebug, xhprof, xml, xmlreader, xmlrpc, xmlwriter, xsl, yac, yaf, yaml, yar, Zend OPcache, zip, zlib, zmq

### Node.js
  Latest 8 version compiled with embedded icu.
  [Read more...](https://nodejs.org/en/)

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
  -it -v $PROJECTPATH/app:/app -v $VARPATH/tmp:/tmp -v $VARPATH/files:/files \
  --publish=443:443 --publish=80:80 \
  -d quay.io/aasaam/aasaam-app:latest entrypoint
```
