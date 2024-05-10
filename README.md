## Statement of work

**You can find the complete statement of this work, in the last point of this document with the title (FINAL WORK: PHP).**

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

# FINAL WORK: PHP

## Instructions:

As the final exercise of the module, you must create a website.

It could be from a fictitious company. The information does not have to be real.

To carry out this project you must use: HTML5, CSS3, JavaScript,
SQL and PHP.

## Realization of the website:

### The first part of the exercise will consist of two sections:

### 1. Website database that will contain the following tables:

**`users_data`**, which will contain the personal information of the users, with the fields:

- idUser: Primary key of type INT, self-incrementing, not null
- name: this field cannot be null
- surnames: this field cannot be null
- email: this field must be unique and cannot be null
- phone: this field must be text type and not null
- date_of birth: field of type date, not null
- address: text type field
- sex: text or enum type field

**`users_login`**, which will contain the login information of the registered users, with the fields:

- idLogin: Primary key of type INT, self-incrementing, not null
- idUser: FK that relates this table to users_data, it must be of type INT, not null and unique
- user: text type field, not null and unique
- password: text type field, not null
- role: not null. The values ​​of this field will be: admin or user

**appointments**, which will contain the information about the appointments requested by users, with the fields:

- Appointmentid: Primary key of type INT, self-incrementing, not null
- idUser: FK that relates this table to users_data, INT, not null
- appointment_date: date type field, not null
- appointment_reason: text type field

**news**, which will contain the different news items written by the website administrators, with the fields:

- idNews: PK of type INT, self-incrementing, not null
- title: text type field, not null, unique
- image: this field cannot be null
- text: long text type field, not null
- date: date type field, not null
- idUser: FK that relates this table to users_data, INT, not null

### 2. Website composed of:

**o A home page, which will be called `index`:**

This page will be the front page of the website and must contain several sections that include different HTML elements such as: texts, images, hyperlinks,...

**o A news page, which will be called news:**

It should show all the news in the database. For each news item you must see the title, date of publication, text of the news, photo of the news and the name of the user who created it.

**o A page that allows visitors to register on the website, called registration:**

This page should include:

A link to the login page in case the visitor is already registered on the website.

A complete form that obtains all the necessary personal data of the visitors to insert into the users_data table and the necessary login data to insert into the users_login table.

**NOTE:**

Whenever a visitor registers through this form, they will do so with the role: user.

If the visitor submits the form and for some reason cannot register (they have already registered before) they should receive an error message.

If the visitor registers correctly, a confirmation message must be sent and redirected to the login.

**o A page that allows visitors to log in to the website, called login:**

This page should include:
 
A hyperlink that allows the visitor to be redirected to the registration page if they do not have an account.

A login form that asks the user for the necessary data to log into the website.

**NOTE:**

If the visitor enters incorrect data in the login form, they should receive an error message.

If the data entered is correct, a confirmation message must be sent to you and you will be redirected to the index.

The visitor should see on all pages of the website (index, news, registration and login) a navigation bar that will allow them to navigate between said pages and highlight which page they are on at that moment within the website.

### Important details to keep in mind while performing the exercise:

Forms must be validated with PHP (at least required fields).

The password must be encrypted during user registration.

The navigation bar will be the same for visitors, users and administrators, but the sections it will display will vary depending on whether you are a visitor, user or administrator.

## Specifications for users:

### When a visitor logs in through the login page and has the role: user in their credentials, they become a user.

### 1. A user will have access to new pages, in addition to the index and news, which will be:

**o A page called profile:**

Where the user's personal data will be displayed (name, surname,...) and can also be modified.

The username you log in with cannot be changed.

The password you log in with can be changed but cannot be viewed.


**o A page called citations:**

Where the user can:

Request appointments on the website through a form, which allows data to be inserted into the appointment table.

Modify the appointments that you already have planned, as long as they have not been made, that is, as long as the date of the appointment is not earlier than today.

Delete planned appointments that have not yet taken place.


### 2. A user's navigation bar should display the following sections:

- **`index`**
- **news**
- **subpoenas**
- **profile**
- **log out** (If the user clicks on this option, they will be allowed to log out of the account and will become a visitor, so the profile and citation pages will no longer be seen in the navigation bar, exclusive of the users).


## Specifications for administrators:

### When a visitor logs in through the login page and has the role: admin in their credentials, they become an administrator.

### 1. An administrator will have access to new pages, in addition to the index, news and profile, which will be:

**o A page called users-administration:**

Where the administrator can:

Create new users and assign them the user or admin role.

Modify existing users.

Delete existing users.

**o A page called appointments-administration:**

Where the administrator can select a user and:

Create appointments for the user.

View the appointments that the user has assigned.

Modify the appointments assigned to the user.

Delete appointments assigned to the user.

**o A page called news-administration:**

Where the administrator can:
 
Create news.

See all news already created.

Modify any of the existing news.
 
Delete any of the existing news.


### 2. An administrator's navigation bar should display the following sections:

- **`index`**
- **news**
- **users-administration**
- **subpoenas-administration**
- **news-administration**
- **profile**
- **log out** (If the administrator clicks on this option, they will be allowed to log out of the account and will become a visitor, so they should no longer be visible (or accessible) in the navigation bar. administrators-only sections).