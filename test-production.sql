-- SQL Queries

-- Returns all potential matches: where request times match tutor availability 

SELECT tutor_id, teacher_email, Request.day, Request.start_time, Request.end_time 
FROM Request, TutorAvailable 
WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time;

SELECT name,day, start_time, end_time 
FROM TutorAvailable, TutorInfo
WHERE TutorAvailable.tutor_id = 'sep45' and TutorAvailable.tutor_id = TutorInfo.tutor_id;

-- Returns a list of teachers at sites 

SELECT Site.name, Teacher.name
FROM Site, Teacher
WHERE Site.name = Teacher.site_name
ORDER BY Site.name; 

-- Returns requests that fit the schedule/requirements for a single tutor identified by their tutor_id

SELECT tutor_id, teacher_email, Request.day, Request.start_time, Request.end_time
FROM Request, TutorAvailable 
WHERE TutorAvailable.day = Request.day and TutorAvailable.start_time <= Request.start_time and TutorAvailable.end_time >= Request.end_time and tutor_id = 'sep45'; 

-- Returns the site and name and request number of all teachers with requests

SELECT SITE.name, Teacher.name
FROM Site, Request, Teacher
WHERE Request.teacher_email  = Teacher.email and Teacher.site_name = Site.name;


-- Joins the request with the teacher requesting it
SELECT * 
FROM Request, Teacher 
WHERE teacher_email = email;

--Return start times, endtimes, teachers of all sites in walking distance

SELECT Teacher.name, Teacher.email, Request.start_time, Request.end_time, Site.name
FROM Request, Teacher, Site
WHERE Request.teacher_email = Teacher.email and Teacher.site_name = Site.name and Site.transportation != 'Car';


--Returns teachers teaching classes at a certain age level
Select Distinct Teacher.name
From Teacher, Request
Where Teacher.email = Request.teacher_email and Request.grade_level = '4';

--Returns number of timeslots per teacher
Select Teacher.name, Count(Teacher.name)
From Request, Teacher
Where Request.teacher_email = Teacher.email
Group By Teacher.name;


--Returns Site with the max number of teachers

Select Teacher.site_name, Count(Teacher.name) as Number_of_teachers
From Teacher
Group By Teacher.site_name
Order By Number_of_teachers DESC
Limit 1;