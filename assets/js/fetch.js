
    $(document).ready(function(){
        // Load initial products
        $(".spinner-border").hide();
        $(".product-container").load("engine/fetch-all.php");

        // Search functionality
        $("#q").on("keyup", function(e){
             e.preventDefault(); 
             let x = $("#q").val(); 
             getData(x); 
        });

        // Category filter functionality
        $(".btn-category").on("click", function(e){
            $(".btn-category").removeClass("active-button");
            $(this).addClass("active-button");
            e.preventDefault();
            let x = $("#q").val(); 
            let category = $(this).attr("id") || '';     
            getData(x, category); 
        });

        // Condition filter (new, used) functionality
        $(".btn-condition").on("change", function(e){  
            e.preventDefault(); 
            let x = $("#q").val(); 
            let category = $(".btn-category").attr("id") || '';
            let condition = $(".btn-condition").val() || ''; 
            getData(x, category, condition); 
        });

        // Price range filter functionality
        $(".price_range").on("change", function(){
            var price_range = $(".price_range").val();
            $(".price_info").html('<span class="text-success"><i class="fas fa-naira-sign"></i>' + price_range + '</span>');
            let x = $("#q").val(); 
            let category = $(".btn-category").attr("id") || '';
            let condition = $(".btn-condition").val() || ''; 
            getData(x, category, condition, price_range);
        });

        // Sorting functionality
        $("#sort").on("change", function(e){
            e.preventDefault();

            let x = $("#q").val(); 
            let category = $(".btn-category").attr("id") || '';
            let condition = $(".btn-condition").val() || ''; 
            let price_range = $(".price_range").val() || ''; 
            let sort = $("#sort").val() || ''; 

            getData(x, category, condition, price_range, sort);  
        });

        // Pagination functionality
        $(document).on('click', '.btn-success', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();

            let x = $("#q").val(); 
            let category = $(".btn-category").attr("id") || '';
            let condition = $(".btn-condition").val() || ''; 
            let price_range = $(".price_range").val() || ''; 
            let sort = $("#sort").val() || '';  
            var page = $(this).attr("id") || 1; // Default to page 1 if undefined
            getData(x, category, condition, price_range, sort, page); 
        });
        // Function to fetch and display data
        function getData(x, category, condition, price_range, sort, page = 1) {
            $(".spinner-border").show(); // Show the spinner
            $.ajax({
                url: "engine/fetch-all.php", 
                method: "POST",
                data: { 
                    q: x,
                    category: category,
                    condition: condition,
                    price_range: price_range,
                    sort: sort,
                    page: page
                }, 
                success: function(data) {
                    $(".spinner-border").hide(); // Hide the spinner after data is received
                    $(".product-container").html(data);  // Update product container with new data
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error: " + textStatus + ": " + errorThrown);
                    $(".spinner-border").hide(); // Hide the spinner if there's an error
                }
            });
        }
    });
