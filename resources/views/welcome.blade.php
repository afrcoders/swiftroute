<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terra Nova Property Services | Winnipeg Snow & Lawn</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css?v=1') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" style="background-color: #000015 !important;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <img src="{{ asset('assets/terranova.png?v=1') }}" alt="Terra Nova" style="height: 48px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#lawn-care">Lawn Care Service</a></li>
                            <li><a class="dropdown-item" href="#snow-ice">Snow & Ice Management</a></li>
                            <li><a class="dropdown-item" href="#property-cleaning">Property Cleaning Service</a></li>
                            <li><a class="dropdown-item" href="#hauling">Light Freight Hauling Service</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#why">Why Us</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#faqs">FAQs</a></li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="modal" data-bs-target="#contactModal">Free Quote</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>

                <a href="tel:+14315577346" class="btn btn-primary ms-lg-3"><i class="bi bi-telephone"></i> 431‑557‑7346</a>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section bg-primary text-white">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6">
                    <h3 class="display-8 fw-bold mb-4">TERRA NOVA PROPERTY SERVICES</h3>
                    <p class="mb-4">Your Year-Round Property Maintenance Partner in Winnipeg.</p>
                    <p class="mb-4">Welcome to Terra Nova Property Services, your trusted local partner for reliable property maintenance in Winnipeg and surrounding communities. From keeping your lawn healthy and tidy in the summer to ensuring driveways, sidewalks, and parking lots are safe and clear in the winter, we provide dependable, professional care you can count on — every season, every year.</p>
                    <button class="btn btn-light btn-lg me-3" data-bs-toggle="modal" data-bs-target="#contactModal">
                        <i class="bi bi-calendar-check me-2"></i>Get Free Quote
                    </button>

                    <a href="tel:+14315577346" class="btn btn-outline-light btn-lg"><i class="bi bi-telephone"></i> Call 431‑557‑7346</a>

                </div>
                <div class="col-lg-6">
                    <div class="padded-image-container mx-auto">
                        <img src="{{ asset('assets/1.jpg') }}"
                            class="img-fluid rounded-image shadow" alt="Snow clearing">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title h1 mb-3">About Us</h2>
                    <p>At <b>Terra Nova Property Services</b>, we are proud to be a locally owned and operated business serving Winnipeg and surrounding communities with dependable lawn care, snow clearing, and property cleaning solutions. We know the challenges of Manitoba’s extreme seasons — from icy winters to hot prairie summers — and we’re here to help you stay ahead of them.</p>
                    <p>As a licensed and fully insured company, we deliver not only quality service but also peace of mind. Whether it’s clearing snow after a heavy storm or keeping your lawn clean, green, and healthy, we bring the same level of care, professionalism, and attention to detail to every property — no matter the size.</p>
                    <p>We value long-term relationships and believe trust is earned through consistent, honest work. We take the time to treat each property with the care it deserves, while our commitment to punctuality and customer satisfaction sets us apart.</p>
                    <p class="mb-0">Thank you for considering <strong>Terra Nova Property Services</strong> — your trusted local partner in year-round property care.</strong></p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/1_1.jpg?v=1') }}" class="rounded-4 w-100 shadow" alt="Local crew at work—Terra Nova Property Services" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="mb-5">
                <h2 class="section-title  h1">Our Services</h2>
                <p class="text-muted mb-2">We provide a full range of professional services to keep your Winnipeg property and operations running smoothly:</p>
                <ul class="list-unstyled text-muted">
                    <li><img src="{{ asset('assets/icons/lawn_care.jpg') }}" class="service-icons"/> <span class="light-text bolden">Lawn Care Service</span> – Expert mowing, trimming, and maintenance for healthy, vibrant lawns.</li>
                    <li><img src="{{ asset('assets/icons/snow_ice.jpg') }}" class="service-icons"/> <span class="light-text bolden">Snow & Ice Management</span> – Reliable plowing, shoveling, and salting to keep your property safe in winter.</li>
                    <li><img src="{{ asset('assets/icons/property_cleaning.jpg') }}" class="service-icons"/> <span class="light-text bolden">Property Cleaning Service</span> – Comprehensive cleaning to maintain tidy, attractive spaces.</li>
                    <li><img src="{{ asset('assets/icons/hauling.jpg') }}" class="service-icons"/> <span class="light-text bolden">Light Freight Hauling Service</span> – Reliable hauling and transport of goods and materials.</li>
                </ul>
            </div>

            <div class="row g-4 align-items-center mb-4">

                <div class="col-lg-12" id="lawn-care">
                    <h3 class="mb-3">Lawn Care Services</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/lawn2.jpg?v=1') }}" class="card-img-top" alt="Spring cleanup" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Spring Cleanup</h5>
                                    <ul class="small mb-0">
                                        <li>Power raking of turf areas</li>
                                        <li>Deep core aeration</li>
                                        <li>Thatch raking &amp; removal</li>
                                        <li>Edging (front yard)</li>
                                        <li>First mow &amp; trim of the season</li>
                                        <li>Bagging &amp; disposal of debris</li>
                                    </ul>
                                    <p><strong>Starting rate</strong>: $250</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/lawn3.jpg') }}" class="card-img-top" alt="Lawn fertilization" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Fertilization</h5>
                                    <ul class="small mb-0">
                                        <li>Deep core aeration</li>
                                        <li>High‑nitrogen fertilizer application</li>
                                    </ul>
                                  <p><strong>Starting rate</strong>: $85</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/lawn4.jpg') }}" class="card-img-top" alt="Lawn maintenance" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Lawn Maintenance</h5>
                                    <p class="small mb-2">Choose the schedule that works best:</p>
                                    <ul class="small mb-2">
                                        <li>Mowing: weekly / bi‑weekly / monthly</li>
                                        <li>Trimming all edges &amp; front‑yard edging</li>
                                        <li>Basic landscaping as needed</li>
                                    </ul>
                                    <p class="small mb-0"><strong>Starting rates</strong>: Weekly from $40/cut; Bi‑weekly from $60/cut; Monthly from $100/cut</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/lawn5.jpg') }}" class="card-img-top" alt="Weed control" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Weed Control</h5>
                                    <ul class="small mb-2">
                                        <li>Seasonal (4-Treatment) — $300</li>
                                        <li>Isolated Treatment — $90</li>
                                        <li>Hardscaped Areas — $60</li>
                                        <li>Rock/Gravel Areas — $100</li>
                                    </ul>
                                    <p class="small mb-0">Seasonal plan includes spring &amp; early summer fertilizer, late summer spot treatment, fall fertilizer + spot treatment, and bonus fall aeration.</p>
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/lawn6.jpg') }}" class="card-img-top" alt="Fall cleanup" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Fall Cleanup</h5>
                                    <ul class="small mb-2">
                                        <li>Leaf blow & rake</li>
                                        <li>Final mow & trim</li>
                                        <li>Bagging of leaves & debris (5 bags included; + $5 for each additional bag)</li>
                                    </ul>
                                    <p class="small mb-0"><strong>Starting rate</strong>: $150</p>
                                    <p class="small mb-0"><strong>Optional add‑on</strong>: Deep core aeration + high‑nitrogen fertilization — $89</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="row g-4 align-items-center">

                <div class="col-lg-12 order-lg-1" id="snow-ice">
                    <h3 class="mb-3">Snow &amp; Ice Management</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('assets/fr.jpg') }}" class="card-img-top" alt="Full residential snow clearing" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Full Residential Clearing</h5>
                                    <ul class="small mb-2">
                                        <li>Snow clearing of your Driveway, front walkway, and steps</li>
                                        <li>Trigger: ≥ 2 inches snowfall</li>
                                        <li>Cleared within 24hrs of a snowfall ending (36hrs during major snow storms)</li>
                                    </ul>
                                    <p class="small mb-0"><strong>One‑Time:</strong> $100 first man‑hour; $25/extra 15 min</p>
                                    <p class="small mb-0"><strong>Monthly:</strong> $300</p>
                                    <p class="small mb-0"><strong>Full Season (Nov 1st to Mar 31st):</strong> $1,300 (5 monthly installments)</p>
                                    <p class="small mb-0">Optional Service: Walkway at side of building and Deck at the back</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('assets/dw.jpg') }}" class="card-img-top" alt="Driveway-only clearing" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Driveway‑Only Clearing</h5>
                                    <ul class="small mb-2">
                                        <li>Snow clearing of your Driveway only</li>
                                        <li>Trigger: ≥ 2 inches snowfall  </li>
                                        <li>Cleared within 24hrs of a snowfall ending (36hrs during major snow storms)</li>
                                    </ul>
                                    <p class="small mb-0"><strong>One‑Time:</strong>  $90 first man‑hour; $25/extra 15 min</p>
                                    <p class="small mb-0"><strong>Monthly:</strong> $250</p>
                                    <p class="small mb-0"><strong>Full Season (Nov 1st to Mar 31st):</strong> $1,100 (5 monthly installments)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('assets/9.jpg') }}" class="card-img-top" alt="Commercial snow clearing" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Commercial Snow Clearing</h5>
                                    <ul class="small mb-2">
                                        <li>Snow clearing of Parking lots and commercial properties (¾-ton/1-ton trucks with plows)</li>
                                        <li>Walkways, sidewalks; building entrances; steps; around vehicles using blowers & shovels</li>
                                    </ul>
                                    <p class="small mb-0"><strong>One‑Time:</strong>  $129.95/30 min; $50/add’l 15 min </p>
                                    <p class="small mb-0"><strong>Monthly/Seasonal:</strong> Custom —  <a class="btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</a>
