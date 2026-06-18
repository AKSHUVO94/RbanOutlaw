<?php 
include('header.php'); 

// High-End Men's Urban Lookbook Imagery
$slides = [
    [
        "title" => "Modern Men's Streetwear",
        "subtitle" => "Premium structures built around raw comfort and perfect masculine draping.",
        "img" => "https://static.vecteezy.com/system/resources/thumbnails/071/426/575/small/young-man-in-stylish-streetwear-poses-in-urban-alley-during-a-cool-afternoon-photo.jpg",
        "link_text" => "Explore Denim"
    ],
    [
        "title" => "Feel Good, Look Bold",
        "subtitle" => "Heavyweight fabrics engineered to elevate your daily routine.",
        "img" => "https://encrypted-tbn2.gstatic.com/licensed-image?q=tbn:ANd9GcQoG57LmzHjgoTtpbeTWuz9tnmILMTNb6IBfMKBJnBRZvETID2uh6zCOdZODlxDJ_6akmZ2IeXxjGBU-os",
        "link_text" => "View Outerwear"
    ]
];

// Expanded Curated Premium Men's Inventory
$products = [
    [
        "title" => "Outlaw Heavyweight Men's Hoodie",
        "price" => 110.00,
        "desc" => "450GSM drop-shoulder loopback luxury terry cotton.",
        "img" => "https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=600&q=80"
    ],
    [
        "title" => "Feel Good Men's Flight Jacket",
        "price" => 185.00,
        "desc" => "Water-resistant matte finish shell with utility zippers.",
        "img" => "https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=600&q=80"
    ],
    [
        "title" => "Rban Premium Men's Cargo Denim",
        "price" => 140.00,
        "desc" => "Relaxed taper fit, Japanese raw selvedge edge design.",
        "img" => "https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=600&q=80"
    ],
    [
        "title" => "Outlaw Technical Men's Overcoat",
        "price" => 220.00,
        "desc" => "Windbreaker shielding layer with subtle modular tactical storage straps.",
        "img" => "https://images.unsplash.com/photo-1544923246-77307dd654cb?auto=format&fit=crop&w=600&q=80"
    ],
    [
        "title" => "Feel Good Box-Fit Heavy Tee",
        "price" => 55.00,
        "desc" => "Combed compact luxury yarn knit tee with side split split-seam hems.",
        "img" => "https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=600&q=80"
    ],
    [
        "title" => "Rban Distressed Ribbed Beanie",
        "price" => 40.00,
        "desc" => "Four-stitch structuring made with premium merino wool blend insulation.",
        "img" => "https://images.unsplash.com/photo-1576871337632-b9aef4c17ab9?auto=format&fit=crop&w=600&q=80"
    ]
];
?>

<!-- ================= SLIDER SPECIFIC STYLES ================= -->
<style>
    .slider-viewport {
        width: 100%;
        height: 75vh;
        position: relative;
        overflow: hidden;
    }
    .slider-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    }
    .slide {
        min-width: 100%;
        height: 100%;
        position: relative;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        padding: 4rem 6rem;
    }
    .slide::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(90deg, rgba(13,13,13,0.9) 0%, rgba(13,13,13,0.4) 100%);
    }
    .slide-content { position: relative; z-index: 2; max-width: 650px; }
    .slide-title { font-size: 3.8rem; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 1rem; line-height: 1.05; }
    .slide-subtitle { color: var(--text-muted); font-size: 1.15rem; margin-bottom: 2.5rem; }
    .slider-nav { position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }
    .slider-dot { width: 24px; height: 2px; background: rgba(255, 255, 255, 0.2); cursor: pointer; transition: background 0.3s; }
    .slider-dot.active { background: var(--accent); }
</style>

<!-- ================= AUTOMATED UPPER SECTION ================= -->
<section class="slider-viewport">
    <div class="slider-wrapper" id="sliderWrapper">
        <?php foreach ($slides as $slide): ?>
            <div class="slide" style="background-image: url('<?php echo $slide['img']; ?>');">
                <div class="slide-content">
                    <p style="color: var(--accent); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 0.75rem; font-weight: 600;">Exclusively for Men</p>
                    <h2 class="slide-title"><?php echo $slide['title']; ?></h2>
                    <p class="slide-subtitle"><?php echo $slide['subtitle']; ?></p>
                    <a href="#catalog" class="btn-primary" style="display: inline-block; width: auto; padding: 1.2rem 2.5rem; text-decoration: none;">
                        <?php echo $slide['link_text']; ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="slider-nav" id="sliderNav">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $index; ?>)"></div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ================= PRODUCT CATALOG SECTION ================= -->
<main class="container" id="catalog">
    <div style="margin-bottom: 3rem; margin-top: 1rem;">
        <p style="color: var(--accent); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 3px; margin-bottom: 0.5rem;">Men's Premium Essentials</p>
        <h1 style="font-size: 2.5rem; font-weight: 800;">Curated Drop 01</h1>
    </div>

    <!-- This grid handles multiple items smoothly via the CSS definitions created in your main file -->
    <div class="grid">
        <?php foreach ($products as $item): ?>
            <div class="card">
                <img src="<?php echo $item['img']; ?>" alt="<?php echo $item['title']; ?>" class="card-img">
                <div class="card-body">
                    <h3 style="margin-bottom: 0.25rem; font-size: 1.2rem;"><?php echo $item['title']; ?></h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;"><?php echo $item['desc']; ?></p>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="price">$<?php echo number_format($item['price'], 2); ?></span>
                        <button class="btn-primary" style="width: auto; padding: 0.6rem 1.5rem; font-size: 0.8rem;">Add To Cart</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
    let currentSlide = 0;
    const totalSlides = <?php echo count($slides); ?>;
    const wrapper = document.getElementById('sliderWrapper');
    const dots = document.querySelectorAll('.slider-dot');
    let autoCycle = setInterval(nextSlide, 4000);

    function updateSlider() {
        wrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, idx) => { dot.classList.toggle('active', idx === currentSlide); });
    }
    function nextSlide() { currentSlide = (currentSlide + 1) % totalSlides; updateSlider(); }
    function goToSlide(index) { clearInterval(autoCycle); currentSlide = index; updateSlider(); autoCycle = setInterval(nextSlide, 4000); }
</script>

<?php include('footer.php'); ?>