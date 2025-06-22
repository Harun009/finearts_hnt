<?php
// manage_artists.php
include("../config.php");
include("../db.php");
include '../includes/header.php';

// Handle insert or update
if (isset($_POST['save_artist'])) {
    $name = $_POST['name'];
    $birth_place = $_POST['birth_place'];
    $birth_date = $_POST['birth_date'];
    $education = $_POST['education'];
    $profile_image_url = $_POST['profile_image_url'];

    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE artists SET name=?, birth_place=?, birth_date=?, education=?, profile_image_url=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $birth_place, $birth_date, $education, $profile_image_url, $id);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO artists (name, birth_place, birth_date, education, profile_image_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $birth_place, $birth_date, $education, $profile_image_url);
        $stmt->execute();
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM artists WHERE id = $id");
}

// Fetch artist for editing
$edit_artist = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM artists WHERE id = $id");
    $edit_artist = $result->fetch_assoc();
}

// Fetch all artists
$artists = $conn->query("SELECT * FROM artists");
?>

<div class="container py-5">
  <h2 class="mb-4">Manage Artists</h2>

  <form method="POST" class="mb-5">
    <input type="hidden" name="id" value="<?= $edit_artist['id'] ?? '' ?>">
    <div class="row g-3">
      <div class="col-md-4">
        <input type="text" name="name" class="form-control" placeholder="Name" required value="<?= $edit_artist['name'] ?? '' ?>">
      </div>
      <div class="col-md-4">
        <input type="text" name="birth_place" class="form-control" placeholder="Birth Place" value="<?= $edit_artist['birth_place'] ?? '' ?>">
      </div>
      <div class="col-md-4">
        <input type="date" name="birth_date" class="form-control" value="<?= $edit_artist['birth_date'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <input type="text" name="education" class="form-control" placeholder="Education" value="<?= $edit_artist['education'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <input type="text" name="profile_image_url" class="form-control" placeholder="Profile Image URL" value="<?= $edit_artist['profile_image_url'] ?? '' ?>">
      </div>
      <div class="col-md-12">
        <button type="submit" name="save_artist" class="btn btn-success">
          <?= isset($edit_artist) ? 'Update Artist' : 'Add Artist' ?>
        </button>
        <?php if (isset($edit_artist)): ?>
          <a href="manage_artists.php" class="btn btn-secondary">Cancel</a>
        <?php endif; ?>
      </div>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Birth Place</th>
        <th>Birth Date</th>
        <th>Education</th>
        <th>Profile Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $artists->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['birth_place'] ?></td>
        <td><?= $row['birth_date'] ?></td>
        <td><?= $row['education'] ?></td>
        <td><img src="<?= $row['profile_image_url'] ?>" width="50" height="50" style="object-fit:cover;"/></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">X</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
