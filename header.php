<div class="container-fluid bg-dark">
  <div class="container-fluid ">
    <div class="row justify-content-center align-items-center">  
      <h1 class="display-4 text-white mt-5">Forex Stocks Riders</h1>
    </div>
  </div>

    <nav class="navbar navbar-expand-xl navbar-dark bg-dark sticky-top" >
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item <?php if ($_SERVER['PHP_SELF']=="/forex/index.php") { echo 'active'; } ?>">
            <a class="nav-link" href="index.php">Home <?php if ($_SERVER['PHP_SELF']=="/forex/index.php") { echo '<span class="sr-only">(current)</span>'; } ?></a>
          </li>
          <li class="nav-item <?php if ($_SERVER['PHP_SELF']=="/forex/registration.php") { echo 'active'; } ?>">
            <a class="nav-link" href="registration.php">Registration <?php if ($_SERVER['PHP_SELF']=="/forex/registration.php") { ?> <?php ?> <span class="sr-only">(current)</span> <?php } ?></a>
          </li>
        </ul>
        <form class="form-inline" name="formSearch" action="index.php" method="post">
          <span style="color:red"><small><?php echo @$nameErr;?>&nbsp;</small></span>
          <input id="datepicker" name="searchDate" placeholder="Deposit Date" aria-label="Search" width="200" readonly>&nbsp;
          <script src="build/js/myScript.js"></script>
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="SubmitButton" onclick="validateSearhForm()">Search</button>
        </form>
      </div>
    </nav>
</div>