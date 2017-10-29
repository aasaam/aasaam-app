# ubuntu:xenial
FROM ubuntu:xenial
MAINTAINER Muhammad Hussein Fattahizadeh <m@mhf.ir>

# build-time metadata as defined at http://label-schema.org
ARG BUILD_DATE
ARG VCS_REF
ARG VERSION
LABEL org.label-schema.build-date=$BUILD_DATE \
      org.label-schema.name="AAASAAM Application Docker Image" \
      org.label-schema.description="Docker image for PHP and JavaScript applications." \
      org.label-schema.url="https://aasaam.com" \
      org.label-schema.vcs-ref=$VCS_REF \
      org.label-schema.vcs-url="https://github.com/AASAAM/aasaam-app" \
      org.label-schema.vendor="AASAAM" \
      org.label-schema.version=$VERSION \
      org.label-schema.schema-version="1.0"

# env variable
ENV DEBIAN_FRONTEND noninteractive
ENV YARN_CACHE_FOLDER /tmp/yarn
ENV COMPOSER_CACHE_DIR /tmp/composer
ENV LANG en_US.utf8

# base dependencies
RUN apt-get update && apt-get -y upgrade && apt-get install -y --no-install-recommends apt-utils \
  && apt-get install -y --no-install-recommends \
    curl git locales lsb-release apt-transport-https bash-completion ca-certificates \
    build-essential software-properties-common \
  && localedef -i en_US -c -f UTF-8 -A /usr/share/locale/locale.alias en_US \
  && mkdir -p /tmp/yarn && echo 'cache = "/tmp/npm"' > /root/.npmrc \
  && cd /tmp && curl -Ls http://packages.couchbase.com/releases/couchbase-release/couchbase-release-1.0-2-amd64.deb > couchbase-release-1.0-2-amd64.deb \
  && dpkg -i couchbase-release-1.0-2-amd64.deb \
  && echo 'deb http://nginx.org/packages/ubuntu/ xenial nginx' > /etc/apt/sources.list.d/repo.list \
  && echo 'deb-src http://nginx.org/packages/ubuntu/ xenial nginx' >> /etc/apt/sources.list.d/repo.list \
  && echo 'deb https://dl.yarnpkg.com/debian/ stable main' >> /etc/apt/sources.list.d/repo.list \
  && curl -sL https://nginx.org/keys/nginx_signing.key | apt-key add - \
  && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
  && add-apt-repository -y ppa:ondrej/php \
  && add-apt-repository -y ppa:pinepain/libv8-5.9 && add-apt-repository -y ppa:pinepain/libv8-6.4 \
  && curl -sL https://deb.nodesource.com/setup_8.x > /tmp/setup_8.x \
  && chmod +x /tmp/setup_8.x && /tmp/setup_8.x \
  && mkdir -p /tmp/build/nginx && cd /tmp/build/nginx && apt-get -y build-dep nginx && apt-get -y source nginx \
  && git clone --depth=1 https://github.com/openresty/headers-more-nginx-module \
  && git clone --depth=1 https://github.com/arut/nginx-rtmp-module \
  && git clone --depth=1 https://github.com/kaltura/nginx-vod-module \
  && git clone --depth=1 https://github.com/openresty/redis2-nginx-module \
  && git clone --depth=1 https://github.com/alibaba/nginx-http-concat \
  && git clone --depth=1 https://github.com/openresty/srcache-nginx-module \
  && cd nginx-1* \
  && sed -i 's#--prefix=/etc/nginx#--prefix=/etc/nginx --add-module=/tmp/build/nginx/headers-more-nginx-module --add-module=/tmp/build/nginx/nginx-rtmp-module --add-module=/tmp/build/nginx/nginx-vod-module --add-module=/tmp/build/nginx/redis2-nginx-module --add-module=/tmp/build/nginx/nginx-http-concat --add-module=/tmp/build/nginx/srcache-nginx-module#g' debian/rules \
  && dpkg-buildpackage -uc -b && dpkg -i /tmp/build/nginx/nginx_1*.deb  && rm -rf /tmp/build/nginx \
  && mkdir -p /tmp/build/nodejs && cd /tmp/build/nodejs && apt-get -y build-dep nodejs && apt-get -y source nodejs \
  && cd nodejs-* && sed -i 's#./configure --prefix=/usr#./configure --prefix=/usr --with-intl=full-icu --download=all#g' debian/rules \
  && dpkg-buildpackage -uc -b && dpkg -i /tmp/build/nodejs/nodejs_8*.deb && cd / && npm update -g && rm -rf /tmp/build/nodejs \
  && apt-get install -y --no-install-recommends \
  php7.1-bcmath php7.1-bz2 php7.1-cli php7.1-curl php7.1-dba php7.1-dev php7.1-enchant php7.1-fpm \
  php7.1-gd php7.1-gmp php7.1-intl php7.1-mbstring php7.1-mysql php7.1-opcache php7.1-pgsql \
  php7.1-phpdbg php7.1-soap php7.1-sqlite3 php7.1-tidy php7.1-xml php7.1-xmlrpc php7.1-xsl \
  php7.1-zip python-pip logrotate \
  libcouchbase-dev libevent-dev libfribidi-bin libgpgme11-dev libmagickwand-dev libmemcached-dev libnghttp2-dev \
  librabbitmq-dev librrd-dev libsodium-dev libssh2-1-dev libuv1-dev libv8-5.9-dev libv8-6.3-dev libhiredis-dev \
  libyaml-dev libzmq-dev libcurl4-openssl-dev pkg-config \
  librabbitmq-dev libuv1-dev libsodium-dev libgpgme11-dev libgeoip-dev libfann-dev libvarnishapi-dev libvips libvips-dev yarn imagemagick \
  && cd /tmp && curl -sL https://pecl.php.net/get/igbinary > igbinary.tgz && tar -xf igbinary.tgz && cd igbinary-* && phpize && ./configure \
  && make && make install && echo '; priority=10' > /etc/php/7.1/mods-available/igbinary.ini \
  && echo 'extension=igbinary.so' >> /etc/php/7.1/mods-available/igbinary.ini && phpenmod igbinary \
  && cd /tmp && curl -sL https://pecl.php.net/get/msgpack > msgpack.tgz && tar -xf msgpack.tgz && cd msgpack-* && phpize && ./configure \
  && make && make install && echo '; priority=10' > /etc/php/7.1/mods-available/msgpack.ini \
  && echo 'extension=msgpack.so' >> /etc/php/7.1/mods-available/msgpack.ini && phpenmod msgpack \
  && cd /tmp && curl -sL https://pecl.php.net/get/yaml > yaml.tgz && tar -xf yaml.tgz && cd yaml-* && phpize && ./configure \
  && make && make install && echo 'extension=yaml.so' > /etc/php/7.1/mods-available/yaml.ini && phpenmod yaml \
  && cd /tmp && curl -sL https://pecl.php.net/get/imagick > imagick.tgz && tar -xf imagick.tgz && cd imagick-* && phpize && ./configure \
  && make && make install && echo 'extension=imagick.so' > /etc/php/7.1/mods-available/imagick.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/memcached > memcached.tgz && tar -xf memcached.tgz && cd memcached-* && phpize && ./configure --enable-memcached-igbinary --enable-memcached-json --enable-memcached-msgpack \
  && make && make install && echo 'extension=memcached.so' > /etc/php/7.1/mods-available/memcached.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/hrtime > hrtime.tgz && tar -xf hrtime.tgz && cd hrtime-* && phpize && ./configure \
  && make && make install && echo 'extension=hrtime.so' > /etc/php/7.1/mods-available/hrtime.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/ds > ds.tgz && tar -xf ds.tgz && cd ds-* && phpize && ./configure \
  && make && make install && echo '; priority=90' > /etc/php/7.1/mods-available/ds.ini \
  && echo 'extension=ds.so' >> /etc/php/7.1/mods-available/ds.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/zmq > zmq.tgz && tar -xf zmq.tgz && cd zmq-* && phpize && ./configure \
  && make && make install && echo 'extension=zmq.so' > /etc/php/7.1/mods-available/zmq.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/ssh2 > ssh2.tgz && tar -xf ssh2.tgz && cd ssh2-* && phpize && ./configure \
  && make && make install && echo 'extension=ssh2.so' > /etc/php/7.1/mods-available/ssh2.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/redis > redis.tgz && tar -xf redis.tgz && cd redis-* && phpize && ./configure --enable-redis-igbinary \
  && make && make install && echo 'extension=redis.so' > /etc/php/7.1/mods-available/redis.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/APCu > APCu.tgz && tar -xf APCu.tgz && cd apcu-* && phpize && ./configure \
  && make && make install && echo 'extension=apcu.so' > /etc/php/7.1/mods-available/apcu.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/mongodb > mongodb.tgz && tar -xf mongodb.tgz && cd mongodb-* && phpize && ./configure \
  && make && make install && echo 'extension=mongodb.so' > /etc/php/7.1/mods-available/mongodb.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/couchbase > couchbase.tgz && tar -xf couchbase.tgz && cd couchbase-* && phpize && ./configure \
  && make && make install && echo '; priority=90' > /etc/php/7.1/mods-available/couchbase.ini \
  && echo 'extension=couchbase.so' >> /etc/php/7.1/mods-available/couchbase.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/swoole > swoole.tgz && tar -xf swoole.tgz && cd swoole-* && phpize && ./configure --enable-openssl --enable-http2 --enable-async-redis \
  && make && make install && echo 'extension=swoole.so' > /etc/php/7.1/mods-available/swoole.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/amqp > amqp.tgz && tar -xf amqp.tgz && cd amqp-* && phpize && ./configure \
  && make && make install && echo 'extension=amqp.so' > /etc/php/7.1/mods-available/amqp.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/gRPC > gRPC.tgz && tar -xf gRPC.tgz && cd grpc-* && phpize && ./configure \
  && make && make install && echo 'extension=grpc.so' > /etc/php/7.1/mods-available/grpc.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/yaf > yaf.tgz && tar -xf yaf.tgz && cd yaf-* && phpize && ./configure \
  && make && make install && echo 'extension=yaf.so' > /etc/php/7.1/mods-available/yaf.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/ev > ev.tgz && tar -xf ev.tgz && cd ev-* && phpize && ./configure \
  && make && make install && echo 'extension=ev.so' > /etc/php/7.1/mods-available/ev.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/yar > yar.tgz && tar -xf yar.tgz && cd yar-* && phpize && ./configure --enable-msgpack \
  && make && make install && echo 'extension=yar.so' > /etc/php/7.1/mods-available/yar.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/yac > yac.tgz && tar -xf yac.tgz && cd yac-* && phpize && ./configure \
  && make && make install && echo 'extension=yac.so' > /etc/php/7.1/mods-available/yac.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/uv > uv.tgz && tar -xf uv.tgz && cd uv-* && phpize && ./configure \
  && make && make install && echo 'extension=uv.so' > /etc/php/7.1/mods-available/uv.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/hprose > hprose.tgz && tar -xf hprose.tgz && cd hprose-* && phpize && ./configure \
  && make && make install && echo 'extension=hprose.so' > /etc/php/7.1/mods-available/hprose.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/libsodium > libsodium.tgz && tar -xf libsodium.tgz && cd libsodium-* && phpize && ./configure \
  && make && make install && echo 'extension=libsodium.so' > /etc/php/7.1/mods-available/libsodium.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/gnupg > gnupg.tgz && tar -xf gnupg.tgz && cd gnupg-* && phpize && ./configure \
  && make && make install && echo 'extension=gnupg.so' > /etc/php/7.1/mods-available/gnupg.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/raphf > raphf.tgz && tar -xf raphf.tgz && cd raphf-* && phpize && ./configure \
  && make && make install && echo 'extension=raphf.so' > /etc/php/7.1/mods-available/raphf.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/rrd > rrd.tgz && tar -xf rrd.tgz && cd rrd-* && phpize && ./configure \
  && make && make install && echo 'extension=rrd.so' > /etc/php/7.1/mods-available/rrd.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/sync > sync.tgz && tar -xf sync.tgz && cd sync-* && phpize && ./configure \
  && make && make install && echo 'extension=sync.so' > /etc/php/7.1/mods-available/sync.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/ast > ast.tgz && tar -xf ast.tgz && cd ast-* && phpize && ./configure \
  && make && make install && echo 'extension=ast.so' > /etc/php/7.1/mods-available/ast.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/request > request.tgz && tar -xf request.tgz && cd request-* && phpize && ./configure \
  && make && make install && echo 'extension=request.so' > /etc/php/7.1/mods-available/request.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/Molten > Molten.tgz && tar -xf Molten.tgz && cd Molten-* && phpize && ./configure \
  && make && make install && echo 'extension=molten.so' > /etc/php/7.1/mods-available/molten.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/geoip > geoip.tgz && tar -xf geoip.tgz && cd geoip-* && phpize && ./configure \
  && make && make install && echo 'extension=geoip.so' > /etc/php/7.1/mods-available/geoip.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/rar > rar.tgz && tar -xf rar.tgz && cd rar-* && phpize && ./configure \
  && make && make install && echo 'extension=rar.so' > /etc/php/7.1/mods-available/rar.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/v8js > v8js.tgz && tar -xf v8js.tgz && cd v8js-* && phpize && ./configure --with-v8js=/opt/libv8-5.9/ \
  && make && make install && echo 'extension=v8js.so' > /etc/php/7.1/mods-available/v8js.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/v8 > v8.tgz && tar -xf v8.tgz && cd v8-* && phpize && ./configure --with-v8=/opt/libv8-6.3/ \
  && make && make install && echo 'extension=v8.so' > /etc/php/7.1/mods-available/v8.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/SeasLog > SeasLog.tgz && tar -xf SeasLog.tgz && cd SeasLog-* && phpize && ./configure \
  && make && make install && echo 'extension=seaslog.so' > /etc/php/7.1/mods-available/seaslog.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/fann > fann.tgz && tar -xf fann.tgz && cd fann-* && phpize && ./configure \
  && make && make install && echo 'extension=fann.so' > /etc/php/7.1/mods-available/fann.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/vips > vips.tgz && tar -xf vips.tgz && cd vips-* && phpize && ./configure \
  && make && make install && echo 'extension=vips.so' > /etc/php/7.1/mods-available/vips.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/opencensus > opencensus.tgz && tar -xf opencensus.tgz && cd opencensus-* && phpize && ./configure \
  && make && make install && echo 'extension=opencensus.so' > /etc/php/7.1/mods-available/opencensus.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/varnish > varnish.tgz && tar -xf varnish.tgz && cd varnish-* && phpize && ./configure \
  && make && make install && echo 'extension=varnish.so' > /etc/php/7.1/mods-available/varnish.ini \
  && cd /tmp && git clone --depth=1 https://github.com/expressif/pecl-event-libevent && cd pecl-event-libevent && phpize && ./configure \
  && make && make install && echo 'extension=libevent.so' > /etc/php/7.1/mods-available/libevent.ini \
  && cd /tmp && git clone --depth=1 https://github.com/viest/v-collect && cd v-collect && phpize && ./configure \
  && make && make install && echo 'extension=vcollect.so' > /etc/php/7.1/mods-available/vcollect.ini \
  && cd /tmp && git clone --depth=1 https://github.com/php-geospatial/geospatial && cd geospatial && phpize && ./configure \
  && make && make install && echo 'extension=geospatial.so' > /etc/php/7.1/mods-available/geospatial.ini \
  && cd /tmp && git clone --depth=1 https://github.com/NoiseByNorthwest/php-spx && cd php-spx && phpize && ./configure \
  && make && make install && echo 'extension=spx.so' > /etc/php/7.1/mods-available/spx.ini \
  && cd /tmp && git clone --depth=1 https://github.com/emirb/php-geohash-ext && cd php-geohash-ext && phpize && ./configure \
  && make && make install && echo 'extension=geohash.so' > /etc/php/7.1/mods-available/geohash.ini \
  && cd /tmp && git clone --depth=1 https://github.com/yaoguais/phpng-xhprof && cd phpng-xhprof && phpize && ./configure \
  && make && make install && echo 'extension=phpng_xhprof.so' > /etc/php/7.1/mods-available/phpng_xhprof.ini \
  && cd /tmp && curl -sL https://pecl.php.net/get/Xdebug > Xdebug.tgz && tar -xf Xdebug.tgz && cd xdebug-* && phpize && ./configure \
  && make && make install && echo 'zend_extension=/usr/lib/php/20160303/xdebug.so' > /etc/php/7.1/mods-available/xdebug.ini \
  && echo 'xdebug.profiler_enable_trigger=1' >> /etc/php/7.1/mods-available/xdebug.ini \
  && echo 'xdebug.profiler_output_dir="/app/var/logs"' >> /etc/php/7.1/mods-available/xdebug.ini \
  && cd /tmp/ && git clone --depth=1 https://github.com/kr/beanstalkd && cd beanstalkd && make && make install \
  && pip install --upgrade pip && pip install setuptools && pip install supervisor \
  && curl -Ls https://getcomposer.org/download/1.5.2/composer.phar > /usr/bin/composer && chmod +x /usr/bin/composer && composer selfupdate \
  && rm -rf ~/.cache && rm -rf ~/.composer && rm -rf ~/.npm && rm -rf ~/.cache/yarn \
  && rm -rf /etc/logrotate.d/ngin* /etc/logrotate.d/php* \
  && rm -r /var/lib/apt/lists/* && rm -rf /tmp && mkdir /tmp && chmod 777 /tmp

# env requirement
ADD conf/.bashrc /root/.bashrc
ADD conf/.npmrc /root/.npmrc
ADD conf/entrypoint /usr/bin/entrypoint
ADD conf/nginx.conf /etc/nginx/nginx.conf
ADD conf/aasaam.ini /etc/php/7.1/mods-available/aasaam.ini
ADD conf/www.conf /etc/php/7.1/fpm/pool.d/www.conf
ADD conf/logrotate.conf /etc/logrotate.conf
ENV YARN_CACHE_FOLDER /app/var/cache/yarn
ENV COMPOSER_CACHE_DIR /app/var/cache/composer

RUN chmod +x /usr/bin/entrypoint && phpenmod aasaam

# ports
EXPOSE 80
EXPOSE 443

# volume
VOLUME ["/app"]
VOLUME ["/tmp"]

# commands
CMD ["/bin/bash", "/usr/bin/entrypoint"]
