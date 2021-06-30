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
  <body class="bg-dark" background-color="">
  <?php
  ob_start();
  session_start();?>

    
<div class="container">
  <main>
    <div class="py-5 text-center">
      <?php
      $service_type_charge = 0;
      $staff_ph_charge = 0;
      $tax = 0;
      $total = 0;
      $customerId = "";
      $firstName = "";
      $lastName = "";
      $street = "";
      $email = "";
      $phoneNumber = "";
      $serviceTypeID = "";
      $staffID = "";
      ?>
    
      <!--<img class="d-block mx-auto mb-4" src="pngarea.com_beard-png-barber-5040958.png" alt="" width="230" height="230">-->
      <h2 style="color:white;">Appointment Form</h2>
      <p class="lead" style="color:white;">Get yourself a new look!</p>
    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-light">Your Bill</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Service Type/Charge</h6>
              <?php
              require_once "pdo.php";

              if(isset($_POST['service_type'])){
                
                echo '<small class="text-muted">'.$_POST['service_type'].'</small>';
              }
              ?>
            </div>
            <?php
              require_once "pdo.php";
              if(isset($_POST['service_type'])){
                $sql = "SELECT Service_Cost, Service_ID  FROM services where Service_Name = :service_type";
                $stmt = $pdo->prepare($sql);
                $stmt-> execute(array(
                  ':service_type' => $_POST['service_type']
                ));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $cost = $result[0]['Service_Cost'];
                $serviceTypeID = $result[0]['Service_ID'];
                $_SESSION['service_type_id'] = $serviceTypeID;
                $service_type_charge = $cost;
                echo '<span class="text-muted">$'.$cost.'</span>';
              }
            ?>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Staff Charge</h6>
              <?php
              if(isset($_POST['staff_name'])){
                echo '<small class="text-muted">'."Staff Name: ".$_POST['staff_name'].'</small>';
              }
              ?>
            </div>
            <?php
              require_once "pdo.php";
              if(isset($_POST['staff_name'])){
                $sql = "SELECT Rate_Per_Hour, Staff_ID FROM staff where FName = :fname";
                $stmt = $pdo->prepare($sql);
                $stmt-> execute(array(
                  ':fname' => $_POST['staff_name']
                ));
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $cost = $result[0]['Rate_Per_Hour'];
                $staffID = $result[0]['Staff_ID'];
                $staff_ph_charge = $cost;
                echo $_SESSION['userid'];
                echo '<span class="text-muted">$'.$cost.'</span>';
              }
            ?>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Taxes</h6>
              <small class="text-muted"></small>
            </div>
            <?php 
            $tax = (($service_type_charge + $staff_ph_charge)/100)*10;
            echo '<span class="text-muted">$'.$tax.'</span>'
            ?>
            
          </li>
          <li class="list-group-item d-flex justify-content-between bg-light">
            <div class="text-success">
              <h6 class="my-0">Promo code</h6>
              <small>BROOME</small>
            </div>
            <span class="text-success">−$5</span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <?php
            $total = ($service_type_charge + $staff_ph_charge + $tax - 5);
            echo '<strong>$'.$total.'</strong>';
            
            ?>
          </li>
        </ul>

          <div class="input-group">
            <input type="text" class="form-control" placeholder="Promo code">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3" style="color:white;">Billing address</h4>
        <?php      
          if(isset($_SESSION['userid'])){
            echo $_SESSION['userid'];

          }
        ?>
        <form method="post">
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label" style="color:white;">First name</label>
              <?php
              require_once "pdo.php";
              if(isset($_SESSION['userid'])){
                $stmt = $pdo->query("SELECT customer_id, username  FROM credentials where credential_id = ".$_SESSION['userid'].";");
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $customerId =  $row[0]['customer_id'];
                $_SESSION['customer_id'] = $customerId;
                $email =  $row[0]['username'];
                $sql = "SELECT Fname, Lname, Street, Phone_Number from customer where CustomerID = :customerid";
                $stmt = $pdo->prepare($sql);
                $stmt-> execute(array(
                  ':customerid' => $customerId
                ));
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $firstName = $row[0]['Fname'];
                $lastName = $row[0]['Lname'];
                $street = $row[0]['Street'];
                $phoneNumber = $row[0]['Phone_Number'];
                echo '<input type="text" class="form-control" id="firstName" disabled placeholder="" value='.$firstName. '>';
              }?>
              <div class="invalid-feedback">
                Valid first name is .
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label" style="color:white;">Last name</label>
              <?php 
                echo '<input type="text" class="form-control" id="lastName" disabled placeholder="" value='.$lastName. '>';
              ?>
              <div class="invalid-feedback">
                Valid last name is .
              </div>
            </div>

            <div class="col-12">
              <label for="username" class="form-label" style="color:white;">Mobile Number</label>
              <div class="input-group has-validation">
                <span class="input-group-text">+91</span>
                <?php 
                echo '<input type="text" class="form-control" id="mobileNumber" disabled placeholder="" value='.$phoneNumber. '>';
                ?>
              <div class="invalid-feedback">
                  Your username is .
                </div>
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label" style="color:white;">Email <span class="text-muted"></span></label>
              <?php 
                echo '<input type="text" class="form-control" id="email" disabled placeholder="" value='.$email. '>';
              ?>
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label" style="color:white;">Address</label>
              <?php 
                echo '<input type="text" class="form-control" id="address" disabled placeholder="" value='.$street. '>';
              ?>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>


            
            <div class="col-md-5">
              <label for="country" class="form-label" style="color:white;">Select Service Type:</label>
              <select class="form-select" name="service_type" id="country" >
              <?php
                require_once "pdo.php";
                $stmt = $pdo->query("SELECT Service_Name FROM services");
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row as $key => $value){
                  $isSelected =""; //added this line
                  if($_REQUEST['opt_side_'.$cside] == $value){
                    $isSelected = "selected";
                  }
                  echo '<option value="'.$row[$key]['Service_Name'].'"'.$isSelected.'>'.$row[$key]['Service_Name'].'</option>';
               }
                ?>
              </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>
            

            <div class="col-md-4">
              <label for="state" class="form-label"  style="color:white;">Staff</label>
              <select class="form-select" id="state" name="staff_name" >
              <?php
                require_once "pdo.php";
                $stmt = $pdo->query("SELECT FName FROM staff");
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row as $key => $value){
                  $isSelected =""; //added this line
                  if($_REQUEST['opt_side_'.$cside] == $value){
                    $isSelected = "selected";
                  }
                  echo '<option value="'.$row[$key]['FName'].'"'.$isSelected.'>'.$row[$key]['FName'].'</option>';
               }
                ?>
              </select>
              <div class="invalid-feedback">
                Please provide a valid state.
              </div>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label" style="color:white;">Notes</label>
              <input type="text" class="form-control" id="zip" placeholder="" >
              <div class="invalid-feedback">
              </div>
            </div>
            <input type="submit" name="" class="btn btn-light" value="Calculate Price"></input>

          </div>

              

          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="same-address">
            <label class="form-check-label" for="same-address" style="color:white;">Save this as my billing address</label>
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="save-info">
            <label class="form-check-label" for="save-info" style="color:white;">Save this information for next time</label>
          </div>

          <hr class="my-4">

          <h4 class="mb-3" style="color:white;">Payment</h4>

          <div class="my-3">
            <div class="form-check">
              <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked >
              <label class="form-check-label" for="credit" style="color:white;">Credit card</label>
            </div>
            <div class="form-check">
              <input id="debit" name="paymentMethod" type="radio" class="form-check-input" >
              <label class="form-check-label" for="debit" style="color:white;">Debit card</label>
            </div>
            <div class="form-check">
              <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" >
              <label class="form-check-label" for="paypal" style="color:white;">PayPal</label>
            </div>
          </div>

          <div class="row gy-3">
            <div class="col-md-6">
              <label for="cc-name" class="form-label" style="color:white;">Name on card</label>
              <input type="text" class="form-control" id="cc-name" placeholder="" >
              <small class="text-muted">Full name as displayed on card</small>
              <div class="invalid-feedback">
                Name on card is 
              </div>
            </div>

            <div class="col-md-6">
              <label for="cc-number" style="color:white;" class="form-label">Credit card number</label>
              <input type="text" class="form-control" id="cc-number" placeholder="" >
              <div class="invalid-feedback">
                Credit card number is 
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-expiration"style="color:white;" class="form-label">Expiration</label>
              <input type="text" class="form-control" id="cc-expiration" placeholder="" >
              <div class="invalid-feedback">
                Expiration date 
              </div>
            </div>

            <div class="col-md-3">
              <label for="cc-cvv"style="color:white;" class="form-label">CVV</label>
              <input type="text" class="form-control" id="cc-cvv" placeholder="" >
              <div class="invalid-feedback">
                Security code 
              </div>
            </div>
          </div>

          <hr class="my-4">
          <input type="submit" name="checkout" class="w-100 btn btn-primary btn-lg" value="Continue To Checkout"></input>
          <?php
          require_once "pdo.php";
          if(isset($_POST['checkout'])){
            $sql = "Insert into appointment (Appointment_Date, Appointment_Time, Customer_ID_Primary) values (CURDATE(), CURTIME(),	:customerId);";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(
              ':customerId' => $customerId
            ));
            $sql = "select Appointment_ID_Primary from appointment where Customer_ID_Primary= :customerID ORDER BY Appointment_ID_Primary DESC;";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(
              ':customerID' => $customerId
            ));
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $newAppointmentId = $row[0]['Appointment_ID_Primary'];
            
            $sql = "insert into service_rendered (Appointment_ID, Service_Order_Number, Service_ID, Staff_ID, Service_Extended_Price) values (
              :appointment_id, 8,	:serviceID,	:staffID,	:totalcost);";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(array(
              ':appointment_id' => $newAppointmentId,
              ':serviceID' => $_SESSION["service_type_id"],
              ':staffID' => $staffID,
              ':totalcost' => $total
            ));
            header("Location: /dbmsproject/dashboard/dashboard.php", TRUE);
            exit();
          }
          ob_end_flush();
          ?>
                    </form>

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