</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('assets/sh.jpg') }}" class="card-img-top" alt="Snow Hauling Service" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Snow Hauling Service</h5>
                                    <p class="small mb-0">Snow piles taking up space? Let us remove it completely. Our snow hauling service keeps your property safe, accessible, and looking its best by transporting excess snow off-site. Fast, reliable, and efficient—so you can enjoy clear lots and walkways all winter long.</p>

                                    <p>
                                    <button class="mt-2 btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('assets/im.jpg') }}" class="card-img-top" alt="Ice management" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Ice Management</h5>
                                    <ul class="small mb-2">
                                        <li>Salting of parking lots, driveways and sidewalks</li>
                                        <li>Ice breaking/scraping </li>
                                        <li>Eco/pet-safe melt </li>
                                        <li>Sanding</li>
                                        <li>Ongoing monitoring with contracts</li>
                                    </ul>
                                    <p class="small mb-0">Pricing varies by property and severity.</p>
                                    
                                    <p>
                                    <button class="mt-2 btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</button>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <p class="small mt-3 mb-0"><em>All pricing subject to property size, layout, and specific requirements. GST not included.</em></p>
                </div>
            </div>

            <div class="row g-4 align-items-center mt-4">
                <div class="col-lg-12" id="property-cleaning">
                    <h3 class="mb-3">Property Cleaning Service</h3>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm loading loaded fade-in-up" style="animation-delay: 1.5s;">
                                <img src="{{ asset('assets/pcs.jpg') }}" class="card-img-top" alt="Property Cleaning Service" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Property Cleaning Service</h5>
                                    <p class="small mb-0">At <strong>Terra Nova Property Services</strong>, we make it simple to keep your property clean and welcoming. From routine upkeep to Post-renovation or move-out cleaning, we deliver reliable, detail-focused service for both commercial and residential clients in Winnipeg and surrounding areas. Contact us for a free quote.</p>
                                    
                                    <p>
                                    <button class="mt-2 btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        
