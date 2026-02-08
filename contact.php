<!DOCTYPE html>
<html lang="en" dir="ltr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title data-en="Contact Us | Eminent Overseas & Consultants" data-ja="お問い合わせ | エミネント海外留学コンサルタント">Contact Us | Eminent Overseas & Consultants</title>
  
  <!-- SEO Meta Tags -->
  <meta name="description" data-en="Contact Eminent Overseas & Consultants for ethical study abroad guidance. Visit our Dhaka office or send us your enquiry for Japan & UK study programs."
         data-ja="倫理的留学ガイダンスのエミネント海外留学コンサルタントにお問い合わせください。ダッカオフィスへの訪問、日本・英国留学プログラムに関するお問い合わせはこちら。">
  <meta name="keywords" data-en="contact study abroad, Japan study enquiry, UK study enquiry, Bangladeshi student consultation, Dhaka education consultancy"
         data-ja="留学お問い合わせ, 日本留学相談, 英国留学相談, バングラデシュ人学生相談, ダッカ教育コンサルタント">
  <meta name="theme-color" content="#0ea5e9">
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="Contact Us | Eminent Overseas & Consultants">
  <meta property="og:description" content="Get in touch with our expert counselors for personalized guidance on studying in Japan or the UK">
  <meta property="og:image" content="images/eminent-office.jpg">
  <meta property="og:url" content="https://eminentoverseas.uk/contact.php">
  <meta property="og:type" content="website">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Contact Eminent Overseas & Consultants">
  <meta name="twitter:description" content="Ethical guidance for studying in Japan & UK">
  
  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  
  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">
  
  <!-- Contact Page Specific CSS -->
  <style>
    /* Contact Page Specific Styles */
    .contact-hero {
      background: linear-gradient(135deg, 
        rgba(14, 165, 233, 0.08) 0%, 
        rgba(14, 165, 233, 0.03) 100%);
      border-bottom: 1px solid var(--border-color);
      margin-top: calc(var(--marquee-height) + var(--navbar-height));
    }

    [data-theme="dark"] .contact-hero {
      background: linear-gradient(135deg, 
        rgba(14, 165, 233, 0.05) 0%, 
        rgba(14, 165, 233, 0.02) 100%);
    }

    .contact-info-card {
      text-align: center;
      padding: 2rem 1.5rem;
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      border: 1px solid var(--border-color);
      box-shadow: var(--shadow-md);
      transition: var(--transition-base);
      height: 100%;
    }

    .contact-info-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
      border-color: var(--primary-300);
    }

    .contact-icon {
      width: 70px;
      height: 70px;
      margin: 0 auto 1.5rem;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-600), var(--primary-400));
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.75rem;
      box-shadow: 0 8px 20px rgba(2, 132, 199, 0.25);
    }

    .contact-info-card h5 {
      font-size: 1.25rem;
      margin-bottom: 1rem;
      color: var(--text-primary);
    }

    .contact-info-card p {
      color: var(--text-secondary);
      line-height: 1.6;
      margin-bottom: 0;
      font-size: 0.95rem;
    }

    .contact-link {
      color: var(--primary-600);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition-fast);
    }

    .contact-link:hover {
      color: var(--primary-700);
      text-decoration: underline;
    }

    .contact-form-card {
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      padding: 2.5rem;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--border-color);
      height: 100%;
    }

    .contact-form-card h2 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--text-primary);
    }

    .contact-form-subtitle {
      color: var(--text-secondary);
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    .map-card {
      background: var(--bg-card);
      border-radius: var(--radius-lg);
      padding: 2rem;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--border-color);
      height: 100%;
    }

    .map-card h3 {
      font-size: 1.75rem;
      color: var(--text-primary);
      margin-bottom: 1.5rem;
    }

    .map-container {
      position: relative;
      width: 100%;
      padding-bottom: 75%;
      border-radius: var(--radius-md);
      overflow: hidden;
      box-shadow: var(--shadow-md);
    }

    .map-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
    }

    .map-card ul li {
      padding: 0.375rem 0;
      color: var(--text-secondary);
      font-size: 0.95rem;
      display: flex;
      align-items: flex-start;
    }

    .map-card ul li i {
      margin-top: 0.25rem;
      margin-right: 0.75rem;
      flex-shrink: 0;
    }

    .contact-faq {
      background: var(--bg-secondary) !important;
      border-top: 1px solid var(--border-color);
      border-bottom: 1px solid var(--border-color);
    }

    [data-theme="dark"] .contact-faq {
      background: var(--bg-primary) !important;
    }

    /* Form Styles */
    .form-control, .form-select {
      padding: 0.875rem 1rem;
      border: 1px solid var(--border-color);
      border-radius: var(--radius-md);
      background: var(--bg-surface);
      color: var(--text-primary);
      font-size: 0.95rem;
      transition: var(--transition-fast);
    }

    [data-theme="dark"] .form-control,
    [data-theme="dark"] .form-select {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.1);
    }

    .form-control:focus, .form-select:focus {
      border-color: var(--primary-500);
      box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
      background: var(--bg-surface);
      color: var(--text-primary);
    }

    [data-theme="dark"] .form-control:focus,
    [data-theme="dark"] .form-select:focus {
      background: rgba(255, 255, 255, 0.08);
      border-color: var(--primary-500);
    }

    .form-label {
      font-weight: 600;
      color: var(--text-secondary);
      margin-bottom: 0.5rem;
      font-size: 0.95rem;
    }

    .form-check-input:checked {
      background-color: var(--primary-600);
      border-color: var(--primary-600);
    }

    .form-check-label {
      color: var(--text-secondary);
      font-size: 0.9rem;
      line-height: 1.5;
    }

    /* Alert Styles */
    .alert {
      border-radius: var(--radius-md);
      border: 1px solid;
      padding: 1.25rem 1.5rem;
    }

    .alert-success {
      background: rgba(16, 185, 129, 0.1);
      border-color: rgba(16, 185, 129, 0.3);
      color: var(--text-primary);
    }

    .alert-success i {
      color: var(--success);
    }

    [data-theme="dark"] .alert-success {
      background: rgba(16, 185, 129, 0.15);
      border-color: rgba(16, 185, 129, 0.25);
    }

    .alert-danger {
      background: rgba(239, 68, 68, 0.1);
      border-color: rgba(239, 68, 68, 0.3);
      color: var(--text-primary);
    }

    .alert-danger i {
      color: var(--error);
    }

    [data-theme="dark"] .alert-danger {
      background: rgba(239, 68, 68, 0.15);
      border-color: rgba(239, 68, 68, 0.25);
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
      .contact-form-card,
      .map-card {
        padding: 2rem;
      }
      
      .contact-info-card {
        padding: 1.75rem 1.25rem;
      }
      
      .contact-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
      }
    }

    @media (max-width: 768px) {
      .contact-hero {
        padding: 3rem 0;
      }
      
      .contact-form-section {
        padding: 3rem 0;
      }
      
      .contact-form-card,
      .map-card {
        padding: 1.75rem;
      }
      
      .contact-form-card h2 {
        font-size: 1.75rem;
      }
      
      .map-card h3 {
        font-size: 1.5rem;
      }
      
      .form-control, .form-select {
        padding: 0.75rem 0.875rem;
      }
    }

    @media (max-width: 576px) {
      .contact-form-card,
      .map-card {
        padding: 1.5rem;
      }
      
      .contact-info-card {
        padding: 1.5rem 1rem;
      }
      
      .contact-icon {
        width: 56px;
        height: 56px;
        font-size: 1.375rem;
        margin-bottom: 1rem;
      }
      
      .map-container {
        padding-bottom: 100%;
      }
    }

    /* Validation Styles */
    .was-validated .form-control:valid {
      border-color: var(--success);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2310b981' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .was-validated .form-control:invalid {
      border-color: var(--error);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23ef4444'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23ef4444' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
      display: none;
      width: 100%;
      margin-top: 0.25rem;
      font-size: 0.875rem;
      color: var(--error);
    }

    .was-validated .form-control:invalid ~ .invalid-feedback {
      display: block;
    }

    /* Fix for placeholder text in dark mode */
    [data-theme="dark"] ::placeholder {
      color: rgba(255, 255, 255, 0.5) !important;
      opacity: 1;
    }

    [data-theme="dark"] ::-webkit-input-placeholder {
      color: rgba(255, 255, 255, 0.5) !important;
    }

    [data-theme="dark"] ::-moz-placeholder {
      color: rgba(255, 255, 255, 0.5) !important;
      opacity: 1;
    }

    [data-theme="dark"] :-ms-input-placeholder {
      color: rgba(255, 255, 255, 0.5) !important;
    }
  </style>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="favicon.png">
  <link rel="apple-touch-icon" href="favicon.png">
  
  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "Eminent Overseas & Consultants",
    "description": "Professional overseas education consultancy for Japan and UK study programs",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "16/9, Indira Road (Behind Tejgaon College)",
      "addressLocality": "Dhaka",
      "postalCode": "1212",
      "addressCountry": "Bangladesh"
    },
    "telephone": "+880 XXXX-XXXXXX",
    "email": "info@eminentoverseas.uk",
    "openingHours": "Sa-Th 10:00-18:00",
    "url": "https://eminentoverseas.uk",
    "sameAs": [
      "https://facebook.com/eminentoverseas",
      "https://linkedin.com/company/eminentoverseas"
    ]
  }
  </script>
