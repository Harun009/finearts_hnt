<?php
// manage_artist_images.php
include("../config.php");
include("../db.php");
include '../includes/header.php';

// Handle file upload
if (isset($_POST['upload_image'])) {
    $artist_id = $_POST['artist_id'];

    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "../uploads/artist_images/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        foreach ($_FILES['images']['name'] as $key => $name) {
            if ($_FILES['images']['error'][$key] === 0) {
                $filename = basename($name);
                $target_file = $target_dir . time() . "_" . uniqid() . "_" . $filename;
                $db_path = str_replace("../", "", $target_file);

                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $target_file)) {
                    $stmt = $conn->prepare("INSERT INTO artist_images (artist_id, image_url) VALUES (?, ?)");
                    $stmt->bind_param("is", $artist_id, $db_path);
                    $stmt->execute();
                }
            }
        }
    }
}

// Handle delete
// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $result = $conn->query("SELECT image_url FROM artist_images WHERE id = $id");
    
    if ($result && $row = $result->fetch_assoc()) {
        $file_path = "../" . $row['image_url'];
        if (file_exists($file_path) && is_file($file_path)) {
            unlink($file_path);
        }
        $conn->query("DELETE FROM artist_images WHERE id = $id");
    } else {
     
    }
}


// Fetch all images
$images = $conn->query("SELECT ai.*, a.name FROM artist_images ai JOIN artists a ON ai.artist_id = a.id");
$artists = $conn->query("SELECT id, name FROM artists");
?>

<div class="container py-5">
  <h2 class="mb-4">Manage Artist Images</h2>

  <form method="POST" enctype="multipart/form-data" class="mb-5">
    <div class="row g-3">
      <div class="col-md-6">
        <select name="artist_id" class="form-select" required>
          <option value="">Select Artist</option>
          <?php while ($artist = $artists->fetch_assoc()): ?>
            <option value="<?= $artist['id'] ?>"><?= $artist['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="col-md-6">
        <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
      </div>
      <div class="col-md-12">
        <input type="submit" name="upload_image" class="btn btn-primary" value="Upload Images">
      </div>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Artist</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $images->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><img src="../<?= $row['image_url'] ?>" width="70" height="70" style="object-fit:cover;"></td>
        <td>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
