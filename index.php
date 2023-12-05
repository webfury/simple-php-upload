<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$per_page = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $per_page;

$files = array();
$dir = opendir('uploads');
while ($file = readdir($dir)) {
    if ($file != '.' && $file != '..') {
        $files[$file] = filemtime('uploads/' . $file);
    }
}
closedir($dir);

// Add the following lines to print out some information
echo "Total Files: " . count($files) . "<br>";
echo "Files Array: ";
print_r($files);

arsort($files);

$total_files = count($files);
$total_pages = ceil($total_files / $per_page);

$files = array_slice($files, $start, $per_page);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gallery</title>
    <style>
        /* Add CSS styles for better layout */
        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .gallery-item {
            flex: 0 0 calc(33.33% - 20px);
            margin: 10px;
        }

        .gallery-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Gallery</h1>
    <a href="upload.php">Upload</a>
    <hr>

    <div class="gallery-container">
        <?php foreach ($files as $file => $time) { ?>
    <div class="gallery-item">
        <a href="uploads/<?php echo $file; ?>">
            <img src="uploads/<?php echo $file; ?>" alt="<?php echo $file; ?>" style="max-width: 200px; max-height: 200px;">
        </a>
    </div>
<?php } ?>

    </div>

    <hr>

    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php } ?>
</body>
</html>
