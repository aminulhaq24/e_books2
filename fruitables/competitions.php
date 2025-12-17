<?php
include('includes/nav.php');

?>

    <style>
        .competition-card {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            transition: all 0.3s;
            overflow: hidden;
        }
        .competition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .badge-status {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .prize-badge {
            background: linear-gradient(45deg, #FFD700, #FFA500);
            color: #333;
            font-weight: bold;
        }
        .countdown-timer {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }
        .timer-unit {
            display: inline-block;
            margin: 0 5px;
        }
        .timer-number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
    
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 mb-3">Writing Competitions</h1>
            <p class="lead">Showcase your writing talent and win exciting prizes</p>
        </div>
        
        <!-- Filter Tabs -->
        <ul class="nav nav-tabs mb-4" id="competitionTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#active">Active Competitions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="upcoming-tab" data-bs-toggle="tab" href="#upcoming">Upcoming</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ended-tab" data-bs-toggle="tab" href="#ended">Past Competitions</a>
            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
                <a class="nav-link" id="my-submissions-tab" data-bs-toggle="tab" href="#my-submissions">My Submissions</a>
            </li>
            <?php endif; ?>
        </ul>
        
        <div class="tab-content" id="competitionTabContent">
            
            <!-- Active Competitions -->
            <div class="tab-pane fade show active" id="active">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM competitions WHERE status = 'active' AND end_date >= CURDATE() ORDER BY end_date ASC";
                    $result = mysqli_query($con, $sql);
                    
                    if(mysqli_num_rows($result) > 0):
                        while($competition = mysqli_fetch_assoc($result)):
                            // Calculate days remaining
                            $end_date = new DateTime($competition['end_date']);
                            $today = new DateTime();
                            $days_remaining = $today->diff($end_date)->days;
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="competition-card h-100 position-relative">
                            <span class="badge-status bg-success">Active</span>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($competition['title']); ?></h5>
                                <p class="card-text text-muted">
                                    <?php echo substr(htmlspecialchars($competition['description']), 0, 100); ?>...
                                </p>
                                
                                <div class="mb-3">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar me-1"></i>
                                        Ends: <?php echo date('M d, Y', strtotime($competition['end_date'])); ?>
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-users me-1"></i>
                                        Participants: <?php echo $competition['current_participants']; ?> / 
                                        <?php echo $competition['max_participants'] ?: 'Unlimited'; ?>
                                    </small>
                                </div>
                                
                                <div class="countdown-timer mb-3">
                                    <small class="text-muted d-block mb-2">Time Remaining</small>
                                    <div>
                                        <span class="timer-unit">
                                            <div class="timer-number"><?php echo $days_remaining; ?></div>
                                            <small>Days</small>
                                        </span>
                                    </div>
                                </div>
                                
                                <?php if($competition['prize_amount'] > 0): ?>
                                <div class="prize-badge badge mb-3">
                                    <i class="fas fa-trophy me-1"></i>
                                    Prize: $<?php echo number_format($competition['prize_amount'], 2); ?>
                                </div>
                                <?php endif; ?>
                                
                                <div class="d-grid gap-2">
                                    <a href="competition-details.php?id=<?php echo $competition['id']; ?>" 
                                       class="btn btn-primary">
                                        View Details
                                    </a>
                                    <?php if(isset($_SESSION['user_id'])): ?>
                                    <a href="submit-entry.php?competition_id=<?php echo $competition['id']; ?>" 
                                       class="btn btn-outline-primary">
                                        Submit Entry
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-pen-fancy fa-3x text-muted mb-3"></i>
                        <h4>No active competitions at the moment</h4>
                        <p class="text-muted">Check back later for upcoming competitions</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Upcoming Competitions -->
            <div class="tab-pane fade" id="upcoming">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM competitions WHERE status = 'upcoming' ORDER BY start_date ASC";
                    $result = mysqli_query($con, $sql);
                    
                    if(mysqli_num_rows($result) > 0):
                        while($competition = mysqli_fetch_assoc($competition)):
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="competition-card h-100">
                            <span class="badge-status bg-info">Upcoming</span>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($competition['title']); ?></h5>
                                <p class="card-text text-muted">
                                    <?php echo substr(htmlspecialchars($competition['description']), 0, 100); ?>...
                                </p>
                                
                                <div class="mb-3">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-calendar me-1"></i>
                                        Starts: <?php echo date('M d, Y', strtotime($competition['start_date'])); ?>
                                    </small>
                                </div>
                                
                                <div class="alert alert-info">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        Registration opens soon
                                    </small>
                                </div>
                                
                                <a href="competition-details.php?id=<?php echo $competition['id']; ?>" 
                                   class="btn btn-outline-primary w-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                        <h4>No upcoming competitions</h4>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- My Submissions Tab (only for logged in users) -->
            <?php if(isset($_SESSION['user_id'])): ?>
            <div class="tab-pane fade" id="my-submissions">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Submissions</h5>
                        <?php
                        $user_id = $_SESSION['user_id'];
                        $sql = "SELECT cs.*, c.title as competition_title 
                                FROM competition_submissions cs
                                JOIN competitions c ON cs.competition_id = c.id
                                WHERE cs.user_id = '$user_id'
                                ORDER BY cs.submitted_at DESC";
                        $result = mysqli_query($con, $sql);
                        
                        if(mysqli_num_rows($result) > 0):
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Competition</th>
                                        <th>Submission Title</th>
                                        <th>Submitted Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($submission = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($submission['competition_title']); ?></td>
                                        <td><?php echo htmlspecialchars($submission['title']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($submission['submitted_at'])); ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $submission['status'] == 'winner' ? 'success' : 
                                                     ($submission['status'] == 'shortlisted' ? 'warning' : 
                                                     ($submission['status'] == 'rejected' ? 'danger' : 'primary'));
                                            ?>">
                                                <?php echo ucfirst($submission['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="view-submission.php?id=<?php echo $submission['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5>No submissions yet</h5>
                            <p class="text-muted">You haven't submitted to any competitions yet.</p>
                            <a href="#active" class="btn btn-primary" data-bs-toggle="tab">Browse Competitions</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <?php include('includes/footer.php'); ?>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>    -->
    <script>
    // Auto-select active tab based on URL
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        
        if(tab) {
            const tabElement = document.querySelector(`#${tab}-tab`);
            if(tabElement) {
                new bootstrap.Tab(tabElement).show();
            }
        }
    });
    </script>
</body>
</html>