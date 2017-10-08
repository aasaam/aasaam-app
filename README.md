[![Docker Repository on Quay](https://quay.io/repository/aasaam/aasaam-app/status "Docker Repository on Quay")](https://quay.io/repository/aasaam/aasaam-app)

# AASAAM Application Docker
Docker image for aasaam PHP/JavaScript application.

* Based on Ubuntu xenial
* Nginx stable with modules

  headers-more, rtmp, vod, redis2, http-concat, srcache
* PHP7.1:

  extenstion list:
  amqp, apcu, ast, bcmath, bz2, calendar, Core, couchbase, ctype, curl, date, dba, dom, ds, enchant, ev, exif, fann, fileinfo, filter, ftp, gd, geoip, gettext, gmp, gnupg, grpc, hash, hprose, hrtime, iconv, igbinary, imagick, intl, json, libevent, libxml, mbstring, memcached, molten, mongodb, msgpack, mysqli, mysqlnd, opencensus, openssl, pcntl, pcre, PDO, pdo_mysql, pdo_pgsql, pdo_sqlite, pgsql, Phar, posix, raphf, rar, readline, redis, Reflection, request, rrd, SeasLog, session, shmop, SimpleXML, soap, sockets, sodium, SPL, sqlite3, ssh2, standard, swoole, sync, sysvmsg, sysvsem, sysvshm, tidy, tokenizer, uv, v8, v8js, varnish, wddx, xdebug, xhprof, xml, xmlreader, xmlrpc, xmlwriter, xsl, yac, yaf, yaml, yar, Zend OPcache, zip, zlib, zmq
* node.js 8.x with icu (embedded)
* supervisord
* beanstalkd

## Usage
### Pull docker image

  ```docker pull quay.io/aasaam/aasaam-app```

### Configure:
1. Intialize container
  `app/entrypoint`
2. Nginx configuration
  `app/etc/nginx`
3. supervisor configuration
  `app/etc/supervisor/supervisor.ini`

### Start container
```
docker run --restart=always --name aasaam-app -h aasaam-app \
  -it -v $(pwd)/app:/app -v $(pwd)/var/tmp:/tmp -v $(pwd)/files:/files \
  --publish=80:80 --publish=443:443 \
  -d quay.io/aasaam/aasaam-app:latest entrypoint
```
