#!/bin/bash

moodle_folders="moodle_data moodledata_data mariadb_data"

for folder in ${moodle_folders}; do
	echo "${folder}"
	echo "-removing folder"
	rm -rf "${folder}"
	echo "-recreating folder"
	mkdir "${folder}"
	echo "-change permissions"
	chmod g+w "${folder}"
done

echo "done"
