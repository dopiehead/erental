<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand text-orange fw-bold" href="#">Erentals</a>
            <div class="position-relative d-flex align-items-center">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="form-control search-input" placeholder="Search">
            </div>
            <div class="d-flex align-items-center gap-3">
            <a href='notifications.php'><i class="fas fa-bell text-secondary"></i>
            <?php 
                $count_notification = $conn->prepare("SELECT count(*) FROM `user_notifications` WHERE `recipient_id` = ? AND pending = 0");
                if($count_notification->bind_param("i",$_SESSION['user_id'])){
                    $count_notification->execute();
                    $res = $count_notification->get_result();
                    $datafound = $res->fetch_assoc(); ?>
                               
                   <span style='margin-top:-30px; font-size:8px;' class='rounded rounded-circle bg-danger text-white px-1 text-sm'><?= htmlspecialchars($datafound['count']); ?></span>

              <?php
              
                 }

              ?>
        
        </a>
                <img src="<?php echo"../" .htmlspecialchars($user_image); ?>" class="rounded-circle" width="32" height="32">
                <span><?php echo htmlspecialchars($user_name); ?></span>
                
            </div>
        </div>
    </nav>