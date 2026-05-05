# 1. Student data imported from excel
Tabel: students {id, student_id, name, email, year_entrance, status, timestamp}

## 1.1. view import students data
## 1.2. Controller import students data
## 1.3. Service import students data
### 1.3.1 Rule: 
## 1.4. Repository import students data

# 2. Lecturers data created into excel -> import to tabel. See: tif.uad.ac.id/dosen
Tabel: lecturers {id, lecturer_id, name, email, expertise, timestamp}

# 3. Skripsi 
Table: skripsi {id, student_id (FK), supervisor_id (FK), title, description, suggestion_supervisor (FK), status, rejection_note, submission_date, approval_date, elective_courses (FK, json)}

Note: elective_courses { {'PKPL', 'A'}, {'P. Mobile', 'B'} }

# 4. Elective Courses
Table: elective_courses {id, courses, timestamp}
