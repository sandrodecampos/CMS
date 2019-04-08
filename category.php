<!--header -->
<?php include "includes/header.php" ?>
<!--navigation bar -->
<?php include "includes/navigation.php" ?>

    <div class="container">
        <div class="row">            
            <div class="col-md-8">
            <?php  
            
            if(isset($_GET['category'])){
                $get_cat_id = $_GET['category'];

            }
                $game_query = "SELECT * FROM games WHERE game_cat_id = $get_cat_id";
                $statement = $db->prepare($game_query);
                $statement->execute();
            ?>
                <h1 class="page-header">
                    Game List
                    
                </h1>
                <?php while($row = $statement->fetch()): ?>
                    <h2>
                        <a href="post/<?=$row['game_id']?>"><?=$row['game_title']?></a>
                    </h2>                
                    <p class="lead">
                        by <a href="/CMS Project"><?=$row['game_author']?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span>Posted on <?=$row['game_date']?></p>
                    <hr>
                    <img class="img-responsive" src="/cms Project/images/<?=$row['game_image']?>" alt="">
                    <hr>
                    <p><?=substr($row['game_content'],0,100)?>...</p>
                    <a class="btn btn-primary" href="<?=$row['game_id']?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                <?php endwhile?> 
            </div>

            <!--sidebar -->
            <?php include "includes/sidebar.php" ?>
        </div>   

        <hr>
<!--footer -->
<?php include "includes/footer.php" ?>
       