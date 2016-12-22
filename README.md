#Installing the App on a Duke VM<

Install Git:

ensure that there is enough room in /boot by deleting old operating systems (can view memory breakdown, current running OS)

sudo apt-get update
sudo apt-get install git

Clone the Repository:

create an ssh key pair and add the public one to git

clone with ssh

Install Apache, Postgres, and PHP:

(stack overflow)

Create the Symbolic Link between /code/316Project/php-tutors and /var/www/html:

(stack overflow)

make sure that it’s accessible from /var/www/html

Give www-data Ownership of /var/www/html/php-tutors:

chown -R www-data:www-data /var/www/html/php-tutors

Creating the database: 

sudo su - postgres

from within the directory containing the milestone1.sql file, run: 
dropdb tutors; createdb tutors; psql tutors -af milestone1.sql;

Open the SQL interpreter by running: 
psql tutors

Add vagrant as a user:
create user vagrant;

Give vagrant a password:
alter user vagrant password “dbpasswd”;

Give vagrant permission to access the tables:
grant all privileges on site to vagrant;
grant all privileges on teacher to vagrant;
grant all privileges on tutorinfo to vagrant;
grant all privileges on tutoravailable to vagrant;
grant all privileges on request to vagrant;
grant all privileges on admininfo to vagrant;
grant all privileges on bookings to vagrant;

Give vagrant permission to access serial:
grant usage, select on sequence request_request_id_seq to vagrant;

CSV Upload Headers:

Name, Email, School, Grade Level, requestBefore, requestSemester, Monday Block 1, Monday Block 2, Monday Block 3, Monday Block 4, Monday Block 5 (for each of the days), Max Tutors Per Slot, Total Tutors, needLanguage, Language, Description

To enable CSV Download: 

Change the owner of php-tutors to www-data