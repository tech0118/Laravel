<!DOCTYPE html>
<html>
<head>
    <title>Task Assigned</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Task Assigned</h1>
    <p>Dear {{ $recipientRole }},</p>
    <p>A new task has been assigned to you.</p>
    <h3>Task Details:</h3>
    <ul>
        <li><strong>Title:</strong> {{ $task->title }}</li>
        <li><strong>Description:</strong> {{ $task->description }}</li>
        <li><strong>Deadline:</strong> {{ $task->deadline }}</li>
    </ul>
    <p>You can view the task details and take further action by clicking the button below:</p>
    <a href="{{ route('user.tasks.show', $task->id) }}" class="button">View Task</a>
    <p>Thank you!</p>
</body>
</html>
