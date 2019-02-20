#!/usr/bin/env bash

cd /vagrant
mysql -u homestead jitterbug < jitterbug.dmp -p secret