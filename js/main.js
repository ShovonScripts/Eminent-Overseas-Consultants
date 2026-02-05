// ======================
// LANGUAGE MANAGEMENT SYSTEM
// ======================

class LanguageManager {
  constructor() {
    this.currentLang = localStorage.getItem('language') || 'en';
    this.marqueeContent = {
      en: [
        "Eminent Overseas & Consultants | Japan & UK Study Guidance | Ethical Visa Support",
        "Japanese Language Training (N5/N4) | UK Higher Education Counseling",
        "No Visa Guarantees | Transparent Process | Guardian-Friendly Approach",
        "Dhaka Office | Sat–Thu, 10:00 AM–6:00 PM | Book Your Free Consultation"
      ],
      ja: [
        "エミネント海外留学コンサルタント | 日本・英国留学サポート | 倫理的ビザガイダンス",
        "日本語研修 (N5/N4) | 英国高等教育カウンセリング",
        "ビザ保証なし | 透明なプロセス | 保護者向けサポート",
        "ダッカオフィス | 土〜木、午前10時〜午後6時 | 無料相談予約"
      ]
    };
  }

  init() {
    this.loadLanguage();
    this.setupEventListeners();
    this.updateMarquee();
  }

  loadLanguage() {
    // Set HTML lang attribute
    document.documentElement.lang = this.currentLang;
    
    // Update language toggle buttons
    this.updateToggleButtons();
    
    // Update all text content
    this.updateAllText();
  }

  updateToggleButtons() {
    const toggleText = this.currentLang === 'en' ? 'EN' : 'JP';
    const toggleMobile = document.getElementById('langToggleMobile');
    const toggleDesktop = document.getElementById('langToggleDesktop');
    
    if (toggleMobile) toggleMobile.textContent = toggleText;
    if (toggleDesktop) toggleDesktop.textContent = toggleText;
  }

  updateAllText() {
    // Update all elements with data-en and data-ja attributes
    document.querySelectorAll('[data-en], [data-ja]').forEach(element => {
      const text = element.dataset[this.currentLang];
      if (text) {
        // Handle HTML content (for headings with spans)
        if (text.includes('<span') || text.includes('<br')) {
          element.innerHTML = text;
        } else {
          element.textContent = text;
        }
      }
    });

    // Update title tag
    if (this.currentLang === 'ja') {
      document.title = 'エミネント海外留学コンサルタント | 日本・英国留学ガイダンス';
    } else {
      document.title = 'Eminent Overseas & Consultants | Japan & UK Study Abroad Guidance';
    }

    // Update meta description
    const metaDesc = document.querySelector('meta[name="description"]');
    if (metaDesc) {
      if (this.currentLang === 'ja') {
        metaDesc.content = 'エミネント海外留学コンサルタントは、日本と英国で高等教育を目指すバングラデシュ人学生に透明で倫理的なガイダンスを提供します。日本語研修(N5/N4)とビザサポート。';
      } else {
        metaDesc.content = 'Eminent Overseas & Consultants provides transparent, ethical guidance for Bangladeshi students pursuing higher education in Japan and the UK. Japanese language training (N5/N4) and visa support.';
      }
    }
  }

  updateMarquee() {
    const marqueeTrack = document.querySelector('.marquee-track');
    if (!marqueeTrack) return;

    const content = this.marqueeContent[this.currentLang];
    
    // Clear existing content
    marqueeTrack.innerHTML = '';
    
    // Create duplicate content for seamless loop (2 sets)
    const items = [...content, ...content].map(item => {
      const div = document.createElement('div');
      div.className = 'marquee-item';
      div.innerHTML = `
        <span class="marquee-dot"></span>
        ${item}
      `;
      return div;
    });
    
    // Append all items
    items.forEach(item => marqueeTrack.appendChild(item));
    
    // Restart animation
    marqueeTrack.style.animation = 'none';
    setTimeout(() => {
      marqueeTrack.style.animation = 'marqueeMove 25s linear infinite';
    }, 10);
  }

