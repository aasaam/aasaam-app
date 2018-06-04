# ubuntu:18.04
FROM ubuntu:18.04

# build-time metadata as defined at http://label-schema.org
LABEL org.label-schema.name="AAASAAM Application Docker Image" \
      org.label-schema.description="Docker image for PHP and JavaScript applications." \
      org.label-schema.url="https://aasaam.com" \
      org.label-schema.vcs-url="https://github.com/AASAAM/aasaam-app" \
      org.label-schema.vendor="AASAAM" \
      org.label-schema.version="2.0.2" \
      org.label-schema.schema-version="2.0.2" \
      maintainer="Muhammad Hussein Fattahizadeh <m@mhf.ir>"

# installation
RUN export DEBIAN_FRONTEND=noninteractive ; \
  export YARN_CACHE_FOLDER=/tmp/yarn ; \
  export COMPOSER_CACHE_DIR=/tmp/composer ; \
  export LANG=en_US.utf8 ; \
  export LC_ALL=C.UTF-8 ; \
  apt-get update -y \
  && apt-get -y upgrade && apt-get install -y --no-install-recommends apt-utils \
  && apt-get install -y --no-install-recommends \
    curl locales ca-certificates \
    build-essential sudo gnupg \
  && localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US \
  && mkdir -p /tmp/yarn && echo 'cache = "/tmp/npm"' > /root/.npmrc \
  && curl -L http://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
  && curl -L http://deb.nodesource.com/gpgkey/nodesource.gpg.key | sudo apt-key add - \
  && echo 'deb http://dl.yarnpkg.com/debian/ stable main' >> /etc/apt/sources.list.d/repo.list \
  && echo "deb http://deb.nodesource.com/node_8.x bionic main" | sudo tee /etc/apt/sources.list.d/nodesource.list \
  && curl -s https://packagecloud.io/install/repositories/immortal/immortal/script.deb.sh | sudo bash \
  && apt-get update -y \
  && apt-get install -y --no-install-recommends \
    bash-completion lsb-release git cmake certbot \
    autoconf automake autotools-dev binutils chromium-browser cython htop imagemagick immortal iputils-ping \
    libc-ares-dev libcunit1-dev libcurl4-openssl-dev libev-dev libevent-dev libfann-dev libbase58-dev libfribidi-bin \
    libgeoip-dev libgpgme11-dev libhiredis-dev libjansson-dev libjemalloc-dev libmagickwand-dev libmemcached-dev \
    libnghttp2-dev librabbitmq-dev librrd-dev libspdylay-dev libssh2-1-dev libssl-dev libsystemd-dev libtool libuv1-dev \
    libvarnishapi-dev libvips libvips-dev libxml2-dev libyaml-dev libzmq3-dev \
    nano vim graphviz apache2-utils \
    logrotate nghttp2 nghttp2-client nghttp2-proxy nghttp2-server nginx-extras nodejs yarn dnsmasq \
    pkg-config python re2c xterm zlib1g-dev \
    php7.2 php7.2-bcmath php7.2-bz2 php7.2-cgi php7.2-cli php7.2-common php7.2-curl php7.2-dba php7.2-dev php7.2-enchant \
    php7.2-fpm php7.2-gd php7.2-gmp php7.2-imap php7.2-interbase php7.2-intl php7.2-json php7.2-ldap php7.2-mbstring php7.2-mysql \
    php7.2-odbc php7.2-opcache php7.2-pgsql php7.2-phpdbg php7.2-pspell php7.2-readline php7.2-recode php7.2-soap php7.2-sqlite3 \
    php7.2-tidy php7.2-xml php7.2-xmlrpc php7.2-xsl php7.2-zip \
  ## geoip
  && curl -L http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz > /tmp/GeoLiteCity.dat.gz \
  && cd /tmp/ && gunzip GeoLiteCity.dat.gz && mkdir -p /usr/local/share/GeoIP && mv GeoLiteCity.dat /usr/local/share/GeoIP/GeoIPCity.dat \
  && curl -L http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz > /tmp/GeoIP.dat.gz \
  && cd /tmp/ && gunzip GeoIP.dat.gz && mkdir -p /usr/local/share/GeoIP && mv GeoIP.dat /usr/local/share/GeoIP/GeoIP.dat \
  ## update npm
  && npm -g update \
  ## nano rc
  && git clone --depth=1 https://github.com/scopatz/nanorc.git ~/.nano && cp ~/.nano/nanorc ~/.nanorc && rm -rf ~/.nano/.git \
  && find ~/.nano -type f ! -name '*.nanorc' -delete \
  ## fluentbit
  && cd /tmp && curl -L https://fluentbit.io/releases/0.13/fluent-bit-0.13.2.tar.gz > fluent-bit.tgz && tar -xf fluent-bit.tgz \
  && cd fluent-bit*/build && cmake ../ && make && make install \
  # jobber
  && cd /tmp \
  && curl -L https://github.com/dshearer/jobber/releases/download/v1.3.2/jobber_1.3.2-1_amd64_ubuntu16.deb > /tmp/jobber.deb \
  && dpkg -i /tmp/jobber.deb \
  ## beanstalkd
  && cd /tmp/ && git clone --depth=1 https://github.com/kr/beanstalkd && cd beanstalkd && make && make install \
  ## php extensions
  && cd /tmp && curl -L https://pecl.php.net/get/igbinary > igbinary.tgz && tar -xf igbinary.tgz && cd igbinary-* && phpize && ./configure \
  && make && make install && echo '; priority=1' > /etc/php/7.2/mods-available/igbinary.ini \
  && echo 'extension=igbinary.so' >> /etc/php/7.2/mods-available/igbinary.ini && phpenmod igbinary \
  && cd /tmp && curl -L https://pecl.php.net/get/msgpack > msgpack.tgz && tar -xf msgpack.tgz && cd msgpack-* && phpize && ./configure \
  && make && make install && echo '; priority=1' > /etc/php/7.2/mods-available/msgpack.ini \
  && echo 'extension=msgpack.so' >> /etc/php/7.2/mods-available/msgpack.ini && phpenmod msgpack \
  && cd /tmp && curl -L https://pecl.php.net/get/yaml > yaml.tgz && tar -xf yaml.tgz && cd yaml-* && phpize && ./configure \
  && make && make install && echo 'extension=yaml.so' > /etc/php/7.2/mods-available/yaml.ini && phpenmod yaml \
  && cd /tmp && curl -L https://pecl.php.net/get/imagick > imagick.tgz && tar -xf imagick.tgz && cd imagick-* && phpize && ./configure \
  && make && make install && echo 'extension=imagick.so' > /etc/php/7.2/mods-available/imagick.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/memcached > memcached.tgz && tar -xf memcached.tgz && cd memcached-* && phpize && ./configure --enable-memcached-igbinary --enable-memcached-json --enable-memcached-msgpack \
  && make && make install && echo 'extension=memcached.so' > /etc/php/7.2/mods-available/memcached.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/hrtime > hrtime.tgz && tar -xf hrtime.tgz && cd hrtime-* && phpize && ./configure \
  && make && make install && echo 'extension=hrtime.so' > /etc/php/7.2/mods-available/hrtime.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/ds > ds.tgz && tar -xf ds.tgz && cd ds-* && phpize && ./configure \
  && make && make install && echo '; priority=70' > /etc/php/7.2/mods-available/ds.ini \
  && echo 'extension=ds.so' >> /etc/php/7.2/mods-available/ds.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/zmq > zmq.tgz && tar -xf zmq.tgz && cd zmq-* && phpize && ./configure \
  && make && make install && echo 'extension=zmq.so' > /etc/php/7.2/mods-available/zmq.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/ssh2 > ssh2.tgz && tar -xf ssh2.tgz && cd ssh2-* && phpize && ./configure \
  && make && make install && echo 'extension=ssh2.so' > /etc/php/7.2/mods-available/ssh2.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/redis > redis.tgz && tar -xf redis.tgz && cd redis-* && phpize && ./configure --enable-redis-igbinary \
  && make && make install && echo 'extension=redis.so' > /etc/php/7.2/mods-available/redis.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/APCu > APCu.tgz && tar -xf APCu.tgz && cd apcu-* && phpize && ./configure \
  && make && make install && echo 'extension=apcu.so' > /etc/php/7.2/mods-available/apcu.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/jsond > jsond.tgz && tar -xf jsond.tgz && cd jsond-* && phpize && ./configure \
  && make && make install && echo 'extension=jsond.so' > /etc/php/7.2/mods-available/jsond.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/mongodb > mongodb.tgz && tar -xf mongodb.tgz && cd mongodb-* && phpize && ./configure \
  && make && make install && echo 'extension=mongodb.so' > /etc/php/7.2/mods-available/mongodb.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/swoole > swoole.tgz && tar -xf swoole.tgz && cd swoole-* && phpize \
  && ./configure --enable-openssl --enable-http2 --enable-async-redis --enable-coroutine --enable-mysqlnd \
  && make && make install && echo 'extension=swoole.so' > /etc/php/7.2/mods-available/swoole.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/amqp > amqp.tgz && tar -xf amqp.tgz && cd amqp-* && phpize && ./configure \
  && make && make install && echo 'extension=amqp.so' > /etc/php/7.2/mods-available/amqp.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/gRPC > gRPC.tgz && tar -xf gRPC.tgz && cd grpc-* && phpize && ./configure \
  && make && make install && echo 'extension=grpc.so' > /etc/php/7.2/mods-available/grpc.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/yaf > yaf.tgz && tar -xf yaf.tgz && cd yaf-* && phpize && ./configure \
  && make && make install && echo 'extension=yaf.so' > /etc/php/7.2/mods-available/yaf.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/ev > ev.tgz && tar -xf ev.tgz && cd ev-* && phpize && ./configure \
  && make && make install && echo 'extension=ev.so' > /etc/php/7.2/mods-available/ev.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/event > event.tgz && tar -xf event.tgz && cd event-* && phpize && ./configure --with-event-core --with-event-extra --with-event-openssl \
  && make && make install && echo 'extension=event.so' > /etc/php/7.2/mods-available/event.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/yac > yac.tgz && tar -xf yac.tgz && cd yac-* && phpize && ./configure \
  && make && make install && echo 'extension=yac.so' > /etc/php/7.2/mods-available/yac.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/uv > uv.tgz && tar -xf uv.tgz && cd uv-* && phpize && ./configure \
  && make && make install && echo 'extension=uv.so' > /etc/php/7.2/mods-available/uv.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/hprose > hprose.tgz && tar -xf hprose.tgz && cd hprose-* && phpize && ./configure \
  && make && make install && echo 'extension=hprose.so' > /etc/php/7.2/mods-available/hprose.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/gnupg > gnupg.tgz && tar -xf gnupg.tgz && cd gnupg-* && phpize && ./configure \
  && make && make install && echo 'extension=gnupg.so' > /etc/php/7.2/mods-available/gnupg.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/raphf > raphf.tgz && tar -xf raphf.tgz && cd raphf-* && phpize && ./configure \
  && make && make install && echo 'extension=raphf.so' > /etc/php/7.2/mods-available/raphf.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/rrd > rrd.tgz && tar -xf rrd.tgz && cd rrd-* && phpize && ./configure \
  && make && make install && echo 'extension=rrd.so' > /etc/php/7.2/mods-available/rrd.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/sync > sync.tgz && tar -xf sync.tgz && cd sync-* && phpize && ./configure \
  && make && make install && echo 'extension=sync.so' > /etc/php/7.2/mods-available/sync.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/ast > ast.tgz && tar -xf ast.tgz && cd ast-* && phpize && ./configure \
  && make && make install && echo 'extension=ast.so' > /etc/php/7.2/mods-available/ast.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/request > request.tgz && tar -xf request.tgz && cd request-* && phpize && ./configure \
  && make && make install && echo 'extension=request.so' > /etc/php/7.2/mods-available/request.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/geoip > geoip.tgz && tar -xf geoip.tgz && cd geoip-* && phpize && ./configure \
  && make && make install && echo 'extension=geoip.so' > /etc/php/7.2/mods-available/geoip.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/rar > rar.tgz && tar -xf rar.tgz && cd rar-* && phpize && ./configure \
  && make && make install && echo 'extension=rar.so' > /etc/php/7.2/mods-available/rar.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/SeasLog > SeasLog.tgz && tar -xf SeasLog.tgz && cd SeasLog-* && phpize && ./configure \
  && make && make install && echo 'extension=seaslog.so' > /etc/php/7.2/mods-available/seaslog.ini \
  && echo 'seaslog.default_basepath=/tmpfs/php/seaslog' >> /etc/php/7.2/mods-available/seaslog.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/fann > fann.tgz && tar -xf fann.tgz && cd fann-* && phpize && ./configure \
  && make && make install && echo 'extension=fann.so' > /etc/php/7.2/mods-available/fann.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/vips > vips.tgz && tar -xf vips.tgz && cd vips-* && phpize && ./configure \
  && make && make install && echo 'extension=vips.so' > /etc/php/7.2/mods-available/vips.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/opencensus > opencensus.tgz && tar -xf opencensus.tgz && cd opencensus-* && phpize && ./configure \
  && make && make install && echo 'extension=opencensus.so' > /etc/php/7.2/mods-available/opencensus.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/varnish > varnish.tgz && tar -xf varnish.tgz && cd varnish-* && phpize && ./configure \
  && make && make install && echo 'extension=varnish.so' > /etc/php/7.2/mods-available/varnish.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/uopz > uopz.tgz && tar -xf uopz.tgz && cd uopz-* && phpize && ./configure \
  && make && make install && echo 'extension=uopz.so' > /etc/php/7.2/mods-available/uopz.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/psr > psr.tgz && tar -xf psr.tgz && cd psr-* && phpize && ./configure \
  && make && make install && echo 'extension=psr.so' > /etc/php/7.2/mods-available/psr.ini \
  && cd /tmp && git clone --depth=1 https://github.com/expressif/pecl-event-libevent && cd pecl-event-libevent && phpize && ./configure \
  && make && make install && echo 'extension=libevent.so' > /etc/php/7.2/mods-available/libevent.ini \
  && cd /tmp && git clone --depth=1 https://github.com/viest/v-collect && cd v-collect && phpize && ./configure \
  && make && make install && echo 'extension=vcollect.so' > /etc/php/7.2/mods-available/vcollect.ini \
  && cd /tmp && git clone --depth=1 https://github.com/php-geospatial/geospatial && cd geospatial && phpize && ./configure \
  && make && make install && echo 'extension=geospatial.so' > /etc/php/7.2/mods-available/geospatial.ini \
  && cd /tmp && git clone --depth=1 https://github.com/cdoco/php-jwt && cd php-jwt && phpize && ./configure --with-openssl \
  && make && make install && echo '; priority=70' > /etc/php/7.2/mods-available/jwt.ini \
  && echo 'extension=jwt.so' >> /etc/php/7.2/mods-available/jwt.ini \
  && cd /tmp && git clone --depth=1 https://github.com/legalthings/base58-php-ext && cd base58-php-ext && phpize && ./configure \
  && make && make install && echo 'extension=base58.so' > /etc/php/7.2/mods-available/base58.ini \
  && cd /tmp && git clone --depth=1 https://github.com/strawbrary/php-sha3 && cd php-sha3 && phpize && ./configure \
  && make && make install && echo 'extension=sha3.so' > /etc/php/7.2/mods-available/sha3.ini \
  && cd /tmp && git clone --depth=1 https://github.com/cdoco/hashids.phpc && cd hashids.phpc && phpize && ./configure \
  && make && make install && echo 'extension=hashids.so' > /etc/php/7.2/mods-available/hashids.ini \
  && cd /tmp && git clone --depth=1 https://github.com/NoiseByNorthwest/php-spx && cd php-spx && phpize && ./configure \
  && make && make install && echo 'extension=spx.so' > /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.data_dir=/tmp/php/spx' >> /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.http_enabled=1' >> /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.http_ui_assets_dir="/usr/share/misc/php-spx/assets/web-ui"' >> /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.http_key="dev"' >> /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.http_ip_var="NGINX_SECURE_PROXY"' >> /etc/php/7.2/mods-available/spx.ini \
  && echo 'spx.http_ip_whitelist="127.0.0.1"' >> /etc/php/7.2/mods-available/spx.ini \
  && cd /tmp && git clone --depth=1 https://github.com/yaoguais/phpng-xhprof && cd phpng-xhprof && phpize && ./configure \
  && make && make install && echo 'extension=phpng_xhprof.so' > /etc/php/7.2/mods-available/phpng_xhprof.ini \
  && cd /tmp && curl -L https://pecl.php.net/get/Xdebug > Xdebug.tgz && tar -xf Xdebug.tgz && cd xdebug-* && phpize && ./configure \
  && make && make install && echo 'zend_extension=/usr/lib/php/20170718/xdebug.so' > /etc/php/7.2/mods-available/xdebug.ini \
  && echo 'xdebug.profiler_enable_trigger=1' >> /etc/php/7.2/mods-available/xdebug.ini \
  && echo 'xdebug.profiler_output_dir="/tmpfs/php/xdebug"' >> /etc/php/7.2/mods-available/xdebug.ini \
  && echo 'xdebug.profiler_enable_trigger_value="dev"' >> /etc/php/7.2/mods-available/xdebug.ini \
  && echo 'xdebug.trace_output_dir="/tmpfs/php/xdebug"' >> /etc/php/7.2/mods-available/xdebug.ini \
  && echo 'xdebug.gc_stats_output_dir="/tmpfs/php/xdebug"' >> /etc/php/7.2/mods-available/xdebug.ini \
  ## php composer
  && curl -Ls https://getcomposer.org/download/1.6.5/composer.phar > /usr/bin/composer && chmod +x /usr/bin/composer && composer selfupdate \
  ## disable php extensions
  && phpdismod amqp && phpdismod apcu && phpdismod ast && phpdismod bcmath && phpdismod bz2 && phpdismod calendar \
  && phpdismod dba && phpdismod ds && phpdismod enchant && phpdismod ev && phpdismod exif \
  && phpdismod fann && phpdismod fileinfo && phpdismod ftp && phpdismod gd && phpdismod geoip && phpdismod geospatial && phpdismod gettext \
  && phpdismod gmp && phpdismod gnupg && phpdismod grpc && phpdismod hprose && phpdismod hrtime && phpdismod iconv && phpdismod imagick \
  && phpdismod imap && phpdismod interbase && phpdismod jsond && phpdismod ldap && phpdismod libevent \
  && phpdismod memcached && phpdismod mongodb && phpdismod odbc && phpdismod opencensus \
  && phpdismod pdo_firebird && phpdismod pdo_odbc && phpdismod pdo_sqlite \
  && phpdismod pgsql && phpdismod phpng_xhprof && phpdismod pspell && phpdismod psr && phpdismod raphf \
  && phpdismod rar && phpdismod recode && phpdismod redis && phpdismod request && phpdismod rrd && phpdismod seaslog && phpdismod shmop \
  && phpdismod soap && phpdismod spx && phpdismod sqlite3 && phpdismod ssh2 && phpdismod swoole && phpdismod sync \
  && phpdismod sysvmsg && phpdismod sysvsem && phpdismod sysvshm && phpdismod tidy && phpdismod uv && phpdismod varnish \
  && phpdismod vcollect && phpdismod vips && phpdismod wddx && phpdismod xdebug && phpdismod xmlrpc && phpdismod yac \
  && phpdismod yaf && phpdismod zmq \
  ## enable defaults
  && phpenmod igbinary && phpenmod ctype && phpenmod pdo && phpenmod pdo_mysql && phpenmod mysqli && phpenmod mysqlnd && phpenmod msgpack \
  && phpenmod yaml && phpenmod json && phpenmod intl && phpenmod phar && phpenmod event \
  && phpenmod curl && phpenmod tokenizer && phpenmod xml && phpenmod dom && phpenmod simplexml && phpenmod posix \
  ## webgrind
  && git clone --depth=1 https://github.com/jokkedk/webgrind /tmp/webgrind && cd /tmp/webgrind && make \
  && rm .git -rf && find . -type f ! -name '*.css' ! -name '*.gif' ! -name '*.ico' ! -name '*.js' ! -name '*.php' ! -name '*.phtml' ! -name '*.png' ! -name '*.py' ! -name 'preprocessor' -delete \
  && cd /tmp && mkdir -p /usr/share/misc/webgrind && mv /tmp/webgrind /usr/share/misc/webgrind/__webgrind \
  ## phpmyadmin
  && git clone --branch=STABLE --depth=1 https://github.com/phpmyadmin/phpmyadmin /tmp/phpmyadmin && cd /tmp/phpmyadmin && composer install --no-dev --optimize-autoloader \
  && rm .git .github test -rf && find . -type f ! -name '*.css' ! -name '*.gif' ! -name '*.ico' ! -name 'theme.json' ! -name '*.js' ! -name '*.php' ! -name '*.phtml' ! -name '*.png' ! -name '*.html' ! -name '*.twig' ! -name '*.sql' -delete \
  && rm config.sample.inc.php \
  && echo 'PD9waHAKJGNmZ1siYmxvd2Zpc2hfc2VjcmV0Il0gPSBoYXNoKCJjcmMzMmIiLCBnbWRhdGUoIlltZCIpIC4gZmlsZV9nZXRfY29udGVudHMoIi9ldGMvZW52aXJvbm1lbnQiKSk7CiRpID0gMDsKJGkrKzsKJGNmZ1siU2VydmVycyJdWyRpXVsiYXV0aF90eXBlIl0gPSAiY29va2llIjsKJGNmZ1siU2VydmVycyJdWyRpXVsiaG9zdCJdID0gIm1hcmlhZGIiOwokY2ZnWyJTZXJ2ZXJzIl1bJGldWyJjb21wcmVzcyJdID0gZmFsc2U7CiRjZmdbIlNlcnZlcnMiXVskaV1bIkFsbG93Tm9QYXNzd29yZCJdID0gdHJ1ZTsKJGkrKzsKJGNmZ1siU2VydmVycyJdWyRpXVsiYXV0aF90eXBlIl0gPSAiY29va2llIjsKJGNmZ1siU2VydmVycyJdWyRpXVsiaG9zdCJdID0gInRpZGIiOwokY2ZnWyJTZXJ2ZXJzIl1bJGldWyJjb21wcmVzcyJdID0gZmFsc2U7CiRjZmdbIlNlcnZlcnMiXVskaV1bIkFsbG93Tm9QYXNzd29yZCJdID0gdHJ1ZTsKJGkrKzsKJGNmZ1siU2VydmVycyJdWyRpXVsiYXV0aF90eXBlIl0gPSAiY29va2llIjsKJGNmZ1siU2VydmVycyJdWyRpXVsiaG9zdCJdID0gIm15c3FsIjsKJGNmZ1siU2VydmVycyJdWyRpXVsiY29tcHJlc3MiXSA9IGZhbHNlOwokY2ZnWyJTZXJ2ZXJzIl1bJGldWyJBbGxvd05vUGFzc3dvcmQiXSA9IHRydWU7CiRjZmdbIlVwbG9hZERpciJdID0gIiI7CiRjZmdbIlNhdmVEaXIiXSA9ICIiOwokY2ZnWyJEZWZhdWx0TGFuZyJdID0gImVuIjsKJGNmZ1siRGlzcGxheVNlcnZlcnNMaXN0Il0gPSB0cnVlOw==' | base64 --decode > config.inc.php \
  && cd /tmp && mkdir -p /usr/share/misc/phpmyadmin && mv /tmp/phpmyadmin /usr/share/misc/phpmyadmin/__phpmyadmin \
  ## adminer
  && mkdir -p /usr/share/misc/adminer/__adminer && curl -L https://github.com/vrana/adminer/releases/download/v4.6.2/adminer-4.6.2-en.php > /usr/share/misc/adminer/__adminer/index.php \
  ## phpinfo
  && mkdir -p /usr/share/misc/phpinfo/__phpinfo && echo '<?php phpinfo();' > /usr/share/misc/phpinfo/__phpinfo/index.php \
  ## container-helper
  && git clone --depth=1 -b stable https://github.com/AASAAM/aasaam-app /tmp/aasaam-app \
  && cd /tmp/aasaam-app/conf/container-helper && composer install --no-dev --optimize-autoloader \
  && ./prebuild && ./build && ./postbuild && chmod +x container-helper.phar && mv container-helper.phar /usr/bin/container-helper \
  ## gc
  && rm -rf ~/.cache && rm -rf ~/.composer && rm -rf ~/.npm && rm -rf ~/.cache/yarn \
  && apt-get clean && apt-get autoremove -y \
  && rm -r /var/lib/apt/lists/* && rm -rf /tmp && mkdir /tmp && chmod 777 /tmp && truncate -s 0 /var/log/*.log

# configuration
ADD conf/.bashrc /root/.bashrc
ADD conf/.npmrc /root/.npmrc
ADD .jobber /root/.jobber
ADD conf/entrypoint /usr/bin/entrypoint
ADD conf/dnsmasq.conf /etc/dnsmasq.conf
ADD conf/install-zephir /usr/bin/install-zephir
ADD conf/nginx.conf /etc/nginx/nginx.conf
ADD conf/aasaam-php-configure.ini /etc/php/7.2/mods-available/aasaam-php-configure.ini
ADD conf/www.conf /etc/php/7.2/fpm/pool.d/www.conf
ADD conf/logrotate.conf /etc/logrotate.conf
ADD conf/mime.types /etc/nginx/mime.types
ENV YARN_CACHE_FOLDER /app/var/cache/yarn
ENV COMPOSER_CACHE_DIR /app/var/cache/composer
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD 1
RUN chmod 0600 /root/.jobber && chmod 0644 /etc/logrotate.conf && chmod +x /usr/bin/entrypoint && chmod +x /usr/bin/install-zephir && phpenmod aasaam-php-configure \
  && truncate -s 0 /var/log/*.log

# ports
EXPOSE 80 443

# volume
VOLUME ["/app", "/tmp", "/tmpfs", "/etc/letsencrypt"]

# work directory
WORKDIR /app/app

# commands
CMD ["/bin/bash", "/usr/bin/entrypoint"]
