-- CREATE TABLE Data
-- (name VARCHAR(256),
--  email VARCHAR(256),
--  school VARCHAR(256),
--  grade VARCHAR(256),
--  monday_1 VARCHAR(256),
--  monday_2 VARCHAR(256),
--  monday_3 VARCHAR(256),
--  tuesday_1 VARCHAR(256),
--  tuesday_2 VARCHAR(256),
--  tuesday_3 VARCHAR(256),
--  wednesday_1 VARCHAR(256),
--  wednesday_2 VARCHAR(256),
--  wednesday_3 VARCHAR(256),
--  thursday_1 VARCHAR(256),
--  thursday_2 VARCHAR(256),
--  thursday_3 VARCHAR(256),
--  friday_1 VARCHAR(256),
--  friday_2 VARCHAR(256),
--  friday_3 VARCHAR(256),
--  max_tutors VARCHAR(256),
--  total_tutors VARCHAR(256),
--  language VARCHAR(256),
--  description VARCHAR(256)
-- );

CREATE TABLE Site
(--site_id INTEGER NOT NULL,
 name VARCHAR(256) NOT NULL,
 transportation VARCHAR(256) NOT NULL,
 --PRIMARY KEY (site_id)
 PRIMARY KEY (name)
);

CREATE TABLE Teacher
(--teacher_id INTEGER NOT NULL,
 --site_id INTEGER NOT NULL,
 site_name VARCHAR(256) NOT NULL,
 name VARCHAR(256) NOT NULL,
 email VARCHAR(256) NOT NULL,
 --PRIMARY KEY (teacher_id),
 --FOREIGN KEY (site_id) REFERENCES Site(site_id)
 PRIMARY KEY (email),
 FOREIGN KEY (site_name) REFERENCES Site(name)
);

CREATE TABLE TutorInfo
(tutor_id VARCHAR(256) NOT NULL,
 name VARCHAR(256) NOT NULL,
 PRIMARY KEY (tutor_id)
);

CREATE TABLE TutorAvailable
(tutor_id VARCHAR(256) NOT NULL,
	-- 0 as Sunday, 1 as Monday, etc.
 day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
 start_time TIME(0) NOT NULL,
 end_time TIME(0) NOT NULL,
 PRIMARY KEY (tutor_id, day, start_time)
);

CREATE TABLE Request
(--request_id INTEGER NOT NULL,
	-- 0 as Sunday, 1 as Monday, etc.
 day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
 grade_level VARCHAR(256) NOT NULL,
 start_time TIME(0) NOT NULL,
 end_time TIME(0) NOT NULL,
 --teacher_id INTEGER NOT NULL,
 teacher_email VARCHAR(256) NOT NULL,
 --esl BOOLEAN NOT NULL,
 --subject VARCHAR(256) NOT NULL,
 --is_one_on_one BOOLEAN NOT NULL,
 num_tutors INTEGER NOT NULL,
 language VARCHAR(256) NOT NULL,
 description VARCHAR(1024),
 request_id SERIAL,

 --PRIMARY KEY (request_id),
 PRIMARY KEY (teacher_email, day, start_time, end_time),
 --FOREIGN KEY (teacher_id) REFERENCES Teacher(teacher_id)
 FOREIGN KEY (teacher_email) REFERENCES Teacher(email)
);

/*CREATE TABLE Matches
(tutor_id VARCHAR(256) NOT NULL,
 request_id INTEGER NOT NULL,
 PRIMARY KEY (tutor_id, request_id),
 FOREIGN KEY (tutor_id) REFERENCES TutorInfo(tutor_id),
 FOREIGN KEY (request_id) REFERENCES Request(request_id)
);*/

-- Not the real Matches table, I just needed to test. 
CREATE TABLE Bookings
(tutor_id VARCHAR(256) NOT NULL, 
teacher_email VARCHAR(256) NOT NULL,
day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
start_time TIME(0) NOT NULL,
end_time TIME(0) NOT NULL,
PRIMARY KEY (tutor_id, teacher_email, day, start_time, end_time)
);



