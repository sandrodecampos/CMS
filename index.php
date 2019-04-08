<!--header -->
<?php include "includes/header.php" ?>
<!--navigation bar -->
<?php include "includes/navigation.php" ?>

    <div class="container">
        <div class="row">            
            <div class="col-md-8">
            <?php 

                $per_page = 4;

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                else{
                    $page = "";
                }

                if($page == "" || $page == 1){
                    $page_1 = 0;
                }
                else{
                    $page_1 = ($page * $per_page) - $per_page;
                }
            
                $game_count_query = "SELECT * FROM games";
                $find_count = $db->prepare($game_count_query);
                $find_count->execute();
                $count = $find_count->rowCount();
                $count = ceil($count / $per_page);

                $game_query = "SELECT * FROM games WHERE game_status = 'published' LIMIT $page_1, $per_page";
                $statement = $db->prepare($game_query);
                $statement->execute();
            ?> 
                <h1 class="page-header">
                    Game List                    
                </h1>
                <div id="sort">
                    <select id="selected">
                        <option selected>Sort By</option>
                        <option value="0">Title</option>
                        <option value="1">Date Created</option>
                        <option value="2">Updated by Date</option>                        
                    </select>
                </div>
                <?php while($row = $statement->fetch()): ?>
                    <h2>
                        <a href="post/<?=$row['game_id']?>"><?=$row['game_title']?></a>
                    </h2>                
                    <p class="lead">
                        by <a href="/CMS Project"><?=$row['game_author']?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span>Posted on <?=$row['game_date']?></p>
                    <hr>
                    <a href="post/<?=$row['game_id']?>">
                    <img class="img-responsive" src="images/<?=$row['game_image']?>" alt="">
                    </a>
                    <hr>
                    <p><?=substr($row['game_content'],0,100)?>...</p>
                    <a class="btn btn-primary" href="post/<?=$row['game_id']?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
                <?php endwhile?> 
            </div>

            <!--sidebar -->
            <?php include "includes/sidebar.php" ?>
        </div>   

        <hr>
        <ul class="pager">
            <?php 

            for($i =1; $i <= $count; $i++){
                if($i == $page){
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                }
                else{
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
                
            } 
            ?>            
        </ul>
<!--footer -->
<?php include "includes/footer.php" ?>
       