  switchLanguage() {
    const newLang = this.currentLang === 'en' ? 'ja' : 'en';
    this.currentLang = newLang;
    localStorage.setItem('language', newLang);
    this.loadLanguage();
    this.updateMarquee();
  }

  setupEventListeners() {
    // Language toggle buttons
    const langToggleMobile = document.getElementById('langToggleMobile');
    const langToggleDesktop = document.getElementById('langToggleDesktop');
    
    if (langToggleMobile) {
      langToggleMobile.addEventListener('click', () => this.switchLanguage());
    }
    
    if (langToggleDesktop) {
      langToggleDesktop.addEventListener('click', () => this.switchLanguage());
    }
  }
}

// ======================
// THEME MANAGEMENT
// ======================

class ThemeManager {
  constructor() {
    this.currentTheme = localStorage.getItem('theme') || 'light';
  }

  init() {
    this.applyTheme(this.currentTheme);
    this.setupEventListeners();
  }

  applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    this.setToggleIcon(theme);
  }

  setToggleIcon(theme) {
    const icon = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
    document.querySelectorAll('.theme-toggle i').forEach(el => {
      el.className = icon;
    });
  }

  toggleTheme() {
    const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
    this.currentTheme = newTheme;
    this.applyTheme(newTheme);
  }

  setupEventListeners() {
    document.querySelectorAll('.theme-toggle').forEach(toggle => {
      toggle.addEventListener('click', () => this.toggleTheme());
    });
  }
}

// ======================
// FULLSCREEN HERO SLIDER
// ======================

class FullscreenHeroSlider {
  constructor() {
    this.currentSlide = 0;
    this.slides = [];
    this.totalSlides = 0;
    this.autoSlideInterval = null;
    this.autoSlideDelay = 5000; // 5 seconds
    this.isAutoPlaying = true;
    this.isTransitioning = false;
    this.touchStartX = 0;
    this.touchEndX = 0;
  }

  init() {
    this.getSlides();
    if (this.totalSlides === 0) return;
    
    this.setupEventListeners();
    this.updateSlider();
    this.startAutoSlide();
  }

  getSlides() {
    this.slides = document.querySelectorAll('.fullscreen-hero .slide');
    this.totalSlides = this.slides.length;
    return this.totalSlides;
  }

  goToSlide(index, direction = 'next') {
    if (this.isTransitioning || this.totalSlides === 0) return;
    
    this.isTransitioning = true;
    const prevSlide = this.currentSlide;
    
    // Calculate new slide index
    if (index >= this.totalSlides) {
      this.currentSlide = 0;
    } else if (index < 0) {
      this.currentSlide = this.totalSlides - 1;
    } else {
      this.currentSlide = index;
    }
    
    // Update slides
    this.slides[prevSlide].classList.remove('active');
    this.slides[this.currentSlide].classList.add('active');
    
    // Update UI
    this.updateIndicators();
    this.updateCounter();
    
    // Reset transitioning flag after animation
    setTimeout(() => {
      this.isTransitioning = false;
    }, 1200); // Match CSS transition duration
  }

  nextSlide() {
    this.goToSlide(this.currentSlide + 1, 'next');
  }

  prevSlide() {
    this.goToSlide(this.currentSlide - 1, 'prev');
  }

  updateSlider() {
    // Ensure only current slide is active
    this.slides.forEach((slide, index) => {
      if (index === this.currentSlide) {
        slide.classList.add('active');
      } else {
        slide.classList.remove('active');
      }
    });
    
    this.updateIndicators();
    this.updateCounter();
  }

  updateIndicators() {
    const indicators = document.querySelectorAll('.fullscreen-hero .indicator');
    indicators.forEach((indicator, index) => {
      if (index === this.currentSlide) {
        indicator.classList.add('active');
      } else {
        indicator.classList.remove('active');
      }
    });
  }

