<?php
    include "connection.php";
    session_start();
    if (isset($_GET['pid'])){
    $id =  mysqli_real_escape_string($con, $_GET['pid']);
    $posts2 = "SELECT * FROM posts WHERE pid=".$id;
    $post = mysqli_query($con, $posts2);
    $info = mysqli_fetch_assoc($post);
    }
?>
<!DOCTYPE html>
<html>

<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Search Page</title>
    <!-- resets browser defaults -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- custom styles -->
    <script src="https://kit.fontawesome.com/a3873631ca.js" crossorigin="anonymous"></script>
</head>
    
<body>
<!--HEADER-->
<?php include "header.php" ?>
<!--HEADER -->
    
<?php
    if(isset($_GET['search'])){
        if (!empty($_GET['search'])){
            
        if(isset($_GET['order'])){
            $order = $_GET['order']; 
        }else{
            $order = 'upload_date';
        }     
            
        if(isset($_GET['sort'])){
            $sort = $_GET['sort'];
        }else{
            $sort = 'DESC';
        }   
            
        if(isset($_GET['order2'])){
            $order2 = $_GET['order2']; 
        }else{
            $order2 = 'role';
        }    
            
        if(isset($_GET['order3'])){
            $order3 = $_GET['order3']; 
        }else{
            $order3 = 'title';
        }   
         
        $search = mysqli_real_escape_string($con, $_GET['search']);
        $sql = "SELECT * From posts WHERE title LIKE '%$search%' OR description LIKE '%$search%' OR upload_date LIKE '%$search%' OR contact LIKE '%$search%' OR email LIKE '%$search%' ORDER BY $order $sort";
        $result = mysqli_query($con,$sql);
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        $search2 = mysqli_real_escape_string($con, $_GET['search']);
        $sql2 = "SELECT * From users WHERE lname LIKE '%$search2%' OR fname LIKE '%$search2%' OR role LIKE '%$search2%' ORDER BY $order2 $sort";
        $result2 = mysqli_query($con,$sql2);
        $results2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
            
        $keyWord =  mysqli_real_escape_string($con, $_GET['search']);
        $videos = "SELECT * FROM videos WHERE title LIKE '%$keyWord%' OR date LIKE '%$keyWord%' ORDER BY $order3 $sort";
        $myvideos = mysqli_query($con, $videos);
        $vid_details = mysqli_fetch_all($myvideos, MYSQLI_ASSOC);
         
        mysqli_close($con);
//        var_dump($vid_details);
            if($results == NULL AND $results2== NULL AND $vid_details == NULL){
                echo "<h2>" . $_GET['search'] . " " . "Not Found</h2>";
            }
        }else{
            echo "<h1>No Content Available</h1>";
            }
        //var_dump($results2);
    }else{
            echo "<h1>No Content Available</h1>";
        }
//    echo "<a href='?search=$_GET['search']?order=$order&&sort=$sort'>Sort by title</a>";
    
?>  

        
    
    
<?php if(!empty($_GET['search'])): ?>
    <?php if(!empty($results)): ?>

    <div class="together">
    <h2 class="ptitle">Posts</h2>
    <div class="dropdown2">
        <button onclick="myFunction()" class="dropbtn2">Sort By</button>
    <div id="click" class="dropdown-content2">
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order=title">Title</a>
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order=upload_date">Date</a>
        </div>
    </div>
    </div>
    <div class="myposts"> 
    
    <?php foreach($results as $row): ?>
        <div class="eapost">
        <p class="title titleSection"><?php echo $row['title']; ?></p>
        <img class="postImg" src=<?php echo $row['img_link']; ?> />
        <p class="descrp"><?php echo $row['description']; ?></p>
        <p class="date"><?php echo $row['upload_date']; ?></p>
        <?php if (isset($_SESSION['uid'])): ?>
        <a class="readmore" href="search.php?pid=<?php echo $row['pid']; ?>&search=<?php echo $_GET['search']; ?>" name="readm">Read More</a>
        <?php endif ?>
         </div>
    <?php endforeach; ?>  
    </div>
    <?php endif ?>
    

    <?php if(!empty($results2)): ?>
    
    <div class="together">
    <h2 class="ptitle">Users</h2> 
    <div class="dropdown2">
        <button onclick="myFunction2()" class="dropbtn2">Sort By</button>
    <div id="click2" class="dropdown-content2">
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order2=role">Role</a>
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order2=lname">Last name</a>
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order2=fname">First name</a>
        </div>
    </div>
    </div>


    <div class="myposts">
         <?php foreach($results2 as $row2): ?>
            <div class="eapost">
            <p class="title"><?php echo $row2['fname']; ?> <?php echo $row2['lname']; ?></p>
            <img class="avatarImg" src=<?php echo $row2['avatar']; ?> />
            <p class="descrp"><?php echo $row2['role']; ?></p>
            <?php if (isset($_SESSION['name'])): ?>
            <a class="readmore" href="profile.php?uid=<?php echo $row2['uid']; ?>">Read More</a>
            <?php endif ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif ?>
    
    
    <?php if(!empty($vid_details)): ?>
    
    <div class="together">
    <h2 class="ptitle">Videos</h2>
    <div class="dropdown2">
        <button onclick="myFunction3()" class="dropbtn2">Sort By</button>
    <div id="click3" class="dropdown-content2">
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order3=title">Title</a>
        <a href="search.php?search=<?php echo $_GET['search']; ?>&order3=date">Date</a>
        </div>
    </div>
    </div>
    <div class="vContainer">
         <?php foreach($vid_details as $row): ?>
    <div class="videos">
    <div class='embed-container'><iframe src='https://www.youtube.com/embed/<?php echo $row['yt_id']; ?>' frameborder='0' allowfullscreen></iframe>
        </div>
        <h4>Title: <?php echo $row['title']; ?></h4>
        <?php if(isset($_SESSION['uid'])): ?>
        <?php if ($_SESSION['uid'] == $row['fk_uid'] OR $_SESSION['uid'] == 1): ?>
                <a onClick="javascript: return confirm('Please confirm video deletion');" href="devideo.php?vid=<?php echo $row['vid']; ?>" name="readm"><i class="fas fa-trash"></i></a>
            <?php endif ?>
            <?php endif ?>
    </div>
    <?php endforeach; ?>
    </div>
    </div>
    <?php endif; ?>
    

    
<?php if(isset($_GET['pid']) AND isset($_GET['search'])): ?>
<div class="bgk">
    <div class="content">
        <div class="myinfo">
            <br>
            <br>
        <p class="title">Title: <?php echo $info['title']; ?></p>
        <img src=<?php echo $info['img_link']; ?> height=300px;/>
        <p class="descrp">Description: <?php echo $info['description']; ?></p>
        <p class="descrp">Contact:<?php echo $info['contact']; ?></p>
            <p class="descrp">Email:<?php echo $info['email']; ?></p>
        <p class="date"><?php echo $info['upload_date']; ?></p>
        <a id="closePost" href="search.php?search=<?php echo $_GET['search']; ?>">+</a>
    </div>
    </div>
</div>
<?php endif ?>
<script>
    
    document.getElementById('closePost').addEventListener('click', function(){
        document.querySelector('.bgk').style.display="none";
    });

</script>
<?php endif ?>
    
<script>
    
function myFunction() {
  document.getElementById("click").classList.toggle("show");
}
function myFunction2() {
  document.getElementById("click2").classList.toggle("show");
}

function myFunction3() {
  document.getElementById("click3").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn2')) {
    var dropdowns = document.getElementsByClassName("dropdown-content2");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}



</script>
    
    
    
    
    
</body>
</html>