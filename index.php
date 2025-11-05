
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Page Metadata -->
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Krupa Bhalsod - Information Technology Student & Developer Portfolio" />
        <meta name="keywords" content="Krupa Bhalsod, IT Student, Web Developer, Data Analyst, Portfolio" />
        <meta name="author" content="Krupa Bhalsod" />
        
        <!-- External Stylesheets and Fonts -->
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" />
        <link rel="stylesheet" href="./style.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet" />
        
        <title>Krupa Bhalsod - Portfolio</title>
    </head>
    <body>
        <!-- Container for Sidebar and Main Content -->
        <div class="cv-page">
            <!-- =====================SIDEBAR===================== -->
            <div class="sidebar-container">
                <div class="sidebar">
                    <!-- Logo Section -->
                    <div class="logo">
                        <a href="#main-page">Krupa Bhalsod</a>
                    </div>

                    <!-- Navigation Section -->
                    <div class="navigation">
                        <ul>
                            <li><a href="#about">About</a></li>
                            <li><a href="#Qualifications">Qualifications</a></li>
                            <li><a href="#skills">Skills</a></li>
                            <li><a href="#internships">Internships</a></li>
                            <li><a href="#projects">Projects</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li><a href="Admin/login.php">Login</a></li>
                        </ul>
                    </div>

                    <!-- Footer Section -->
                    <div class="footer">
                        <h6>&copy; All rights reserved | Krupa Bhalsod</h6>
                        <div class="social-links">
                            <a href=""><i class="bx bxl-instagram-alt"></i></a>
                            <a href="#"><i class="bx bxl-gmail"></i></a>
                            <a href=""><i class="bx bxl-github"></i></a>
                            <a href=""><i class="bx bxl-linkedin-square"></i></a>
                        </div>
                    </div>
                </div>

                <div class="navbar">
                    <!-- Logo Section -->
                    <div class="logo">
                        <a href="#main-page">Krupa Bhalsod</a>
                    </div>

                    <!-- Menu Button -->
                    <div class="menu-btn">
                        <svg viewBox="0 0 24 24" fill="white">
                            <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Sidebar Content (will be hidden on mobile) -->
                <div class="sidebar-content">
                    <!-- Navigation Section -->
                    <div class="navigation">
                        <ul>
                            <li><a href="#about">About</a></li>
                            <li><a href="#Qualifications">Qualifications</a></li>
                            <li><a href="#skills">Skills</a></li>
                            <li><a href="#internships">Internships</a></li>
                            <li><a href="#projects">Projects</a></li>
                            <li><a href="#contact">Contact</a></li>
                            <li><a href="Admin/login.php">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- =====================MAIN WEBSITE CONTENT===================== -->
            <?php
            /**
             * Database Configuration and Connection
             * Establishes connection to MySQL database for portfolio content
             * Configured for phpMyAdmin local development
             */
            
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "cv_db";

            // Create MySQL connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verify database connection
            if ($conn->connect_error) {
                die("
                    <div style='
                        font-family: Arial, sans-serif; 
                        max-width: 600px; 
                        margin: 50px auto; 
                        padding: 20px; 
                        border: 1px solid #dc3545; 
                        border-radius: 5px; 
                        background-color: #f8d7da; 
                        color: #721c24;
                    '>
                        <h3>Database Connection Error</h3>
                        <p>Unable to connect to the database. Please ensure:</p>
                        <ul>
                            <li>XAMPP/WAMP is running</li>
                            <li>MySQL service is started</li>
                            <li>Database 'cv_db' exists in phpMyAdmin</li>
                        </ul>
                        <small>Check phpMyAdmin at <a href='http://localhost/phpmyadmin'>http://localhost/phpmyadmin</a></small>
                    </div>
                ");
            }

            /**
             * Fetch Homepage Content
             * Retrieves main page data including title, description, and profile image
             */
            $sql = "SELECT home_title, home_description, home_image FROM homepage LIMIT 1";
            $result = $conn->query($sql);

            // Initialize default values
            $home_title = "Welcome to My Portfolio";
            $home_description = "Information Technology Student & Developer";
            $home_image = "me.jpeg";

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $home_title = htmlspecialchars($row["home_title"]);
                $home_description = htmlspecialchars($row["home_description"]);
                $home_image = htmlspecialchars($row["home_image"]);
            }
            ?>
            <div class="web-content">
                <!-- =====================HOMEPAGE SECTION===================== -->
                <div class="main-page" id="main-page">
                    <div class="main-img">
                        <img src="<?php echo $home_image; ?>" alt="Profile Image - <?php echo $home_title; ?>" class="profile-image" />
                    </div>

                    <div class="main-content">
                        <h1 class="main-title"><?php echo $home_title; ?></h1>
                        <p class="main-description">
                            <?php echo nl2br($home_description); ?>
                        </p>
                        <div class="main-btn">
                            <a href="#" class="btn" aria-label="Download Resume">Download Resume</a>
                            <a href="#contact" class="btn" aria-label="Contact Me">Let's Connect</a>
                        </div>
                    </div>
                </div>

                <?php
                /**
                 * Fetch About Section Content
                 * Retrieves about page data including image and description text
                 */
                $sql = "SELECT about_image, about_text FROM about LIMIT 1";
                $result = $conn->query($sql);
                
                // Initialize default values
                $about_image = "about.png";
                $about_text = "Information about me will be displayed here.";
                
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $about_image = htmlspecialchars($row["about_image"]);
                    $about_text = htmlspecialchars($row["about_text"]);
                }
                ?>
                
                <!-- =====================ABOUT SECTION===================== -->
                <div class="about-section">
                    <div class="heading" id="about">About Me</div>
                    <div class="about-img">
                        <img src="<?php echo $about_image; ?>" alt="About Image - Krupa Bhalsod" />
                    </div>
                    <div class="about-content">
                        <p><?php echo nl2br($about_text); ?></p>
                        <a href="#contact" class="btn" id="about-btn" aria-label="Contact Me">Let's Connect</a>
                    </div>
                </div>

                <!-- =====================QUALIFICATIONS SECTION===================== -->
                <div class="heading" id="Qualifications">Qualifications</div>   
                <?php
                /**
                 * Fetch and Display Educational Qualifications
                 * Creates timeline-style layout for education history
                 */
                $query = "SELECT * FROM qualifications ORDER BY id";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $qualifications = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $count = count($qualifications);

                    for ($i = 0; $i < $count; $i++) {
                        $degree = htmlspecialchars($qualifications[$i]['degree']);
                        $college = htmlspecialchars($qualifications[$i]['college']);
                        $duration = htmlspecialchars($qualifications[$i]['duration']);
                        $cgpa = $qualifications[$i]['cgpa'] ? htmlspecialchars($qualifications[$i]['cgpa']) : 'N/A';

                        $isLast = ($i == $count - 1);

                        if ($i % 2 == 0) {
                            // Even index: Right side of timeline
                            echo '<div class="qualification">';
                            echo '<div class="qualification-details">';
                            echo '<p class="qualification_title">' . $degree . '</p>';
                            echo '<p class="qualification_subtitle">' . $college . '</p>';
                            echo '<p class="qualification_duration">' . $duration . '</p>';
                            if ($cgpa !== 'N/A') {
                                echo '<p class="qualification_score">CGPA - ' . $cgpa . '</p>';
                            }
                            echo '</div>';
                            echo '<div>';
                            echo '<div class="timeline_circle"></div>';
                            if (!$isLast) {
                                echo '<span class="timeline-line"></span>';
                            }
                            echo '</div>';
                            echo '<div></div>';
                            echo '</div>';
                        } else {
                            // Odd index: Left side of timeline
                            echo '<div class="qualification">';
                            echo '<div></div>';
                            echo '<div>';
                            echo '<div class="timeline_circle"></div>';
                            if (!$isLast) {
                                echo '<span class="timeline-line"></span>';
                            }
                            echo '</div>';
                            echo '<div class="qualification-details">';
                            echo '<p class="qualification_title">' . $degree . '</p>';
                            echo '<p class="qualification_subtitle">' . $college . '</p>';
                            echo '<p class="qualification_duration">' . $duration . '</p>';
                            if ($cgpa !== 'N/A') {
                                echo '<p class="qualification_score">CGPA - ' . $cgpa . '</p>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    echo '<p class="text-center">No qualifications found.</p>';
                }
                ?>


                                <!-- =====================SKILLS SECTION===================== -->
                <?php
                /**
                 * Fetch and Display Skills with Progress Rings
                 * Shows skills in organized containers with percentage indicators
                 */
                $sql = "SELECT skill_name, skill_percentage FROM skills ORDER BY skill_name";
                $result = $conn->query($sql);

                $counter = 0;
                ?>

                <div class="skills">
                    <div class="heading" id="skills">Skills</div>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Start new container for every set of 4 skills
                            if ($counter % 4 == 0) {
                                if ($counter > 0) {
                                    echo "</div>"; // Close previous container
                                }
                                echo "<div class='skills-container'>"; // Start new container
                            }

                            $skill_name = htmlspecialchars($row['skill_name']);
                            $skill_percentage = (int)$row['skill_percentage'];
                            ?>
                            
                            <!-- Individual Skill Display -->
                            <div class="skill">
                                <div class="skill-name"><?php echo $skill_name; ?></div>
                                <div class="progress-ring" data-percentage="<?php echo $skill_percentage; ?>">
                                    <svg class="progress-ring__svg" width="150" height="150">
                                        <circle class="progress-ring__circle-background" cx="75" cy="75" r="70"></circle>
                                        <circle class="progress-ring__circle-progress" cx="75" cy="75" r="70" 
                                                stroke-dasharray="471" 
                                                stroke-dashoffset="<?php echo 471 - (471 * $skill_percentage / 100); ?>">
                                        </circle>
                                    </svg>
                                    <div class="percentage-text"><?php echo $skill_percentage; ?>%</div>
                                </div>
                            </div>
                            
                            <?php
                            $counter++;
                        }

                        // Close the last skills container
                        if ($counter > 0) {
                            echo "</div>";
                        }
                    } else {
                        echo '<p class="text-center">No skills found.</p>';
                    }
                    ?>
                </div>

                <!-- =====================INTERNSHIPS SECTION===================== -->
                <?php
                /**
                 * Fetch and Display Internship Experience
                 * Shows internships in timeline format with details
                 */
                $sql = "SELECT internship_role, internship_duration, internship_details FROM internships ORDER BY id DESC";
                $result = $conn->query($sql);
                ?>

                <div class="internship-section">
                    <div class="heading" id="internships">Internships</div>
                    <div class="internship_container">
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $internship_role = htmlspecialchars($row['internship_role']);
                                $internship_duration = htmlspecialchars($row['internship_duration']);
                                $internship_details = htmlspecialchars($row['internship_details']);
                        ?>
                                <!-- Individual Internship Entry -->
                                <div class="internship">
                                    <div class="timeline_circle"></div>
                                    <div class="timeline_line"></div>
                                    <div class="internship-details">
                                        <h3><?php echo $internship_role; ?></h3>
                                        <p class="internship-duration"><?php echo $internship_duration; ?></p>
                                        <div class="internship-description">
                                            <?php echo nl2br($internship_details); ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "<p class='text-center'>No internships available.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- =====================PROJECTS SECTION===================== -->
                <?php
                /**
                 * Fetch and Display Project Portfolio
                 * Shows projects with titles, links, and descriptions
                 */
                $sql = "SELECT project_title, project_github_link, project_description FROM projects ORDER BY id DESC";
                $result = $conn->query($sql);
                ?>

                <div class="heading" id="projects">Projects</div>
                <div class="projects-container">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $project_title = htmlspecialchars($row['project_title']);
                            $project_github_link = htmlspecialchars($row['project_github_link']);
                            $project_description = htmlspecialchars($row['project_description']);
                    ?>
                            <!-- Individual Project Entry -->
                            <div class="projects">
                                <h3><?php echo $project_title; ?></h3>
                                <a href="<?php echo $project_github_link; ?>" target="_blank" rel="noopener noreferrer" 
                                   aria-label="View <?php echo $project_title; ?> project">
                                    View Project
                                </a>
                                <p><?php echo nl2br($project_description); ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p class='text-center'>No projects available.</p>";
                    }
                    ?>
                </div>
                <!-- =====================CONTACT SECTION===================== -->
                <div class="heading" id="contact">Contact Me</div>
                <div class="contact-form-container">
                    <form class="contact-form" method="POST" action="#contact">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact Number</label>
                            <input type="tel" id="contact" name="contact" required 
                                   value="<?php echo isset($_POST['contact']) ? htmlspecialchars($_POST['contact']) : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                        </div>

                        <div class="form-group">
                            <label for="title">Message Title</label>
                            <input type="text" id="title" name="title" required 
                                   value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" />
                        </div>

                        <div class="form-group full-width">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        </div>

                        <button type="submit" id="submit" class="btn">Submit Message</button>
                    </form>
                    
                    <?php
                    /**
                     * Handle Contact Form Submission
                     * Processes form data and stores in database with proper validation
                     */
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
                        isset($_POST['name'], $_POST['contact'], $_POST['email'], $_POST['title'], $_POST['message'])) {
                        
                        // Sanitize and validate input data
                        $name = trim(htmlspecialchars($_POST['name']));
                        $contact = trim(htmlspecialchars($_POST['contact']));
                        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
                        $title = trim(htmlspecialchars($_POST['title']));
                        $message = trim(htmlspecialchars($_POST['message']));
                        
                        // Validate email format
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            echo '<div class="alert alert-error">Invalid email format. Please try again.</div>';
                        } elseif (empty($name) || empty($contact) || empty($email) || empty($title) || empty($message)) {
                            echo '<div class="alert alert-error">All fields are required. Please fill out the form completely.</div>';
                        } else {
                            // Prepare and execute database insertion
                            $stmt = $conn->prepare("INSERT INTO contact (name, contact_number, email, message_title, message) VALUES (?, ?, ?, ?, ?)");
                            
                            if ($stmt) {
                                $stmt->bind_param("sssss", $name, $contact, $email, $title, $message);
                                
                                if ($stmt->execute()) {
                                    echo '<div class="alert alert-success">Thank you for your message! I will get back to you soon.</div>';
                                    // Clear form data after successful submission
                                    unset($_POST);
                                } else {
                                    echo '<div class="alert alert-error">Sorry, there was an error sending your message. Please try again later.</div>';
                                }
                                
                                $stmt->close();
                            } else {
                                echo '<div class="alert alert-error">Database error. Please try again later.</div>';
                            }
                        }
                    }
                    ?>
                </div>
                
                <!-- Footer Section for Mobile -->
                <div class="footer footer-mobile">
                    <h6>&copy; <?php echo date('Y'); ?> All rights reserved | Krupa Bhalsod</h6>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram"><i class="bx bxl-instagram-alt"></i></a>
                        <a href="#" aria-label="Gmail"><i class="bx bxl-gmail"></i></a>
                        <a href="#" aria-label="GitHub"><i class="bx bxl-github"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="bx bxl-linkedin-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
        /**
         * Close Database Connection
         * Clean up resources
         */
        $conn->close();
        ?>
        
        <!-- JavaScript Files -->
        <script src="./script.js"></script>
    </body>
</html>
