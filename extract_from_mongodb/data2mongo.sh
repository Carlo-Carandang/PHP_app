#!/bin/bash
#
user="$1"
pass="$2"
db="$3"
#
echo
#MySQL: Create new tables
mysql -u "$user" --password="$pass" "$db" -e "source new_tables.sql;"
#
echo "-> MySQL: 13 new tables created"
#
#MongoDB: Drop AUTHOR, ARTICLE, and INITIAL_ARTICLE collections
mongo "$db" -u "$user" -p "$pass" --eval "db.AUTHOR.drop()"
mongo "$db" -u "$user" -p "$pass" --eval "db.ARTICLE.drop()"
mongo "$db" -u "$user" -p "$pass" --eval "db.INITIAL_ARTICLE.drop()"
#
echo "-> MongoDB: AUTHOR, ARTICLE, and INITIAL_ARTICLE collections dropped"
#
#MongDB: Import articles.json
mongoimport -d "$db" -u "$user" -p "$pass" -c INITIAL_ARTICLE --file articles.json
#
echo "-> MongoDB: articles.json imported into collection INITIAL_ARTICLE"
#
#MongoDB: Clean and import data from INITIAL_ARTICLE collection into ARTICLE collection
mongo "$db" -u "$user" -p "$pass" --eval "
var i=0
db.INITIAL_ARTICLE.find().sort({_id: 1}).forEach(function(cleanUp) {
	i = i+1
    try {
        if (cleanUp.author instanceof Array) {
            var author = new Array()
            cleanUp.author.forEach(function(arrayCheck) {
                author.push(arrayCheck.ftext)
            })
        } else {
            var author = new Array(cleanUp.author.ftext)
        }
        var title = cleanUp.title.ftext
		title = title.replace(/,/g, '')
        var pages = cleanUp.pages.ftext
        var year = cleanUp.year.ftext
        var volume = cleanUp.volume.ftext
        var journal = cleanUp.journal.ftext
        db.ARTICLE.insert({
            article_id: i,
            author: author,
            title: title,
            pages: pages,
            year: year,
            volume: volume,
            journal: journal
        })
    } catch (err) {}
})"
#
echo "-> MongoDB: data loaded into ARTICLE collection"
#
#MonhoDB: Clean and import data from ARTICLE collection into AUTHOR collection
mongo "$db" -u "$user" -p "$pass" --eval "
var i = 0
db.ARTICLE.find().sort({_id: 1}).forEach(function(authorArray) {
    i = i + 1
    try {
        if (authorArray.author instanceof Array) {
            var author = new Array()
            authorArray.author.forEach(function(arrayCheck) {
                author.push(arrayCheck)
            })
            author.forEach(function(loopArray) {
                db.AUTHOR.insert({
                    article_id: i,
                    fname: loopArray.split(' ').shift(),
                    lname: loopArray.split(' ').pop(),
                    email: 'NULL'
                })
            })
        } else {
            db.AUTHOR.insert({
                article_id: i,
                fname: authorArray.author.split(' ').shift(),
                lname: authorArray.author.split(' ').pop(),
                email: 'NULL'
            })
        }
    } catch (err) {}
})"
#
echo "-> MongoDB: data loaded into AUTHOR collection"
#