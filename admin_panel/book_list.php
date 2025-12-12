<?php

include('includes/nav.php');

// Fetch books with category + subcategory names
$query = "
SELECT b.*, c.category_name, s.subcategory_name
FROM books b
LEFT JOIN categories c ON b.category_id = c.id
LEFT JOIN subcategories s ON b.subcategory_id = s.id
ORDER BY b.book_id DESC
";
$result = mysqli_query($con, $query);
?>

<div class="container mt-4">
    <h2 class="mb-4">📚 All Books</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Price</th>
                <th>Free?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php while($row = mysqli_fetch_assoc($result)){ ?>
            <tr>
                <td><?= $row['book_id']; ?></td>

                <td>
                    <img src="uploads/<?= $row['cover_image']; ?>" width="60">
                </td>

                <td><?= $row['title']; ?></td>

                <td><?= $row['category_name']; ?></td>

                <td><?= $row['subcategory_name']; ?></td>

                <td><?= $row['price']; ?> PKR</td>

                <td><?= ($row['price'] == 0) ? "Yes" : "No"; ?></td>

                <td>
                    <!-- Edit Button -->
                    <button class="btn btn-primary btn-sm editBookBtn"
                        data-id="<?= $row['book_id']; ?>"
                        data-title="<?= $row['title']; ?>"
                        data-author="<?= $row['author']; ?>"
                        data-desc="<?= $row['description']; ?>"
                        data-category="<?= $row['category_id']; ?>"
                        data-subcategory="<?= $row['subcategory_id']; ?>"
                        data-price="<?= $row['price']; ?>"
                    >
                        Edit
                    </button>

                    <!-- Delete Button -->
                    <a href="delete_book.php?id=<?= $row['book_id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this book?');">
                        Delete
                    </a>
                </td>

            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>


<!-- ======================= EDIT MODAL ======================= -->

<div class="modal fade" id="editBookModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

        <form action="update_book.php" method="POST">

        <div class="modal-header">
            <h5 class="modal-title">Edit Book</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <input type="hidden" name="book_id" id="edit_book_id">

            <label>Title</label>
            <input type="text" class="form-control" id="edit_title" name="title">

            <label class="mt-2">Author</label>
            <input type="text" class="form-control" id="edit_author" name="author">

            <label class="mt-2">Description</label>
            <textarea class="form-control" id="edit_desc" name="description"></textarea>

            <label class="mt-2">Category</label>
            <select class="form-control" id="edit_category" name="category_id">
                <?php
                $cat = mysqli_query($con, "SELECT * FROM categories");
                while($c = mysqli_fetch_assoc($cat)){
                    echo "<option value='{$c['category_id']}'>{$c['category_name']}</option>";
                }
                ?>
            </select>

            <label class="mt-2">Subcategory</label>
            <select class="form-control" id="edit_subcategory" name="subcategory_id">
                <?php
                $sub = mysqli_query($con, "SELECT * FROM subcategories");
                while($s = mysqli_fetch_assoc($sub)){
                    echo "<option value='{$s['subcategory_id']}'>{$s['subcategory_name']}</option>";
                }
                ?>
            </select>

            <label class="mt-2">Price</label>
            <input type="number" class="form-control" id="edit_price" name="price">

        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Update</button>
        </div>

        </form>

    </div>
  </div>
</div>
<?php
include('includes/footer.php');
?>
<script>
document.querySelectorAll(".editBookBtn").forEach(btn => {
    btn.addEventListener("click", function(){
        document.getElementById("edit_book_id").value = this.dataset.id;
        document.getElementById("edit_title").value = this.dataset.title;
        document.getElementById("edit_author").value = this.dataset.author;
        document.getElementById("edit_desc").value = this.dataset.desc;
        document.getElementById("edit_category").value = this.dataset.category;
        document.getElementById("edit_subcategory").value = this.dataset.subcategory;
        document.getElementById("edit_price").value = this.dataset.price;

        new bootstrap.Modal(document.getElementById("editBookModal")).show();
    });
});
</script>
