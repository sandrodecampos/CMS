<?php  include "includes/connect.php"; ?>
  <?php  include "includes/header.php"; ?>

 <?php 
 
 if(isset($_POST['submit'])){

     $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $user_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
     $user_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $user_firstname = filter_input(INPUT_POST, 'user_firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
     $user_lastname = filter_input(INPUT_POST, 'user_lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
     $username = $_POST['username'];
     $user_email = $_POST['email'];
     $user_password = $_POST['password'];
     $user_firstname = $_POST['user_firstname'];
     $user_lastname = $_POST['user_lastname'];
     $user_role = 'subscriber';
     $salted = "3248cf789d9rmoksf7fj".$user_password;
     $hashed = hash('sha512',$salted);
     $user_password = $hashed;

     

     try{
        
        $query = "INSERT INTO users (user_firstname, user_lastname, username, user_role, user_email, user_password)
              VALUES (:user_firstname, :user_lastname, :username, :user_role, :user_email, :user_password)";
        $insert_query = $db->prepare($query);                                    
        $insert_query->bindValue(':user_firstname', $user_firstname);
        $insert_query->bindValue(':user_lastname', $user_lastname);
        $insert_query->bindValue(':username', $username);
        $insert_query->bindValue(':user_role', $user_role);
        $insert_query->bindValue(':user_email', $user_email);
        $insert_query->bindValue(':user_password', $user_password);            
        
        // Execute the INSERT.
        $insert_query->execute(); 

        header("Location: index.php");
    }
    catch(PDOException $e) {
        print "Error: " . $e->getMessage();
        die();
    }
     
 }
 
 
 
 
 ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" >Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                         <div class="form-group">
                            <label for="email" >Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required>
                        </div>
                         <div class="form-group">
                            <label for="password" >Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input type="text" class="form-control" name="user_firstname" required>
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input type="text" class="form-control" name="user_lastname" required>
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