  updateCounter() {
    const currentEl = document.querySelector('.fullscreen-hero .slide-counter .current');
    const totalEl = document.querySelector('.fullscreen-hero .slide-counter .total');
    
    if (currentEl) {
      currentEl.textContent = String(this.currentSlide + 1).padStart(2, '0');
    }
    
    if (totalEl) {
      totalEl.textContent = String(this.totalSlides).padStart(2, '0');
    }
  }

  startAutoSlide() {
    if (this.autoSlideInterval) {
      clearInterval(this.autoSlideInterval);
    }
    
    this.autoSlideInterval = setInterval(() => {
      if (this.isAutoPlaying && !this.isTransitioning) {
        this.nextSlide();
      }
    }, this.autoSlideDelay);
  }

  stopAutoSlide() {
    if (this.autoSlideInterval) {
      clearInterval(this.autoSlideInterval);
      this.autoSlideInterval = null;
    }
  }

  restartAutoSlide() {
    this.stopAutoSlide();
    this.startAutoSlide();
  }

  setupEventListeners() {
    // Previous button
    const prevBtn = document.querySelector('.fullscreen-hero .prev-btn');
    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.prevSlide();
        this.restartAutoSlide();
      });
    }

    // Next button
    const nextBtn = document.querySelector('.fullscreen-hero .next-btn');
    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        this.nextSlide();
        this.restartAutoSlide();
      });
    }

    // Dot indicators
    const indicatorsContainer = document.querySelector('.fullscreen-hero .slide-indicators');
    if (indicatorsContainer) {
      indicatorsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('indicator')) {
          const slideIndex = parseInt(e.target.getAttribute('data-slide'));
          if (!isNaN(slideIndex)) {
            this.goToSlide(slideIndex);
            this.restartAutoSlide();
          }
        }
      });
    }

    // Pause on hover
    const hero = document.querySelector('.fullscreen-hero');
    if (hero) {
      hero.addEventListener('mouseenter', () => {
        this.isAutoPlaying = false;
      });
      
      hero.addEventListener('mouseleave', () => {
        this.isAutoPlaying = true;
        this.restartAutoSlide();
      });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (document.querySelector('.fullscreen-hero')) {
        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          this.prevSlide();
          this.restartAutoSlide();
        } else if (e.key === 'ArrowRight') {
          e.preventDefault();
          this.nextSlide();
          this.restartAutoSlide();
        }
      }
    });

    // Touch/swipe support
    if (hero) {
      hero.addEventListener('touchstart', (e) => {
        this.touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      
      hero.addEventListener('touchend', (e) => {
        this.touchEndX = e.changedTouches[0].screenX;
        this.handleSwipe();
      }, { passive: true });
    }
  }

  handleSwipe() {
    const swipeThreshold = 50;
    const diff = this.touchStartX - this.touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe left - next slide
        this.nextSlide();
      } else {
        // Swipe right - previous slide
        this.prevSlide();
      }
      this.restartAutoSlide();
    }
  }
}

// ======================
// COMPANY OVERVIEW SLIDER
// ======================

class CompanyOverviewSlider {
  constructor() {
    this.currentSlide = 0;
    this.slides = [];
    this.autoSlideInterval = null;
    this.autoSlideDelay = 5000; // 5 seconds
    this.isAutoPlaying = true;
  }

  init() {
    this.getSlides();
    this.setupEventListeners();
    this.updateSliderPosition();
    this.startAutoSlide();
  }

  getSlides() {
    this.slides = document.querySelectorAll('.overview-slide');
    return this.slides.length;
  }

  goToSlide(index) {
    const totalSlides = this.getSlides();
    if (index >= totalSlides) {
      this.currentSlide = 0;
    } else if (index < 0) {
      this.currentSlide = totalSlides - 1;
    } else {
      this.currentSlide = index;
    }
    
    this.updateSliderPosition();
    this.updateActiveDot();
    this.updateProgressBar();
    this.updateCounter();
  }

  nextSlide() {
    this.goToSlide(this.currentSlide + 1);
  }

  prevSlide() {
    this.goToSlide(this.currentSlide - 1);
  }