<div class="col-md-6">
                            <div class="card h-100 shadow-sm loading loaded fade-in-up" style="animation-delay: 1.5s;">
                                <img src="{{ asset('assets/wcs.jpg') }}" class="card-img-top" alt="Window Cleaning" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Window Cleaning</h5>
                                    <p class="small mb-0">We provide professional window cleaning for both residential and commercial properties. With the right tools and expertise, our team can handle everything from ground-level windows to those hard-to-reach upper floors — inside and out.</p>
                                    <p class="small mb-0">Using our water-fed carbon fiber extension poles, we safely and efficiently reach high windows, ensuring a streak-free shine without the need for ladders or lifts. Whatever the type of glass, our team makes it look like new.</p>
                                    
                                    <p>
                                    <button class="mt-2 btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row g-4 align-items-center mt-4">
                <div class="col-lg-12" id="hauling">
                    <h3 class="mb-3">Light Freight Hauling Service</h3>
                    <div class="row g-4">

                    
<div class="col-md-6">
                            <div class="card h-100 shadow-sm loading loaded fade-in-up" style="animation-delay: 1.5s;">
                                <img src="{{ asset('assets/hcs.jpg') }}" class="card-img-top" alt="Hauling / Expidite Service" loading="lazy">
                                <div class="card-body">
                                    <h5 class="card-title">Hauling / Expidite Service</h5>
                                    <p class="small mb-0">At <strong>Terra Nova Property Services</strong>, we offer reliable hauling and transport solutions for both residential and commercial clients in Winnipeg and surrounding areas. Whether you need materials, equipment, or other items moved quickly and safely, our team is equipped to handle the job efficiently using our pickup trucks and professional crew.</p>
                                    <p class="small mb-0">We pride ourselves on timely, dependable service, ensuring your items are delivered where they need to be — on schedule and without hassle. Whatever the size or type of load, we make moving it simple, safe, and stress-free.</p>
                                    <p class="small mb-0 bolden">Specifically, we offer:</p>
                                    <ul class="small mb-2">
                                        <li>Expedited freight logistics</li>
                                        <li>Same-day pickup and delivery</li>
                                        <li>Furniture and appliances</li>
                                        <li>Construction and garden materials</li>
                                        <li>Specialty item transport</li>
                                    </ul>
                                    <p>
                                    <button class="mt-2 btn btn-primary btn-sm fade-in-up" data-bs-toggle="modal" data-bs-target="#contactModal">Request a Quote</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>

    <!-- Emergency Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="display-6 fw-bold mb-4">24/7 Emergency Snow Removal</h2>
                    <p class="lead">Ready When You Need Us Most</p>
                    <p>Winter storms can strike unexpectedly, leaving your property buried under heavy snow and dangerous ice. At Terra Nova, we offer rapid-response emergency snow removal services in Winnipeg to ensure your home or business stays safe and accessible no matter the weather.</p>
                    
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/8.jpg') }}"
                        class="img-fluid rounded" alt="24/7 Emergency Snow Removal">
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="why" class="py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title h1">Why Choose Us</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-geo-alt"></i></div>
                        <h6>Locally Owned &amp; Insured</h6>
                        <p class="small mb-0">Winnipeg‑based, fully insured for peace of mind.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-sunrise"></i></div>
                        <h6>Built for Extreme Seasons</h6>
                        <p class="small mb-0">Solutions tailored to prairie winters and summers.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-clock-history"></i></div>
                        <h6>Punctual &amp; Dependable</h6>
                        <p class="small mb-0">We show up on time and do it right.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 border rounded-4 h-100">
                        <div class="feature-icon mb-3"><i class="bi bi-hand-thumbs-up"></i></div>
                        <h6>Honest, Relationship‑Focused</h6>
                        <p class="small mb-0">Straightforward pricing and lasting service.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="faqs" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="section-title h1">FAQs</h2>
            </div>
            <div class="accordion" id="faqAcc">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q1h"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#q1">When do you clear after a snowfall?</button></h2>
                    <div id="q1" class="accordion-collapse collapse show" data-bs-parent="#faqAcc">
                        <div class="accordion-body">Within 24 hours (36 hours during major storms).</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q2h"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q2">What triggers a clearing?</button></h2>
                    <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                        <div class="accordion-body">A snowfall of 2 inches or more.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q3h"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q3">Do prices include GST?</button></h2>
                    <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                        <div class="accordion-body">No. GST is not included in listed prices.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q4h"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q4">Do you offer seasonal contracts?</button></h2>
                    <div id="q4" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                        <div class="accordion-body">Yes — monthly and full‑season options are available.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="q5h"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#q5">Do you provide emergency service?</button></h2>
                    <div id="q5" class="accordion-collapse collapse" data-bs-parent="#faqAcc">
                        <div class="accordion-body">Yes — 24/7 emergency clearing and removal during winter (additional call‑out rates apply).</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h2 class="display-6 fw-bold mb-4">Say Goodbye to Snow-Covered Driveways</h2>
            <p class="lead mb-4">Request Your Hassle-Free Snow Removal Service!</p>

            <button class="btn btn-light btn-lg" data-bs-toggle="modal" data-bs-target="#contactModal" style="animation-delay: 0.2s;">
                <i class="bi bi-calendar-check me-2"></i>Get Free Quote Now
            </button>

        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <p class="lead"><strong>Contact TERRA NOVA PROPERTY SERVICES Today to Request a Quote!</strong></p>
                <p>To receive the fastest response, please call the number below with any enquiries, big or small.</p>
                <a href="tel:431-557-7346" class="btn btn-primary btn-lg mb-4">
                    <i class="bi bi-telephone me-2"></i>431-557-7346
                </a>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <form id="contactForm">
            <div id="contactAlert" class="alert alert-success d-none mt-3">
              Thanks! Your message was sent successfully. We'll get back to you shortly.
            </div><input type="text" name="website" class="d-none" autocomplete="off" tabindex="-1" />
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required name="name">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-6">
                                <label for="service" class="form-label">Service Type</label>
                                <select class="form-select" id="service" name="service">
                                    <option value="">Select a service</option>
                                    <option value="lawn">Lawn Care</option>
                                    <option value="residential-snow">Residential Snow Clearing</option>
                                    <option value="commercial-snow">Commercial Snow Clearing</option>
                                    <option value="property-cleaning">Property Cleaning</option>
                                    <option value="window-cleaning">Window Cleaning</option>
                                    <option value="hauling">Light Freight Hauling Service</option>
                                    <option value="emergency-snow">Emergency Snow Clearing/Removal</option>
                                </select>
                                
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="4" placeholder="Tell us about your needs..." name="message"></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <p><i class="bi bi-geo-alt me-2"></i>909 St. Mary's Road, Winnipeg, MB R2M 3R4</p>
                </div>
                <div class="col-md-8">
                    <div class="row">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <p>© {{ date("Y") }} Terra Nova Property Services. All rights reserved.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="social-links">
                        <a class="text-decoration-none text-reset" href="#home">Back to top</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Get Free Quote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleForm">
        <div id="quoteAlert" class="alert alert-success d-none mt-3">
          Thank you! Your request was submitted successfully. We'll contact you shortly.
        </div>
                        <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">How did you find us?</label>
              <select class="form-select" name="how_found">
                <option value="">-- Select an option --</option>
                <option>Google Search</option>
                <option>Facebook</option>
                <option>Instagram</option>
                <option>Friend/Referral</option>
                <option>Flyer/Poster</option>
                <option>Other</option>
              </select>
            </div>
        
                            <div class="col-md-6">
                                <label class="form-label">First Name *</label>
                                <input class="form-control" required name="first_name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name *</label>
                                <input class="form-control" required name="last_name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Company (optional)</label>
                                <input class="form-control" name="company">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address *</label>
                                <input class="form-control" required name="address">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">City</label>
                                <input class="form-control" name="city">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Zip Code</label>
                                <input class="form-control" name="zip">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone *</label>
                                <input class="form-control" type="tel" required name="phone">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input class="form-control" type="email" required name="email">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Services Needed</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="small text-muted fw-semibold mt-2">Lawn Care</div>
