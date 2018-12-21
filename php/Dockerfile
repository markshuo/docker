FROM centos:latest

MAINTAINER ma
RUN yum -y install  pcre pcre-devel openssl openssl-devel libicu-devel gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng \
 libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel ncurses ncurses-devel \
 curl curl-devel krb5-devel libidn libidn-devel openldap openldap-devel nss_ldap jemalloc-devel cmake boost-devel bison automake \
 libevent libevent-devel gd gd-devel libtool* libmcrypt libmcrypt-devel mcrypt mhash libxslt libxslt-devel readline readline-devel \
 gmp gmp-devel libcurl libcurl-devel openjpeg-devel
 
ENV TIME_ZONE Asia/shanghai
RUN cp -frp /usr/lib64/libldap* /usr/lib/ && cp -frp /usr/lib64/libldap* /usr/lib/
ADD php-7.2.12.tar.gz /usr/local/src

RUN cd /usr/local/src/php-7.2.12 && ./configure --prefix=/usr/local/php \
--with-config-file-path=/usr/local/php/etc \
--enable-fpm \
--with-fpm-user=www \
--with-fpm-group=www \
--enable-mysqlnd \
--with-mysqli=mysqlnd \
--with-pdo-mysql=mysqlnd \
--enable-mysqlnd-compression-support \
--with-iconv-dir \
--with-freetype-dir \
--with-jpeg-dir \
--with-png-dir \
--with-zlib \
--with-libxml-dir \
--enable-xml \
--disable-rpath \
--enable-bcmath \
--enable-shmop \
--enable-sysvsem \
--enable-inline-optimization \
--with-curl \
--enable-mbregex \
--enable-mbstring \
--enable-intl \
--with-libmbfl \
--enable-ftp \
--with-gd \
--with-openssl \
--with-mhash \
--enable-pcntl \
--enable-sockets \
--with-xmlrpc \
--enable-zip \
--enable-soap \
--with-gettext \
--disable-fileinfo \
--enable-opcache \
--with-pear \
--enable-maintainer-zts \
--with-ldap=shared \
--without-gdbm  && \
make -j 4 && \
make install


#RUN wget https://gitee.com/hanlicun/ltmp/raw/master/src/phpredis.tar.gz && tar zxvf phpredis.tar.gz && \
#rm -rf phpredis.tar.gz && cd phpredis && /usr/local/php/bin/phpize && ./configure --with-php-config=/usr/local/php/bin/php-config && \
#make && make install && sed -i '$a extension_dir =/usr/local/php/lib/php/extensions/no-debug-zts-20151012/\nextension=redis.so\n' && cd .. && \
#rm -rf phpredis
 
RUN cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf && \
    echo "${TIME_ZONE}" > /etc/timezone && ln -sf /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime
RUN rm -rf /usr/local/src/php* && yum clean all

WORKDIR /usr/local/php

#CMD ["./sbin/php-fpm","-c","/usr/local/php/etc/php-fpm.conf"]
CMD ["./sbin/php-fpm"]


