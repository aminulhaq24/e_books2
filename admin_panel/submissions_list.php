<?php
include('includes/nav.php');

// Fetch submissions + competition + user
$sql = "
SELECT s.*, 
c.title AS comp_title,
u.name AS user_name
FROM competition_submissions s
JOIN competitions c ON s.competition_id = c.id
JOIN users u ON s.user_id = u.id
ORDER BY s.id DESC
";

$res = mysqli_query($con, $sql);
?>

<div class="container mt-4">
    <h3 class="mb-3">Competition Submissions</h3>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Competition</th>
                    <th>File</th>
                    <th>Submitted At</th>
                    <th>Status</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                <?php 
                if(mysqli_num_rows($res) == 0){
                    echo "<tr><td colspan='7' class='text-center text-muted'>No submissions found.</td></tr>";
                } 
                else {
                    while($row = mysqli_fetch_assoc($res)){

                        // STATUS BADGES
                        $status = $row['status'];
                        if($status == "received")   $badge = "<span class='badge bg-secondary'>Received</span>";
                        if($status == "shortlisted") $badge = "<span class='badge bg-warning text-dark'>Shortlisted</span>";
                        if($status == "winner")      $badge = "<span class='badge bg-success'>Winner</span>";
                        if($status == "rejected")    $badge = "<span class='badge bg-danger'>Rejected</span>";
                        ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['user_name'] ?></td>
                    <td><?= $row['comp_title'] ?></td>
                    
                    <td>
                        <a href="../uploads/competitions/<?= $row['filename'] ?>" 
                        class="btn btn-sm btn-info" download>
                        Download
                        </a>
                    </td>
                    
                    <td><?= date("d M Y h:i A", strtotime($row['submitted_at'])) ?></td>
                    <td><?= $badge ?></td>
                    
                    <td>
                        <a href="#" class="btn btn-warning btn-sm statusBtn"
                           data-id="<?= $row['id'] ?>"
                           data-status="<?= $row['status'] ?>">
                           Change Status
                        </a>

                        <a href="delete_submission.php?id=<?= $row['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this submission?')">
                        Delete
                    </a>
                </td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- STATUS UPDATE MODAL -->

<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="update_submission_status.php" method="POST" class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Update Submission Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="id" id="sub_id">

        <div class="mb-3">
          <label>Status</label>
          <select name="status" id="sub_status" class="form-control">
            <option value="received">Received</option>
            <option value="shortlisted">Shortlisted</option>
            <option value="winner">Winner</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-primary">Update</button>
      </div>

    </form>
  </div>
</div>


<?php
include('includes/footer.php');

?>

<script>
document.querySelectorAll(".statusBtn").forEach(btn => {
    btn.addEventListener("click", function(){
        document.getElementById("sub_id").value = this.dataset.id;
        document.getElementById("sub_status").value = this.dataset.status;
        var myModal = new bootstrap.Modal(document.getElementById("statusModal"));
        myModal.show();
    });
});
</script>
