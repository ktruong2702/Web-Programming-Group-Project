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
  Have all the files in the htdocs folder (XAMPP)
  When download XAMPP, the folder will usually in Local Disk (C:)
  Example:
    C:\xampp\htdocs\CinemaCitizen(this is the folder created to have all the files in there)
    
    Run the code by hit start on "Admin" button on Apache (XAMPP)
    Go to home page then you can explore the web page from there (http://localhost/CinemaCitizen/home.php)
    
    Set up table in MySQL (XAMPP):
    Create a database name "login_db"
    Create 2 table name "user" and "ratings"
    
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