<div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc1" name="services[]" value="Lawn Mowing (Weekly)">
                                            <label class="form-check-label" for="lc1">Lawn Mowing (Weekly)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc2" name="services[]" value="Lawn Mowing (Bi‑Weekly)">
                                            <label class="form-check-label" for="lc2">Lawn Mowing (Bi‑Weekly)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc3" name="services[]" value="Lawn Mowing (Monthly)">
                                            <label class="form-check-label" for="lc3">Lawn Mowing (Monthly)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc4" name="services[]" value="Edging">
                                            <label class="form-check-label" for="lc4">Edging</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc5" name="services[]" value="Aeration">
                                            <label class="form-check-label" for="lc5">Aeration</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="lc6" name="services[]" value="Dethatching">
                                            <label class="form-check-label" for="lc6">Dethatching</label>
                                        </div>
                                        <div class="small text-muted fw-semibold mt-2">Snow &amp; Ice Mgt.</div>
<div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sn1" name="services[]" value="Snow Clearing">
                                            <label class="form-check-label" for="sn1">Snow Clearing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sn2" name="services[]" value="Snow Hauling">
                                            <label class="form-check-label" for="sn2">Snow Hauling</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sn3" name="services[]" value="Residential Driveway">
                                            <label class="form-check-label" for="sn3">Residential Driveway</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sn4" name="services[]" value="Sidewalk/Walkway">
                                            <label class="form-check-label" for="sn4">Sidewalk/Walkway</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sn5" name="services[]" value="Salting/Sanding">
                                            <label class="form-check-label" for="sn5">Salting/Sanding</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="pc1" name="services[]" value="Property Cleaning">
                                            <label class="form-check-label" for="pc1">Property Cleaning</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="wc1" name="services[]" value="Window Cleaning">
                                            <label class="form-check-label" for="wc1">Window Cleaning</label>
                                        </div>
                                        <div class="small text-muted fw-semibold mt-2">Light Freight</div>
<div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="hs1" name="services[]" value="Hauling/Expedite Service">
                                            <label class="form-check-label" for="hs1">Hauling/Expedite Service</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="em1" name="services[]" value="Emergency Snow">
                                            <label class="form-check-label" for="em1">Emergency Snow</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Additional information</label>
                                <textarea name="additional_info" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        
                    </form>


                </div>
                <div class="modal-footer">
                    <button style="display:none;" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="scheduleForm" class="btn btn-primary">Request a Quote</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js?v=3') }}"></script>
    <script src="{{ asset('js/forms.js?v=3') }}" defer></script>
</body>

</html>
