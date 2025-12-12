<style>
.container-fluid {
    margin-bottom: 15%;
    margin-left: 89px;

}
</style>

<?php
include('includes/nav.php');

$sql = "SELECT * FROM categories ORDER BY id DESC";
$result = mysqli_query($con, $sql);

?>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-11 px-2">
            <div class="bg-white shadow rounded h-100 p-4">

                <!-- Header Row -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-primary mb-0">
                        <i class="fa fa-folder-open"></i> Categories
                    </h3>

                    <button class="btn btn-success shadow-sm" data-toggle="modal" data-target="#addCategoryModal">
                        <i class="fa fa-plus"></i> Add Category
                    </button>

                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="10%">ID</th>
                                <th>Category Name</th>
                                <th width="19%" class="px-4">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><strong><?php echo $row['id']; ?></strong></td>
                                <td><?php echo $row['category_name']; ?></td>

                                <td class="d-flex justify-content-between align-items-center px-4">

                                    <a href="#" class="btn btn-primary btn-sm editBtn"
                                        data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['category_name']; ?>"
                                        data-toggle="modal" data-target="#editCategoryModal"><i class="fa fa-edit"></i>
                                        Edit
                                    </a>

                                    <a href="delete_category.php?id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this category?');"
                                        class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- Add Category Modal -->
 
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times fa-sm"></i></span>
                </button>

            </div>

            <form action="insert_category.php" method="POST">
                <div class="modal-body">

                    <label class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control" required>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Add Category Modal End -->


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


<!-- Edit Category Modal jquery -->

<?php include('includes/footer.php'); ?>
<script>
$(document).on("click", ".editBtn", function() {
    var id = $(this).data("id");
    var name = $(this).data("name");

    $("#edit_id").val(id);
    $("#edit_name").val(name);
});
</script>

