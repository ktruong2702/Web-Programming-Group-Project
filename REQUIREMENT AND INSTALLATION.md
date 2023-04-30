PLease view this as RAW


Title of Web Aplication: CinemaCitizen

TEAM EVALUATION/ CONTRIBUTION:
  Mark Carter:
    Visual
    Page Layout (Skeleton/ Where things should be on the web page: Logo, Nav bar, Section)
    Mainly HTML, CSS, Script, Final Report
  Khang Truong:
    API integration
    Page content (Apply content from API into the website)
    Mainly PHP (convert Mark Carter’s HTML files into PHP), SQL, Script, Final Report
  Gregory Vaughan:
    No contributions except Presentation
  Mark Chai:
    No contributions except Presentation



INSTALLATION/ REQUIREMENT:
Step 1: 
  Download XAMPP from https://www.apachefriends.org/
  On the Setup step when finally downloaded XAMPP:
    Server:
      Choose the option Apache and MySQL
    Programming Languages:
      PHP
    Programming Languages:
      phpMyAdmin
      Webalizer
      Fake Sendmail
  Choose the destination for your XAMPP file, Prefer (C:\xampp)

Step 2: 
Download all the code files and save to a folder.
  Example file name: CinemaCitizen

Now, go to  your Disk (C:), look for xampp folder.
xampp -> htdocs -> move your CinemaCitizen folder in here.
  Example:
    C:\xampp\htdocs\CinemaCitizen

Step 3: Setup database in MySQL.
  After hit "Start" for MySQL on XAMPP. Choose "Admin" button, then phpMyAdmin will popup.
    Create a new database named "login_db"
    Go to SQL section on the top of the page.
    
    Insert the following lines of code:
      CREATE TABLE user (
        id INT(11) NOT NUL AUTO_INCREMENT,
        name VARCHAR(128) NOT NULL UNIQUE,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
      );

      CREATE TABLE ratings (
        id INT(11) NOT NUL AUTO_INCREMENT,
        user_id INT(11) NOT NULL,
        moive_id VARCHAR(255) NOT NULL,
        rating FLOAT NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES user(id),
        INDEX (movie_id)
      );
    
Step 4:
  Choose "Start" button for Apache. 
  Choose "Admin" button for Apache, then a page will open up.
  Now, on the search bar of the website, type:
    http://localhost/CinemaCitizen/home.php
      -> This will lead you to the home page of our Website CinemaCitizen
      
Step 5: 
  Explore the website.

*You do not need to have Python Flask in order for the webpage to function.
