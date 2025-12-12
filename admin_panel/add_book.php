<?php 
include('includes/nav.php'); 
?>

<style>
/* Upload Book Page Styling */
.upload-container {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: calc(100vh - 76px);
    padding: 2rem 0;
}

.upload-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 2.5rem;
    margin-bottom: 3rem;
    border: none;
}

.form-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    border-left: 4px solid #4e73df;
}

.form-section h5 {
    color: #4e73df;
    margin-bottom: 1rem;
    font-weight: 600;
}

.form-section h5 i {
    margin-right: 10px;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s;
}

.form-control:focus, .form-select:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.file-upload-area {
    border: 2px dashed #4e73df;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background: rgba(78, 115, 223, 0.05);
    cursor: pointer;
    transition: all 0.3s;
    margin-bottom: 1rem;
}

.file-upload-area:hover {
    background: rgba(78, 115, 223, 0.1);
    border-color: #2e59d9;
}

.file-upload-area i {
    font-size: 3rem;
    color: #4e73df;
    margin-bottom: 1rem;
}

.format-option-card {
    border: 2px solid #e3e6f0;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    cursor: pointer;
    transition: all 0.3s;
}

.format-option-card:hover {
    border-color: #4e73df;
    transform: translateY(-2px);
}

.format-option-card.active {
    border-color: #4e73df;
    background: rgba(78, 115, 223, 0.05);
}

