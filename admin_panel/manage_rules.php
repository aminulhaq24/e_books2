<?php
include("includes/nav.php");

if (!isset($_GET['competition_id'])) {
    die("Competition ID not provided");
}

$competition_id = intval($_GET['competition_id']);

// Fetch Competition Title
$cq = mysqli_query($con, "SELECT title FROM competitions WHERE id = $competition_id");
$comp = mysqli_fetch_assoc($cq);
?>

<h2>Manage Rules — <?= $comp['title'] ?></h2>

<button class="btn btn-primary" id="openAddRuleModal">
    Add Rule
</button>



<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Rule</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $rules = mysqli_query($con, "SELECT * FROM competition_rules WHERE competition_id = $competition_id");

        $i = 1;
        while ($rule = mysqli_fetch_assoc($rules)) {
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $rule['rule_text'] ?></td>
            <td>
                <button class="btn btn-warning editRuleBtn" data-id="<?= $rule['id']; ?>"
                    data-rule="<?= htmlspecialchars( $rule['rule_text']); ?>">
                    Edit
                </button>


                <a href="delete_rule.php?id=<?= $rule['id'] ?>&competition_id=<?= $competition_id ?>"
                    class="btn btn-sm btn-danger" onclick="return confirm('Delete this rule?')">
                    Delete
                </a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<!-- ADD RULE MODAL -->
<div class="modal fade" id="addRuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="save_rule.php">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Rule</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                
                <div class="modal-body">
                    <textarea name="rule_text" class="form-control" rows="4" required></textarea>
                    <input type="hidden" name="competition_id" value="<?= $competition_id ?>">
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-primary">Save Rule</button>
                </div>
            </form>
            
        </div>
    </div>
</div>


<!-- EDIT RULE MODAL -->
<div class="modal fade" id="editRuleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form method="POST" action="update_rule.php">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rule</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                        
                </div>

                <div class="modal-body">
                    <textarea id="edit_rule_text" name="rule_text" class="form-control" rows="4" required></textarea>
                    <input type="hidden" id="edit_rule_id" name="rule_id">
                    <input type="hidden" name="competition_id" value="<?= $competition_id ?>">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update Rule</button>
                </div>
            </form>

        </div>
    </div>
</div>




<?php
include('includes/footer.php');
?>

<script>
document.querySelectorAll(".editRuleBtn").forEach(btn => {
    btn.addEventListener("click", function() {

        // Get data from button
        let rule_id = this.getAttribute("data-id");
        let rule_text = this.getAttribute("data-rule");

        // Fill modal fields
        document.getElementById("edit_rule_id").value = rule_id;
        document.getElementById("edit_rule_text").value = rule_text;

        // Show modal
        let editModal = new bootstrap.Modal(document.getElementById("editRuleModal"));
        editModal.show();
    });
});



// add rule
document.getElementById("openAddRuleModal").addEventListener("click", function() {
    var addRuleModal = new bootstrap.Modal(document.getElementById("addRuleModal"));
    addRuleModal.show();
});
</script>