<?php

  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gamez Shop - Create Account</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
  </head>

  <body>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Information</h4>
          </div>
          <div class="modal-body">
            <p id="modal-text">Some text in the modal.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- End Modal -->

    <script>
        var statusMsg;

        statusMsg = "<?php echo $_GET['error']; ?>";

        if(statusMsg!=="") {

            $('#modal-text').text(statusMsg);
            $('#myModal').modal('show');
        }
    </script>

    <!-- NAV BAR -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Gamez Shop</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="register.php">Create Account</a></li>
            <li><a href="cart.php">View Cart</a></li>
          </ul>
          <form action="index.php" class="navbar-form navbar-right" method="get">
            <input type="text" name="search" class="form-control" placeholder="Search" autocomplete="off" />
            <button class="btn btn-primary" type="submit">Search</button>
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <!-- END OF NAV BAR -->

    <!-- BODY CONTAINER -->
    <div class="container">

      <!-- CONTENT -->
      <div class="row">

        <!-- LEFT SIDE OF CONTAINER -->
        <div class="col-md-4">

          <!-- LOGIN PANEL -->
          <div class="login-block">
              <?php
              if(isset($_SESSION['customerID'])) {

                  echo "<h3>Welcome, " . $_SESSION['cust_name'] . "!</h3>";
              }
              else {
                  ?>
                <form class="" method="post" action="login.php">
                  <input name="username" type="text" class="form-control" placeholder="Enter Username"><br/>
                  <input name="password" type="password" class="form-control" placeholder="Enter Password"><br/>
                  <button name="submit" type="submit" class="btn btn-primary">Login</button>
                </form>
                  <?php
              }
              ?>
          </div>
          <!-- END OF LOGIN PANEL -->

          <!-- CATEGORY PANEL -->
          <div class="panel panel-default panel-list">
            <div class="panel-heading panel-heading-dark">
              <h3 class="panel-title">
                Categories
              </h3>
            </div>
            <!-- List group -->
            <ul class="list-group">
              <li class="list-group-item"><a href="index.php">All Platforms</a></li>
              <li class="list-group-item"><a href="index.php?platform=xbox_one">Xbox One Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=xbox_360">Xbox 360 Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=ps4">Playstation 4 Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=ps3">Playstation 3 Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=switch">Nintendo Switch Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=wii_u">Nintendo Wii U Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=wii">Nintendo Wii Games</a></li>
              <li class="list-group-item"><a href="index.php?platform=3ds">Nintendo 3DS Games</a></li>
            </ul>
          </div>
          <!-- END OF CATEGORY PANEL -->

          <!-- RATTING PANEL -->
          <div class="panel panel-default panel-list">
            <div class="panel-heading panel-heading-dark">
              <h3 class="panel-title">
                Rating
              </h3>
            </div>
            <!-- List group -->
            <ul class="list-group">
              <li class="list-group-item"><a href="#"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> 5.0</a></li>
              <li class="list-group-item"><a href="#"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> 4.0</a></li>
              <li class="list-group-item"><a href="#"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> 3.0</a></li>
              <li class="list-group-item"><a href="#"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> 2.0 or less</a></li>
            </ul>
          </div>
          <!-- RATTING PANEL -->
        </div>
        <!-- END OF LEFT SIDE -->

        <!--RIGHT SIDE CONTENT -->
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading panel-heading-green">
              <h3 class="panel-title">Account Information</h3>
            </div>
            <div class="panel-body">
              <form role="form" method="post" action="createUser.php">
                <div class="form-group">
                  <label>First Name*</label>
                  <input type="text" class="form-control" name="name" placeholder="Enter Your Name">
                </div>
                <div class="form-group">
                  <label>Email Address*</label>
                  <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address">
                </div>
                <div class="form-group">
                  <label>Choose Username*</label>
                  <input type="text" class="form-control" name="username" placeholder="Create A Username">
                </div>
                <div class="form-group">
                  <label>Password*</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter A Password">
                </div>
                <div class="form-group">
                  <label>Confirm Password*</label>
                  <input type="password" class="form-control" name="password2" placeholder="Enter Password Again">
                </div>

                <button type="submit" class="btn btn-primary">Register</button>
              </form>
            </div>
          </div>
        </div>
        <!--RIGHT SIDE CONTENT -->

      </div>
      <!-- END OF CONTENT -->

    </div>
    <!-- END OF BODY CONTAINER -->

    <!-- FOOTER -->
    <div class="row footer">
      <div class="container">
        <p>&COPY; 2017 Gamez Shop</p>
      </div>
    </div>
    <!-- END OF FOOTER -->

  </body>
</html>
