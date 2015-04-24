#!/bin/bash

##
# NOTES :
#  	   $ printenv : lister les variable d'env
#      $ . export_env.sh : lancer en en sourçant le script
#


export SYMFONY__DATABASEPROD__HOST=mysql51-158.perso
export SYMFONY__DATABASEPROD__DBNAME=autodomhttp
export SYMFONY__DATABASEPROD__USER=autodomhttp
export SYMFONY__DATABASEPROD__PASSWORD=Hermanos84

echo "Liste des variables d'environement sf : "
printenv | grep SYMFONY
