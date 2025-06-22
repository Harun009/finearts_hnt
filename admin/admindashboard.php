<?php
// admin-dashboard.php
include("../config.php");
include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
  <h1 class="mb-4">🎨 Admin Dashboard</h1>

  <div class="row g-4">
    <!-- Artists CRUD -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Manage Artists</h5>
          <p class="card-text">Add, edit, or remove artists.</p>
          <a href="manage_artists.php" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Artist Images CRUD -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Artist Images</h5>
          <p class="card-text">Upload and assign images to artists.</p>
          <a href="manage_artist_images.php" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Artist Details CRUD -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Artist Details</h5>
          <p class="card-text">Manage bio, education, and exhibitions.</p>
          <a href="manage_artist_details.php" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Art Info CRUD -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Artworks Info</h5>
          <p class="card-text">Manage artwork records and descriptions.</p>
          <a href="manage_artinfo.php" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

    <!-- Art Images CRUD -->
    <div class="col-md-4">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Art Images</h5>
          <p class="card-text">Upload artwork images and set featured image.</p>
          <a href="manage_art_images.php" class="btn btn-primary">Open</a>
        </div>
      </div>
    </div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include '../includes/footer.php'; ?>
