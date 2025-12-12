<?php

include("includes/nav.php");

// Competition ID from URL
if(!isset($_GET['id'])){
    echo "<h2 class='text-center mt-5'>Invalid Competition</h2>";
    exit;
}

$id = intval($_GET['id']);

// Fetch Competition
$q = "SELECT * FROM competitions WHERE id = $id";
$run = mysqli_query($con, $q);

if(mysqli_num_rows($run) == 0){
    echo "<h2 class='text-center mt-5'>Competition Not Found</h2>";
    exit;
}

$comp = mysqli_fetch_assoc($run);

// Status logic
$today = date("Y-m-d");

if($today < $comp['start_datetime']){
    $status = "Upcoming";
    $badge = "warning";
}
else if($today > $comp['end_datetime']){
    $status = "Ended";
    $badge = "danger";
}
else{
    $status = "Ongoing";
    $badge = "success";
}
?>


<!-- Banner Section -->
<div class="container-fluid p-0">
    <div class="competition-banner" 
         style="background: url('img/comp-banner.jpg') center/cover no-repeat;
                height: 50vh;">
        
        <div class="banner-overlay d-flex justify-content-center align-items-center"
            style="background: rgba(0,0,0,0.4); height:100%;">

            <h1 class="text-white display-4"><?= $comp['title'] ?></h1>

        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">

        <div class="col-lg-8">
            <h2><?= $comp['title'] ?></h2>

            <!-- Status Badge -->
            <span class="badge bg-<?= $badge ?> px-3 py-2">
                <?= $status ?>
            </span>

            <p class="mt-3">
                <strong>Start Date:</strong> <?= $comp['start_datetime'] ?><br>
                <strong>End Date:</strong> <?= $comp['end_datetime'] ?>
            </p>

            <h4>Description</h4>
            <p><?= nl2br($comp['description']) ?></p>

            <h4>Rules</h4>
            <p><?= nl2br($comp['rules']) ?></p>

            <a href="competition-join.php?id=<?= $comp['id'] ?>" 
               class="btn btn-primary rounded-pill px-4 py-2 mt-3">
               Join Now
            </a>
        </div>

        <!-- Right Side Image -->
        <div class="col-lg-4">
            <img src="admin_panel/uploads/<?= $comp['image'] ?>" 
                 class="img-fluid rounded shadow">
        </div>

    </div>
</div>



<?php

include("includes/footer.php");

?>