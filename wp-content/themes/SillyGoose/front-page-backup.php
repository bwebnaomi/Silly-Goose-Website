<?php
/**
 * Front Page Template - Custom Design
 */
get_header(); ?>

<main id="main" class="site-main">
    
    <!-- Hero Section -->
    <section class="hero" style="
        background-image: url('https://images.unsplash.com/photo-1746309226522-f986af8bc6c5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjb2xvcmZ1bCUyMGdlb21ldHJpYyUyMHBhdHRlcm5zfGVufDF8fHx8MTc1ODMxNjM0OXww&ixlib=rb-4.1.0&q=80&w=1080');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        position: relative;
        padding: 6rem 1rem;
    ">
        <div style="
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.1);
            z-index: 1;
        "></div>
        
        <div style="position: relative; z-index: 2; max-width: 1200px; margin: 0 auto;">
            <h1 class="gradient-text" style="
                font-size: 3rem; 
                font-weight: 900; 
                margin-bottom: 1rem;
                background: linear-gradient(135deg, var(--primary), var(--secondary), var(--accent));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            ">
                Silly Goose
            </h1>
            
            <p style="font-size: 1.5rem; margin-bottom: 1rem; color: var(--primary);">
                We're not going to be beaten by AI, we're making it our bitch.
            </p>
            
            <p style="font-size: 1.125rem; margin-bottom: 2rem;">
                A wickedly creative digital agency that turns your wildest ideas into jaw-dropping websites, apps, and marketing campaigns that actually work.
            </p>
            
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="#contact" class="btn btn-primary">Let's Get Silly</a>
                <a href="#work" class="btn btn-outline">See Our Work</a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section style="padding: 3rem 1rem;">
        <div class="container-constrained">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div class="card" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; font-weight: 900; color: var(--primary); margin-bottom: 0.5rem;">200+</div>
                    <div style="color: var(--muted-foreground); font-size: 0.875rem;">Happy Clients</div>
                </div>
                <div class="card" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; font-weight: 900; color: var(--secondary); margin-bottom: 0.5rem;">500+</div>
                    <div style="color: var(--muted-foreground); font-size: 0.875rem;">Projects Delivered</div>
                </div>
                <div class="card" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; font-weight: 900; color: var(--accent); margin-bottom: 0.5rem;">50+</div>
                    <div style="color: var(--muted-foreground); font-size: 0.875rem;">Awards Won</div>
                </div>
                <div class="card" style="text-align: center; padding: 2rem;">
                    <div style="font-size: 3rem; font-weight: 900; color: var(--primary); margin-bottom: 0.5rem;">24/7</div>
                    <div style="color: var(--muted-foreground); font-size: 0.875rem;">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section style="padding: 6rem 1rem; background-color: var(--muted);">
        <div class="container-constrained">
            <h2 style="text-align: center; margin-bottom: 1rem;">What We Do Best</h2>
            <p style="text-align: center; font-size: 1.25rem; margin-bottom: 3rem;">
                We're like a Swiss Army knife, but for digital stuff. And way more fun to work with.
            </p>
            
            <div class="services-grid">
                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(255, 107, 53, 0.1); color: var(--primary); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                        </svg>
                    </div>
                    <h3>Web Design</h3>
                    <p>Stunning, user-friendly designs that make your competitors weep tears of envy.</p>
                    <ul>
                        <li>UI/UX Design</li>
                        <li>Responsive Design</li>
                        <li>Brand Identity</li>
                        <li>Prototyping</li>
                    </ul>
                </div>

                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(78, 205, 196, 0.1); color: var(--secondary); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    </div>
                    <h3>Web Development</h3>
                    <p>Rock-solid code that's faster than your morning coffee kick and more reliable than your best mate.</p>
                    <ul>
                        <li>React & Next.js</li>
                        <li>E-commerce</li>
                        <li>CMS Integration</li>
                        <li>API Development</li>
                    </ul>
                </div>

                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(255, 210, 63, 0.1); color: var(--accent); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3>SEO</h3>
                    <p>We'll get you to the top of Google faster than you can say 'search engine optimisation'.</p>
                    <ul>
                        <li>Technical SEO</li>
                        <li>Content Strategy</li>
                        <li>Local SEO</li>
                        <li>Performance Monitoring</li>
                    </ul>
                </div>

                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(255, 107, 53, 0.1); color: var(--primary); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </div>
                    <h3>Paid Media Marketing</h3>
                    <p>Targeted ads so precise, they'll make Cupid jealous of our targeting skills.</p>
                    <ul>
                        <li>Google Ads</li>
                        <li>Facebook & Instagram Ads</li>
                        <li>LinkedIn Campaigns</li>
                        <li>Conversion Tracking</li>
                    </ul>
                </div>

                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(78, 205, 196, 0.1); color: var(--secondary); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <h3>E-commerce</h3>
                    <p>Online stores that convert visitors into customers faster than you can say 'shopping trolley'.</p>
                    <ul>
                        <li>Shopify</li>
                        <li>WooCommerce</li>
                        <li>Payment Integration</li>
                        <li>Inventory Management</li>
                    </ul>
                </div>

                <div class="card">
                    <div style="display: inline-flex; padding: 0.75rem; border-radius: 50%; background: rgba(255, 210, 63, 0.1); color: var(--accent); margin-bottom: 1.5rem;">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3>Brand Strategy</h3>
                    <p>We'll make your brand so memorable, people will tattoo it on their foreheads (results may vary).</p>
                    <ul>
                        <li>Brand Positioning</li>
                        <li>Logo Design</li>
                        <li>Brand Guidelines</li>
                        <li>Market Research</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section style="padding: 6rem 1rem;">
        <div class="container-constrained">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
                <div>
                    <h2>We're the Silly Ones</h2>
                    <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">
                        Started in a garage (okay, it was actually a rather nice office, but 'garage' sounds cooler), 
                        Silly Goose has grown into a team of digital misfits who refuse to take ourselves too seriously — 
                        but we take your success <strong>very</strong> seriously.
                    </p>
                    <p style="font-size: 1.125rem; margin-bottom: 2rem;">
                        We believe that great design doesn't have to be boring, code doesn't have to be ugly, 
                        and marketing doesn't have to feel like selling your soul.
                    </p>
                    <a href="/#contact" class="btn btn-secondary">Meet the Flock</a>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1532623034127-3d92b01fb3c5?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHx3ZWIlMjBkZXZlbG9wbWVudCUyMHRlYW0lMjB3b3Jrc3BhY2V8ZW58MXx8fHwxNzU4MzE2MzUyfDA&ixlib=rb-4.1.0&q=80&w=1080" 
                         alt="Web development team workspace" 
                         style="width: 100%; height: auto; border-radius: 1rem;">
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section style="padding: 4rem 1rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); text-align: center;">
        <div class="container-constrained" style="color: white;">
            <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">Ready to Make Magic Happen?</h2>
            <p style="font-size: 1.25rem; margin-bottom: 2rem; opacity: 0.9;">Let's turn your wildest ideas into digital reality.</p>
            <a href="#contact" style="
                display: inline-block; 
                padding: 1rem 2rem; 
                background: white; 
                color: var(--primary); 
                text-decoration: none; 
                border-radius: var(--radius); 
                font-weight: 700; 
                font-size: 1.125rem;
            ">Get Started Today</a>
        </div>
    </section>

</main>

<?php get_footer(); ?>