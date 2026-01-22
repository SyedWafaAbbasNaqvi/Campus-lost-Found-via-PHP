<?php
require_once 'config.php';
$page_title = 'Contact & About';
include 'includes/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1>About Us</h1>
        <p>Campus Lost & Found Portal - CSC 337 Project</p>
    </div>
    
    <div class="content-section">
        <div class="about-grid">
            <div class="about-card">
                <h2>📋 Project Overview</h2>
                <p>The Campus Lost & Found Portal is a web-based application designed to help students reunite with their lost belongings. Built with PHP and MySQL, this platform demonstrates full CRUD (Create, Read, Update, Delete) operations in a real-world application.</p>
            </div>
            
            <div class="about-card">
                <h2>🎯 Our Mission</h2>
                <p>To create a centralized platform where students can easily report lost items and help others find their belongings, fostering a helpful and caring campus community.</p>
            </div>
            
            <div class="about-card">
                <h2>✨ Key Features</h2>
                <ul>
                    <li>Post lost and found items with images</li>
                    <li>Advanced search and filtering</li>
                    <li>User authentication and profiles</li>
                    <li>Real-time item status updates</li>
                    <li>Category-based organization</li>
                    <li>Secure contact information sharing</li>
                </ul>
            </div>
            
            <div class="about-card">
                <h2>🛠️ Technology Stack</h2>
                <ul>
                    <li><strong>Frontend:</strong> HTML5, CSS3, JavaScript</li>
                    <li><strong>Backend:</strong> PHP 7.4+</li>
                    <li><strong>Database:</strong> MySQL</li>
                    <li><strong>Server:</strong> Apache</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="content-section">
        <h2 class="section-title">👥 Group Members</h2>
        <div class="members-grid">
            <div class="member-card">
                <div class="member-icon">👤</div>
                <h3>Member 1 Name</h3>
                <p class="member-id">Student ID: 001</p>
                <p class="member-role">Role: Team Lead & Backend Developer</p>
            </div>
            
            <div class="member-card">
                <div class="member-icon">👤</div>
                <h3>Member 2 Name</h3>
                <p class="member-id">Student ID: 002</p>
                <p class="member-role">Role: Database Designer</p>
            </div>
            
            <div class="member-card">
                <div class="member-icon">👤</div>
                <h3>Member 3 Name</h3>
                <p class="member-id">Student ID: 003</p>
                <p class="member-role">Role: Frontend Developer</p>
            </div>
            
            <div class="member-card">
                <div class="member-icon">👤</div>
                <h3>Member 4 Name</h3>
                <p class="member-id">Student ID: 004</p>
                <p class="member-role">Role: PHP Developer</p>
            </div>
            
            <div class="member-card">
                <div class="member-icon">👤</div>
                <h3>Member 5 Name</h3>
                <p class="member-id">Student ID: 005</p>
                <p class="member-role">Role: Testing & Documentation</p>
            </div>
        </div>
    </div>
    
    <div class="content-section">
        <h2 class="section-title">📞 Contact Information</h2>
        <div class="contact-grid">
            <div class="contact-card">
                <div class="contact-icon">📧</div>
                <h3>Email</h3>
                <p><a href="mailto:support@campus.edu">support@campus.edu</a></p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">📱</div>
                <h3>Phone</h3>
                <p><a href="tel:+923001234567">+92-300-1234567</a></p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">🏫</div>
                <h3>Location</h3>
                <p>Campus Building, Room 101<br>University Name</p>
            </div>
            
            <div class="contact-card">
                <div class="contact-icon">💻</div>
                <h3>GitHub</h3>
                <p><a href="#" target="_blank">View Source Code</a></p>
            </div>
        </div>
    </div>
    
    <div class="content-section">
        <h2 class="section-title">📚 Course Information</h2>
        <div class="course-info">
            <p><strong>Course:</strong> CSC 337 - Web Programming Languages</p>
            <p><strong>Instructor:</strong> [Instructor Name]</p>
            <p><strong>Project:</strong> Assignment 4 - PHP CRUD-Based Dynamic Website</p>
            <p><strong>Semester:</strong> Spring 2026</p>
            <p><strong>Submission Date:</strong> January 15, 2026</p>
        </div>
    </div>
</div>

<style>
.content-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    margin: 2rem 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.about-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.about-card {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 4px solid #667eea;
}

.about-card h2 {
    color: #667eea;
    margin-bottom: 1rem;
}

.about-card ul {
    list-style-position: inside;
    line-height: 2;
}

.members-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.member-card {
    text-align: center;
    padding: 2rem 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    transition: transform 0.3s;
}

.member-card:hover {
    transform: translateY(-5px);
}

.member-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.member-card h3 {
    margin-bottom: 0.5rem;
}

.member-id {
    font-weight: bold;
    margin: 0.5rem 0;
}

.member-role {
    font-size: 0.9rem;
    opacity: 0.9;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin: 2rem 0;
}

.contact-card {
    text-align: center;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.contact-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.contact-card a {
    color: #667eea;
    text-decoration: none;
}

.contact-card a:hover {
    text-decoration: underline;
}

.course-info {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 8px;
    border-left: 4px solid #28a745;
}

.course-info p {
    margin: 0.8rem 0;
    font-size: 1.1rem;
}
</style>

<?php include 'includes/footer.php'; ?>