-- INSERT INTO Site VALUES(1, 'Crest Street', 'Car');
-- INSERT INTO Site VALUES(2, 'Address2', 'Bus');
-- INSERT INTO Site VALUES(3, 'Address3', 'Walk');
-- INSERT INTO Site VALUES(4, 'Address4', 'Car');

INSERT INTO Site VALUES('Crest Street', 'Car');
INSERT INTO Site VALUES('Address2', 'Bus');
INSERT INTO Site VALUES('Address3', 'Walk');
INSERT INTO Site VALUES('Address4', 'Car');

-- INSERT INTO Teacher VALUES(123, 1, 'Mr. Bergkamp');
-- INSERT INTO Teacher VALUES(124, 2, 'Ms. Wall');
-- INSERT INTO Teacher VALUES(125, 3, 'Ms. Goldstein');
-- INSERT INTO Teacher VALUES(126, 4, 'Ms. Polson');
-- INSERT INTO Teacher VALUES(127, 4, 'Ms. Smith');

INSERT INTO Teacher VALUES('Crest Street', 'Mr. Bergkamp', 'bergkamp@fakeemail.com');
INSERT INTO Teacher VALUES('Address2', 'Ms. Wall', 'wall@fakeemail.com');
INSERT INTO Teacher VALUES('Crest Street', 'Ms. Goldstein', 'goldstein@fakeemail.com');
INSERT INTO Teacher VALUES('Address3', 'Ms. Polson', 'polson@fakeemail.com');
INSERT INTO Teacher VALUES('Address4', 'Ms. Smith', 'smith@fakeemail.com');

INSERT INTO TutorInfo VALUES('bew21', 'Bailey Wall');
INSERT INTO TutorInfo VALUES('cg1', 'Cosi Goldstein');
INSERT INTO TutorInfo VALUES('jtb43', 'Justin Bergkamp');
INSERT INTO TutorInfo VALUES('sep45', 'Sophie Polson');

INSERT INTO TutorAvailable VALUES('bew21', 1, '01:00PM', '09:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 2, '11:30AM', '01:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 2, '6:00PM', '06:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 3, '01:00PM', '03:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 3, '04:30PM', '09:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 4, '03:00PM', '09:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 5, '09:00AM', '11:30AM');
INSERT INTO TutorAvailable VALUES('bew21', 5, '01:00PM', '03:00PM');

INSERT INTO TutorAvailable VALUES('cg1', 2, '08:00AM', '12:00PM');
INSERT INTO TutorAvailable VALUES('bew21', 1, '12:00AM', '01:00PM');
INSERT INTO TutorAvailable VALUES('cg1', 1, '12:00AM', '01:00PM');
INSERT INTO TutorAvailable VALUES('jtb43', 3, '01:00PM', '03:00PM');
INSERT INTO TutorAvailable VALUES('sep45', 4, '02:00PM', '04:00PM');
INSERT INTO TutorAvailable VALUES ('sep45', 5, '10:00AM', '01:00PM');
INSERT INTO TutorAvailable VALUES('cg1', 5, '08:00AM', '12:00PM');

-- INSERT INTO Request VALUES(1, 4, '2:15 PM', '3:15 PM', 123, 'TRUE', 'Math', 'FALSE', 1);
-- INSERT INTO Request VALUES(2, 4, '3:00 PM', '4:00 PM', 124, 'TRUE', 'Writing', 'FALSE', 1);
-- INSERT INTO Request VALUES(3, 4, '3:00 PM', '4:30 PM', 125, 'TRUE', 'Writing', 'FALSE', 1);
-- INSERT INTO Request VALUES(4, 1, '12:00 AM', '1:00 AM', 124, 'TRUE', 'Science', 'FALSE', 1);
-- INSERT INTO Request VALUES(5, 2, '9:00 AM', '10:00 AM', 125, 'TRUE', 'Reading', 'TRUE', 1);
-- INSERT INTO Request VALUES(6, 3, '2:15 PM', '3:15 PM', 126, 'TRUE', 'Math', 'FALSE', 1);
-- INSERT INTO Request VALUES(7, 3, '12:15 PM', '3:15 PM', 125, 'TRUE', 'Math', 'FALSE', 1);

