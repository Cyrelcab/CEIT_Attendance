<?php require_once('config.php') ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Information Technology Event Attendance System</title>
    <link rel="icon" href="http://localhost/event/uploads/1709299980_download.jpg">
    <link rel="stylesheet" href="../event/dist/css/login.css">
   <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </head>
  <body>
  <?php require_once('inc/header.php') ?>
    <div class="bg-img">
      <div class="content">
        <header>Information Technology Event Attendance System</header>
        <form action="" id="r-login">
          <div class="field">
            <span class="fa fa-user"></span>
            <input type="text" name="username" required placeholder="Username">
          </div>
          <div class="field space">
            <span class="fa fa-lock"></span>
            <input type="text" class="pass-key"  name="password" required placeholder="Password">
            <span class="show">SHOW</span>
          </div>
          <div class="pass">
          </div>
          <div class="field">
            <input type="submit" value="LOGIN">
          </div>
          <br>
           <div class="help-block text-center">
               <a href="<?php echo base_url.'admin' ?>">Login as Admin</a>
           </div>
         </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function(){
        end_loader();
      })
    </script>
    <script>
      const pass_field = document.querySelector('.pass-key');
      const showBtn = document.querySelector('.show');
      showBtn.addEventListener('click', function(){
       if(pass_field.type === "password"){
         pass_field.type = "text";
         showBtn.textContent = "HIDE";
         showBtn.style.color = "#3498db";
       }else{
         pass_field.type = "password";
         showBtn.textContent = "SHOW";
         showBtn.style.color = "#222";
       }
      });
    </script>


  </body>
</html>
