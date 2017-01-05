CREATE TABLE Site
(name VARCHAR(256) NOT NULL,
 transportation VARCHAR(256) NOT NULL,
 travel_time INTEGER,
 is_van_eligible BOOLEAN,
 PRIMARY KEY (name)
);

CREATE TABLE Teacher
(site_name VARCHAR(256) NOT NULL,
 name VARCHAR(256) NOT NULL,
 email VARCHAR(256) NOT NULL,
 PRIMARY KEY (email),
 FOREIGN KEY (site_name) REFERENCES Site(name)
);

CREATE TABLE ClassesOffered
(class VARCHAR(256) NOT NULL,
PRIMARY KEY (class)
);

CREATE TABLE TutorInfo
(tutor_id VARCHAR(256) NOT NULL,
 name VARCHAR(256) NOT NULL,
 password VARCHAR(256) NOT NULL,
 birth_date VARCHAR(256),
 duke_email VARCHAR(256),
 graduation_year VARCHAR(256),
 course VARCHAR(256),
 major_and_minor VARCHAR(256),
 has_previous_experience VARCHAR(256),
 is_education_minor VARCHAR(256),
 is_licensure_track VARCHAR(256),
 is_america_reads_america_counts_tutor VARCHAR(256),
 is_varsity_athlete VARCHAR(256),
 varsity_team VARCHAR(256),
 varsity_academic_advisor VARCHAR(256),
 other_languages VARCHAR(256),
 PRIMARY KEY (tutor_id)
);

CREATE TABLE TutorAvailable
(tutor_id VARCHAR(256) NOT NULL,
 day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
 start_time TIME(0) NOT NULL,
 end_time TIME(0) NOT NULL,
 PRIMARY KEY (tutor_id, day, start_time)
);

CREATE TABLE Request
(day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
 grade_level VARCHAR(256) NOT NULL,
 start_time TIME(0) NOT NULL,
 end_time TIME(0) NOT NULL,
 teacher_email VARCHAR(256) NOT NULL,
 num_tutors INTEGER NOT NULL,
 language VARCHAR(256) NOT NULL,
 description VARCHAR(1024),
 is_hidden BOOLEAN,
 request_id SERIAL,
 PRIMARY KEY (teacher_email, day, start_time, end_time),
 FOREIGN KEY (teacher_email) REFERENCES Teacher(email)
);

CREATE TABLE AdminInfo
(
keycode VARCHAR(256) NOT NULL
);

INSERT INTO AdminInfo VALUES('admin');

CREATE TABLE Bookings
(tutor_id VARCHAR(256) NOT NULL, 
teacher_email VARCHAR(256) NOT NULL,
day INTEGER NOT NULL CHECK (day >= 1 AND day <= 5),
start_time TIME(0) NOT NULL,
end_time TIME(0) NOT NULL,
needs_van BOOLEAN NOT NULL,
isapproved VARCHAR(256), 
PRIMARY KEY (tutor_id, teacher_email, day, start_time, end_time)
);


-- INSERT INTO Site VALUES('Crest Street', 'Car');
-- INSERT INTO Site VALUES('Address2', 'Bus');
-- INSERT INTO Site VALUES('Address3', 'Walk');
-- INSERT INTO Site VALUES('Address4', 'Car');

-- INSERT INTO Teacher VALUES('Crest Street', 'Mr. Bergkamp', 'bergkamp@fakeemail.com');
-- INSERT INTO Teacher VALUES('Address2', 'Ms. Wall', 'wall@fakeemail.com');
-- INSERT INTO Teacher VALUES('Crest Street', 'Ms. Goldstein', 'goldstein@fakeemail.com');
-- INSERT INTO Teacher VALUES('Address3', 'Ms. Polson', 'polson@fakeemail.com');
-- INSERT INTO Teacher VALUES('Address4', 'Ms. Smith', 'smith@fakeemail.com');

INSERT INTO TutorInfo VALUES('bew21', 'Bailey Wall', 'password');
INSERT INTO TutorInfo VALUES('cmg64', 'Cosi Goldstein', 'password');
INSERT INTO TutorInfo VALUES('jtb43', 'Justin Bergkamp', 'password');
INSERT INTO TutorInfo VALUES('sep45', 'Sophie Polson', 'password');

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

-- INSERT INTO Request VALUES(1, '4-6', '02:15 PM', '03:15 PM', 'bergkamp@fakeemail.com', 1, 'Spanish', '', FALSE);
-- INSERT INTO Request VALUES(2, '3rd', '03:00 PM', '04:00 PM', 'wall@fakeemail.com', 1, 'None', '', FALSE);
-- INSERT INTO Request VALUES(3, 'PreK and K', '03:00 PM', '04:30 PM', 'goldstein@fakeemail.com', 1, 'French', '', FALSE);
-- INSERT INTO Request VALUES(5, '4', '09:00 AM', '10:00 AM', 'goldstein@fakeemail.com', 1, 'None', '', FALSE);
-- INSERT INTO Request VALUES(1, '7th', '02:15 PM', '03:15 PM', 'polson@fakeemail.com', 1, 'Arabic', '', FALSE);
-- INSERT INTO Request VALUES(2, 'Kindergarten', '12:15 PM', '03:15 PM', 'goldstein@fakeemail.com', 1, 'Japanese', '', FALSE);
-- INSERT INTO Request VALUES(5, '4', '09:10 AM', '10:00 AM', 'goldstein@fakeemail.com', 1, 'None', '', FALSE);
-- INSERT INTO Request VALUES(5, '4', '09:00 AM', '10:10 AM', 'goldstein@fakeemail.com', 1, 'None', '', TRUE);


