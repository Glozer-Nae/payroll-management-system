#!/bin/bash
sed -i "s/Listen 10000/Listen ${PORT:-10000}/g" /etc/apache2/ports.conf
sed -i "s/*:10000>/*:${PORT:-10000}>/g" /etc/apache2/sites-available/000-default.conf
echo "ServerName localhost" >> /etc/apache2/apache2.conf

exec apache2-foreground