</head>
<body>
  <!-- Top Running Marquee -->
  <div class="top-marquee" aria-label="Eminent Overseas Announcement">
    <a href="contact.php" title="Start Your Study Abroad Journey">
      <div class="marquee-container">
        <div class="marquee-track">
          <!-- Content will be populated by JavaScript -->
        </div>
      </div>
    </a>
  </div>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.html" aria-label="Eminent Overseas Home">
        <img src="logo.png" alt="Eminent Overseas & Consultants Logo" class="brand-logo-img" loading="lazy" />
      </a>

      <div class="mobile-controls d-lg-none">
        <button class="lang-toggle lang-toggle-mobile" id="langToggleMobile" type="button" aria-label="Toggle language">
          EN
        </button>
        <button class="theme-toggle theme-toggle-mobile" id="themeToggleMobile" type="button" aria-label="Toggle theme">
          <i class="fas fa-moon"></i>
        </button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-label="Open menu" aria-expanded="false" aria-controls="navbarNav">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <!-- Home -->
          <li class="nav-item"><a class="nav-link" href="index.html" data-en="Home" data-ja="ホーム">Home</a></li>
          
          <!-- About Us -->
          <li class="nav-item"><a class="nav-link" href="about.html" data-en="About Us" data-ja="会社概要">About Us</a></li>
          
          <!-- Destinations Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-en="Destinations" data-ja="留学先">Destinations</span>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="study-japan.html" data-en="Study in Japan" data-ja="日本留学">Study in Japan</a></li>
              <li><a class="dropdown-item" href="study-uk.html" data-en="Study in UK" data-ja="英国留学">Study in UK</a></li>
            </ul>
          </li>
          
          <!-- Services Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-en="Services" data-ja="サービス">Services</span>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="japanese-course.html" data-en="Japanese Course" data-ja="日本語コース">Japanese Course</a></li>
              <li><a class="dropdown-item" href="visa-guidance.html" data-en="Visa Guidance" data-ja="ビザサポート">Visa Guidance</a></li>
            </ul>
          </li>
          
          <!-- Process -->
          <li class="nav-item"><a class="nav-link" href="process.html" data-en="Process" data-ja="プロセス">Process</a></li>
          
          <!-- Stories -->
          <li class="nav-item"><a class="nav-link" href="success-stories.html" data-en="Stories" data-ja="成功事例">Stories</a></li>
          
          <!-- Contact (will show as Book Consultation button on desktop) -->
          <li class="nav-item d-lg-none"><a class="nav-link active" href="contact.php" data-en="Contact" data-ja="お問い合わせ">Contact</a></li>
        </ul>

        <div class="d-flex align-items-center gap-2 d-none d-lg-flex">
          <button class="lang-toggle" id="langToggleDesktop" type="button" aria-label="Toggle language">
            EN
          </button>
          <button class="theme-toggle" id="themeToggleDesktop" type="button" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
          </button>
          <!-- Contact now shows as Book Consultation button on desktop -->
          <a href="contact.php" class="nav-highlight" data-en="Book Consultation" data-ja="相談を予約">Book Consultation</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <!-- Contact Hero Section -->
    <section class="contact-hero py-5">
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
            <h1 class="display-3 mb-4 animate-on-scroll text-gradient" 
                data-en="Contact Us" 
                data-ja="お問い合わせ">
              Contact Us
            </h1>
            <p class="lead mb-4 animate-on-scroll" style="transition-delay: 100ms;"
               data-en="Get in touch with our expert counselors for personalized guidance on studying in Japan or the UK"
               data-ja="日本または英国留学に関する個別ガイダンスのため、専門カウンセラーにお問い合わせください">
              Get in touch with our expert counselors for personalized guidance on studying in Japan or the UK
            </p>
            <div class="row g-4 mt-5">
              <div class="col-md-4 animate-on-scroll">
                <div class="contact-info-card">
                  <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <h5 data-en="Our Office" data-ja="当社オフィス">Our Office</h5>
                  <p data-en="16/9, Indira Road (Behind Tejgaon College)<br>Dhaka 1212, Bangladesh"
                     data-ja="16/9 インディラ通り (テジガオン大学裏)<br>ダッカ 1212, バングラデシュ">
                    16/9, Indira Road (Behind Tejgaon College)<br>Dhaka 1212, Bangladesh
                  </p>
                </div>
              </div>
              <div class="col-md-4 animate-on-scroll" style="transition-delay: 100ms;">
                <div class="contact-info-card">
                  <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                  </div>
                  <h5 data-en="Office Hours" data-ja="営業時間">Office Hours</h5>
                  <p data-en="Saturday - Thursday<br>10:00 AM - 6:00 PM<br>Friday: Closed"
                     data-ja="土曜日 - 木曜日<br>午前10時 - 午後6時<br>金曜日: 休業">
                    Saturday - Thursday<br>10:00 AM - 6:00 PM<br>Friday: Closed
                  </p>
                </div>
              </div>
              <div class="col-md-4 animate-on-scroll" style="transition-delay: 200ms;">
                <div class="contact-info-card">
                  <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <h5 data-en="Call Us" data-ja="お電話で">Call Us</h5>
                  <p>
                    <a href="tel:+880XXXXXXXXXX" class="contact-link">
                      +880 XXXX-XXXXXX
                    </a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form & Map Section -->
    <section class="contact-form-section py-5">
      <div class="container">
        <div class="row g-5">
          <!-- Contact Form -->
          <div class="col-lg-6 animate-on-scroll">
            <div class="contact-form-card">
              <h2 class="mb-4" data-en="Send Your Enquiry" data-ja="お問い合わせフォーム">Send Your Enquiry</h2>
              <p class="contact-form-subtitle mb-4" 
                 data-en="Fill out the form below and our counselors will contact you within 24 hours"
                 data-ja="以下のフォームにご記入ください。カウンセラーが24時間以内にご連絡いたします">
                Fill out the form below and our counselors will contact you within 24 hours
              </p>

              <!-- Form Section -->
              <form id="enquiryForm" class="needs-validation" action="send_email.php" method="POST" novalidate>
                <input type="hidden" name="form_type" value="contact_form">
                
                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="firstName" class="form-label" data-en="First Name *" data-ja="名 *">First Name *</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                    <div class="invalid-feedback" data-en="Please enter your first name" data-ja="名を入力してください">
                      Please enter your first name
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="lastName" class="form-label" data-en="Last Name *" data-ja="姓 *">Last Name *</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                    <div class="invalid-feedback" data-en="Please enter your last name" data-ja="姓を入力してください">
                      Please enter your last name
                    </div>
                  </div>
                </div>
                
                <div class="mb-3 mt-3">
                  <label for="email" class="form-label" data-en="Email Address *" data-ja="メールアドレス *">Email Address *</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                  <div class="invalid-feedback" data-en="Please enter a valid email address" data-ja="有効なメールアドレスを入力してください">
                    Please enter a valid email address
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="phone" class="form-label" data-en="Phone Number *" data-ja="電話番号 *">Phone Number *</label>
                  <input type="tel" class="form-control" id="phone" name="phone" required>
                  <div class="invalid-feedback" data-en="Please enter your phone number" data-ja="電話番号を入力してください">
                    Please enter your phone number
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="country" class="form-label" data-en="Country of Interest *" data-ja="希望留学先国 *">Country of Interest *</label>
                  <select class="form-select" id="country" name="country" required>
                    <option value="" selected disabled data-en="Select a country" data-ja="国を選択してください">Select a country</option>
                    <option value="japan" data-en="Japan" data-ja="日本">Japan</option>
                    <option value="uk" data-en="United Kingdom" data-ja="英国">United Kingdom</option>
                    <option value="both" data-en="Both Japan & UK" data-ja="日本と英国の両方">Both Japan & UK</option>
                    <option value="not-sure" data-en="Not Sure Yet" data-ja="まだ決めていません">Not Sure Yet</option>
                  </select>
                  <div class="invalid-feedback" data-en="Please select a country" data-ja="国を選択してください">
                    Please select a country
                  </div>
                </div>
                
                <div class="mb-3">
                  <label for="educationLevel" class="form-label" data-en="Current Education Level" data-ja="現在の学歴">Current Education Level</label>
                  <select class="form-select" id="educationLevel" name="educationLevel">
                    <option value="" selected data-en="Select education level" data-ja="学歴を選択してください">Select education level</option>
                    <option value="hsc" data-en="HSC / A-Level Completed" data-ja="HSC / A-Level 修了">HSC / A-Level Completed</option>
                    <option value="diploma" data-en="Diploma Completed" data-ja="ディプロマ修了">Diploma Completed</option>
                    <option value="bachelor" data-en="Bachelor's Degree" data-ja="学士号">Bachelor's Degree</option>
                    <option value="master" data-en="Master's Degree" data-ja="修士号">Master's Degree</option>
                    <option value="other" data-en="Other" data-ja="その他">Other</option>
                  </select>
                </div>
                
                <div class="mb-3">
                  <label for="message" class="form-label" data-en="Your Message *" data-ja="メッセージ *">Your Message *</label>
                  <textarea class="form-control" id="message" name="message" rows="4" required 
                            data-en-placeholder="Tell us about your study goals, timeline, and any specific questions..."
                            data-ja-placeholder="留学の目標、タイムライン、具体的な質問などをお知らせください"></textarea>
                  <div class="invalid-feedback" data-en="Please enter your message" data-ja="メッセージを入力してください">
                    Please enter your message
                  </div>
                </div>
                
                <div class="mb-3 form-check">
                  <input type="checkbox" class="form-check-input" id="consent" name="consent" required>
                  <label class="form-check-label" for="consent" 
                         data-en="I agree to receive information and updates about study abroad programs"
                         data-ja="留学プログラムに関する情報と更新を受け取ることに同意します">
                    I agree to receive information and updates about study abroad programs
                  </label>
                  <div class="invalid-feedback" data-en="You must agree before submitting" data-ja="送信前に同意が必要です">
                    You must agree before submitting
                  </div>
                </div>
                
                <!-- Honeypot spam protection -->
                <div style="display: none;">
                  <input type="text" name="honeypot" id="honeypot">
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-3">
                  <i class="fas fa-paper-plane me-2"></i>
                  <span data-en="Send Enquiry" data-ja="お問い合わせを送信">Send Enquiry</span>
                </button>
              </form>
            </div>
          </div>
          
          <!-- Google Map -->
          <div class="col-lg-6 animate-on-scroll" style="transition-delay: 150ms;">
            <div class="map-card">
              <h3 class="mb-4" data-en="Visit Our Office" data-ja="オフィスへのアクセス">Visit Our Office</h3>
              <div class="map-container">
                <iframe 
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.726084151411!2d90.38570937602312!3d23.757145388516097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b9540622f167%3A0xe3d018ed5ed30105!2sEminent%20Overseas%20Limited!5e0!3m2!1sen!2sbd!4v1770275041485!5m2!1sen!2sbd" 
                  style="border:0;" 
                  allowfullscreen="" 
                  loading="lazy" 
                  referrerpolicy="no-referrer-when-downgrade"
                  title="Eminent Overseas & Consultants Office Location"
                  data-en-title="Eminent Overseas & Consultants Office Location"
                  data-ja-title="エミネント海外留学コンサルタント オフィス所在地">
                </iframe>
              </div>
              
              <div class="mt-4">
                <h5 data-en="Getting Here" data-ja="アクセス方法">Getting Here</h5>
                <ul class="list-unstyled">
                  <li class="mb-2">
                    <i class="fas fa-bus text-primary me-2"></i>
                    <span data-en="Bus routes: 6, 8, 17, 21, 27 stop at Tejgaon" 
                          data-ja="バス路線: 6, 8, 17, 21, 27 がテジガオンで停車">
                      Bus routes: 6, 8, 17, 21, 27 stop at Tejgaon
                    </span>
                  </li>
                  <li class="mb-2">
                    <i class="fas fa-train text-primary me-2"></i>
                    <span data-en="Nearest metro station: Farmgate (15 min walk)" 
                          data-ja="最寄りのメトロ駅: ファームゲート (徒歩15分)">
                      Nearest metro station: Farmgate (15 min walk)
                    </span>
                  </li>
                  <li class="mb-2">
                    <i class="fas fa-car text-primary me-2"></i>
                    <span data-en="Parking available in the building premises" 
                          data-ja="建物内に駐車場あり">
                      Parking available in the building premises
                    </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="contact-faq py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center mb-5">
            <h2 class="display-3 mb-4 animate-on-scroll" data-en="Frequently Asked Questions" data-ja="よくある質問">Frequently Asked Questions</h2>
            <p class="lead animate-on-scroll" style="transition-delay: 120ms;"
               data-en="Quick answers to common questions about contacting us" 
               data-ja="お問い合わせに関するよくある質問への回答">
              Quick answers to common questions about contacting us
            </p>
          </div>
        </div>
        
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="accordion" id="contactFAQ">
              <div class="accordion-item animate-on-scroll">
                <h3 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                          data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1"
                          data-en="How soon will I get a response to my enquiry?" 
                          data-ja="お問い合わせにはどのくらいで返信がありますか？">
                    How soon will I get a response to my enquiry?
                  </button>
                </h3>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactFAQ">
                  <div class="accordion-body">
                    <p data-en="We respond to all enquiries within 24 hours during office hours (Saturday-Thursday, 10AM-6PM). For enquiries sent on Friday, you will receive a response on Saturday morning."
                       data-ja="営業時間内（土曜日から木曜日、午前10時から午後6時）に送信されたすべてのお問い合わせには24時間以内に返信いたします。金曜日に送信されたお問い合わせには、土曜日の午前中に返信いたします。">
                      We respond to all enquiries within 24 hours during office hours (Saturday-Thursday, 10AM-6PM). For enquiries sent on Friday, you will receive a response on Saturday morning.
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="accordion-item animate-on-scroll" style="transition-delay: 120ms;">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                          data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2"
                          data-en="Do I need to book an appointment for office visit?" 
                          data-ja="オフィス訪問には予約が必要ですか？">
                    Do I need to book an appointment for office visit?
                  </button>
                </h3>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                  <div class="accordion-body">
                    <p data-en="While walk-ins are welcome, we recommend booking an appointment to ensure dedicated time with our counselors. You can book through the 'Book Consultation' button or call us in advance."
                       data-ja="飛び込みでの訪問も歓迎しますが、カウンセラーとの専用時間を確保するために事前予約をお勧めします。「相談予約」ボタンから予約するか、事前にお電話ください。">
                      While walk-ins are welcome, we recommend booking an appointment to ensure dedicated time with our counselors. You can book through the 'Book Consultation' button or call us in advance.
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="accordion-item animate-on-scroll" style="transition-delay: 240ms;">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                          data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3"
                          data-en="What documents should I bring for consultation?" 
                          data-ja="相談にはどのような書類を持参すべきですか？">
                    What documents should I bring for consultation?
                  </button>
                </h3>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                  <div class="accordion-body">
                    <p data-en="For initial consultation, please bring your academic transcripts, passport copy (if available), and any language proficiency certificates. If you don't have these yet, don't worry – come as you are for the first discussion."
                       data-ja="初回相談には、成績証明書、パスポートのコピー（お持ちの場合）、語学能力証明書をお持ちください。まだお持ちでない場合でも心配ありません。まずは現状でご来社ください。">
                      For initial consultation, please bring your academic transcripts, passport copy (if available), and any language proficiency certificates. If you don't have these yet, don't worry – come as you are for the first discussion.
                    </p>
                  </div>
                </div>
              </div>
              
              <div class="accordion-item animate-on-scroll" style="transition-delay: 360ms;">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                          data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4"
                          data-en="Can parents/guardians accompany students for consultation?" 
                          data-ja="保護者は学生と一緒に相談に参加できますか？">
                    Can parents/guardians accompany students for consultation?
                  </button>
                </h3>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#contactFAQ">
                  <div class="accordion-body">
                    <p data-en="Absolutely! We encourage students to come with their parents or guardians. Studying abroad is a family decision, and we provide comprehensive information to help families make informed choices together."
                       data-ja="もちろんです！学生は保護者と一緒に来ることをお勧めします。留学は家族での決断であり、家族が一緒に情報に基づいた選択ができるよう包括的な情報を提供します。">
                      Absolutely! We encourage students to come with their parents or guardians. Studying abroad is a family decision, and we provide comprehensive information to help families make informed choices together.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="text-center mt-5 animate-on-scroll" style="transition-delay: 480ms;">
              <a href="tel:+880XXXXXXXXXX" class="btn btn-primary px-5 py-3 me-3">
                <i class="fas fa-phone me-2"></i>
                <span data-en="Call Us Now" data-ja="今すぐお電話">Call Us Now</span>
              </a>
              <a href="#enquiryForm" class="btn btn-outline-primary px-5 py-3">
                <i class="fas fa-envelope me-2"></i>
                <span data-en="Send Message" data-ja="メッセージを送信">Send Message</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-5 mb-lg-0 animate-on-scroll">
          <div class="footer-logo">
            <img src="logo.png" alt="Eminent Overseas & Consultants Logo" class="brand-logo-img" loading="lazy" />
          </div>
          <p class="footer-description" 
             data-en="Eminent Overseas & Consultants provides ethical, transparent study abroad guidance for Bangladesh students pursuing education in Japan and United Kingdom. We focus on proper preparation and honest counseling."
             data-ja="エミネント海外留学コンサルタントは、日本と英国で教育を追求するバングラデシュ人学生に倫理的で透明性のある留学ガイダンスを提供します。適切な準備と誠実なカウンセリングに焦点を当てています。">
            Eminent Overseas & Consultants provides ethical, transparent study abroad guidance 
            for Bangladesh students pursuing education in Japan and United Kingdom. 
            We focus on proper preparation and honest counseling.
          </p>

          <div class="social-links">
            <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-4 mb-5 mb-md-0 animate-on-scroll" style="transition-delay: 120ms;">
          <h5 class="footer-heading" data-en="Quick Links" data-ja="クイックリンク">Quick Links</h5>
          <a href="index.html" class="footer-link" data-en="Home" data-ja="ホーム">Home</a>
          <a href="about.html" class="footer-link" data-en="About Us" data-ja="会社概要">About Us</a>
          <a href="study-japan.html" class="footer-link" data-en="Study in Japan" data-ja="日本留学">Study in Japan</a>
          <a href="study-uk.html" class="footer-link" data-en="Study in UK" data-ja="英国留学">Study in UK</a>
          <a href="japanese-course.html" class="footer-link" data-en="Japanese Course" data-ja="日本語コース">Japanese Course</a>
          <a href="visa-guidance.html" class="footer-link" data-en="Visa Guidance" data-ja="ビザサポート">Visa Guidance</a>
          <a href="process.html" class="footer-link" data-en="Process" data-ja="プロセス">Process</a>
          <a href="success-stories.html" class="footer-link" data-en="Success Stories" data-ja="成功事例">Success Stories</a>
          <a href="#faq" class="footer-link" data-en="FAQ" data-ja="よくある質問">FAQ</a>
          <a href="contact.php" class="footer-link" data-en="Contact" data-ja="お問い合わせ">Contact</a>
        </div>

        <div class="col-lg-3 col-md-4 mb-5 mb-md-0 animate-on-scroll" style="transition-delay: 240ms;">
          <h5 class="footer-heading" data-en="Our Services" data-ja="サービス一覧">Our Services</h5>
          <a href="study-japan.html" class="footer-link" data-en="Japan Study Guidance" data-ja="日本留学ガイダンス">Japan Study Guidance</a>
          <a href="study-uk.html" class="footer-link" data-en="UK Study Guidance" data-ja="英国留学ガイダンス">UK Study Guidance</a>
          <a href="japanese-course.html#n5" class="footer-link" data-en="Japanese N5 Course" data-ja="日本語N5コース">Japanese N5 Course</a>
          <a href="japanese-course.html#n4" class="footer-link" data-en="Japanese N4 Course" data-ja="日本語N4コース">Japanese N4 Course</a>
          <a href="visa-guidance.html" class="footer-link" data-en="Student Visa Support" data-ja="学生ビザサポート">Student Visa Support</a>
          <a href="process.html" class="footer-link" data-en="Application Process" data-ja="申請プロセス">Application Process</a>
          <a href="contact.php" class="footer-link" data-en="Free Counseling" data-ja="無料相談">Free Counseling</a>
        </div>

        <div class="col-lg-3 col-md-4 animate-on-scroll" style="transition-delay: 360ms;">
          <h5 class="footer-heading" data-en="Contact Information" data-ja="連絡先情報">Contact Information</h5>
          <div class="mb-4">
            <div class="d-flex align-items-start mb-3">
              <i class="fas fa-map-marker-alt mt-1 me-3" style="color: var(--primary-600);"></i>
              <div>
                <div class="fw-bold small" data-en="Office Address" data-ja="事務所住所">Office Address</div>
                <div class="text-tertiary" data-en="16/9, Indira Road, Dhaka 1212" data-ja="16/9 インディラ通り, ダッカ 1212">16/9, Indira Road, Dhaka 1212</div>
              </div>
            </div>

            <div class="d-flex align-items-start mb-3">
              <i class="fas fa-clock mt-1 me-3" style="color: var(--primary-600);"></i>
              <div>
                <div class="fw-bold small" data-en="Office Hours" data-ja="営業時間">Office Hours</div>
                <div class="text-tertiary" data-en="Saturday – Thursday" data-ja="土曜日 – 木曜日">Saturday – Thursday</div>
                <div class="text-tertiary" data-en="10:00 AM – 6:00 PM" data-ja="午前10時 – 午後6時">10:00 AM – 6:00 PM</div>
              </div>
            </div>

            <div class="d-flex align-items-start">
              <i class="fas fa-phone mt-1 me-3" style="color: var(--primary-600);"></i>
              <div>
                <div class="fw-bold small" data-en="Phone/WhatsApp" data-ja="電話/WhatsApp">Phone/WhatsApp</div>
                <a href="tel:+880XXXXXXXXXX" class="footer-link">+880 XXXX-XXXXXX</a>
                <div class="text-tertiary small mt-1" data-en="Call or message for appointment" data-ja="予約のためにお電話またはメッセージを">Call or message for appointment</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-bottom animate-on-scroll" style="transition-delay: 480ms;">
        <p data-en="© <span id='currentYear'></span> Eminent Overseas & Consultants. All rights reserved."
           data-ja="© <span id='currentYear'></span> エミネント海外留学コンサルタント。無断複写・転載を禁じます。">
          © <span id="currentYear"></span> Eminent Overseas & Consultants. All rights reserved.
        </p>
        <div class="footer-legal">
          <a href="terms.html" data-en="Terms & Conditions" data-ja="利用規約">Terms & Conditions</a>
          <a href="privacy.html" data-en="Privacy Policy" data-ja="プライバシーポリシー">Privacy Policy</a>
          <a href="disclaimer.html" data-en="Disclaimer" data-ja="免責事項">Disclaimer</a>
          <a href="sitemap.html" data-en="Sitemap" data-ja="サイトマップ">Sitemap</a>
        </div>
        <div class="crafted-by">
          <a href="https://prodo.top" target="_blank" rel="noopener" class="footer-link" 
             data-en="Crafted by ProDo" data-ja="ProDoによって作成">
            Crafted by ProDo
          </a>
        </div>
        <p class="small text-tertiary mt-2" data-en="We provide guidance and preparation support. We do not guarantee visa approval or admission outcomes."
           data-ja="ガイダンスと準備サポートを提供します。ビザ承認や入学結果を保証するものではありません。">
          We provide guidance and preparation support. We do not guarantee visa approval or admission outcomes.
        </p>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <button class="back-top" id="backTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
  </button>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
  
  <!-- Contact Page Specific JavaScript -->
  <script>
    // Contact Page JavaScript
    document.addEventListener('DOMContentLoaded', function() {
      // Update current year in footer
      const yearEl = document.getElementById('currentYear');
      if (yearEl) {
        yearEl.textContent = new Date().getFullYear();
      }

      // Initialize the app with custom marquee content for contact page
      if (typeof LanguageManager !== 'undefined') {
        const originalInit = LanguageManager.prototype.init;
        LanguageManager.prototype.init = function() {
          this.marqueeContent = {
            en: [
              "Contact Eminent Overseas & Consultants | Book Your Free Consultation | Dhaka Office",
              "Japan & UK Study Guidance | Ethical Counseling | No Visa Guarantees | Transparent Process",
              "Visit Our Office: 16/9, Indira Road, Dhaka | Sat-Thu: 10:00 AM - 6:00 PM",
              "Call/WhatsApp: +880 XXXX-XXXXXX | Email: info@eminentoverseas.uk"
            ],
            ja: [
              "エミネント海外留学コンサルタントにお問い合わせ | 無料相談予約 | ダッカオフィス",
              "日本・英国留学ガイダンス | 倫理的カウンセリング | ビザ保証なし | 透明なプロセス",
              "オフィス訪問: 16/9 インディラ通り, ダッカ | 土-木: 午前10時 - 午後6時",
              "電話/WhatsApp: +880 XXXX-XXXXXX | メール: info@eminentoverseas.uk"
            ]
          };
          originalInit.call(this);
        };
      }

      // Form functionality
      const form = document.getElementById('enquiryForm');
      if (form) {
        // Update textarea placeholder based on language
        function updateFormPlaceholders() {
          const currentLang = document.documentElement.lang || 'en';
          const messageTextarea = document.getElementById('message');
          if (messageTextarea) {
            const placeholder = messageTextarea.getAttribute(`data-${currentLang}-placeholder`);
            if (placeholder) {
              messageTextarea.placeholder = placeholder;
            }
          }
        }

        // Initialize placeholders
        updateFormPlaceholders();

        // Listen for language changes
        const observer = new MutationObserver(updateFormPlaceholders);
        observer.observe(document.documentElement, { 
          attributes: true, 
          attributeFilter: ['lang'] 
        });

        // Form submission handler
        form.addEventListener('submit', function(event) {
          event.preventDefault();
          event.stopPropagation();

          if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
          }

          const submitBtn = form.querySelector('button[type="submit"]');
          const originalContent = submitBtn.innerHTML;
          const currentLang = document.documentElement.lang || 'en';

          // Update button to loading state
          if (currentLang === 'ja') {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>送信中...';
          } else {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
          }
          submitBtn.disabled = true;

          // Honeypot check
          const honeypot = document.getElementById('honeypot');
          if (honeypot && honeypot.value) {
            // Likely spam
            showAlert('danger', currentLang === 'ja' ? 'スパムが検出されました' : 'Spam detected');
            resetSubmitButton(submitBtn, originalContent);
            return;
          }

          // Prepare form data
          const formData = new FormData(form);

          // Submit via fetch
          fetch('send_email.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.text())
          .then(data => {
            // Handle response
            if (data.includes('success') || data.includes('Success')) {
              showAlert('success', currentLang === 'ja' 
                ? 'ありがとうございます！お問い合わせが送信されました。24時間以内にご連絡いたします。'
                : 'Thank you! Your enquiry has been submitted. We\'ll contact you within 24 hours.');
              form.reset();
              form.classList.remove('was-validated');
            } else {
              showAlert('danger', currentLang === 'ja' 
                ? '送信エラーが発生しました。もう一度お試しください。'
                : 'Submission error. Please try again.');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            showAlert('danger', currentLang === 'ja' 
              ? '送信中にエラーが発生しました。後でもう一度お試しください。'
              : 'An error occurred while sending. Please try again later.');
          })
          .finally(() => {
            resetSubmitButton(submitBtn, originalContent);
          });
        });

        // Helper function to reset submit button
        function resetSubmitButton(button, originalContent) {
          setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;
          }, 2000);
        }

        // Helper function to show alerts
        function showAlert(type, message) {
          // Remove existing alerts
          const existingAlerts = document.querySelectorAll('.alert');
          existingAlerts.forEach(alert => alert.remove());

          const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
          const alertHTML = `
            <div class="alert alert-${type} alert-dismissible fade show mt-4" role="alert">
              <i class="fas ${icon} me-2"></i>
              ${message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;

          form.insertAdjacentHTML('beforebegin', alertHTML);

          // Scroll to alert
          const alertElement = document.querySelector('.alert');
          if (alertElement) {
            alertElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          }
        }
      }

      // Initialize scroll animations
      function initScrollAnimations() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible');
            }
          });
        }, {
          threshold: 0.1,
          rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(element => observer.observe(element));

        // Check initial state
        window.addEventListener('load', () => {
          elements.forEach(element => {
            const rect = element.getBoundingClientRect();
            if (rect.top < window.innerHeight - 50) {
              element.classList.add('visible');
            }
          });
        });
      }

      // Initialize back to top button
      function initBackToTop() {
        const backTopBtn = document.getElementById('backTop');
        if (!backTopBtn) return;

        window.addEventListener('scroll', () => {
          if (window.scrollY > 300) {
            backTopBtn.classList.add('show');
          } else {
            backTopBtn.classList.remove('show');
          }
        });

        backTopBtn.addEventListener('click', () => {
          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        });
      }

      // Initialize FAQ accordion
      function initFAQAccordion() {
        const accordionButtons = document.querySelectorAll('.accordion-button');
        
        accordionButtons.forEach(button => {
          button.addEventListener('click', () => {
            const collapseElement = button.nextElementSibling;
            if (collapseElement.classList.contains('show')) {
              collapseElement.style.maxHeight = collapseElement.scrollHeight + 'px';
              setTimeout(() => {
                collapseElement.style.maxHeight = '0';
              }, 10);
            } else {
              collapseElement.style.maxHeight = collapseElement.scrollHeight + 'px';
              setTimeout(() => {
                collapseElement.style.maxHeight = 'none';
              }, 300);
            }
          });
        });
      }

      // Initialize all functions
      initScrollAnimations();
      initBackToTop();
      initFAQAccordion();

      // Smooth scroll for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          const targetId = this.getAttribute('href');
          if (targetId === '#') return;
          
          const targetElement = document.querySelector(targetId);
          if (targetElement) {
            e.preventDefault();
            const navbar = document.querySelector('.navbar');
            const marquee = document.querySelector('.top-marquee');
            const navbarHeight = navbar ? navbar.offsetHeight : 0;
            const marqueeHeight = marquee ? marquee.offsetHeight : 0;
            
            const offsetTop = targetElement.offsetTop - navbarHeight - marqueeHeight;
            
            window.scrollTo({
              top: Math.max(offsetTop, 0),
              behavior: 'smooth'
            });
          }
        });
      });
    });
  </script>
</body>
</html>