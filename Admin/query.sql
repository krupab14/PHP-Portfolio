-- Create the database
CREATE DATABASE cv_db;

-- Use the database
USE cv_db;

-- Create the users table for the login form
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create the profile table for the profile form
CREATE TABLE about (
    id INT AUTO_INCREMENT PRIMARY KEY,
    about_image VARCHAR(255),
    about_text TEXT NOT NULL
);

-- Create the projects table for the projects form
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_title VARCHAR(255),
    project_github_link VARCHAR(255),
    project_description TEXT
);

-- Create the internships table for the internships form
CREATE TABLE internships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    internship_role VARCHAR(255),
    internship_duration VARCHAR(255),
    internship_details TEXT
);

-- Create the skills table for the skills form
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(255),
    skill_percentage INT
);

-- Create the homepage table for the homepage form
CREATE TABLE homepage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    home_title VARCHAR(255) NOT NULL,
    home_description TEXT NOT NULL,
    home_image VARCHAR(255)
);

CREATE TABLE contact ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL, contact_number VARCHAR(20) NOT NULL, email VARCHAR(255) NOT NULL, message_title VARCHAR(255) NOT NULL, message TEXT NOT NULL );

CREATE TABLE qualifications (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each qualification
    degree VARCHAR(255) NOT NULL,      -- Degree name
    college VARCHAR(255) NOT NULL,     -- College or university name
    duration VARCHAR(255) NOT NULL,    -- Duration of the degree
    cgpa DECIMAL(4, 2) NOT NULL        -- CGPA (up to two decimal places)
);


INSERT INTO homepage (home_title, home_description, home_image) VALUES ( 'I''m Krupa Bhalsod', 'Hello! I''m Krupa, a third-year Information Technology student at Marwadi University with a current CGPA of 8.18. I hold a Diploma in Computer Engineering from the Government Polytechnic for Girls, Ahmedabad, with a CGPA of 8.25. I am currently working as a Data Analyst Intern at Edulyt. I have formerly worked as a Web developer Intern at Codsoft. I am a tech enthusiast and would love to connect with like-minded individuals.', 'me.jpeg' );

INSERT INTO about (about_image, about_text)
VALUES (
    'about.png',
    'I am Krupa Bhalsod, an ambitious Information Technology student currently pursuing my Bachelor of Technology in IT. With a solid foundation in programming and software development, I am passionate about bringing innovative solutions to life. My experience spans web development and data analysis, where I have honed my skills in HTML, CSS, JavaScript, and various data manipulation tools. Through internships at CodSoft and Edulyt, I have gained hands-on experience in designing responsive web applications and conducting insightful data analysis, all while collaborating with cross-functional teams. My educational background, complemented by certifications in Python, SQL, and networking essentials, has equipped me with a well-rounded skill set. I have successfully completed projects ranging from developing interactive games and managing data-driven systems to creating engaging web portfolios. My dedication to learning and my drive to contribute to meaningful software projects make me eager to take on challenges in dynamic work environments, where I can continue to grow as a software engineer.'
);




-- Insert Skills
INSERT INTO skills (skill_name, skill_percentage) VALUES
('Java', 80),
('Python', 70),
('SQL', 90),
('.NET', 75),
('HTML & CSS', 85),
('JavaScript', 80),
('WordPress', 65),
('Android Studio', 70),
('Communication', 90),
('Precision', 85),
('Teamwork', 75),
('Problem Solving', 80);

-- Insert Data Analyst Intern at Edulyt
INSERT INTO internships (internship_role, internship_duration, internship_details)
VALUES (
    'Data Analyst Intern at Edulyt',
    'June 16, 2024 - September 16, 2024',
    'Engaged in data analysis projects, focusing on data manipulation, visualization, and reporting. Developed proficiency in various data analysis tools and techniques to support company objectives.'
);

-- Insert Web Developer Intern at CodSoft
INSERT INTO internships (internship_role, internship_duration, internship_details)
VALUES (
    'Web Developer Intern at CodSoft',
    'June 5, 2024 - July 5, 2024',
    'Developed practical skills in HTML, CSS, and JavaScript through hands-on projects. Created a personal portfolio, a landing page, and a functional calculator, enhancing web design and development skills.'
);

-- Insert TurboTypist Project
INSERT INTO projects (project_title, project_github_link, project_description)
VALUES (
    'TurboTypist',
    'https://krupab14.github.io/TurboTypist/',
    'Developed a typing speed indicator using HTML, CSS, and JavaScript for real-time speed calculations. Integrated a text-to-speech feature for enhanced accessibility. Designed a user-friendly interface that highlights errors and provides accuracy feedback.'
);

-- Insert VedicVitality Project
INSERT INTO projects (project_title, project_github_link, project_description)
VALUES (
    'VedicVitality',
    'https://krupab14.github.io/VedicVitality/',
    'Created an Ayurvedic eCommerce landing page using HTML, CSS, and JavaScript for CodSoft. Showcased Ayurvedic herbs and wellness products with engaging design elements.'
);

-- Insert Fun Games Project
INSERT INTO projects (project_title, project_github_link, project_description)
VALUES (
    'Fun Games',
    'https://krupab14.github.io/FunGames/',
    'Developed Tic Tac Toe and Maze games using HTML, CSS, and JavaScript. Provided users with interactive gaming experiences and challenging gameplay mechanics.'
);

-- Insert Portfolio Project
INSERT INTO projects (project_title, project_github_link, project_description)
VALUES (
    'Portfolio',
    'https://krupab14.github.io/Portfolio14/',
    'Designed a dynamic portfolio website to showcase projects and skills. Developed a responsive layout for optimal viewing on all devices. Integrated a MongoDB database for efficient data management.'
);

-- Insert Mess Management System Project
INSERT INTO projects (project_title, project_github_link, project_description)
VALUES (
    'Mess Management System',
    'https://github.com/krupab14/Mess-Management-System',
    'Implemented user registration and authentication for over 100 users. Developed features for daily meal tracking and billing accuracy. Managed the storage of over 1000 records using MySQL for efficient data access.'
);

-- Insert Bachelor's of Technology qualification
INSERT INTO qualifications (degree, college, duration, cgpa)
VALUES 
('Bachelor\'s of Technology - Information Technology', 'Marwadi University, Rajkot', 'September 2023 - Present', 8.18);

-- Insert Diploma qualification
INSERT INTO qualifications (degree, college, duration, cgpa)
VALUES 
('Diploma - Computer Engineering', 'Government Polytechnic for Girls, Ahmedabad', 'October 2020 - July 2023', 8.25);

-- Insert SSC qualification (Note: SSC does not have a CGPA, so we can insert NULL or a placeholder for cgpa)
INSERT INTO qualifications (degree, college, duration, cgpa)
VALUES 
('SSC', 'Shree Satya Sai Vidyalaya', 'May 2020', NULL);


Username = root
password = 
database = cv_db