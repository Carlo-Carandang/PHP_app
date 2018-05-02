#!/bin/bash
#
user="$1"
pass="$2"
db="$3"
#
echo
#
#MongoDB: Export article.csv and author.csv
mongoexport -d $db -u "$user" -p "$pass" -c ARTICLE --type csv --out article.csv --fields article_id,title,pages,year,volume,journal
#
echo "-> MongoDB: data exported to csv from ARTICLE collection"
#
mongoexport -d $db -u "$user" -p "$pass" -c AUTHOR --type csv --out author.csv --fields article_id,lname,fname,email
#
echo "-> MongoDB: data exported to csv from AUTHOR collection"
#
javac author_to_insert_staging.java
#
javac article_to_insert_staging.java
#
java author_to_insert_staging
#
java article_to_insert_staging
#
echo "-> Java: insert_staging_author.slq and insert_staging_article.sql files were created successfully"
#
#MySQL: Load the ARTICLE and AUTHOR collections into a staging tables
mysql -u "$user" --password="$pass" "$db" -e "source insert_staging_author.sql;"
#
echo "-> MySQL: Data loaded into STAGING_AUTHOR tables"
#
mysql -u "$user" --password="$pass" "$db" -e "source insert_staging_article.sql;"
#
echo "-> MySQL: Data loaded into STAGING_ARTICLE tables"
#
mysql -u "$user" --password="$pass" "$db" -e "source insert.sql;"
#
echo "-> MySQL: Data loaded into all tables"
#
rm article_to_insert_staging.java
rm author_to_insert_staging.java
rm author_to_insert_staging.class
rm article_to_insert_staging.class
rm article.csv
rm author.csv
rm insert_staging_article.sql
rm insert_staging_author.sql
rm insert.sql
#
