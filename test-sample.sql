-- SQL Queries

-- Returns all potential matches: where request times match tutor availability 

SELECT tutor_id, request_id, teacher_id, Request.day, Request.start_time, Request.end_time 
FROM Request, TutorAvailable 
WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time 
ORDER BY Request.day, Request.start_time;

-- Returns Information about a tutor given their unique tutorID

SELECT name,day, start_time, end_time 
FROM TutorAvailable, TutorInfo
WHERE TutorAvailable.tutor_id = 'sep45' and TutorAvailable.tutor_id = TutorInfo.tutor_id;

-- Returns a list of teachers at sites 

SELECT Site.site_id, Teacher.name
FROM Site, Teacher
WHERE Site.site_id = Teacher.site_id
ORDER BY Site.site_id; 

-- Returns requests that fit the schedule/requirements for a single tutor identified by their tutor_id

SELECT tutor_id, request_id, teacher_id, Request.day, Request.start_time, Request.end_time 
FROM Request, TutorAvailable 
WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and tutor_id = 'sep45' and Request.subject = 'Writing' and Request.esl = 'TRUE'
ORDER BY Request.day, Request.start_time;

-- Returns the site and name and request number of all teachers with requests

SELECT SITE.name, Request.request_id, Teacher.name
FROM Site, Request, Teacher
WHERE Request.teacher_id  = Teacher.teacher_id and Teacher.site_id = Site.site_id;

-- Returns Tutors without a match
SELECT tutor_id 
FROM TutorInfo
WHERE tutor_id NOT IN (
	SELECT tutor_id
	FROM Matches);