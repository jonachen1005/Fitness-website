<div class="topnav">
  <a class="active" href="index.php">BC Fitness</a>
  <a href="videoCourse.php?search=all">Videos</a>
  <a href="contact.php">Contact</a>
    <?php if(isset($_SESSION['uid']) AND $_SESSION['uid'] == 1): ?>
    <a href="control.php">Control</a>
    <?php endif ?>
    <div class="dropdown">
    <?php if(isset($_SESSION['name'])): ?>
    <button class="dropbtn">Hi, <?php echo $_SESSION['name']; ?> 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
       
        <a href="profile.php?uid=<?php echo $_SESSION['uid']; ?>">Profile</a>
    
        <a href="logout.php">Log Out?</a>
    </div>
    <?php else: ?>
         <button class="dropbtn">Hi, Guest
      <i class="fa fa-caret-down"></i>
    </button>
        <div class="dropdown-content">
        <a href="login.php">Log In?</a>
        </div>
    <?php endif ?>
  </div> 
   
 <div class="search-container">
    <form action="search.php" method="GET">
      <input type="text" name="search" placeholder="Search.." name="search" required>
      <button type="submit" ><i class="fa fa-search"></i></button>
    </form>
  </div>

</div>