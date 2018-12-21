#The dockerfile of centos
FROM centos:latest
MAINTAINER MA 

#install sshd net-tools
#RUN yum -y update
#RUN yum -y install openssh-server net-tools wget vim pcre pcre-devel openssl openssl-devel libicu-devel gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng \
 libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel ncurses ncurses-devel \
 curl curl-devel krb5-devel libidn libidn-devel openldap openldap-devel nss_ldap jemalloc-devel cmake boost-devel bison automake \
 libevent libevent-devel gd gd-devel libtool* libmcrypt libmcrypt-devel mcrypt mhash libxslt libxslt-devel readline readline-devel \
 gmp gmp-devel libcurl libcurl-devel openjpeg-devel
RUN yum -y install openssh-server net-tools
#set password for root
RUN sed -i 's/UsePAM yes/UsePAM no/' /etc/ssh/sshd_config
RUN useradd ma
RUN echo 'ma:mashuo' | chpasswd
RUN echo 'ma ALL=(ALL)	 ALL' >> /etc/sudoers
RUN ssh-keygen -t dsa -f /etc/ssh/ssh_host_dsa_key  
RUN ssh-keygen -t rsa -f /etc/ssh/ssh_host_rsa_key
RUN mkdir /var/run/sshd

#change timezone CST
RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime

#open port
EXPOSE 22
#CMD ["/usr/sbin/sshd","-D"]
CMD ["/usr/sbin/init","-D"]
