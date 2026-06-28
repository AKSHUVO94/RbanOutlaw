
<?php

include('header.php');

include('db.php'); // Establishes your live database bridge connection



// High-End Men's Urban Lookbook Imagery

$slides = [

[

"title" => "Modern Men's Streetwear",

"subtitle" => "Premium structures built around raw comfort.",

"img" => "https://images.unsplash.com/photo-1509281373149-e957c6296406?auto=format&fit=crop&w=1200&q=80",

"link_text" => "Explore Denim"

],

[

"title" => "Feel Good, Look Bold",

"subtitle" => "Heavyweight fabrics engineered to elevate your daily routine.",

"img" => "https://images.unsplash.com/photo-1511499767150-a48a237f0083?auto=format&fit=crop&w=1200&q=80",

"link_text" => "View Outerwear"

]

];



// FETCH PRODUCTS FROM DYNAMIC DATABASE ENGINE

// Automatically discards 'inactive' elements straight from the SQL query statement layer

$product_query = $conn->query("SELECT * FROM products WHERE status = 'active' ORDER BY id DESC");

$products = [];



if ($product_query && $product_query->num_rows > 0) {

while($row = $product_query->fetch_assoc()) {

$products[] = $row;

}

}

?>



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

transition: transform 0.6s ease-in-out;

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

top:0; left:0; width:100%; height:100%;

background: rgba(0,0,0,0.6);

}

.slide-content { position: relative; z-index: 2; max-width: 650px; }

