<?php
$getcomment = $conn->prepare("SELECT 
            user_profile.user_name AS user_name, 
            user_profile.user_email AS user_email, 
            user_profile.user_image AS user_image,
            seller_comment.id AS id,
            seller_comment.sender_email AS sender_email, 
            seller_comment.comment AS comment, 
            seller_comment.product_name AS product_name,
            seller_comment.date AS date
        FROM user_profile
        INNER JOIN seller_comment ON seller_comment.sender_email = user_profile.user_email
        WHERE seller_comment.product_name =  ?");
            $getcomment->bind_param("s", $product_name); 
            $getcomment->execute();
            $comment_result = $getcomment->get_result();
             ?>