<?php
include('includes/nav.php');

// Fetch all competitions
$sql = "SELECT * FROM competitions ORDER BY id DESC";
$res = mysqli_query($con, $sql);
?>

<div class="container-fluid pt-4 px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary mb-0"><i class="fa fa-trophy"></i> Competitions</h3>

        <button class="btn btn-primary shadow-sm" data-toggle="modal" data-target="#addCompetitionModal">
            + Add New Competition
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Prize</th>
                    <th>Add Rules</th>
                    <th>Status</th>
                    <th width="15%">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                if(mysqli_num_rows($res) == 0){
                    echo "<tr><td colspan='7' class='text-center text-muted'>No competitions found.</td></tr>";
                } else {
                    while($row = mysqli_fetch_assoc($res)){

                        $now = date("Y-m-d H:i:s");
                        $start = $row['start_datetime'];
                        $end   = $row['end_datetime'];

                // STATUS LOGIC
                if ($now < $start) {
                    $status = "<span class='badge bg-primary'>Upcoming</span>";
                } 
                elseif ($now >= $start && $now <= $end) {
                    $status = "<span class='badge bg-success'>Running</span>";
                } 
                else {
                    $status = "<span class='badge bg-danger'>Ended</span>";
                }
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['type'] ?></td>
                    <td><?= date("d M Y h:i A", strtotime($row['start_datetime'])) ?></td>
                    <td><?= date("d M Y h:i A", strtotime($row['end_datetime'])) ?></td>
                    <td>
                        1st: <?= $row['first_prize'] ?><br>
                        2nd: <?= $row['second_prize'] ?><br>
                        3rd: <?= $row['third_prize'] ?>
                    </td>
                    <td>
                        <a href="manage_rules.php?competition_id=<?= $row['id'] ?>" class="btn btn-sm btn-info">
                            Manage Rules
                        </a>
                    </td>

                    <td><?= $status ?></td>


                    <td>
                        <a href="#" class="btn btn-primary btn-sm editBtn" data-id="<?= $row['id']; ?>"
                            data-title="<?= $row['title']; ?>" data-type="<?= $row['type']; ?>"
                            data-start="<?= $row['start_datetime']; ?>" data-end="<?= $row['end_datetime']; ?>"
                            data-desc="<?= htmlspecialchars($row['description']); ?>"
                            data-first="<?= $row['first_prize']; ?>" data-second="<?= $row['second_prize']; ?>"
                            data-third="<?= $row['third_prize']; ?>" data-toggle="modal"
                            data-target="#editCompetitionModal">
                            ✏️ Edit
                        </a>


                        <a href="delete_competition.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this competition?')">🗑 Delete</a>
                    </td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ADD COMPETITION MODAL -->

<div class="modal fade" id="addCompetitionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form action="insert_competition.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Competition</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Competition Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Competition Type</label>
                        <select name="type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Essay">Essay</option>
                            <option value="Poetry">Poetry</option>
                            <option value="Story Writing">Story Writing</option>
                            <option value="Quiz">Quiz</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Start Date & Time</label>
                        <input type="datetime-local" name="start_datetime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>End Date & Time</label>
                        <input type="datetime-local" name="end_datetime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Prize</label>
                        <input type="text" name="first_prize" class="form-control"
                            placeholder="e.g. 1st Prize: Rs 5000">
                    </div>

                    <div class="form-group">
                        <label>2nd Prize</label>
                        <input type="text" name="second_prize" class="form-control" placeholder="e.g. Rs. 3000">
                    </div>

                    <div class="form-group">
                        <label>3rd Prize</label>
                        <input type="text" name="third_prize" class="form-control" placeholder="e.g. Rs. 1500">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="4" class="form-control"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Add Competition</button>
                </div>
            </form>

        </div>
    </div>
</div>


<!-- Edit Competition Modal -->

<div class="modal fade" id="editCompetitionModal" tabindex="-1" role="dialog"
    aria-labelledby="editCompetitionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="update_competition.php" method="POST">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="editCompetitionModalLabel">Edit Competition</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" id="edit_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="Essay" <?= (($row['type'] ?? '') == 'Essay' ? 'selected' : '') ?>>Essay
                            </option>
                            <option value="Poetry" <?= (($row['type'] ?? '') == 'Poetry' ? 'selected' : '') ?>>Poetry
                            </option>
                            <option value="Story Writing"
                                <?= (($row['type'] ?? '') == 'Story Writing' ? 'selected' : '') ?>>Story Writing
                            </option>
                            <option value="Quiz" <?= (($row['type'] ?? '') == 'Quiz' ? 'selected' : '') ?>>Quiz</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Start Date & Time</label>
                        <input type="datetime-local" name="start_datetime" id="edit_start" class="form-control"
                            required>
                    </div>

                    <div class="form-group">
                        <label>End Date & Time</label>
                        <input type="datetime-local" name="end_datetime" id="edit_end" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" id="edit_desc" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Prizes</label>
                        <input type="text" name="first_prize" id="edit_first" class="form-control mb-2"
                            placeholder="1st Prize">
                        <input type="text" name="second_prize" id="edit_second" class="form-control mb-2"
                            placeholder="2nd Prize">
                        <input type="text" name="third_prize" id="edit_third" class="form-control"
                            placeholder="3rd Prize">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Update Competition</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>

<script>
$(document).on("click", ".editBtn", function() {
    $("#edit_id").val($(this).data("id"));
    $("#edit_title").val($(this).data("title"));
    $("#edit_type").val($(this).data("type"));
    $("#edit_start").val($(this).data("start"));
    $("#edit_end").val($(this).data("end"));
    $("#edit_desc").val($(this).data("desc"));
    $("#edit_first").val($(this).data("first"));
    $("#edit_second").val($(this).data("second"));
    $("#edit_third").val($(this).data("third"));
});
</script>