  updateSliderPosition() {
    const track = document.getElementById('overviewSliderTrack');
    if (track) {
      const slideWidth = 100; // 100% per slide
      track.style.transform = `translateX(-${this.currentSlide * slideWidth}%)`;
      
      // Update slide opacity
      this.slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === this.currentSlide);
      });
    }
  }

  updateActiveDot() {
    const dots = document.querySelectorAll('.slider-dot');
    dots.forEach((dot, index) => {
      if (index === this.currentSlide) {
        dot.classList.add('active');
      } else {
        dot.classList.remove('active');
      }
    });
  }

  updateProgressBar() {
    const progressBar = document.getElementById('progressBar');
    if (progressBar && this.slides.length > 0) {
      const progress = ((this.currentSlide + 1) / this.slides.length) * 100;
      progressBar.style.width = `${progress}%`;
    }
  }

  updateCounter() {
    const currentSlideEl = document.getElementById('currentSlide');
    const totalSlidesEl = document.getElementById('totalSlides');
    
    if (currentSlideEl) {
      currentSlideEl.textContent = this.currentSlide + 1;
    }
    
    if (totalSlidesEl) {
      totalSlidesEl.textContent = this.slides.length;
    }
  }

  startAutoSlide() {
    if (this.autoSlideInterval) {
      clearInterval(this.autoSlideInterval);
    }
    
    this.autoSlideInterval = setInterval(() => {
      if (this.isAutoPlaying) {
        this.nextSlide();
      }
    }, this.autoSlideDelay);
  }

  stopAutoSlide() {
    if (this.autoSlideInterval) {
      clearInterval(this.autoSlideInterval);
      this.autoSlideInterval = null;
    }
  }

  setupEventListeners() {
    // Previous button
    const prevBtn = document.getElementById('overviewSliderPrev');
    if (prevBtn) {
      prevBtn.addEventListener('click', () => {
        this.prevSlide();
        this.restartAutoSlide();
      });
    }

    // Next button
    const nextBtn = document.getElementById('overviewSliderNext');
    if (nextBtn) {
      nextBtn.addEventListener('click', () => {
        this.nextSlide();
        this.restartAutoSlide();
      });
    }

    // Dot navigation
    const dotsContainer = document.getElementById('overviewSliderDots');
    if (dotsContainer) {
      dotsContainer.addEventListener('click', (e) => {
        if (e.target.classList.contains('slider-dot')) {
          const slideIndex = parseInt(e.target.getAttribute('data-slide'));
          this.goToSlide(slideIndex);
          this.restartAutoSlide();
        }
      });
    }

    // Pause auto-slide on hover
    const sliderWrapper = document.querySelector('.overview-slider-wrapper');
    if (sliderWrapper) {
      sliderWrapper.addEventListener('mouseenter', () => {
        this.isAutoPlaying = false;
      });
      
      sliderWrapper.addEventListener('mouseleave', () => {
        this.isAutoPlaying = true;
        this.startAutoSlide();
      });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      const overviewSection = document.getElementById('overview');
      if (!overviewSection) return;
      
      const rect = overviewSection.getBoundingClientRect();
      const isInView = rect.top < window.innerHeight && rect.bottom >= 0;
      
      if (isInView) {
        if (e.key === 'ArrowLeft') {
          e.preventDefault();
          this.prevSlide();
          this.restartAutoSlide();
        } else if (e.key === 'ArrowRight') {
          e.preventDefault();
          this.nextSlide();
          this.restartAutoSlide();
        }
      }
    });

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    const sliderContainer = document.querySelector('.slider-aspect-ratio');
    if (sliderContainer) {
      sliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      });
      
      sliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        this.handleSwipe(touchStartX, touchEndX);
      });
    }
  }

  handleSwipe(startX, endX) {
    const swipeThreshold = 50;
    const diff = startX - endX;
    
    if (Math.abs(diff) > swipeThreshold) {
      if (diff > 0) {
        // Swipe left - next slide
        this.nextSlide();
      } else {
        // Swipe right - previous slide
        this.prevSlide();
      }
      this.restartAutoSlide();
    }
  }

  restartAutoSlide() {
    this.stopAutoSlide();
    this.startAutoSlide();
  }
}

