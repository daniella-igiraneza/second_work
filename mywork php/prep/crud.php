<?php
$conn = mysqli_connect("localhost", "root", "", "miss_rwanda");
if (!$conn) {
    die("Database connection failed!");
}

$id = "";
$full_name = "";
$age = "";
$height = "";
$province = "";
$occupation = "";
$photo = "";

if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM candidates WHERE id=$del_id");
    header("Location: crud.php"); // refresh page
    exit();
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM candidates WHERE id=$id");
    if ($row = mysqli_fetch_assoc($res)) {
        $full_name = $row['full_name'];
        $age = $row['age'];
        $height = $row['height'];
        $province = $row['province'];
        $occupation = $row['occupation'];
        $photo = $row['photo'];
    }
}


if (isset($_POST['submit'])) {
    $full_name = $_POST['full_name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $province = $_POST['province'];
    $occupation = $_POST['occupation'];


    if (!empty($_FILES['photo']['name'])) {
        $photo = "uploads/" . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }

    if (!empty($_POST['id'])) {
        
        $id = $_POST['id'];
        $sql = "UPDATE candidates SET 
                full_name='$full_name', 
                age='$age', 
                height='$height', 
                province='$province', 
                occupation='$occupation', 
                photo='$photo'
                WHERE id=$id";
    } else {
    
        $sql = "INSERT INTO candidates (full_name, age, height, province, occupation, photo) 
                VALUES ('$full_name','$age','$height','$province','$occupation','$photo')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: crud.php"); // refresh page to show updated list
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<html>
<head>
    <title>Miss Rwanda CRUD</title>
</head>
<body>

<h2><?php echo $id ? "Edit Candidate" : "Add Candidate"; ?></h2>

<form method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Full Name: <input type="text" name="full_name" value="<?php echo $full_name; ?>" required><br><br>
    Age: <input type="number" name="age" value="<?php echo $age; ?>" required><br><br>
    Height (cm): <input type="number" name="height" value="<?php echo $height; ?>" required><br><br>
    Province:
    <select name="province" required>
        <option value="Kigali" <?php if($province=='Kigali') echo 'selected'; ?>>Kigali</option>
        <option value="East" <?php if($province=='East') echo 'selected'; ?>>East</option>
        <option value="West" <?php if($province=='West') echo 'selected'; ?>>West</option>
        <option value="North" <?php if($province=='North') echo 'selected'; ?>>North</option>
        <option value="South" <?php if($province=='South') echo 'selected'; ?>>South</option>
    </select><br><br>
    Occupation: <input type="text" name="occupation" value="<?php echo $occupation; ?>" required><br><br>
    Photo: <input type="file" name="photo"><br><br>
    <button name="submit"><?php echo $id ? "Update Candidate" : "Add Candidate"; ?></button>
</form>

<hr>
<h2>All Candidates</h2>

<?php
// Display all candidates
$result = mysqli_query($conn, "SELECT * FROM candidates");

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='8'>";
    echo "<tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Height</th>
            <th>Province</th>
            <th>Occupation</th>
            <th>Photo</th>
            <th>Actions</th>
          </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['age']."</td>";
        echo "<td>".$row['height']."</td>";
        echo "<td>".$row['province']."</td>";
        echo "<td>".$row['occupation']."</td>";
        echo "<td>";
        if (!empty($row['photo'])) {
            echo "<img src='".$row['photo']."' width='80'>";
        } else {
            echo "No photo";
        }
        echo "</td>";
        echo "<td>
                <a href='?edit=".$row['id']."'>Edit</a> | 
                <a href='?delete=".$row['id']."' onclick=\"return confirm('Are you sure?');\">Delete</a>
              </td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No candidates yet!";
}
?>

</body>
</html>
