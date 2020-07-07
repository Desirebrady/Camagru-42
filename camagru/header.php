<header id="header">
  <div class="container-fluid">

    <div id="logo" class="pull-left">
      <h1><a href="#intro" class="scrollto">Camagru</a></h1>
    </div>

    <nav id="nav-menu-container">
      <ul class="nav-menu">
        <?php if (!empty($_SESSION['username'])) : ?>
          Welcome, <?php echo $_SESSION['username']; ?>
        <?php else : ?>
          Welcome Anonymouse
        <?php endif ?>
        <?php if (!$_SESSION['verified']) : ?>
          <li class=><a href="../index.php">Home</a></li>
        <?php else : ?>
          <li><a href="gallery.php">Gallery</a></li>
          <li class="menu-has-children"><a href="webcam.php">Profile</a></li>
          <li class="menu-has-children"><a href="">Action</a>
            <ul>
              <li><a href="../admin/signup.php">Sign Up</a></li>
              <?php if (!empty($_SESSION['username'])) : ?>
                <li><a href="../admin/login.php?logout='0'" style="color: red;">Bye</a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif ?>
      </ul>
    </nav>
  </div>
</header>