// ======================
// MAIN APPLICATION
// ======================

class App {
  constructor() {
    this.languageManager = new LanguageManager();
    this.themeManager = new ThemeManager();
    this.heroSlider = new FullscreenHeroSlider();
    this.companyOverviewSlider = new CompanyOverviewSlider();
    this.init();
  }

  init() {
    // Initialize managers
    this.languageManager.init();
    this.themeManager.init();
    
    // Initialize hero slider if exists
    if (document.querySelector('.fullscreen-hero')) {
      this.heroSlider.init();
    }
    
    // Initialize company overview slider if exists
    if (document.querySelector('.overview-slider-track')) {
      this.companyOverviewSlider.init();
    }

    // Initialize other components
    this.initScrollAnimations();
    this.initNavbarScroll();
    this.initCounters();
    this.initBackToTop();
    this.initEventListeners();
    this.initCurrentYear();
    this.initMarqueePause();
    this.initMobileMenu();
    this.initPlayButton();
    this.initFAQAccordion();
  }

  initScrollAnimations() {
    const observerOptions = { 
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, observerOptions);

    const animateEls = document.querySelectorAll('.animate-on-scroll');
    animateEls.forEach(el => observer.observe(el));

    // Make sections visible immediately if already in view
    window.addEventListener('load', () => {
      animateEls.forEach(el => {
        const r = el.getBoundingClientRect();
        if (r.top < window.innerHeight - 20) {
          el.classList.add('visible');
        }
      });
    });
  }

  initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;
    
    // Check initial state
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    }
    
    // Update on scroll
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  }

  initCounters() {
    const counters = document.querySelectorAll('.stat-number');
    if (counters.length === 0) return;
    
    let counterStarted = false;

    const animateCounter = () => {
      const speed = 200;

      counters.forEach(counter => {
        const target = Number(counter.getAttribute('data-count') || 0);
        const suffix = counter.getAttribute('data-suffix') || '';
        const currentText = counter.innerText;
        const current = Number(currentText.replace(/[^0-9]/g, '') || 0);
        const increment = target / speed;

        if (current < target) {
          const newValue = Math.ceil(current + increment);
          counter.innerText = newValue + suffix;
        } else {
          counter.innerText = target + suffix;
        }
      });

      const stillCounting = [...counters].some(c => {
        const t = Number(c.getAttribute('data-count') || 0);
        const v = Number(c.innerText.replace(/[^0-9]/g, '') || 0);
        return v < t;
      });

      if (stillCounting) {
        requestAnimationFrame(animateCounter);
      }
    };

    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !counterStarted) {
          counterStarted = true;
          animateCounter();
        }
      });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) statsObserver.observe(statsSection);
  }

  initBackToTop() {
    const backTopBtn = document.getElementById('backTop');
    if (!backTopBtn) return;

    const updateBackTopVisibility = () => {
      if (window.scrollY > 300) {
        backTopBtn.classList.add('show');
      } else {
        backTopBtn.classList.remove('show');
      }
    };

    // Initial check
    updateBackTopVisibility();

    // Throttled scroll listener
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          updateBackTopVisibility();
          ticking = false;
        });
        ticking = true;
      }
    });

    // Click handler
    backTopBtn.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }

  initEventListeners() {
    // Top marquee pause on hover
    const marquee = document.querySelector('.top-marquee');
    if (marquee) {
      marquee.addEventListener('mouseenter', () => {
        const track = marquee.querySelector('.marquee-track');
        if (track) track.style.animationPlayState = 'paused';
      });
      
      marquee.addEventListener('mouseleave', () => {
        const track = marquee.querySelector('.marquee-track');
        if (track) track.style.animationPlayState = 'running';
      });
    }

    // Testimonial marquee pause on hover (if exists)
    const testimonialTrack = document.querySelector('.testimonial-marquee-track');
    const testimonialPause = document.querySelector('.testimonial-pause');
    
    if (testimonialTrack && testimonialPause) {
      testimonialPause.addEventListener('mouseenter', () => {
        testimonialTrack.style.animationPlayState = 'paused';
      });
      
      testimonialPause.addEventListener('mouseleave', () => {
        testimonialTrack.style.animationPlayState = 'running';
      });
    }
  }

  initCurrentYear() {
    const yearEl = document.getElementById('currentYear');
    if (yearEl) yearEl.textContent = String(new Date().getFullYear());
  }

  initMarqueePause() {
    // Already handled in initEventListeners
  }

  initMobileMenu() {
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navLinks && navbarCollapse) {
      navLinks.forEach(link => {
        link.addEventListener('click', () => {
          if (window.innerWidth < 992) {
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
            if (bsCollapse) {
              bsCollapse.hide();
            }
          }
        });
      });
    }
  }

  initPlayButton() {
    const playButton = document.querySelector('.play-button');
    if (playButton) {
      playButton.addEventListener('click', function(e) {
        e.stopPropagation();
        console.log('Facility tour video would play here.');
        // Add video functionality here
        // Example: open a modal with a video player
      });
    }
  }

  initFAQAccordion() {
    // Initialize Bootstrap accordion behavior
    const accordionButtons = document.querySelectorAll('.accordion-button');
    
    accordionButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Add smooth transition for the accordion body
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
}

