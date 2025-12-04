$(document).ready(function () {

    $("#filter-category").load("../api/categories/get_categories.php");
    $("#filter-supplier").load("../api/suppliers/get_suppliers.php");
    // === DASHBOARD === \\
    // LOAD TOTAL COUNTS
    loadCounts();
    function loadCounts() {
    $.get("api/dashboard/get_counts.php", function(response) {
        let parts = response.split("|||");
        $("#total-products").text(parts[0]);
        $("#total-categories").text(parts[1]);
        $("#total-suppliers").text(parts[2]);
    });
}

loadLowStock();
function loadLowStock() {
    $.get("api/products/get_low_stock_products.php", function(response) {
        let parts = response.split("|||");
        let count = parts[0].trim();
        let html = parts[1];

        $("#low-stock-count").text(count);
        $("#low-stock-table").html(html);
    });
}



    $("#category-select").load("../api/categories/get_categories.php");
    $("#supplier-select").load("../api/suppliers/get_suppliers.php");
    
    
    // === PRODUCTS === \\
    loadProducts();
    function loadProducts() {
        var query = $("#product-search").val();                // search text
        var category = $("#filter-category").val();     // selected category
        var supplier = $("#filter-supplier").val();     // selected supplier

        $.ajax({
            url: "../api/products/filter_products.php",        // unified endpoint
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
    $("#product-search").on("keyup", loadProducts);
    $("#filter-category, #filter-supplier").on("change", loadProducts);

    // Edit products
     $(document).on("click", ".edit-product-btn", function (e) {
    e.preventDefault();

    let id = $(this).data("id");

    window.location.href = "../products/edit.php?id=" + id;
    });

    // Delete products
     $(document).on("click", ".delete-product-btn", function (e) {
    e.preventDefault();

    if (!confirm("Delete this product?")) return;

    let id = $(this).data("id");

    $.post("../api/products/delete_product.php", { id: id }, function (response) {
        loadProducts();
        loadCounts();
        loadLowStock();
         });
    });

    // === MODAL === \\ 
    // Quick edit products
   let selectedProductId = null;

    // Open modal
    $(document).on("click", ".qty-btn", function () {
        selectedProductId = $(this).data("id");
        $("#qty-modal").css("display", "flex");
        $("#qty-amount").val("").focus(); 
    });

    // Close modal
    $("#qty-close").on("click", function () {
        $("#qty-modal").hide();
    });

    // Increase
    $("#qty-increase").on("click", function () {
        updateQuantity("increase");
    });

    // Decrease
    $("#qty-decrease").on("click", function () {
        updateQuantity("decrease");
    });

    function updateQuantity(type) {
        let amount = $("#qty-amount").val();

        $.post("../api/products/update_quantity.php",
            {
                id: selectedProductId,
                amount: amount,
                type: type
            },
            function (response) {
                if (response.trim() === "OK") {
                    // alert("Quantity updated!");
                    $("#qty-modal").hide();
                    $("#qty-amount").val(1);

                    if (typeof loadProducts === "function") loadProducts();
                    if (typeof loadDashboardCounts === "function") loadDashboardCounts();
                } else {
                    alert("Error: " + response);
                }
            }
        );
    }



    // === SUPPLIERS === \\
    
     loadSuppliers();
     function loadSuppliers() {
             $.ajax({
                    url: "../api/suppliers/filter_suppliers.php",
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

        $.post("../api/suppliers/delete_supplier.php", { id: id }, loadSuppliers);
    });


     // === CATAGORIES === \\

     loadCategories(); 
     function loadCategories() {
            $.ajax({
                url: "../api/categories/filter_categories.php",
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

    $.post("../api/categories/delete_category.php", { id: id }, loadCategories);


});

    $("#products-export-csv").on("click", function(e) {
    e.preventDefault();

    let q = $("#product-search").val();
    let category = $("#filter-category").val();
    let supplier = $("#filter-supplier").val();

    let url = `../api/products/export_products.php?q=${encodeURIComponent(q)}&category=${category}&supplier=${supplier}`;
    window.location.href = url;
});


// === AUDIT LOGS === \\
loadAuditLogs();

function loadAuditLogs() {
    var query = $("#search").val(); // search text

    $.ajax({
        url: "../api/audit/filter_audit.php",
        method: "GET",
        data: { q: query },
        success: function(data) {
            $("#audit-table tbody").html(data);
        }
    });
}

$("#search").on("input", loadAuditLogs);

// Export CSV
$("#audit-export-csv").on("click", function(e) {
    e.preventDefault();

    var q = $("#search").val();
    var url = `../api/audit/export_audit.php?q=${encodeURIComponent(q)}`;
    window.location.href = url;
});



});
