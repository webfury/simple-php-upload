<?php
session_start();

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if(isset($_FILES['file'])) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    if(in_array($file_ext, $allowed_ext)) {
        $new_file_name = uniqid('', true) . '.' . $file_ext;
        move_uploaded_file($file_tmp, 'uploads/' . $new_file_name);
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid file type!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload</title>
</head>
<body>
    <h1>Upload</h1>
    <?php if(isset($error)) { ?>
        <p><?php echo $error; ?></p>
    <?php } ?>
    <form method="post" enctype="multipart/form-data">
        <label>Choose file:</label>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