.slide-title { font-size: 3.5rem; font-weight: 900; margin-bottom: 1rem; color: #fff; }

.slide-subtitle { color: #ccc; font-size: 1.1rem; margin-bottom: 2rem; }


.slider-nav { position: absolute; bottom: 2rem; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }

.slider-dot { width: 24px; height: 3px; background: rgba(255, 255, 255, 0.3); cursor: pointer; }

.slider-dot.active { background: #fff; }



/* FIXED STICKY AUTO-HIDE NAV HEADER BAR */

header, .header {

position: fixed !important;

top: 0 !important;

left: 0 !important;

width: 100% !important;

z-index: 9999 !important;

transition: transform 0.3s ease, opacity 0.3s ease !important;

}

.header-hidden {

transform: translateY(-100%) !important;

opacity: 0 !important;

}



/* FILTER SELECTION MENU STYLING */

.filter-menu {

display: flex;

gap: 1.5rem;

margin: 2rem 0;

border-bottom: 1px solid #333;

padding-bottom: 0.75rem;

}

.filter-btn {

background: none;

border: none;

color: #888;

font-size: 0.9rem;

font-weight: 700;

text-transform: uppercase;

cursor: pointer;

padding: 0.25rem 0.5rem;

transition: color 0.2s;

}

.filter-btn.active, .filter-btn:hover {

color: #fff;

}


/* Clean grid layout configuration fallback */

.grid {

display: grid;

grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));

gap: 2rem;

}



.card {

display: flex;

flex-direction: column;

background: #111;

border-radius: 8px;

overflow: hidden;

transition: opacity 0.3s ease, transform 0.3s ease;

}

</style>



<section class="slider-viewport">

<div class="slider-wrapper" id="sliderWrapper">

<?php foreach ($slides as $slide): ?>

<div class="slide" style="background-image: url('<?php echo $slide['img']; ?>');">

<div class="slide-content">

<h2 class="slide-title"><?php echo $slide['title']; ?></h2>

<p class="slide-subtitle"><?php echo $slide['subtitle']; ?></p>

<a href="#catalog" class="btn-primary" style="padding: 1rem 2rem; text-decoration: none; display: inline-block;">

<?php echo $slide['link_text']; ?>

</a>

</div>

</div>

<?php endforeach; ?>

</div>

<div class="slider-nav">

<?php foreach ($slides as $index => $slide): ?>

<div class="slider-dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $index; ?>)"></div>

<?php endforeach; ?>

</div>

</section>



<main class="container" id="catalog" style="margin-top: 3rem;">

<div>

<h1 style="font-size: 2.2rem; font-weight: 800; margin-bottom: 0.5rem;">Curated Drops</h1>

</div>



<div class="filter-menu">

<button class="filter-btn active" onclick="applyFilter('all', this)">All Outfits</button>

<button class="filter-btn" onclick="applyFilter('new', this)">New Arrival</button>

<button class="filter-btn" onclick="applyFilter('top', this)">Top</button>

<button class="filter-btn" onclick="applyFilter('bottom', this)">Bottom</button>

</div>



<div class="grid" id="productGrid">

<?php foreach ($products as $item): ?>

<?php $isSoldOut = ($item['stock'] === 'soldout'); ?>


<div class="card" data-cat="<?php echo $item['cat']; ?>" style="<?php echo $isSoldOut ? 'opacity: 0.55;' : ''; ?>">


<div style="position: relative; width: 100%; aspect-ratio: 1 / 1; overflow: hidden; background: #1a1a1a;">

<img src="<?php echo $item['img']; ?>" alt="<?php echo $item['title']; ?>" style="width: 100%; height: 100%; object-fit: cover; display: block; <?php echo $isSoldOut ? 'filter: grayscale(100%) blur(1px);' : ''; ?>">


<?php if ($isSoldOut): ?>

<div style="position: absolute; inset: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; z-index: 3; pointer-events: none;">

<span style="background: #ff4d4d; color: #fff; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; padding: 6px 14px; border-radius: 2px; box-shadow: 0 4px 12px rgba(0,0,0,0.5);">SOLD OUT</span>

</div>

<?php endif; ?>


<div style="position: absolute; bottom: 12px; left: 12px; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); color: rgba(255, 255, 255, 0.7); padding: 4px 10px; font-size: 0.65rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; border-radius: 2px; pointer-events: none; user-select: none; z-index: 2;">

© BRAND NAME

</div>

</div>



<div class="card-body" style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">

<h3 style="font-size: 1.2rem; margin-bottom: 0.5rem; color: #fff; font-weight: 700; min-height: 2.8rem; line-height: 1.3;"><?php echo $item['title']; ?></h3>

<p style="color: #888; font-size: 0.85rem; margin-bottom: 1.5rem; line-height: 1.45; flex-grow: 1;"><?php echo $item['desc']; ?></p>


<div style="margin-bottom: 1.2rem; display: flex; align-items: center; gap: 10px;">

<span style="color: #666; font-size: 0.8rem; font-weight: 700; text-transform: uppercase;">Size:</span>

<select class="product-size" <?php echo $isSoldOut ? 'disabled' : ''; ?> style="background: #222; color: <?php echo $isSoldOut ? '#555' : '#fff'; ?>; border: 1px solid #444; padding: 0.4rem 0.8rem; border-radius: 4px; font-size: 0.85rem; font-weight: 600; cursor: <?php echo $isSoldOut ? 'not-allowed' : 'pointer'; ?>; outline: none; flex-grow: 1;">

<option value="S">S</option>

<option value="M" selected>M</option>

<option value="L">L</option>

<option value="XL">XL</option>

</select>

</div>



<div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; background: rgba(255,255,255,0.02); padding: 0.75rem; border-radius: 6px;">

<div style="display: flex; flex-direction: column;">

<span class="price" style="font-size: 1.25rem; font-weight: 700; color: #f4c430;">৳<?php echo number_format($item['price'], 0); ?></span>

<span style="color: #666; font-size: 0.8rem; margin-top: 1px;">$<?php echo $item['usd']; ?> USD</span>

</div>


<?php if ($isSoldOut): ?>

<button class="btn-primary" disabled style="padding: 0.6rem 1.2rem; font-size: 0.8rem; width: auto; font-weight: 700; background: #1c1c1c; color: #555; border-color: #252525; cursor: not-allowed;">

Out Of Stock

</button>

<?php else: ?>

<button class="btn-primary" onclick="saveToCart('<?php echo addslashes($item['title']); ?>', <?php echo $item['price']; ?>, '<?php echo $item['img']; ?>', this)" style="padding: 0.6rem 1.2rem; font-size: 0.8rem; width: auto; font-weight: 700; white-space: nowrap;">

Add To Cart

</button>

<?php endif; ?>

</div>

</div>



</div>

<?php endforeach; ?>

</div>

</main>



<script>

// Safe Filter Engine Configuration

function applyFilter(category, button) {

document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));

button.classList.add('active');



document.querySelectorAll('#productGrid .card').forEach(card => {

const cardCat = card.getAttribute('data-cat');

if (category === 'all' || cardCat === category) {

card.style.setProperty('display', 'flex', 'important');

setTimeout(() => {

card.style.opacity = '1';

card.style.transform = 'scale(1)';

}, 10);

} else {

card.style.opacity = '0';

card.style.transform = 'scale(0.95)';

setTimeout(() => { card.style.setProperty('display', 'none', 'important'); }, 300);

}

});

}



// Smart Navigation Bar Scroll Tracker

