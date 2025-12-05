<?php include 'includes/header.php'; ?>

<section class="hero text-center py-5 bg-primary text-white">
    <h1>Welcome to Spice Isle Tours</h1>
    <p>Explore the best of Grenada with our guided tours</p>
    <a href="tours.php" class="btn btn-light btn-lg">View Tours</a>
</section>

<section class="featured-tours py-5 container">
    <h2 class="mb-4">Featured Tours</h2>
    <div class="row">
        <?php
        include 'includes/db_connect.php';
        $result = $conn->query("SELECT * FROM tours ORDER BY created_at DESC LIMIT 3");
        while($tour = $result->fetch_assoc()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card tour-card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($tour['title']) ?></h5>
                    <p class="card-text"><?= $tour['duration'] ?> hours - $<?= number_format($tour['fee'],2) ?></p>
                    <a href="tour_details.php?id=<?= $tour['id'] ?>" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- === JavaScript Magic === -->
<script>
// Fade-in animation for hero section
document.addEventListener("DOMContentLoaded", () => {
    const hero = document.querySelector(".hero");
    hero.style.opacity = 0;
    hero.style.transition = "opacity 1.5s ease-in-out";
    setTimeout(() => {
        hero.style.opacity = 1;
    }, 300);
});

// Subtle card hover effect using JS class toggles
const tourCards = document.querySelectorAll(".tour-card");
tourCards.forEach(card => {
    card.addEventListener("mouseenter", () => {
        card.style.transform = "scale(1.05)";
        card.style.transition = "transform 0.3s ease";
        card.style.boxShadow = "0 8px 20px rgba(0,0,0,0.2)";
    });
    card.addEventListener("mouseleave", () => {
        card.style.transform = "scale(1)";
        card.style.boxShadow = "0 2px 6px rgba(0,0,0,0.1)";
    });
});

// Scroll-to-top button
const scrollBtn = document.createElement("button");
scrollBtn.textContent = "↑";
scrollBtn.style.position = "fixed";
scrollBtn.style.bottom = "30px";
scrollBtn.style.right = "30px";
scrollBtn.style.padding = "10px 15px";
scrollBtn.style.fontSize = "20px";
scrollBtn.style.border = "none";
scrollBtn.style.borderRadius = "50%";
scrollBtn.style.backgroundColor = "#007bff";
scrollBtn.style.color = "white";
scrollBtn.style.cursor = "pointer";
scrollBtn.style.display = "none";
scrollBtn.style.boxShadow = "0 4px 8px rgba(0,0,0,0.2)";
document.body.appendChild(scrollBtn);

window.addEventListener("scroll", () => {
    scrollBtn.style.display = window.scrollY > 300 ? "block" : "none";
});

scrollBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
});
</script>
