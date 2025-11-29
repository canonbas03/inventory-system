$(document).ready(function () {

    $("#filter-category").load("/inventory/api/categories/get_categories.php");
    $("#filter-supplier").load("/inventory/api/suppliers/get_suppliers.php");
    // === DASHBOARD === \\
    // LOAD TOTAL COUNTS
    loadCounts();
    function loadCounts() {
    $.get("/inventory/api/dashboard/get_counts.php", function(response) {
        let parts = response.split("|||");
        $("#total-products").text(parts[0]);
        $("#total-categories").text(parts[1]);
        $("#total-suppliers").text(parts[2]);
    });
}

loadLowStock();
function loadLowStock() {
    $.get("/inventory/api/products/get_low_stock_products.php", function(response) {
        let parts = response.split("|||");
        let count = parts[0].trim();
        let html = parts[1];

        $("#low-stock-count").text(count);
        $("#low-stock-table").html(html);
    });
}



    $("#category-select").load("/inventory/api/categories/get_categories.php");
    $("#supplier-select").load("/inventory/api/suppliers/get_suppliers.php");
    
    
    // === PRODUCTS === \\
    loadProducts();
    function loadProducts() {
        var query = $("#search").val();                // search text
        var category = $("#filter-category").val();     // selected category
        var supplier = $("#filter-supplier").val();     // selected supplier

        $.ajax({
            url: "/inventory/api/products/filter_products.php",        // unified endpoint
            method: "GET",
            data: {
                q: query,
                category: category,
                supplier: supplier
            },
            success: function (data) {
                $("#product-table tbody").html(data);
                loadCounts();
                loadLowStock();
            }
        });
    }

    // Search
    $("#search").on("keyup", loadProducts);
    $("#filter-category, #filter-supplier").on("change", loadProducts);

    // Edit products
     $(document).on("click", ".edit-product-btn", function (e) {
    e.preventDefault();

    let id = $(this).data("id");

    window.location.href = "/inventory/products/edit.php?id=" + id;
    });

    // Delete products
     $(document).on("click", ".delete-product-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this product?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/products/delete_product.php", { id: id }, function (response) {
        loadProducts();
        loadCounts();
        loadLowStock();
         });
    });


    // === SUPPLIERS === \\
    
     loadSuppliers();
     function loadSuppliers() {
             $.ajax({
                    url: "/inventory/api/suppliers/filter_suppliers.php",
                    method: "GET",
                    data: {
                        q: $("#search-supplier").val()
                    },
                    success: function(data) {
                        $("#supplier-table tbody").html(data); // update tbody only
                    }
                 });
                
    }

    // Search supplier
        $("#search-supplier").on("keyup", loadSuppliers);

    // Edit supplier
        $(document).on("click", ".edit-supplier-btn", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        window.location.href = "../suppliers/edit.php?id=" + id;
    });

    // Delete supplier
        $(document).on("click", ".delete-supplier-btn", function (e) {
        e.preventDefault();

        if (!confirm("Delete this supplier?")) return;

        let id = $(this).data("id");

        $.post("/inventory/api/suppliers/delete_supplier.php", { id: id }, loadSuppliers);
    });


     // === CATAGORIES === \\

     loadCategories(); 
     function loadCategories() {
            $.ajax({
                url: "/inventory/api/categories/filter_categories.php",
                method: "GET",
                data: {
                    q: $("#search-category").val()
                },
                success: function(data) {
                    $("#category-table table").html(
                        "<tr><th>ID</th><th>Name</th><th>Actions</th></tr>" + data
                    );
                }
            });
        }

    // Search
        $("#search-category").on("keyup", loadCategories);

    // Edit category
        $(document).on("click", ".edit-category-btn", function (e) {
        e.preventDefault();

        let id = $(this).data("id");

        window.location.href = "../categories/edit.php?id=" + id;
    });

    // Delete category
    $(document).on("click", ".delete-category-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this category?")) return;

    let id = $(this).data("id");

    $.post("/inventory/api/categories/delete_category.php", { id: id }, loadCategories);


});
});