// ======================
// GLOBAL SWIPE SUPPORT FOR MOBILE
// ======================

let touchStartX = 0;
let touchEndX = 0;

document.addEventListener('touchstart', (e) => {
  touchStartX = e.changedTouches[0].screenX;
}, false);

document.addEventListener('touchend', (e) => {
  touchEndX = e.changedTouches[0].screenX;
  handleGlobalSwipe();
}, false);

function handleGlobalSwipe() {
  // Check which slider is in view and handle accordingly
  const overviewSection = document.getElementById('overview');
  const heroSection = document.querySelector('.fullscreen-hero');
  
  // Check hero slider
  if (heroSection) {
    const heroRect = heroSection.getBoundingClientRect();
    const heroInView = heroRect.top < window.innerHeight && heroRect.bottom >= 0;
    
    if (heroInView && window.app && window.app.heroSlider) {
      const swipeThreshold = 50;
      
      if (touchEndX < touchStartX - swipeThreshold) {
        // Swipe left - next slide
        window.app.heroSlider.nextSlide();
        window.app.heroSlider.restartAutoSlide();
      } else if (touchEndX > touchStartX + swipeThreshold) {
        // Swipe right - previous slide
        window.app.heroSlider.prevSlide();
        window.app.heroSlider.restartAutoSlide();
      }
      return;
    }
  }
  
  // Check overview slider
  if (overviewSection) {
    const overviewRect = overviewSection.getBoundingClientRect();
    const overviewInView = overviewRect.top < window.innerHeight && overviewRect.bottom >= 0;
    
    if (overviewInView && window.app && window.app.companyOverviewSlider) {
      const swipeThreshold = 50;
      
      if (touchEndX < touchStartX - swipeThreshold) {
        // Swipe left - next slide
        window.app.companyOverviewSlider.nextSlide();
        window.app.companyOverviewSlider.restartAutoSlide();
      } else if (touchEndX > touchStartX + swipeThreshold) {
        // Swipe right - previous slide
        window.app.companyOverviewSlider.prevSlide();
        window.app.companyOverviewSlider.restartAutoSlide();
      }
    }
  }
}

