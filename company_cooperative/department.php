<?php
$servername = "localhost";
$username = "root";
$password = "far123456";
$dbname = "db_company_cooperative";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// เพิ่มข้อมูลแผนก
if (isset($_POST['add'])) {
    $department_name = $_POST['department_name'];
    $sql = "INSERT INTO departments (department_name) VALUES ('$department_name')";
    $conn->query($sql);
}

// ลบข้อมูลแผนก
if (isset($_POST['delete'])) {
    $department_id = $_POST['department_id'];
    $sql = "DELETE FROM departments WHERE department_id = $department_id";
    $conn->query($sql);
}

// แก้ไขข้อมูลแผนก
if (isset($_POST['edit'])) {
    $department_id = $_POST['department_id'];
    $department_name = $_POST['department_name'];
    $sql = "UPDATE departments SET department_name = '$department_name' WHERE department_id = $department_id";
    $conn->query($sql);
}

// ดึงข้อมูลแผนกทั้งหมด
$result = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Departments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }
    </style>
</head>

<body>
    <h2>Manage Departments</h2>
    <form method="post" action="">
        <label>Department Name:</label>
        <input type="text" name="department_name" required>
        <button type="submit" name="add">Add</button>
    </form>

    <h3>Departments List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['department_id']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
                <td>
                    <form method="post" action="" style="display:inline-block;">
                        <input type="hidden" name="department_id" value="<?php echo $row['department_id']; ?>">
                        <input type="text" name="department_name" value="<?php echo $row['department_name']; ?>">
                        <button type="submit" name="edit">Edit</button>
                    </form>
                    <form method="post" action="" style="display:inline-block;">
                        <input type="hidden" name="department_id" value="<?php echo $row['department_id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>

<?php
$conn->close();
?>