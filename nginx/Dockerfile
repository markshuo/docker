FROM centos:latest

MAINTAINER ma

ENV TIME_ZONE Asia/shanghai
RUN yum install -y gcc pcre-devel openssl-devel zlib-devel
ADD nginx-1.15.7.tar.gz /usr/local/src
RUN cd /usr/local/src/nginx-1.15.7 && \
  ./configure --prefix=/usr/local/nginx && \
   make -j 2 && make install
RUN rm -rf /usr/local/src/php* && yum clean all && echo "${TIME_ZONE}" > /etc/timezone && ln -sf /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime
#WORKDIR /usr/local/nginx
EXPOSE 80
CMD ["/usr/local/nginx/sbin/nginx","-g","daemon off;"]
