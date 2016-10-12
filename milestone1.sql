CREATE TABLE Teacher
(teacher_id INTEGER NOT NULL,
 name VARCHAR(256) NOT NULL,
 PRIMARY KEY (teacher_id)
);

CREATE TABLE Site
(site_id INTEGER NOT NULL,
 name VARCHAR(256) NOT NULL,
 transportation VARCHAR(256) NOT NULL,
 PRIMARY KEY (site_id)
);

CREATE TABLE TutorInfo
(tutor_id VARCHAR(256) NOT NULL,
 name VARCHAR(256) NOT NULL,
 PRIMARY KEY (tutor_id)
);

CREATE TABLE TutorAvailable
(tutor_id VARCHAR(256) NOT NULL,
	-- 0 as Sunday, 1 as Monday, etc.
 day INTEGER NOT NULL CHECK (day >= 0 AND day <= 7),
 start_time TIMESTAMP NOT NULL,
 end_time TIMESTAMP NOT NULL,
 PRIMARY KEY (tutor_id, day, start_time)
);

CREATE TABLE Request
(request_id INTEGER NOT NULL,
	-- 0 as Sunday, 1 as Monday, etc.
 day INTEGER NOT NULL CHECK (day >= 0 AND day <= 7),
 start_time TIMESTAMP NOT NULL,
 end_time TIMESTAMP NOT NULL,
 teacher_id INTEGER NOT NULL,
 site_id INTEGER NOT NULL,
 esl BOOLEAN NOT NULL,
 subject VARCHAR(256) NOT NULL,
 is_one_on_one BOOLEAN NOT NULL,
 num_tutors INTEGER NOT NULL,
 PRIMARY KEY (request_id),
 FOREIGN KEY (teacher_id) REFERENCES Teacher(teacher_id),
 FOREIGN KEY (site_id) REFERENCES Site(site_id)
);

CREATE TABLE Matches
(tutor_id VARCHAR(256) NOT NULL,
 request_id INTEGER NOT NULL,
 PRIMARY KEY (tutor_id, request_id),
 FOREIGN KEY (tutor_id) REFERENCES TutorInfo(tutor_id),
 FOREIGN KEY (request_id) REFERENCES Request(request_id)
);