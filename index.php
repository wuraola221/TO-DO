<?php

session_start();


$servername = "localhost";
$username = "lolli";
$password = "";
$dbname = "todo-list";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// task deletion 
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM task WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['message_1'] = "Task deleted successfully!";
    } else {
        $_SESSION['error_1'] = "Error deleting task: " . $stmt->error;
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


// new task submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_name'])) {
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);
    $due_date = $_POST['due_date'];
    $reminder_date = $_POST['reminder_date'];

    $stmt = $conn->prepare("INSERT INTO task (task_name, due_date, reminder_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $task_name, $due_date, $reminder_date);


    if ($reminder_date > $due_date) {
        $_SESSION['reminder'] = "reminder date must be before the due date";

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }


    if ($stmt->execute()) {
        $_SESSION['message'] = "Task added successfully!";
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch all tasks
$tasks = $conn->query("SELECT * FROM task");

// Fetch today's reminders
$today = date("Y-m-d");
$reminders = $conn->query("SELECT * FROM task WHERE reminder_date = '$today'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1>TO-DO List</h1>

        <form method="post">
            <label for="task_name">
                Task name
                <input type="text" name="task_name" placeholder="Task name">
            </label>
            <label for="due_date"> Due date
                <input type="date" name="due_date">
            </label>
            <label for="reminder_date">Reminder date
                <input type="date" name="reminder_date">
            </label>
            <button type="submit">Add Task</button>
        </form>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="succ"><?= $_SESSION['message'] ?></div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['reminder'])): ?>
            <div class="succ"><?= $_SESSION['reminder'] ?></div>
            <?php unset($_SESSION['reminder']); ?>
        <?php endif; ?>



    </div>
    <section>
        <div class="wrapper-1">
            <h1>Active Tasks</h1>

            <?php if ($tasks->num_rows > 0): ?>
                <?php while ($task = $tasks->fetch_assoc()): ?>
                    <div class="act-task">
                        <div class="task-1">
                            <?= htmlspecialchars($task['task_name']) ?>
                        </div>
                        <div class="task-2">
                            Due: <?= $task['due_date'] ?>
                            <div class="task-3">
                                Reminder: <?= $task['reminder_date'] ?>
                            </div>



                        </div>
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?= $task['id'] ?>">
                            <button type="submit">Delete</button>
                        </form>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no">No tasks found!</p>
            <?php endif; ?>

            <?php if (isset($_SESSION['message_1'])): ?>
                <div class="succ"><?= $_SESSION['message_1'] ?></div>
                <?php unset($_SESSION['message_1']); ?>
            <?php endif; ?>
        </div>
    </section>

    <section>
        <div class="wrapper-2">
            <h1>Today's Reminder (<?= $today ?>)</h1>
            <?php if ($reminders->num_rows > 0): ?>
                <?php while ($reminder = $reminders->fetch_assoc()): ?>
                    <div class="act-task">
                        <?= htmlspecialchars($reminder['task_name']) ?>
                        (Due: <?= $reminder['due_date'] ?>)
                        <form method="post">
                            <input type="hidden" name="delete_id" value="<?= $reminder['id'] ?>">
                            <button type="submit">Dismiss</button>
                        </form>

                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no">No reminders for today
                <?php endif; ?>
        </div>
    </section>
</body>

</html>