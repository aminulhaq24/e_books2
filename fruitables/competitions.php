<?php
include('includes/nav.php'); // DB connection

// Fetch competitions by status
$ongoing = mysqli_query($con, "SELECT * FROM competitions WHERE start_datetime <= NOW() AND end_datetime >= NOW() ORDER BY start_datetime DESC");
$upcoming = mysqli_query($con, "SELECT * FROM competitions WHERE start_datetime > NOW() ORDER BY start_datetime ASC");
$ended   = mysqli_query($con, "SELECT * FROM competitions WHERE end_datetime < NOW() ORDER BY end_datetime DESC");
?>




<!-- <div class="comp-banner">

    <img src="img/comp-banner.jpg" class="img-fluid comp-banner" alt="">
</div> -->

<div class="container mt-0 comp">
<div class="competition-banner" style="
    width: 100%;
    height: 50vh;
    background: url('img/comp-banner.jpg') center/cover no-repeat;
    display: flex;
    justify-content: center;
    align-items: center;
"></div>
    <h1 class="mb-4 mt-5">Our Competitions</h1>

    <!-- Tabs -->
    <ul class="nav nav-pills mb-4" id="competitionTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="ongoing-tab" data-bs-toggle="pill" data-bs-target="#ongoing" type="button">Ongoing</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="upcoming-tab" data-bs-toggle="pill" data-bs-target="#upcoming" type="button">Upcoming</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="ended-tab" data-bs-toggle="pill" data-bs-target="#ended" type="button">Ended</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Ongoing -->
        <div class="tab-pane fade show active" id="ongoing">
            <div class="row">
            <?php if(mysqli_num_rows($ongoing) > 0) {
                while($comp = mysqli_fetch_assoc($ongoing)) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="competition-card">
                            
                            <div class="card-body">
                                <h5><?= $comp['title'] ?></h5>
                                <p><?= $comp['description'] ?></p>
                                <p><strong>Start:</strong> <?= date("d M Y", strtotime($comp['start_datetime'])) ?></p>
                                <p><strong>End:</strong> <?= date("d M Y", strtotime($comp['end_datetime'])) ?></p>
                                <a href="competition_details.php?id=<?= $comp['id'] ?>" class="btn btn-success w-100">Join Now</a>
                            </div>
                        </div>
                    </div>
            <?php } } else { echo "<p class='text-muted'>No ongoing competitions.</p>"; } ?>
            </div>
        </div>

        <!-- Upcoming -->
        <div class="tab-pane fade" id="upcoming">
            <div class="row">
            <?php if(mysqli_num_rows($upcoming) > 0) {
                while($comp = mysqli_fetch_assoc($upcoming)) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="competition-card">
                            <img src="uploads/<?= $comp['image'] ?>" alt="<?= $comp['title'] ?>">
                            <div class="card-body">
                                <h5><?= $comp['title'] ?></h5>
                                <p><?= $comp['description'] ?></p>
                                <p><strong>Start:</strong> <?= date("d M Y", strtotime($comp['start_date'])) ?></p>
                                <p><strong>End:</strong> <?= date("d M Y", strtotime($comp['end_date'])) ?></p>
                                <span class="badge bg-warning text-dark w-100">Upcoming</span>
                            </div>
                        </div>
                    </div>
            <?php } } else { echo "<p class='text-muted'>No upcoming competitions.</p>"; } ?>
            </div>
        </div>

        <!-- Ended -->
        <div class="tab-pane fade" id="ended">
            <div class="row">
            <?php if(mysqli_num_rows($ended) > 0) {
                while($comp = mysqli_fetch_assoc($ended)) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="competition-card">
                            <img src="uploads/<?= $comp['image'] ?>" alt="<?= $comp['title'] ?>">
                            <div class="card-body">
                                <h5><?= $comp['title'] ?></h5>
                                <p><?= $comp['description'] ?></p>
                                <p><strong>Start:</strong> <?= date("d M Y", strtotime($comp['start_date'])) ?></p>
                                <p><strong>End:</strong> <?= date("d M Y", strtotime($comp['end_date'])) ?></p>
                                <span class="badge bg-danger w-100">Ended</span>
                                <a href="competition_winners.php?id=<?= $comp['id'] ?>" class="btn btn-primary w-100 mt-2">View Winners</a>
                            </div>
                        </div>
                    </div>
            <?php } } else { echo "<p class='text-muted'>No ended competitions.</p>"; } ?>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>