Creating the database: 
On your VM shell, from within the directory containing the milestone1.sql file, run the command: 

dropdb tutors; createdb tutors; tutors -af milestone1.sql

This should create and populate the database with sample data (for now) for use in querying.

If you would now like to open the SQL interpreter, run the command: psql tutors.
