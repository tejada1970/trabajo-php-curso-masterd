## Work description

**You can find the complete statement of this work, in the last point of this document with the title (DESCRIPTION-WORK-PHP).**

**'It is important to note that this is a fictional project used for educational and practice purposes'**

## Characteristics

**Use database:**

To ensure the correct functioning of PHP work, this database is provided in SQL format (small_pets.sql) that contains the data necessary for its operation.

**'It is important to note that this database is designed exclusively to support the operation of PHP work and should not be used for any other purpose'**

**Server requirements:**

For its correct functioning, the project must be executed from a server. For example, it is recommended to use XAMPP or another local server to host the application.

## Access credentials

To log in as an administrator or user and check the operation of the application, I have established two default credentials that are displayed on the "Login" page of the project.

To log in with your own real or fictitious credentials, you can do so by registering from the "Registration" page of the application. (In this case, you can only register as "user").

## Download and Configuration in Local Environment

**Download the Project:** 
Click the "Code" button in this repository and select "Download ZIP".

**Project Extraction:**
Create a new folder on your desktop. Go to the downloads folder and drag the downloaded ZIP file to the new folder to extract it.

**Location of the Project on the Local Server:**
Copy the extracted project folder and paste it into the folder on your local server. For example, in XAMPP, the folder is usually xampp/htdocs.

**Local Environment Configuration:**
Before running the project in your local environment, you will need to configure your local server and database. Follow the steps below:

1. **Make sure you have XAMPP or a similar web server installed on your computer**.

2. **Database Import Process:**

    To ensure the correct functioning of the application, it is necessary to import the provided database. Follow these detailed steps to import successfully:

    1. On Windows, access the XAMPP Control Panel from the start menu (Start > XAMPP > XAMPP Control Panel) and run it as administrator to ensure you have the necessary permissions.

    2. Start both Apache and MySQL from the control panel. These are essential services for the web server and the database, respectively.

    3. After starting MySQL, click the “Admin” button next to it to open the phpMyAdmin interface in your default web browser.

    4. Within phpMyAdmin, select the "Database" option at the top and create a new database with the name 'small_pets'.

    5. Return to the main phpMyAdmin page and select the 'Import' tab. Here, upload the provided SQL file along with the project files.

    6. Once the file is uploaded, click on the 'Import' button to start the import process. This step may take a while depending on the size of the database.

    7. After the import completes successfully, you will receive an on-screen confirmation. Now the database is ready to be used by the application.

3. **Fill in the following variables with your local environment information in the project's .env.php file:**
   
    - `SERVER`: Keep 'localhost' if local or change it to the address of your database server.
    - `BD`: Keep the name 'small_pets' provided in the repository for correct import and operation.
    - `USER`: Change 'username' to the username of your database.
    - `PASSWORD`: Change 'password' to your database password.

    **By following these steps, you will have correctly configured your local environment and you will have imported the database necessary for the application to function.**

4. **Project View:** Open your web browser and navigate to (localhost/put here the folder name of the extracted project), this will load the project in your browser and you can interact with it locally. 

5. **IMPORTANT:**
"Credential security in a production project is of utmost importance to protect data integrity and user privacy. Credentials, such as usernames and passwords, provide privileged access to critical systems and databases. Inadvertent exposure of these credentials can result in devastating security breaches, compromising the confidentiality and availability of information. Therefore, it is essential to implement robust security practices, such as secure storage of credentials, use of appropriate access policies, and careful management of permissions. Additionally, it is important to educate the entire team on the importance of keeping credentials confidential and avoiding sharing sensitive information in unsecured environments. Protecting credentials is an essential component of any security strategy when developing and deploying applications in production."

# DESCRIPTION-WORK-PHP

## Objective of the work:

Create a complete website for a fictitious company using the technologies and tools learned so far.

## Website functionalities:

- Database.
- User authentication system.
- User roles system.
- User management system.
- Appointments management system.
- News management system.
- Logout.

## Access:

Access to the different pages and management systems will depend on the "role" of each authenticated user, as well as access to the various links in the navigation bar.

## Website composition:

**1. Homepage**

Website front page with several sections.

**2. News Page**

Includes: A section where all the news created by the administrators is displayed.

**3. Registration Page**

Includes: A form for users to authenticate.

**4. Appointments Page**

Includes: A system for managing appointments through forms.

**5. Profile Page**

Includes: A form with user data, which can be modified.

**6. User Management Page**

Includes: A user management system through a table.

**7. Appointments Management Page**

Includes: An appointment management system through a table.

**8. News Management Page**

Includes: A news management system through a table.

## Styles and other elements:

- Attractive and modern design.
- Fixed navigation bar with name and logo, highlighting the current section.