// ======================
// INITIALIZE APP
// ======================

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  // Override marquee content for Eminent
  if (typeof LanguageManager !== 'undefined') {
    const originalInit = LanguageManager.prototype.init;
    LanguageManager.prototype.init = function() {
      this.marqueeContent = {
        en: [
          "Eminent Overseas & Consultants | Japan & UK Study Guidance | Ethical Visa Support",
          "Japanese Language Training (N5/N4) | UK Higher Education Counseling",
          "No Visa Guarantees | Transparent Process | Guardian-Friendly Approach",
          "Dhaka Office | Sat–Thu, 10:00 AM–6:00 PM | Book Your Free Consultation"
        ],
        ja: [
          "エミネント海外留学コンサルタント | 日本・英国留学サポート | 倫理的ビザガイダンス",
          "日本語研修 (N5/N4) | 英国高等教育カウンセリング",
          "ビザ保証なし | 透明なプロセス | 保護者向けサポート",
          "ダッカオフィス | 土〜木、午前10時〜午後6時 | 無料相談予約"
        ]
      };
      originalInit.call(this);
    };
  }
  
  const app = new App();
  window.app = app; // Make app globally accessible
  
  // Initialize Bootstrap tooltips if any
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
  
  // Initialize Bootstrap collapse for mobile menu
  const navbarCollapse = document.querySelector('.navbar-collapse');
  if (navbarCollapse) {
    new bootstrap.Collapse(navbarCollapse, {
      toggle: false
    });
  }
  
  // Initialize all accordions
  const accordionElements = document.querySelectorAll('.accordion');
  accordionElements.forEach(accordion => {
    new bootstrap.Collapse(accordion, {
      toggle: false
    });
  });
});

// ======================
// WINDOW RESIZE HANDLER
// ======================

let resizeTimer;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(() => {
    // Update any responsive features here
    if (window.app) {
      // Reinitialize language manager for responsive text updates
      window.app.languageManager.updateAllText();
    }
  }, 250);
});

// ======================
// ERROR HANDLING
// ======================

// Global error handler for better debugging
window.addEventListener('error', function(e) {
  console.error('Global error:', e.message, e.filename, e.lineno);
});

// Promise rejection handler
window.addEventListener('unhandledrejection', function(e) {
  console.error('Unhandled promise rejection:', e.reason);
});

// ======================
// ADDITIONAL UTILITIES
// ======================

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const targetId = this.getAttribute('href');
    if (targetId === '#') return;
    
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      e.preventDefault();
      const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
      const marqueeHeight = document.querySelector('.top-marquee')?.offsetHeight || 0;
      const heroHeight = document.querySelector('.fullscreen-hero')?.offsetHeight || 0;
      let offsetTop = targetElement.offsetTop;
      
      // Adjust offset based on whether we have a hero slider
      if (heroHeight > 0 && targetId !== '#home') {
        offsetTop = offsetTop - navbarHeight - marqueeHeight;
      } else {
        offsetTop = offsetTop - navbarHeight - marqueeHeight - heroHeight;
      }
      
      window.scrollTo({
        top: Math.max(offsetTop, 0),
        behavior: 'smooth'
      });
    }
  });
});

// Form validation helper
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}

function validatePhone(phone) {
  const re = /^[\d\s\-\+\(\)]{10,}$/;
  return re.test(phone);
}

// Add loading state to buttons
document.addEventListener('submit', function(e) {
  if (e.target.tagName === 'FORM') {
    const submitButton = e.target.querySelector('button[type="submit"]');
    if (submitButton) {
      submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
      submitButton.disabled = true;
    }
  }
});

// Lazy loading for images
if ('IntersectionObserver' in window) {
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        const src = img.getAttribute('data-src');
        if (src) {
          img.src = src;
          img.removeAttribute('data-src');
        }
        observer.unobserve(img);
      }
    });
  });

  document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
  });
}

// Preload critical images
function preloadImage(url) {
  const img = new Image();
  img.src = url;
}

// Preload hero images on page load
window.addEventListener('load', () => {
  const heroImages = [
    'images/hero-banner-1.jpg',
    'images/hero-banner-2.jpg',
    'images/hero-banner-3.jpg'
  ];
  
  heroImages.forEach(url => preloadImage(url));
});

// Add CSS for print styles
window.addEventListener('beforeprint', () => {
  document.body.classList.add('print-mode');
});

window.addEventListener('afterprint', () => {
  document.body.classList.remove('print-mode');
});