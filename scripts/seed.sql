-- DaurixSkills Platform Database Seeder
-- Version: 1.0
-- Author: Jules

-- Use the database specified in the .env file
-- USE daurix_db;

-- 1. Create Users
-- Passwords are pre-hashed.
-- Admin User: admin@daurix.local / Password123!
-- Demo Student: demo@daurix.local / DemoPass123
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin User', 'admin@daurix.local', '$2y$10$nOUIs5u4OFEL4U3MHVl.3uWc.3oA3Xp3g.7a.8b.9c.0d.1e.2f', 'admin'),
(2, 'Demo Student', 'demo@daurix.local', '$2y$10$V0i2v.a4b.c6d.e8f.g0h.i2j.k4l.m6n.o8p.q0r.s2t.u4v.w6x', 'student');

-- 2. Create Courses
INSERT INTO `courses` (`id`, `title`, `description`, `slug`) VALUES
(1, 'Web Development Basics', 'Learn the fundamentals of web development, from HTML and CSS to the basics of JavaScript.', 'web-development-basics'),
(2, 'Intro to Data Science', 'Get started with data science by learning Python and its core libraries like NumPy and Pandas.', 'intro-to-data-science');

-- 3. Create Course Summaries for RAG AI
INSERT INTO `course_summaries` (`course_id`, `summary`) VALUES
(1, 'The Web Development Basics course covers three main areas: HTML for structure, CSS for styling, and JavaScript for interactivity. It is designed for absolute beginners.'),
(2, 'The Intro to Data Science course focuses on teaching Python for data analysis. Key topics include Python programming fundamentals, and using the NumPy and Pandas libraries to manipulate data.');

-- 4. Create Modules
-- Modules for Web Development Basics (Course ID: 1)
INSERT INTO `modules` (`id`, `course_id`, `title`, `order`) VALUES
(1, 1, 'Module 1: HTML & CSS Essentials', 1),
(2, 1, 'Module 2: JavaScript Fundamentals', 2);

-- Modules for Intro to Data Science (Course ID: 2)
INSERT INTO `modules` (`id`, `course_id`, `title`, `order`) VALUES
(3, 2, 'Module 1: Python for Data Science', 1),
(4, 2, 'Module 2: Core Libraries (NumPy & Pandas)', 2);

-- 5. Create Lessons
-- Lessons for Module 1 (HTML & CSS)
INSERT INTO `lessons` (`module_id`, `title`, `content`, `order`) VALUES
(1, 'Introduction to HTML', 'This lesson covers the basic structure of an HTML document.', 1),
(1, 'Styling with CSS', 'This lesson introduces you to the power of Cascading Style Sheets.', 2);

-- Lessons for Module 2 (JavaScript)
INSERT INTO `lessons` (`module_id`, `title`, `content`, `order`) VALUES
(2, 'Variables and Data Types', 'Learn about variables and the different data types in JavaScript.', 1),
(2, 'Functions and Events', 'Understand how to create functions and handle user events.', 2);

-- Lessons for Module 3 (Python)
INSERT INTO `lessons` (`module_id`, `title`, `content`, `order`) VALUES
(3, 'Python Basics', 'An introduction to Python syntax, variables, and control flow.', 1),
(3, 'Data Structures in Python', 'Learn about lists, tuples, and dictionaries.', 2);

-- Lessons for Module 4 (NumPy & Pandas)
INSERT INTO `lessons` (`module_id`, `title`, `content`, `order`) VALUES
(4, 'Introduction to NumPy', 'Learn how to create and manipulate NumPy arrays.', 1),
(4, 'DataFrames with Pandas', 'Discover the power of Pandas for data manipulation.', 2);

-- 6. Create Quizzes
INSERT INTO `quizzes` (`id`, `course_id`, `title`) VALUES
(1, 1, 'Web Dev Basics Quiz'),
(2, 2, 'Data Science Intro Quiz');

-- 7. Create Questions & Answers
-- Questions for Quiz 1 (Web Dev)
INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `type`) VALUES
(1, 1, 'What does HTML stand for?', 'multiple_choice'),
(2, 1, 'Which property is used to change the background color in CSS?', 'multiple_choice');

INSERT INTO `answers` (`question_id`, `answer_text`, `is_correct`) VALUES
(1, 'Hyper Text Markup Language', 1),
(1, 'High Tech Modern Language', 0),
(1, 'Hyperlink and Text Markup Language', 0),
(2, 'color', 0),
(2, 'background-color', 1),
(2, 'bgcolor', 0);

-- Questions for Quiz 2 (Data Science)
INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `type`) VALUES
(3, 2, 'Which keyword is used to define a function in Python?', 'multiple_choice'),
(4, 2, 'Pandas is primarily used for what purpose?', 'multiple_choice');

INSERT INTO `answers` (`question_id`, `answer_text`, `is_correct`) VALUES
(3, 'function', 0),
(3, 'def', 1),
(3, 'define', 0),
(4, 'Web Development', 0),
(4, 'Data Manipulation and Analysis', 1),
(4, 'Game Development', 0);

-- 8. Enroll Demo Student in a Course
INSERT INTO `enrollments` (`user_id`, `course_id`) VALUES
(2, 1); -- Enroll Demo Student in "Web Development Basics"
