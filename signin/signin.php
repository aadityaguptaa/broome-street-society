<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    

    <!-- Bootstrap core CSS -->

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
    <link href="signin.css" rel="stylesheet">
  </head>
  <body class="text-center"
  style="background-image: url('18515351.jpg');background-size: cover"
>


    
<main class="form-signin">
  
  <form method="post">
    <img class="mb-4" src="—Pngtree—cartoons depicting barber_2820272.png" alt="" width="130" height="130">
    <h1 class="h3 mb-3 fw-normal" style="color:white">Please sign in</h1>

    <div class="form-floating">
      <input type="email" name="name" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3" style="color:white">
      <label>
        <input type="checkbox" value="remember-me" > Remember me
      </label>
    </div>
    <input type="submit" value="Sign In" class="w-100 btn btn-lg btn-light"  onclick="document.location.href='/dbmsproject/homepage/homepage.php'">Sign in</button>
    <p class="mt-5 mb-3 text-muted" >&copy; 2017–2021</p>
  </form>
  <div style="color:white"></div>
  <?php
  echo "<pre>\n";
  require_once "pdo.php";
  require_once "data.php";

  if(isset($_POST['name']) && isset($_POST['password'])){
    $sql = "SELECT credential_id from credentials where username = :name and password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt-> execute(array(
      ':name' => $_POST['name'],
      ':password' => $_POST['password']
    ));
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cou = count($result);
    if($cou == 1){
      session_start();
      $username = $result[0]['credential_id'];
      $_SESSION['userid'] = $username;
      header("Location: /dbmsproject/homepage/homepage.php");
      exit();
      echo $username;
    }
    
  }
  /*$stmt = $pdo->query("SELECT * FROM credentials");
  while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
    print_r($row);
  }
  echo "</pre>\n";?>*/
  ?>
  </div>
</main>


    
  </body>
</html>
