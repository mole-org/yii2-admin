#!/usr/bin/env bash
function backup_file {
	if [[ "x$1" = "x" ]]; then
		echo "Params error."
		exit 1
	fi

	if [[ -f $1 && ! -f $1.bak ]]; then
		cp -f $1 $1.bak
	elif [[ -f $1.bak ]]; then
		cp -f $1.bak $1
	fi
}

function apt_get {
	DEBIAN_FRONTEND=noninteractive \
		apt-get --option "Dpkg::Options::=--force-confold" --assume-yes "$@"
}

hostname=$1
lockfile=/var/setup.lock
# Configure hostname
echo $hostname > /etc/hostname
hostname $hostname
echo 'nameserver 114.114.114.114' > /etc/resolv.conf

if [[ ! -f $lockfile ]]; then
	# Set timezone
	timedatectl set-timezone Asia/Shanghai
	
	# # Configure hostname
	# echo $hostname > /etc/hostname
	# hostname $hostname

	# Configure apt sources list
	backup_file /etc/apt/sources.list
	cat > /etc/apt/sources.list <<EOT
#deb http://cn.archive.ubuntu.com/ubuntu trusty main universe
#deb http://cn.archive.ubuntu.com/ubuntu trusty-updates main universe
deb http://mirrors.163.com/ubuntu trusty main universe
deb http://mirrors.163.com/ubuntu trusty-updates main universe
EOT
	add-apt-repository ppa:nginx/stable	
	add-apt-repository ppa:ondrej/php5-5.6
	add-apt-repository ppa:chris-lea/redis-server
	apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv 7F0CEB10
	echo "deb http://repo.mongodb.org/apt/ubuntu "$(lsb_release -sc)"/mongodb-org/3.0 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-3.0.list

	# Configure vim	
	cat > /etc/vim/vimrc.local <<EOT
if has("autocmd")
  au BufReadPost * if line("'\"") > 1 && line("'\"") <= line("$") | exe "normal! g'\"" | endif
endif

if has("autocmd")
  filetype plugin indent on
endif

set nu
set ts=4
set sw=4
set modeline
set modelines=5
colorscheme desert
EOT
	
	# Add upstar script
	cat > /etc/init/play.conf <<EOT
description "Play server"
start on vagrant-mounted

pre-start script
    [ "\$MOUNTPOINT" = "/vagrant" ] || stop
end script

script
	service nginx restart
end script
EOT
	
	# Fixed bug
	# https://github.com/mitchellh/vagrant/issues/6074
#	cat > /etc/init/workaround-vagrant-bug-6074.conf <<EOT
## workaround for https://github.com/mitchellh/vagrant/issues/6074
#start on filesystem
#task
#
#env MOUNTPOINT=/vagrant
#
#script
#  until mountpoint -q \$MOUNTPOINT; do sleep 1; done
#  /sbin/initctl emit --no-wait vagrant-mounted MOUNTPOINT=\$MOUNTPOINT
#end script
#EOT
	
	# Change ll display
	sed -e "s/^alias ll='ls -alF'/alias ll='ls -hlF'/" -i /etc/skel/.bashrc /root/.bashrc /home/vagrant/.bashrc

	# Install packages
	apt_get update
	apt_get install \
		nginx \
		php5-fpm php5-curl php5-gd php5-imagick php5-intl php5-redis \
		php5-mcrypt php5-memcached php5-mongo php5-mysqlnd php5-sqlite php5-xdebug \
		mongodb-org-shell mysql-client 
		#nodejs npm
		#redis-server
	#npm install --global gulp
	
	# Configure nginx
	update-rc.d -f nginx remove
	rm -rf /etc/nginx/sites-enabled/default
	ln -fs /vagrant/nginx.conf /etc/nginx/sites-enabled/default
	ln -fs /vagrant /home/vagrant/www
	sed -e "s/^user www-data;/user vagrant;/" -i /etc/nginx/nginx.conf
	sed -e "s/sendfile on;/sendfile off;/" -i /etc/nginx/nginx.conf
	sed -e "s/www-data/vagrant/" -i /etc/php5/fpm/pool.d/www.conf

#	# Configure apache
#	update-rc.d -f apache2 remove
#	a2dissite 000-default.conf
#	sed -e "s/^[^#]/#/" -i /etc/apache2/ports.conf
#	sed -e "s/^export APACHE_RUN_USER=www-data/export APACHE_RUN_USER=vagrant/" \
#		-e "s/export APACHE_RUN_GROUP=www-data/export APACHE_RUN_GROUP=vagrant/" -i /etc/apache2/envvars
#	ln -f -s /vagrant/server.conf /etc/apache2/sites-enabled/
#	ln -f -s /vagrant /home/vagrant/www
#	#rm -rf /home/vagrant/tmp

	# Configure php
	cat > /etc/php5/mods-available/local.ini <<EOT
; vim: ft=dosini ts=4 sw=4
; priority=99
cgi.fix_pathinfo=0
display_errors=On
error_reporting=E_ALL
error_log=/var/log/php5-error.log
always_populate_raw_post_data=-1
;session.save_path=/tmp
xdebug.default_enable=0
xdebug.remote_enable=1
xdebug.remote_connect_back=1
EOT
	php5enmod local

	# Set php error log file and change it's owner.
	touch /var/log/php5-error.log
	chown vagrant:vagrant /var/log/php5-error.log

	# Restart
	service php5-fpm restart
	nginx -t
	service nginx restart

	## Install composer
	#curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin
	
	touch $lockfile	
fi

echo "Provision execute completely."

# vim: syntax=sh ts=4 sw=4
