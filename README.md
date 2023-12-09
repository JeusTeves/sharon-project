# sharon-project
Student Queue System using Mysql and PHP
Functions Explain below
    Login (process_login.php):
        Starts or resumes a session.
        Validates user login credentials against the user_login table in the database.
        If successful, sets a session variable 'user' with the username and redirects to student_management.php.
        If unsuccessful, redirects back to login.php with an error parameter.

    Student Management (student_management.php):
        Ensures that the user is logged in; otherwise, redirects to login.php.
        Retrieves student queue data from the database and displays it in a table.
        Provides a table with columns for Queue Number, Name, Email, Course, Date, Time, Status, and Actions (Edit and Delete).
        Converts 24-hour time format to 12-hour format for better readability.
        Includes links to edit records and a delete link that triggers a JavaScript confirmation before deletion.
        Displays a logout link to end the user's session.

    Edit Record (edit_record.php):
        Retrieves details of a specific student record based on the provided record ID.
        Displays a form pre-filled with the existing record details for editing.
        Allows users to modify and save the changes, updating the database.

    Delete Record (delete_record.php):
        Deletes a specific student record based on the provided record ID.
        Linked from the student_management.php page and triggered with a confirmation prompt.

    Insert Record (index.php):
        Provides a form for users to submit new student queue entries.
        Validates form input and inserts a new record into the database.
        Dynamically calculates and assigns a queue number.

    Logout (logout.php):
        Destroys the session, logging out the user.
        Redirects to the login.php page.

These components collectively form a Student Queue System, allowing users to log in, manage student queue records, edit existing entries, delete records with confirmation, insert new records, and log out of the system. The system is designed for administrative tasks related to student queues.
