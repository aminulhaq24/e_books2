<?php
include('includes/nav.php');

// Fetch all main categories
$cat_sql = "SELECT * FROM categories ORDER BY id DESC";
$cat_res = mysqli_query($con, $cat_sql);
?>

<style>
.container-fluid {
    margin-bottom: 15%;
    /* margin-left: 10px; */
    /* margin-right: 130px; */

}

/* Category Row Design */
.category-row {
    background: #f9f9f9;
    cursor: pointer;
    transition: 0.2s;
}

.category-row:hover {
    background: #eef5ff;
    transform: scale(1.01);
}

/* Accordion Sub Row */
.subcat-box {
    background: #ffffff;
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #e8e8e8;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
}

/* Subcategory List */
.list-group-item {
    border: none;
    border-bottom: 1px solid #eee;
}

.list-group-item:last-child {
    border-bottom: none;
}

/* Action Buttons */
.btn-sm {
    border-radius: 50px;
    padding: 4px 10px;
}

.editBtn,
.editSubBtn {
    background: #4c8bf5;
    border: none;
}

.btn-danger {
    background: #e63946 !important;
}

.category-title {
    font-size: 17px;
    font-weight: 600;
}



@media (max-width: 768px) {
    .table-responsive table {

        width: 100%;
    }

    .table thead {
        display: none;
        /* Hide headers on mobile */
    }

    .table tbody tr {
        display: flex;
        flex-direction: column;
        border-bottom: 1px solid #ddd;
        margin-bottom: 10px;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        width: 100%;
    }

    .table tbody td .btn {
        margin-left: 5px;
        margin-top: 5px;
        flex: 1;
        /* allow buttons to shrink */
    }

}

@media (max-width: 576px) {
    .btn {
        font-size: 14px;
        margin-left: 24px;
        padding: 6px 10px;
        width: 100%;
        /* optional: full width for small screens */
    }
}
</style>

<div class="container-fluid pt-4 px-4 ">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary mb-0"><i class="fa fa-folder"></i> Categories</h3>

        <div>
            <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addCategoryModal">
                + Add Category
            </button>

            <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#addSubcategoryModal">
                + Add Subcategory
            </button>
        </div>
    </div>

    <!-- CATEGORY ACCORDION -->

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php while ($cat = mysqli_fetch_assoc($cat_res)) { ?>

                <!-- CATEGORY ROW -->
                <tr class="category-row" data-toggle="collapse" data-target="#cat<?php echo $cat['id']; ?>">
                    <td><?php echo $cat['id']?></td>
                    <td class="category-title">
                        📂 <?php echo $cat['category_name']; echo ' <img src="img/down.png" height="12px" alt="">' ?>
                    </td>

                    <td>
                        <button type="button" class="btn btn-sm btn-primary editBtn" data-id="<?php echo $cat['id']; ?>"
                            data-name="<?php echo $cat['category_name']; ?>" data-toggle="modal"
                            data-target="#editCategoryModal">✏️ Edit</button>

                        <a href="delete_category.php?id=<?php echo $cat['id']; ?>" class="btn btn-sm btn-danger"><i
                                class="fa fa-trash"></i>&nbsp; Delete</a>
                    </td>
                </tr>

                <!-- SUB CATEGORY SECTION -->
                <tr class="collapse m-4" id="cat<?php echo $cat['id']; ?>">
                    <td colspan="3">
                        <div class="subcat-box">

                            <div class="sub-header mb-4">Subcategories:</div>

                            <?php
                        $sub_res = mysqli_query($con, "SELECT * FROM subcategories WHERE category_id=".$cat['id']);
                        ?>

                            <?php if(mysqli_num_rows($sub_res)==0){ ?>
                            <p class="text-muted">No subcategories found.</p>

                            <?php } else { ?>

                            <ul class="list-group">
                                <div class="d-flex"> <p><u>ID</u></p> <p style="margin-left:70px;"><u>Sub-category Name</u></p> </div>
                                <?php while($sub = mysqli_fetch_assoc($sub_res)) { ?>

                                <li class="list-group-item d-flex justify-content-between align-items-center">

                                    <!-- LEFT SIDE → ID + Subcategory -->
                                    <div class="d-flex align-items-center">

                                        <!-- ID -->
                                        <span class="badge bg-dark text-white me-3"
                                            style="width: 40px; text-align:center; margin-left: -22px">
                                            <?php echo $sub['id']; ?>
                                        </span>

                                        <!-- Subcategory name -->
                                        <span style="font-size:16px; margin-left: 40px">
                                            📘 <?php echo $sub['subcategory_name']; ?>
                                        </span>

                                    </div>

                                    <!-- RIGHT SIDE → Buttons -->
                                    <span>
                                        <button class="btn btn-sm btn-primary editSubBtn"
                                            data-id="<?php echo $sub['id']; ?>"
                                            data-name="<?php echo $sub['subcategory_name']; ?>"
                                            data-cat="<?php echo $sub['category_id']; ?>" data-toggle="modal"
                                            data-target="#editSubcategoryModal">
                                            ✏️ Edit
                                        </button>

                                        <a href="delete_subcategory.php?id=<?php echo $sub['id']; ?>"
                                            class="btn btn-sm btn-danger">
                                            🗑 Delete
                                        </a>
                                    </span>

                                </li>

                                <?php } ?>
                            </ul>


                            <?php } ?>

                        </div>
                    </td>
                </tr>

                <?php } ?>

            </tbody>
        </table>
    </div>


