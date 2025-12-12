<?php
// edit_book.php - Optimized Version

include 'includes/nav.php';

// Check admin authentication


$book_id = intval($_GET['id'] ?? 0);
if (!$book_id) {
    header("Location: books.php?error=invalid_id");
    exit;
}

// Get book details
$book = getBookById($book_id);
if (!$book) {
    header("Location: books.php?error=book_not_found");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = updateBook($book_id, $_POST, $_FILES);
    
    if ($result['success']) {
        $_SESSION['success'] = "Book updated successfully!";
        header("Location: edit_book.php?id=" . $book_id);
        exit;
    } else {
        $error = $result['error'];
    }
}

// Get categories and subcategories
$categories = getAllCategories();
$subcategories = getSubcategoriesByCategory($book['category_id']);
?>

    
    
    <div class="container">
        <h2>Edit Book: <?= htmlspecialchars($book['title']) ?></h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="book-form">
            <!-- Basic Details -->
            <div class="form-section">
                <h3>Basic Information</h3>
                <input type="text" name="title" value="<?= $book['title'] ?>" required>
                <input type="text" name="author" value="<?= $book['author'] ?>" required>
                
                <select name="category_id" id="categorySelect" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $book['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['category_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="subcategory_id" id="subcategorySelect" required>
                    <option value="">Select Subcategory</option>
                    <?php foreach ($subcategories as $sub): ?>
                        <option value="<?= $sub['id'] ?>" <?= $sub['id'] == $book['subcategory_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['subcategory_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <textarea name="description" rows="4"><?= $book['description'] ?></textarea>
            </div>
            
            <!-- Format & Pricing -->
            <div class="form-section">
                <h3>Format & Pricing</h3>
                <select name="format_type" id="formatType">
                    <option value="HARDCOPY" <?= $book['format_type'] == 'HARDCOPY' ? 'selected' : '' ?>>Hardcopy</option>
                    <option value="PDF" <?= $book['format_type'] == 'PDF' ? 'selected' : '' ?>>PDF</option>
                    <option value="CD" <?= $book['format_type'] == 'CD' ? 'selected' : '' ?>>CD</option>
                </select>
                
                <input type="number" name="price" value="<?= $book['price'] ?>" placeholder="Price" step="0.01">
                
                <div class="checkbox-group">
                    <label>
                        <input type="checkbox" name="is_free_for_members" value="1" <?= $book['is_free_for_members'] ? 'checked' : '' ?>>
                        Free for Members
                    </label>
                    
                    <label>
                        <input type="checkbox" name="cd_available" value="Yes" <?= $book['cd_available'] == 'Yes' ? 'checked' : '' ?>>
                        CD Available
                    </label>
                </div>
            </div>
            
            <!-- File Uploads -->
            <div class="form-section">
                <h3>Files</h3>
                <div class="file-upload">
                    <label>Cover Image (Current: <?= basename($book['cover_image']) ?>)</label>
                    <input type="file" name="cover_image" accept="image/*">
                </div>
                
                <div class="file-upload">
                    <label>PDF File (Current: <?= basename($book['pdf_file']) ?>)</label>
                    <input type="file" name="pdf_file" accept=".pdf,.doc,.docx">
                </div>
            </div>
            
            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Book</button>
                <a href="books.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    
    <?php include 'includes/footer.php'; ?>
    
    <script>
    // AJAX for subcategory loading
    document.getElementById('categorySelect').addEventListener('change', function() {
        let categoryId = this.value;
        fetch('includes/get_subcategories.php?category_id=' + categoryId)
            .then(response => response.json())
            .then(data => {
                let subSelect = document.getElementById('subcategorySelect');
                subSelect.innerHTML = '<option value="">Select Subcategory</option>';
                data.forEach(sub => {
                    subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    });
    </script>