.format-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.format-icon.pdf { color: #ff6b6b; }
.format-icon.hardcopy { color: #1dd1a1; }
.format-icon.cd { color: #54a0ff; }

.price-input-group {
    position: relative;
}

.price-input-group .input-group-text {
    background: #4e73df;
    color: white;
    border: none;
    border-radius: 8px 0 0 8px;
    font-weight: 600;
}

.switch-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    margin-bottom: 1rem;
}

.switch {
    position: relative;
    width: 60px;
    height: 30px;
    margin-right: 10px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #4e73df;
}

input:checked + .slider:before {
    transform: translateX(30px);
}

.form-tabs {
    border-bottom: 2px solid #e3e6f0;
    margin-bottom: 2rem;
}

.form-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    margin-right: 1rem;
}

.form-tabs .nav-link.active {
    color: #4e73df;
    border-bottom: 3px solid #4e73df;
    background: transparent;
}

.submit-btn {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(78, 115, 223, 0.4);
}

.preview-card {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.preview-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.required-star {
    color: #ff6b6b;
}

@media (max-width: 768px) {
    .upload-card {
        padding: 1.5rem;
    }
    
    .form-section {
        padding: 1rem;
    }
}
</style>

<div class="upload-container">
    <div class="container">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="text-primary fw-bold">
                            <i class="fas fa-cloud-upload-alt me-2"></i>Upload New Book
                        </h2>
                        <p class="text-muted">Add a new book to your eBook publishing system</p>
                    </div>
                    <a href="manage_books.php" class="btn btn-outline-primary">
                        <i class="fas fa-list me-1"></i> View All Books
                    </a>
                </div>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="upload-card">
            <form action="insert_book.php" method="POST" enctype="multipart/form-data" id="bookUploadForm">
                
                <!-- Form Tabs -->
                <ul class="nav form-tabs" id="bookTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button">
                            <i class="fas fa-info-circle me-1"></i> Basic Info
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="format-tab" data-bs-toggle="tab" data-bs-target="#format" type="button">
                            <i class="fas fa-file-alt me-1"></i> Format & Pricing
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button">
                            <i class="fas fa-upload me-1"></i> Upload Files
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="bookTabsContent">
                    
                    <!-- Tab 1: Basic Information -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel">
                        <div class="form-section">
                            <h5><i class="fas fa-book"></i> Book Details</h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Book Title <span class="required-star">*</span></label>
                                    <input type="text" name="title" class="form-control" required 
                                           placeholder="Enter book title">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Author Name <span class="required-star">*</span></label>
                                    <input type="text" name="author" class="form-control" required 
                                           placeholder="Enter author name">
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Main Category <span class="required-star">*</span></label>
                                    <select name="category_id" class="form-select" required 
                                            onchange="loadSubcategories(this.value)">
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        $cat = mysqli_query($con, "SELECT * FROM categories ORDER BY category_name ASC");
                                        while($c = mysqli_fetch_assoc($cat)){
                                            echo "<option value='{$c['id']}'>{$c['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label class="form-label">Subcategory <span class="required-star">*</span></label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-select" required>
                                        <option value="">-- Select Subcategory --</option>
                                        <?php
                                        $sub = mysqli_query($con, "SELECT * FROM subcategories ORDER BY subcategory_name ASC");
                                        while($s = mysqli_fetch_assoc($sub)){
                                            echo "<option value='{$s['id']}' data-category='{$s['category_id']}'>{$s['subcategory_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <label class="form-label">Book Description</label>
                                    <textarea name="description" class="form-control" rows="4" 
                                              placeholder="Enter book description..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 2: Format & Pricing -->
                    <div class="tab-pane fade" id="format" role="tabpanel">
                        <div class="form-section">
                            <h5><i class="fas fa-cogs"></i> Book Format & Pricing</h5>
                            
                            <!-- Format Type Selection -->
                            <div class="mb-4">
                                <label class="form-label mb-3">Select Book Format <span class="required-star">*</span></label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="format-option-card" onclick="selectFormat('HARDCOPY')" id="hardcopyCard">
                                            <div class="format-icon hardcopy">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <h6>Hard Copy</h6>
                                            <p class="text-muted small">Physical printed book</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="format-option-card" onclick="selectFormat('PDF')" id="pdfCard">
                                            <div class="format-icon pdf">
                                                <i class="fas fa-file-pdf"></i>
                                            </div>
                                            <h6>PDF eBook</h6>
                                            <p class="text-muted small">Digital PDF version</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="format-option-card" onclick="selectFormat('CD')" id="cdCard">
                                            <div class="format-icon cd">
                                                <i class="fas fa-compact-disc"></i>
                                            </div>
                                            <h6>CD Version</h6>
                                            <p class="text-muted small">Digital copy on CD</p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="format_type" id="format_type" value="HARDCOPY" required>
                            </div>
                            
                            <!-- Pricing Section -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Base Price (Rs) <span class="required-star">*</span></label>
                                    <div class="price-input-group">
                                        <div class="input-group">
                                            <span class="input-group-text">Rs</span>
                                            <input type="number" name="price" class="form-control" 
                                                   placeholder="0" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- CD Price (Only for CD format) -->
                                <div class="col-md-6" id="cdPriceSection" style="display: none;">
                                    <label class="form-label">CD Price (Rs)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs</span>
                                        <input type="number" name="cd_price" class="form-control" 
                                               placeholder="0" min="0" step="0.01">
                                    </div>
                                </div>
                                
                                <!-- Subscription (Only for PDF format) -->
                                <div class="col-md-6" id="subscriptionSection" style="display: none;">
                                    <label class="form-label">Subscription Duration (Months)</label>
                                    <select name="subscription_duration" class="form-select">
                                        <option value="0">No subscription</option>
                                        <option value="1">1 Month</option>
                                        <option value="3">3 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">12 Months</option>
                                    </select>
                                </div>
                                
                                <!-- Physical Book Details -->
                                <div class="col-md-6" id="physicalSection">
                                    <label class="form-label">Weight (kg) - For Shipping</label>
                                    <input type="number" name="weight" class="form-control" 
                                           placeholder="0.00" min="0" step="0.01">
                                </div>
                                
                                <div class="col-md-6" id="deliverySection">
                                    <label class="form-label">Delivery Charges (Rs)</label>
                                    <input type="number" name="delivery_charges" class="form-control" 
                                           placeholder="0" min="0" step="0.01">
                                </div>
                            </div>
                            
                            <!-- Additional Options -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="form-label">CD Availability</label>
                                    <select name="cd_available" class="form-select">
                                        <option value="No">Not Available</option>
                                        <option value="Yes">Available</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="form-label">Additional Options</label>
                                        <div class="switch-label">
                                            <label class="switch">
                                                <input type="checkbox" name="is_free_for_members" value="1">
                                                <span class="slider"></span>
                                            </label>
                                            <span>Free for Registered Members</span>
                                        </div>
                                        
                                        <div class="switch-label">
                                            <label class="switch">
                                                <input type="checkbox" name="is_competition_winner" value="1">
                                                <span class="slider"></span>
                                            </label>
                                            <span>Competition Winner Book</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab 3: File Uploads -->
                    <div class="tab-pane fade" id="files" role="tabpanel">
                        <div class="form-section">
                            <h5><i class="fas fa-file-upload"></i> Upload Files</h5>
                            
                            <!-- Cover Image Upload -->
                            <div class="mb-4">
                                <label class="form-label">Cover Image <span class="required-star">*</span></label>
                                <div class="file-upload-area" onclick="document.getElementById('cover_image').click()">
                                    <i class="fas fa-image"></i>
                                    <h5>Click to upload cover image</h5>
                                    <p class="text-muted">JPG, PNG, or WebP • Max 5MB</p>
                                    <div id="coverPreview" class="mt-3"></div>
                                </div>
                                <input type="file" name="cover_image" id="cover_image" class="d-none" 
                                       accept="image/*" onchange="previewImage(this, 'coverPreview')">
                            </div>
                            
                            <!-- PDF File Upload (Conditional) -->
                            <div class="mb-4" id="pdfUploadSection" style="display: none;">
                                <label class="form-label">PDF eBook File</label>
                                <div class="file-upload-area" onclick="document.getElementById('pdf_file').click()">
                                    <i class="fas fa-file-pdf"></i>
                                    <h5>Click to upload PDF file</h5>
                                    <p class="text-muted">PDF only • Max 50MB</p>
                                    <div id="pdfPreview" class="mt-3"></div>
                                </div>
                                <input type="file" name="pdf_file" id="pdf_file" class="d-none" 
                                       accept=".pdf" onchange="previewFile(this, 'pdfPreview', 'PDF')">
                            </div>
                            
                            <!-- Soft Copy Upload -->
                            <div class="mb-4">
                                <label class="form-label">Soft Copy File (Optional)</label>
                                <div class="file-upload-area" onclick="document.getElementById('soft_copy_file').click()">
                                    <i class="fas fa-file-word"></i>
                                    <h5>Click to upload soft copy</h5>
                                    <p class="text-muted">DOCX, EPUB, or TXT • Max 10MB</p>
                                    <div id="softCopyPreview" class="mt-3"></div>
                                </div>
                                <input type="file" name="soft_copy_file" id="soft_copy_file" class="d-none" 
                                       accept=".doc,.docx,.epub,.txt" onchange="previewFile(this, 'softCopyPreview', 'Document')">
                            </div>
                            
                            <!-- File Summary -->
                            <div class="preview-card">
                                <h6><i class="fas fa-clipboard-list me-2"></i>File Summary</h6>
                                <div id="fileSummary">
                                    <p class="text-muted mb-0">No files selected yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                    <div>
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="fas fa-redo me-1"></i> Reset Form
                        </button>
                    </div>
                    <div>
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save me-2"></i> Save Book
                        </button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script>
// JavaScript Functions
function loadSubcategories(categoryId) {
    const subcategorySelect = document.getElementById('subcategory_id');
    const options = subcategorySelect.querySelectorAll('option');
    
    // Reset and show all options
    options.forEach(option => {
        if(option.value === "") {
            option.style.display = 'block';
        } else {
            const dataCategory = option.getAttribute('data-category');
            if(dataCategory === categoryId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        }
    });
    
    // Reset selection
    subcategorySelect.value = "";
}

function selectFormat(format) {
    // Update active card
    document.querySelectorAll('.format-option-card').forEach(card => {
        card.classList.remove('active');
    });
    
    if(format === 'HARDCOPY') {
        document.getElementById('hardcopyCard').classList.add('active');
        document.getElementById('physicalSection').style.display = 'block';
        document.getElementById('deliverySection').style.display = 'block';
        document.getElementById('pdfUploadSection').style.display = 'none';
        document.getElementById('subscriptionSection').style.display = 'none';
        document.getElementById('cdPriceSection').style.display = 'none';
    } else if(format === 'PDF') {
        document.getElementById('pdfCard').classList.add('active');
        document.getElementById('pdfUploadSection').style.display = 'block';
        document.getElementById('subscriptionSection').style.display = 'block';
        document.getElementById('physicalSection').style.display = 'none';
        document.getElementById('deliverySection').style.display = 'none';
        document.getElementById('cdPriceSection').style.display = 'none';
    } else if(format === 'CD') {
        document.getElementById('cdCard').classList.add('active');
        document.getElementById('cdPriceSection').style.display = 'block';
        document.getElementById('physicalSection').style.display = 'block';
        document.getElementById('deliverySection').style.display = 'block';
        document.getElementById('pdfUploadSection').style.display = 'none';
        document.getElementById('subscriptionSection').style.display = 'none';
    }
    
    // Update hidden input
    document.getElementById('format_type').value = format;
}

function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="preview-image" alt="Preview">
                <p class="mt-2">${input.files[0].name} (${formatBytes(input.files[0].size)})</p>
            `;
            updateFileSummary();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewFile(input, previewId, fileType) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        preview.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-file me-2"></i>
                ${fileType} File: ${input.files[0].name}<br>
                <small>Size: ${formatBytes(input.files[0].size)}</small>
            </div>
        `;
        updateFileSummary();
    }
}

function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function updateFileSummary() {
    const summary = document.getElementById('fileSummary');
    const files = [];
    
    const coverFile = document.getElementById('cover_image').files[0];
    const pdfFile = document.getElementById('pdf_file').files[0];
    const softFile = document.getElementById('soft_copy_file').files[0];
    
    if(coverFile) files.push(`Cover: ${coverFile.name} (${formatBytes(coverFile.size)})`);
    if(pdfFile) files.push(`PDF: ${pdfFile.name} (${formatBytes(pdfFile.size)})`);
    if(softFile) files.push(`Soft Copy: ${softFile.name} (${formatBytes(softFile.size)})`);
    
    if(files.length > 0) {
        summary.innerHTML = files.map(file => `<div class="mb-1"><i class="fas fa-check text-success me-2"></i>${file}</div>`).join('');
    } else {
        summary.innerHTML = '<p class="text-muted mb-0">No files selected yet</p>';
    }
}

function resetForm() {
    if(confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
        document.getElementById('bookUploadForm').reset();
        document.querySelectorAll('.format-option-card').forEach(card => card.classList.remove('active'));
        document.getElementById('hardcopyCard').classList.add('active');
        document.getElementById('format_type').value = 'HARDCOPY';
        document.querySelectorAll('[id$="Preview"]').forEach(el => el.innerHTML = '');
        document.getElementById('fileSummary').innerHTML = '<p class="text-muted mb-0">No files selected yet</p>';
        
        // Reset tab to first
        document.getElementById('basic-tab').click();
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set default format
    selectFormat('HARDCOPY');
    
    // Form validation
    document.getElementById('bookUploadForm').addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value;
        const format = document.getElementById('format_type').value;
        const coverFile = document.getElementById('cover_image').files[0];
        
        if(!title.trim()) {
            e.preventDefault();
            alert('Please enter book title');
            document.getElementById('basic-tab').click();
            return;
        }
        
        if(!coverFile) {
            e.preventDefault();
            alert('Please upload a cover image');
            document.getElementById('files-tab').click();
            return;
        }
        
        if(format === 'PDF') {
            const pdfFile = document.getElementById('pdf_file').files[0];
            if(!pdfFile) {
                e.preventDefault();
                if(confirm('PDF format selected but no PDF file uploaded. Continue anyway?')) {
                    return;
                } else {
                    document.getElementById('files-tab').click();
                    return;
                }
            }
        }
        
        // Show loading
        const submitBtn = document.querySelector('.submit-btn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Uploading...';
        submitBtn.disabled = true;
        
        // Re-enable after 5 seconds in case of error
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });
});
</script>

<?php include('includes/footer.php'); ?>