INSERT INTO Request VALUES(1, '4-6', '02:15 PM', '03:15 PM', 'bergkamp@fakeemail.com', 1, 'Spanish');
INSERT INTO Request VALUES(1, '4-6', '02:15 AM', '03:15 AM', 'bergkamp@fakeemail.com', 1, 'Spanish');
INSERT INTO Request VALUES(2, '3rd', '03:00 PM', '04:00 PM', 'wall@fakeemail.com', 1, 'None');
INSERT INTO Request VALUES(3, 'PreK and K', '03:00 PM', '04:30 PM', 'goldstein@fakeemail.com', 1, 'French');
INSERT INTO Request VALUES(4, '12', '12:00 AM', '01:00 AM', 'wall@fakeemail.com', 1, 'None');
INSERT INTO Request VALUES(5, '4', '09:00 AM', '10:00 AM', 'goldstein@fakeemail.com', 1, 'None');
INSERT INTO Request VALUES(1, '7th', '02:15 PM', '03:15 PM', 'polson@fakeemail.com', 1, 'Arabic');
INSERT INTO Request VALUES(2, 'Kindergarten', '12:15 PM', '03:15 PM', 'goldstein@fakeemail.com', 1, 'Japanese');
INSERT INTO Request VALUES(5, '4', '09:10 AM', '10:00 AM', 'goldstein@fakeemail.com', 1, 'None');
INSERT INTO Request VALUES(5, '4', '09:00 AM', '10:10 AM', 'goldstein@fakeemail.com', 1, 'None');


SELECT * FROM Request;
INSERT INTO Request VALUES(4, "K", '12:00PM', '01:00PM', 'goldstein@fakeemail.com', 4, 'None');
SELECT * FROM Request;

INSERT INTO Bookings VALUES('bew21', 'bergkamp@fakeemail.com', 1, '02:15 AM', '03:15 AM');

-- INSERT INTO Matches VALUES('bew21', 2);
-- INSERT INTO Matches VALUES('cg1', 5);
-- INSERT INTO Matches VALUES('sep45', 1);

-- SQL Queries

-- Returns all potential matches: where request times match tutor availability 

-- SELECT tutor_id, request_id, teacher_id, Request.day, Request.start_time, Request.end_time 
-- FROM Request, TutorAvailable 
-- WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time 
-- ORDER BY Request.day, Request.start_time;

-- -- Returns Information about a tutor given their unique tutorID

-- SELECT name,day, start_time, end_time 
-- FROM TutorAvailable, TutorInfo
-- WHERE TutorAvailable.tutor_id = 'sep45' and TutorAvailable.tutor_id = TutorInfo.tutor_id;

-- -- Returns a list of teachers at sites 

-- SELECT Site.site_id, Teacher.name
-- FROM Site, Teacher
-- WHERE Site.site_id = Teacher.site_id
-- ORDER BY Site.site_id; 

-- -- Returns requests that fit the schedule/requirements for a single tutor identified by their tutor_id

-- SELECT tutor_id, request_id, teacher_id, Request.day, Request.start_time, Request.end_time 
-- FROM Request, TutorAvailable 
-- WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and tutor_id = 'sep45' and Request.subject = 'Writing' and Request.esl = 'TRUE'
-- ORDER BY Request.day, Request.start_time;

-- -- Returns the site and name and request number of all teachers with requests

-- SELECT SITE.name, Request.request_id, Teacher.name
-- FROM Site, Request, Teacher
-- WHERE Request.teacher_id  = Teacher.teacher_id and Teacher.site_id = Site.site_id;

-- -- Returns Tutors without a match
-- SELECT tutor_id 
-- FROM TutorInfo
-- WHERE tutor_id NOT IN (
-- 	SELECT tutor_id
-- 	FROM Matches);

