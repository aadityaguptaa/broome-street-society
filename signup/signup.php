<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Checkout example · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/checkout/">


    

    <!-- Bootstrap core CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light" 
  style="background-image: url('18515351.jpg');background-size: cover">
  <?php
  ob_start();
  session_start();
  ?>
    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <h2 style="color:white">Sign Up</h2>
      <p class="lead"></p>
    </div>

      <div class="col-md-7 col-lg-8">
        <form method="post">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label" style="color:white">First name</label>
              <input type="text" name="firstname" class="form-control" id="firstName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label" style="color:white">Last name</label>
              <input type="text" name="lastname" class="form-control" id="lastName" placeholder="" value="" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="username"  class="form-label" style="color:white">Mobile Number</label>
              <div class="input-group has-validation">
                <span class="input-group-text">+91</span>
                <input type="text" name="mobilenumber" class="form-control" id="username" placeholder="" required>
              <div class="invalid-feedback">
                  Your username is required.
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label" style="color:white">Email <span class="text-muted"></span></label>
              <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label" style="color:white">Address</label>
              <input type="text" name="address" class="form-control" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>
            <div class="col-12">
              <label for="password" class="form-label" style="color:white">Password</label>
              <input type="password" name="password" class="form-control" id="address"  required>
              <div class="invalid-feedback">
                Please enter your Password.
              </div>
            </div>
            <div class="col-12">
              <label for="confirmpassword" class="form-label" style="color:white">Confirm Password</label>
              <input type="password" name="confirmpassword" class="form-control" id="address"  required>
              <div class="invalid-feedback">
                Please enter the Password again.
              </div>
            </div>

            

            <div class="col-md-5">
              <label for="ender" class="form-label" style="color:white">Gender</label>
              <select class="form-select" name="gender" id="country" required>
                <option value="">Choose...</option>
                <option>FEMALE</option>
                <option>MALE</option>
                <option>OTHER</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            

            <div class="col-md-3">
              <label for="zip" class="form-label" style="color:white">Zip</label>
              <input type="text" name="zip" class="form-control" id="zip" placeholder="" required>
              <div class="invalid-feedback">
                Zip code required.
              </div>
            </div>
          </div>

          <hr class="my-4" style="color:white">
          <input type="submit" class="w-100 btn btn-light btn-lg" name="account" value="CREATE_ACCOUNT!"></input>
        </form>

        <?php 
        require_once "pdo.php";
          if(isset($_POST['firstname'])){
            $sql = "insert into customer (FName, LName, Phone_Number, Street, ZipCode, Sex) Values (:firstname, :lastname, :phonenumber, :street, :zipcode, :gender );";
          
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(
              ':firstname' => $_POST['firstname'],
              ':lastname' => $_POST['lastname'],
              ':phonenumber' => $_POST['mobilenumber'],
              ':street' => $_POST['address'],
              ':zipcode' => $_POST['zip'],
              ':gender' => $_POST['gender']
            ));

            $stmt = $pdo->query("select CustomerID from customer order by CustomerID DESC");
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $newCustomerId = $row[0]['CustomerID'];

            $sql = "insert into credentials (username, password, customer_id) values (:email, :password, :customerid);";
          
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(
              ':email' => $_POST['email'],
              ':password' => $_POST['password'],
              ':customerid' => $newCustomerId,
              
            ));

            $stmt = $pdo->query("select credential_id from credentials order by credential_id DESC");
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $credential_id = $row[0]['credential_id'];
            $_SESSION['userid'] = $credential_id;


            header("Location: /dbmsproject/homepage/homepage.php", TRUE);
            exit();
          }
          ob_end_flush();

        ?>

      </div>
    </div>
  </main>

  <footer class="my-5 pt-5 text-muted text-center text-small">
    <p class="mb-1">&copy; 2017–2021 BROOME STREET SOCIETY</p>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#">Privacy</a></li>
      <li class="list-inline-item"><a href="#">Terms</a></li>
      <li class="list-inline-item"><a href="#">Support</a></li>
    </ul>
  </footer>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="form-validation.js"></script>
  </body>
</html>
