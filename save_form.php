<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formData']) && isset($_POST['formTitle'])) {
    $formData = $_POST['formData'];
    $formTitle = htmlspecialchars($_POST['formTitle'], ENT_QUOTES, 'UTF-8');
    $fullHtml = '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
  <title>' . $formTitle . '</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css" />

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/css/components.css" />
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8">
            <div class="card card-primary">
              <div class="card-header"><h4>' . $formTitle . '</h4></div>
              <div class="card-body">
                <form method="POST" action="your_post_handler.php">
                  ' . $formData . '
                  <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>';

    $filename = 'form.html';
    
    if (file_put_contents($filename, $fullHtml)) {
        http_response_code(200);
        echo 'Form berhasil disimpan ke ' . $filename;
    } else {
        http_response_code(500);
        echo 'Gagal menyimpan form.';
    }
} else {
    http_response_code(400);
    echo 'Permintaan tidak valid.';
}
?>
