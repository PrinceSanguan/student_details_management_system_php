<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/dbconnection.php');

if (strlen($_SESSION['sid']) == 0) {
  header('location:logout.php');
} else {
  if (isset($_POST['submit'])) {
    // Fetch data from form
    $studentno = mysqli_real_escape_string($con, $_POST['studentno']);
    $studentName = mysqli_real_escape_string($con, $_POST['studentName']);
    $class = mysqli_real_escape_string($con, $_POST['class']);
    $dateofbirth = mysqli_real_escape_string($con, $_POST['dateofbirth']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contactno = mysqli_real_escape_string($con, $_POST['contactno']);
    $nextphone = mysqli_real_escape_string($con, $_POST['nextphone']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $village = mysqli_real_escape_string($con, $_POST['village']);
    $studentImage = $_FILES['studentImage'];
    $parentName = mysqli_real_escape_string($con, $_POST['parentName']);
    $relation = mysqli_real_escape_string($con, $_POST['relation']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $generated_code = mysqli_real_escape_string($con, $_POST['generated_code']);

    
    // Handle photo upload
    if ($studentImage['error'] == UPLOAD_ERR_OK) {
      $uploadDir = 'studentimages/';
      $uploadFile = $uploadDir . basename($studentImage['name']);
      
      if (move_uploaded_file($studentImage['tmp_name'], $uploadFile)) {
        $studentImagePath = $studentImage['name']; // Store only the file name in the database
      } else {
        echo "<script>alert('Failed to upload image.');</script>";
        exit;
      }
    } else {
      echo "<script>alert('Error uploading file.');</script>";
      exit;
    }

    // SQL query to insert data into database
    $query = mysqli_query($con, "INSERT INTO students (studentno, studentName, class, dateofbirth, age, gender, email, parentName, relation, occupation, country, district, state, village, studentImage, contactno, nextphone, generated_code)
      VALUES ('$studentno', '$studentName', '$class', '$dateofbirth', '$age', '$gender', '$email', '$parentName', '$relation', '$occupation', '$country', '$district', '$state', '$village', '$studentImagePath', '$contactno', '$nextphone', '$generated_code')");

    // Check if query was successful
    if ($query) {
      echo "<script>alert('Student has been registered.');</script>";
      echo "<script>window.location.href = 'add_student.php';</script>";
    } else {
      echo "<script>alert('Something Went Wrong. Please try again.');</script>";
    }
  }
}
?>

  <!DOCTYPE html>
  <html>
  <?php @include("includes/head.php"); ?>
  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <!-- Navbar -->
      <?php @include("includes/header.php"); ?>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <?php @include("includes/sidebar.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Add Student</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row ">
              <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Add Student</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form role="form" method="post" action="add_student.php" enctype="multipart/form-data">
                    <div class="card-body">
                      <span style="color: brown"><h5>Student details</h5></span>
                      <hr>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="studentno">Student No.</label>
                          <input type="text" class="form-control" id="studentno" name="studentno" placeholder="Enter student No" required>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="names">Names</label>
                          <input type="text" class="form-control" id="studentName" name="studentName" placeholder="Names" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="age">Age</label>
                          <input type="text" class="form-control" id="age" name="age" placeholder="age"required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="sex">Sex</label>
                          <select type="select" class="form-control" id="sex" name="sex"required>
                            <option>Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label for="age">Age</label>
                          <select type="select" class="form-control" id="class" name="class" required>
                            <option>Select Class</option>
                            <option value="S1">S1</option>
                            <option value=S2>S2</option>
                            <option value="S3">S3</option>
                            <option value="S4">S4</option>
                            <option value="S5">S5</option>
                            <option value="S6">S6</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="age">Birthdate<span style="color: blue;">*required</span></label><br>
                            <input type="date" id="dateofbirth" name="dateofbirth">
                        </div>

                        <div class="form-group col-md-4">
                          <label for="exampleInputFile">Student Photo</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="" name="studentImage" id="photo" required>
                            </div>
                          </div>
                        </div>

                      </div>
                      <hr>
                      <span style="color: brown"><h5>Parent details</h5></span>
                      <div class="row">
                        <div class="form-group col-md-3">
                          <label for="parentname">Parent Name.</label>
                          <input type="text" class="form-control" id="parentname" name="parentname" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-5">
                          <label for="relation">Relationship</label>
                          <select type="select" class="form-control" id="relation" name="relation"required>
                            <option>Select Relationship</option>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Uncel</option>
                            <option value="Mother">Ant</option>
                            <option value="Mother">Grand</option>
                          </select>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="age">Email</label>
                          <input type="text" class="form-control" id="email" name="email" placeholder="email" required>
                        </div>
                        <div class="form-group col-md-2">
                          <label for="sex">Ocupation</label>
                          <select type="select" class="form-control" id="ocupation" name="ocupation"required>
                            <option>occupation</option>
                            <option value="Doctor">Doctor</option>
                            <option value="Engineer">Engineer</option>
                            <option value="Bussiness man">Bussiness man</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Driver">Driver</option>
                            <option value="Pilot">Pilot</option>
                            <option value="Software developer">Software developer</option>
                            <option value="Farmer">Farmer</option>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-3 offset-md-6">
                          <label for="phone1">Phone 1</label>
                          <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Phone"required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="nextphone">Phone 2</label>
                          <input type="text" class="form-control" id="nextphone" name="nextphone" placeholder="phone2" required>
                        </div>
                      </div>
                      <hr>
                      <span style="color: brown"><h5>Address</h5></span>
                      <div class="row">
                        <div class="form-group col-md-3 ">
                          <label for="phone1">Country</label>
                          <select type="select" class="form-control" id="country" name="country"required>
                            <option>Select country</option>
                            <option value="England">England</option>
                            <option value="Spain">Spain</option>
                            <option value="USA">USA</option>
                            <option value="France">France</option>
                            <option value="Russia">Russia</option>
                            <option value="Dubai">Dubai</option>
                            <option value="Uganda">Uganda</option>
                            <option value="United Kingdom">United Kingdom</option>
                            <option value="Canada">Canada</option>
                            <option value="India">India</option>
                        
                          </select>
                        </div>
                        <div class="form-group col-md-3 ">
                          <label for="district">District</label>
                          <input type="text" class="form-control" id="district" name="district" placeholder="district"required>
                        </div>
                        <div class="form-group col-md-3 ">
                          <label for="county">State</label>
                          <input type="text" class="form-control" id="state" name="state" placeholder="State"required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="village">Village</label>
                          <input type="text" class="form-control" id="village" name="village" placeholder="Village"required>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                          <button type="button" class="btn btn-secondary form-control qr-generator" onclick="generateQrCode()" style="width:200px;">Generate QR Code</button>
                          <div class="qr-con text-center" style="display: none;">
                          <input type="hidden" class="form-control" id="generated_code" name="generated_code">
                          <p>Take a pic with your qr code.</p>
                          <img class="mb-4" src="" id="qrImg" alt="">
                          
                          <button type="submit" class="btn btn-dark" id="submit-btn" name="submit">Submit</button>
                      </div>
                  </form>

                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <?php @include("includes/footer.php"); ?>

    </div>

    <!-- ./wrapper -->
    <?php @include("includes/foot.php"); ?>
    <script>
    function generateQrCode() {
    const qrImg = document.getElementById('qrImg');
    const generatedCodeInput = document.getElementById('generated_code');

    // Generate a random code
    const randomCode = generateRandomCode(10);
    generatedCodeInput.value = randomCode;

    // Use the random code to generate the QR code
    const apiUrl = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent(randomCode)}`;
    qrImg.src = apiUrl;

    // Show the QR code and submit button
    document.querySelector('.qr-con').style.display = '';
    document.querySelector('.qr-generator').style.display = 'none';
    document.getElementById('submit-btn').style.display = 'block';
}

function generateRandomCode(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    let randomString = '';

    for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        randomString += characters.charAt(randomIndex);
    }

    return randomString;
}
    </script>
  </body>
  </html>
  <?php
?>
