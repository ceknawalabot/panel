<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include 'includes/navbar.php'; ?>
      <?php include 'includes/sidebar.php'; ?>
      <!-- Main Content -->
      <div class="main-content d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="section w-75">
          <div class="row">
            <div class="col-md-3">
              <h5>Form Builder</h5>
              <div class="list-group">
                <button type="button" class="list-group-item list-group-item-action" onclick="addInput('text')">Add Text Input</button>
                <button type="button" class="list-group-item list-group-item-action" onclick="addInput('textarea')">Add Textarea</button>
                <button type="button" class="list-group-item list-group-item-action" onclick="addInput('checkbox')">Add Checkbox</button>
              </div>
            </div>
        <div class="col-md-9">
          <h5>
            <input type="text" id="formTitle" class="form-control mb-3" value="Form Preview" placeholder="Form Title" />
          </h5>
          <form id="formBuilder" method="POST" action="save_form.php" onsubmit="return prepareFormData()">
            <div id="formElements"></div>
            <input type="hidden" name="formData" id="formData" />
            <input type="hidden" name="formTitle" id="formTitleHidden" />
            <button type="submit" class="btn btn-primary mt-3">Save Form</button>
          </form>
        </div>
          </div>
        </div>
        <script>
          function addInput(type) {
            const container = document.getElementById('formElements');
            const id = 'elem_' + Date.now();
            let elementHTML = '';
            if (type === 'text') {
              elementHTML = `
                <div class="form-group" id="\${id}">
                  <input type="text" class="form-control mb-1" placeholder="Label" value="Text Input Label" />
                  <input type="text" name="\${id}_input" class="form-control" placeholder="Enter text" />
                  <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeElement('\${id}')">Remove</button>
                </div>`;
            } else if (type === 'textarea') {
              elementHTML = `
                <div class="form-group" id="\${id}">
                  <input type="text" class="form-control mb-1" placeholder="Label" value="Textarea Label" />
                  <textarea name="\${id}_textarea" class="form-control" rows="3" placeholder="Enter text"></textarea>
                  <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeElement('\${id}')">Remove</button>
                </div>`;
            } else if (type === 'checkbox') {
              elementHTML = `
                <div class="form-group form-check" id="\${id}">
                  <input type="checkbox" name="\${id}_checkbox" class="form-check-input" id="\${id}_check" />
                  <input type="text" class="form-control d-inline-block ml-2" style="width:auto; vertical-align: middle;" placeholder="Label" value="Checkbox Label" />
                  <button type="button" class="btn btn-danger btn-sm mt-1" onclick="removeElement('\${id}')">Remove</button>
                </div>`;
            }
            container.insertAdjacentHTML('beforeend', elementHTML);
          }

          function removeElement(id) {
            const elem = document.getElementById(id);
            if (elem) {
              elem.remove();
            }
          }

          function prepareFormData() {
          const form = document.getElementById('formBuilder');
          const clone = document.getElementById('formElements').cloneNode(true);
          clone.querySelectorAll('button').forEach(btn => btn.remove());
          clone.querySelectorAll('.form-group, .form-check').forEach(container => {
            const labelInput = container.querySelector('input[type="text"]');
            if (labelInput) {
              const labelText = labelInput.value.trim();
              const label = document.createElement('label');
              label.textContent = labelText;
              container.insertBefore(label, labelInput);
              labelInput.remove();
            }
          });
          clone.querySelectorAll('input[type="text"], textarea').forEach(el => {
            if (!el.closest('.form-group, .form-check').querySelector('label') || el.type !== 'text') {
              el.setAttribute('value', el.value);
            }
          });
          clone.querySelectorAll('textarea').forEach(textarea => {
            textarea.textContent = textarea.value;
          });
          clone.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            if (checkbox.checked) {
              checkbox.setAttribute('checked', 'checked');
            } else {
              checkbox.removeAttribute('checked');
            }
          });
          const formTitleInput = document.getElementById('formTitle');
          const formTitleHidden = document.getElementById('formTitleHidden');
          if (formTitleInput && formTitleHidden) {
            formTitleHidden.value = formTitleInput.value;
          }
          const formHTML = clone.innerHTML;
          document.getElementById('formData').value = formHTML;
          return true;
        }
        </script>
      </div>
      <?php include 'includes/footer.php'; ?>
    </div>
  </div>

  <?php include 'includes/scripts.php'; ?>
</body>
</html>
