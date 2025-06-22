<?php
// manage_artist_details.php
include("../config.php");
include("../db.php");
include '../includes/header.php';

// Fetch artists for dropdown
$artists = $conn->query("SELECT id, name FROM artists");

// Handle insert or update
if (isset($_POST['save_detail'])) {
    $id = $_POST['detail_id'];
    $artist_id = $_POST['artist_id'];
    $profile_image = $_POST['profile_image'];
    $location = $_POST['location'];
    $date_of_birth = $_POST['date_of_birth'];
    $short_bio = $_POST['short_bio'];
    $education = $_POST['education'];
    $exhibitions = $_POST['exhibitions'];
    $achievements = $_POST['achievements'];
    $youtube_links = $_POST['youtube_links'];
    $past_work_description = $_POST['past_work_description'];
    $book_description = $_POST['book_description'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE artist_details SET artist_id=?, profile_image=?, location=?, date_of_birth=?, short_bio=?, education=?, exhibitions=?, achievements=?, youtube_links=?, past_work_description=?, book_description=? WHERE id=?");
        $stmt->bind_param("issssssssssi", $artist_id, $profile_image, $location, $date_of_birth, $short_bio, $education, $exhibitions, $achievements, $youtube_links, $past_work_description, $book_description, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO artist_details (artist_id, profile_image, location, date_of_birth, short_bio, education, exhibitions, achievements, youtube_links, past_work_description, book_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssss", $artist_id, $profile_image, $location, $date_of_birth, $short_bio, $education, $exhibitions, $achievements, $youtube_links, $past_work_description, $book_description);
    }
    $stmt->execute();
}

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM artist_details WHERE id = $id");
}

// Edit selected detail
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $edit_query = $conn->query("SELECT * FROM artist_details WHERE id = $edit_id");
    $edit_data = $edit_query->fetch_assoc();
}

// Fetch all details with artist name
$details = $conn->query("SELECT ad.*, a.name FROM artist_details ad JOIN artists a ON ad.artist_id = a.id");
?>

<div class="container py-5">
  <h2 class="mb-4">Manage Artist Details</h2>

  <form method="POST" class="mb-5">
    <input type="hidden" name="detail_id" value="<?= $edit_data['id'] ?? '' ?>">
    <div class="row g-3">
      <div class="col-md-6">
        <select name="artist_id" class="form-select" required>
          <option value="">Select Artist</option>
          <?php foreach ($conn->query("SELECT id, name FROM artists") as $artist): ?>
            <option value="<?= $artist['id'] ?>" <?= (isset($edit_data) && $edit_data['artist_id'] == $artist['id']) ? 'selected' : '' ?>><?= $artist['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <input type="text" name="profile_image" class="form-control" placeholder="Profile Image URL" value="<?= $edit_data['profile_image'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <input type="text" name="location" class="form-control" placeholder="Location" value="<?= $edit_data['location'] ?? '' ?>">
      </div>
      <div class="col-md-6">
        <input type="date" name="date_of_birth" class="form-control" value="<?= $edit_data['date_of_birth'] ?? '' ?>">
      </div>
      <div class="col-md-12">
        <textarea name="short_bio" class="form-control" rows="2" placeholder="Short Bio"><?= $edit_data['short_bio'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="education" class="form-control" rows="2" placeholder="Education"><?= $edit_data['education'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="exhibitions" class="form-control" rows="2" placeholder="Exhibitions"><?= $edit_data['exhibitions'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="achievements" class="form-control" rows="2" placeholder="Achievements"><?= $edit_data['achievements'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="youtube_links" class="form-control" rows="2" placeholder="YouTube Links (comma separated)"><?= $edit_data['youtube_links'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="past_work_description" class="form-control" rows="2" placeholder="Past Work Description"><?= $edit_data['past_work_description'] ?? '' ?></textarea>
      </div>
      <div class="col-md-6">
        <textarea name="book_description" class="form-control" rows="2" placeholder="Book Description"><?= $edit_data['book_description'] ?? '' ?></textarea>
      </div>
      <div class="col-md-12">
        <button type="submit" name="save_detail" class="btn btn-primary">Save Artist Detail</button>
      </div>
    </div>
  </form>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Artist Name</th>
        <th>Profile Image</th>
        <th>Location</th>
        <th>Date of Birth</th>
        <th>Short Bio</th>
        <th>Education</th>
        <th>Exhibitions</th>
        <th>Achievements</th>
        <th>YouTube Links</th>
        <th>Past Work</th>
        <th>Book</th>
        <th>Created At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($row = $details->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><img src="<?= $row['profile_image'] ?>" width="50" height="50" style="object-fit:cover;"></td>
        <td><?= $row['location'] ?></td>
        <td><?= $row['date_of_birth'] ?></td>
        <td><?= $row['short_bio'] ?></td>
        <td><?= $row['education'] ?></td>
        <td><?= $row['exhibitions'] ?></td>
        <td><?= $row['achievements'] ?></td>
        <td><?= $row['youtube_links'] ?></td>
        <td><?= $row['past_work_description'] ?></td>
        <td><?= $row['book_description'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