let lastScroll = window.scrollY;

const mainHeader = document.querySelector('header') || document.querySelector('.header');



if (mainHeader) {

window.addEventListener('scroll', () => {

let currentScroll = window.scrollY;

if (currentScroll > lastScroll && currentScroll > 80) {

mainHeader.classList.add('header-hidden');

} else {

mainHeader.classList.remove('header-hidden');

}

lastScroll = currentScroll;

});

}



// Lookbook Slideshow Carousel Config

let activeSlide = 0;

const slideCount = <?php echo count($slides); ?>;

const sliderWrap = document.getElementById('sliderWrapper');

const allDots = document.querySelectorAll('.slider-dot');



function updateSlider() {

if(sliderWrap) {

sliderWrap.style.transform = `translateX(-${activeSlide * 100}%)`;

allDots.forEach((dot, idx) => dot.classList.toggle('active', idx === activeSlide));

}

}

function goToSlide(index) {

activeSlide = index;

updateSlider();

}

setInterval(() => {

activeSlide = (activeSlide + 1) % slideCount;

updateSlider();

}, 5000);



// Dynamic Browser Storage Cart Engine

function saveToCart(title, price, img, button) {

const cardBody = button.closest('.card-body');

const selectedSize = cardBody.querySelector('.product-size').value;



let cart = JSON.parse(localStorage.getItem('streetwearCart')) || [];

const existingProduct = cart.find(item => item.title === title && item.size === selectedSize);



if (existingProduct) {

existingProduct.qty += 1;

} else {

cart.push({

title: title,

price: price,

img: img,

size: selectedSize,

qty: 1

});

}



localStorage.setItem('streetwearCart', JSON.stringify(cart));

updateCartCount();



button.innerHTML = "Added ✓";

button.style.pointerEvents = "none";

setTimeout(() => {

button.innerHTML = "Add To Cart";

button.style.pointerEvents = "auto";

}, 1200);

}



function updateCartCount() {

let cart = JSON.parse(localStorage.getItem('streetwearCart')) || [];

let totalItems = cart.reduce((sum, item) => sum + item.qty, 0);

const totalDisplay = document.getElementById('header-cart');

if (totalDisplay) { totalDisplay.innerText = `Cart (${totalItems})`; }

}



document.addEventListener("DOMContentLoaded", updateCartCount);

</script>