</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="insert_category.php" method="post">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add category Modal End -->

<!-- Edit Category Modal -->

<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="update_category.php" method="POST">
                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <label>Category Name</label>
                    <input type="text" id="edit_name" name="category_name" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>



<!-- Edit Category Modal End -->


<!-- Add Subcategory Modal -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" role="dialog" aria-labelledby="addSubcategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="add_subcategory.php" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubcategoryModalLabel">Add New Subcategory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select Main Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <?php
                $cat_sql2 = "SELECT * FROM categories ORDER BY category_name ASC";
                $cat_res2 = mysqli_query($con, $cat_sql2);
                while($c = mysqli_fetch_assoc($cat_res2)) {
                    echo "<option value='{$c['id']}'>{$c['category_name']}</option>";
                }
                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Subcategory</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add Subcategory Modal End -->

<!-- EDIT SUBCATEGORY MODAL -->
<div class="modal fade" id="editSubcategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="edit_subcategory.php" method="POST">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Subcategory</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="sub_id" id="editSubId">

                    <label>Main Category</label>
                    <select name="category_id" id="editSubCat" class="form-control" required>
                        <?php
                        $cat_res = mysqli_query($con, "SELECT * FROM categories");
                        while($row = mysqli_fetch_assoc($cat_res)){ ?>
                        <option value="<?= $row['id'] ?>"><?= $row['category_name'] ?></option>
                        <?php } ?>
                    </select>

                    <label class="mt-3">Subcategory Name</label>
                    <input type="text" name="subcategory_name" id="editSubName" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- EDIT SUBCATEGORY MODAL End -->


<?php
include('includes/footer.php');
?>


<script>
$(document).on("click", ".editBtn", function() {
    var id = $(this).data("id");
    var name = $(this).data("name");

    $("#edit_id").val(id);
    $("#edit_name").val(name);
});

// for edit subcategory

$(document).on("click", ".editSubBtn", function() {
    let id = $(this).data("id");
    let name = $(this).data("name");
    let cat = $(this).data("cat");

    $("#editSubId").val(id);
    $("#editSubName").val(name);
    $("#editSubCat").val(cat);
});

// PREVENT ACCORDION FROM OPENING WHEN CLICKING EDIT/DELETE BUTTONS
$(document).on("click", ".editBtn, .editSubBtn, .btn-danger", function(e) {
    e.stopPropagation();
});
</script>