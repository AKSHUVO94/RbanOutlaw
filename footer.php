<!-- ================= PREMIUM MULTI-COLUMN FOOTER ================= -->
    <style>
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
    </style>

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
                <form class="newsletter-form" action="#" method="POST" onsubmit="event.preventDefault(); alert('Joined successfully!');">
                    <input type="email" class="newsletter-input" placeholder="Your email address" required>
                    <button type="submit" class="btn-primary" style="width: auto; padding: 0 1rem; font-size: 0.8rem;">Join</button>
                </form>
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
</body>
</html>