<?php include('footer.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <!-- Premium Multi-Column Footer Styles -->
    <style>
        :root {
            --input-border: #222;
            --text-primary: #fff;
            --text-muted: #888;
            --accent: #f4c430;
        }
        body { background: #000; color: #fff; font-family: sans-serif; margin: 0; padding: 0; }

        .footer-wrapper {
            background-color: #080808;
            border-top: 1px solid var(--input-border);
            padding: 5rem 4rem 2rem 4rem;
            margin-top: 8rem;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .footer-column h4 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }
        .footer-column ul { list-style: none; padding: 0; }
        .footer-column ul li { margin-bottom: 0.75rem; }
        .footer-column ul li a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        .footer-column ul li a:hover { color: var(--accent); }
        
        .newsletter-form { display: flex; gap: 0.5rem; margin-top: 1rem; }
        .newsletter-input {
            background: #141414;
            border: 1px solid var(--input-border);
            padding: 0.75rem;
            color: #fff;
            flex-grow: 1;
            font-size: 0.85rem;
            border-radius: 4px;
        }
        .newsletter-input:focus { border-color: var(--accent); outline: none; }
        
        .btn-primary {
            background: var(--accent);
            color: #000;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; }

        .footer-bottom {
            max-width: 1200px;
            margin: 4rem auto 0 auto;
            padding-top: 2rem;
            border-top: 1px solid #141414;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        .payment-icons { display: flex; gap: 1rem; color: var(--text-muted); font-size: 0.8rem; letter-spacing: 1px; }
        .logo { font-size: 1.5rem; font-weight: bold; letter-spacing: 1px; }
        .logo span { color: var(--accent); }

        /* ================= POPUP MODAL LOGIN STYLES ================= */
        .login-modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Dark background overlay */
            backdrop-filter: blur(8px); /* Smooth premium blur background */
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: #111;
            border: 1px solid #222;
            padding: 2.5rem;
            width: 100%;
            max-width: 400px;
            border-radius: 6px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.7);
        }
        .close-modal {
            position: absolute;
            top: 1rem;
            right: 1.2rem;
            color: #666;
            font-size: 1.8rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-modal:hover { color: var(--accent); }
        .modal-content h3 { margin-top: 0; margin-bottom: 1.5rem; letter-spacing: 2px; text-transform: uppercase; font-size: 1.1rem; }
        .modal-content label { display: block; font-size: 0.8rem; margin-bottom: 0.4rem; color: #aaa; text-transform: uppercase; letter-spacing: 1px; }
        .modal-content input {
            width: 100%;
            padding: 0.75rem;
            background: #141414;
            border: 1px solid #333;
            color: #fff;
            margin-bottom: 1.25rem;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .modal-content input:focus { border-color: var(--accent); outline: none; }
    </style>
</head>
<body>

   

    <!-- ================= SINGLE FOOTER BLOCK ================= -->
    <footer class="footer-wrapper">
        <div class="footer-grid">
            <!-- Brand Column -->
            <div class="footer-column">
                <div class="logo" style="margin-bottom: 1rem;">Rban<span>Outlaw</span></div>
                <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6;">
                    Premium men's street apparel engineered for uncompromising character and dynamic aesthetic confidence.
                </p>
            </div>

            <!-- Shop Navigation Links -->
            <div class="footer-column">
                <h4>Collections</h4>
                <ul>
                    <li><a href="#catalog">Heavyweight Hoodies</a></li>
                    <li><a href="#catalog">Outerwear &amp; Jackets</a></li>
                    <li><a href="#catalog">Japanese Raw Denim</a></li>
                    <li><a href="#catalog">New Drops</a></li>
                </ul>
            </div>

            <!-- Customer Service links -->
            <div class="footer-column">
                <h4>Assistance</h4>
                <ul>
                    <li><a href="#shipping">Track Your Order</a></li>
                    <li><a href="#returns">Returns &amp; Exchanges</a></li>
                    <li><a href="#size-guide">Men's Size Guide</a></li>
                    <li><a href="#contact">Contact Support</a></li>
                </ul>
            </div>

            <!-- VIP Newsletter Sign-up -->
            <div class="footer-column">
                <h4>Stay Connected</h4>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Subscribe for early access to Drop 02.</p>
                
                <!-- Notice we changed the input wrapper to a div container to prevent forms nesting -->
                <div class="newsletter-form">
                    <input type="email" class="newsletter-input" placeholder="Your email address" required>
                    <button type="button" class="btn-primary" onclick="alert('Joined successfully!');" style="width: auto; padding: 0 1rem; font-size: 0.8rem; height: 38px;">Join</button>
                    
                    <!-- Login Button: Triggers JavaScript Modal pop-up -->
                    <button type="button" class="btn-primary" id="openLoginBtn" style="width: auto; padding: 0 1rem; font-size: 0.8rem; height: 38px; background: #222; color: #fff; border: 1px solid #333;">Login</button>
                </div>
            </div>
        </div>

        <!-- Copyright and Payments bar -->
        <div class="footer-bottom">
            <p style="color: var(--text-muted); font-size: 0.8rem;">
                &copy; <?php echo date('Y'); ?> RBAN OUTLAW CO. ALL RIGHTS RESERVED.
            </p>
            <div class="payment-icons">
                <span>VISA</span> • <span>MC</span> • <span>AMEX</span> • <span>APPLE PAY</span>
            </div>
        </div>
    </footer>

    <!-- ================= THE LOGIN POPUP MODAL ================= -->
    <div id="loginModal" class="login-modal">
        <div class="modal-content">
            <span class="close-modal" id="closeLoginBtn">&times;</span>
            <h3>Portal Login</h3>
            
            <!-- Submits credentials directly to your admin dashboard backend -->
            <form action="admin.php" method="POST">
                <label>Admin Username</label>
                <input type="text" name="admin_username" placeholder="Enter username" required>
                
                <label>Password</label>
                <input type="password" name="admin_password" placeholder="••••••••" required>
                
                <button type="submit" class="btn-primary" style="width: 100%; padding: 0.8rem; font-size: 0.9rem;">Access Dashboard</button>
            </form>
        </div>
    </div>

    <!-- ================= MODAL SCRIPT ENGINE ================= -->
    <script>
        const modal = document.getElementById("loginModal");
        const openBtn = document.getElementById("openLoginBtn");
        const closeBtn = document.getElementById("closeLoginBtn");

        // Reveal the window overlay
        openBtn.onclick = function() {
            modal.style.display = "flex";
        }

        // Hide when close button 'x' clicked
        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        // Hide automatically if user clicks on the background blur outside the form frame
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
//