# TO-DO
 Simple TO-DO Reminder App

 # To-Do Reminder App

This is a simple to-do reminder web application built with PHP and SQL. It allows users to add tasks with due dates and reminder dates, displays active tasks, and provides reminders for today's reminder.

## Features

*   Add Task: Users can input a task name, due date, and reminder date. The "Add Task" button submits this data to the database and dynamically adds the new task to the "Active Tasks" section on the page.
*   Delete Task: Each task in the "Active Tasks" section has a "Delete" button. Clicking this button removes the task from both the page and the database.
*   Today's Reminders: The app includes a "Today's Reminders" section that displays any tasks whose reminder date matches the current day.

## Technologies Used

*   PHP: Server-side scripting language for handling form submissions, database interactions, and dynamic content generation.
*   SQL:  Used for storing and managing task data in a database.
*   HTML:  Structures the web page and forms.
*   CSS:  Styles the appearance of the application.
*   

## Installation

1.  Clone the repository: `git clone <repository_url>`
2.  Set up a database: Create a database in your preferred database management system (e.g., phpMyAdmin).
3.  Configure database connection: Update the database credentials in your PHP code to match your database setup.
4.  Import database schema (if provided): If there's an SQL file for the database schema, import it into your database.
5.  Run the application: Open the `index.php` file (or the main PHP file) in your web browser.

## Usage

1.  Add a task: Fill in the task name, due date, and reminder date in the form and click "Add Task."
2.  View active tasks: The "Active Tasks" section displays all the added tasks.
3.  Delete a task: Click the "Delete" button next to a task to remove it.
4.  Check today's reminders: The "Today's Reminders" section shows tasks with a reminder set for the current day.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.

