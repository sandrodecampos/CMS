<?php ob_start(); ?>
<?php session_start();?>

<!--header -->
<?php include "includes/header.php" ?>
<!--navigation bar -->
<?php include "includes/navigation.php" ?>
<style>

.demo-error {
	display:inline-block;
	color:#FF0000;
	margin-left:5px;
}

.demo-success {
    margin-top: 5px;
    color: #478347;
    background: #e2ead1;
    padding: 10px;
    border-radius: 5px;
}
.captcha-input {
	background:#FFF url('captcha_code.php') repeat-y;
	padding-left: 85px;
}
</style>

    <div class="container">
        <div class="row">            
            <div class="col-md-8">
            <?php        
            
            if(isset($_GET['p_id'])){
                $get_game_id = $_GET['p_id'];
            }
                $game_query = "SELECT * FROM games WHERE game_id = $get_game_id";
                $statement = $db->prepare($game_query);
                $statement->execute();
            ?>
                <h1 class="page-header">
                    Game List
                    
                </h1>
                <?php while($row = $statement->fetch()): ?>
                    <h2>
                        <a href="<?=$row['game_id']?>"><?=$row['game_title']?></a>
                    </h2>                
                    <p class="lead">
                        by <a href="/CMS Project"><?=$row['game_author']?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span>Posted on <?=$row['game_date']?></p>
                    <hr>
                    <img class="img-responsive" src="/cms Project/images/<?=$row['game_image']?>" alt="">
                    <hr>
                    <p><?=$row['game_content']?></p>                    
                    <hr>
                <?php endwhile?> 

                           
                <!-- Blog Comments -->
                <!-- Comments Form -->

                <?php 
                if(count($_POST)>0) {
                    if($_POST["captcha_code"]==$_SESSION["captcha_code"]){
                    
                        if(isset($_POST['create_comment'])){
                    
                            $the_game_id = $_GET['p_id'];                    
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content = $_POST['comment_content'];
                            $comment_status = 'unapproved';
                            $comment_date = date('y-m-d');
                        
                            $query = "INSERT INTO comments (comment_game_id, comment_author, comment_date, comment_email, comment_content, comment_status)
                            VALUES (:comment_game_id, :comment_author, :comment_date, :comment_email, :comment_content, :comment_status)";
                            $insert_query = $db->prepare($query);                                    
                            $insert_query->bindValue(':comment_game_id', $the_game_id);
                            $insert_query->bindValue(':comment_author', $comment_author);
                            $insert_query->bindValue(':comment_date', $comment_date);
                            $insert_query->bindValue(':comment_email', $comment_email);
                            $insert_query->bindValue(':comment_content', $comment_content);
                            $insert_query->bindValue(':comment_status', $comment_status);                    
                            // Execute the INSERT.
                            $insert_query->execute();

                            $query ="UPDATE games SET game_comment_count = game_comment_count + 1 WHERE game_id = $the_game_id ";
                            $update_comment_count = $db->prepare($query); 
                            $update_comment_count->execute();
                            $success_message = "Your message received successfully. Wait for approval!";
                        }
                    }else{
                        $error_message = "Incorrect Captcha Code";   
                        if(isset($_POST['create_comment'])){
                    
                            $the_game_id = $_GET['p_id'];                    
                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content = $_POST['comment_content']; 
                        }
                         
                                   
                    }
            }
                ?>

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="comment_author" class="form-control" value="<?php if(isset($error_message)) { echo $comment_author;}?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" name="comment_email" class="form-control" value="<?php if(isset($error_message)) { echo $comment_email;}?>">
                        </div>
                        <div class="form-group">
                            <label for="comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"><?php if(isset($error_message)) { echo $comment_content;}?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="captcha">Captcha:</label>
                            <div id="error-captcha" class="demo-error"><?php if(isset($error_message)) { echo $error_message; } ?></div><br/>
                            <input name="captcha_code" type="text" class="demo-input captcha-input">
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        <?php if(isset($success_message)) { ?>
                        <div class="demo-success"><?php echo $success_message; ?></div>
                        <?php } ?>
                    </form>
                </div>
                <hr>
                <!-- Posted Comments -->
                <?php
                    $the_game_id = $_GET['p_id'];
                    $query = "SELECT * FROM comments WHERE comment_game_id = {$the_game_id} AND comment_status = 'approved' ORDER BY comment_id DESC ";                    

                    $select_comment_query = $db->prepare($query);
                    $select_comment_query->execute();

                    while($row = $select_comment_query->fetch()){
                        $comment_date = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author = $row['comment_author'];

                ?>
                    <!-- Comment -->
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?= $comment_author ?>
                                <small><?= $comment_date ?></small>
                            </h4>
                            <?= $comment_content ?>
                        </div>
                    </div>  
                <?php } ?>    
            </div>

            <!--sidebar -->
            <?php include "includes/sidebar.php" ?>
        </div>   

        <hr>
<!--footer -->
<?php include "includes/footer.php" ?>
       