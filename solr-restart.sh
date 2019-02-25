#!/usr/bin/env bash

# Go to the Solr Home direoctory
cd /opt/solr

# Stop the Solr instance
bin/solr stop -p 8983

# Start the Solr instance
bin/solr start