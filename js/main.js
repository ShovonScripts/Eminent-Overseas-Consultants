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
    // First, update the current year before any language changes
    this.updateCurrentYear();
    
    // Update all elements with data-en and data-ja attributes
    // BUT skip elements that contain #currentYear
    document.querySelectorAll('[data-en], [data-ja]').forEach(element => {
      // Skip updating if this element contains the current year span
      if (element.innerHTML.includes('currentYear')) {
        return;
      }
      
      const text = element.dataset[this.currentLang];
      if (text) {
        // Check if the text contains the current year placeholder
        if (text.includes('currentYear')) {
          // Replace placeholder with actual year
          const currentYear = new Date().getFullYear();
          element.innerHTML = text.replace('currentYear', `<span id="currentYear">${currentYear}</span>`);
        } else {
          element.textContent = text;
        }
      }
    });

    // Update title tag
    const titleElement = document.querySelector('title');
    if (titleElement) {
      if (this.currentLang === 'ja') {
        const jaTitle = titleElement.getAttribute('data-ja') || 'エミネント海外留学コンサルタント | 日本・英国留学ガイダンス';
        titleElement.textContent = jaTitle;
      } else {
        const enTitle = titleElement.getAttribute('data-en') || 'Eminent Overseas & Consultants | Japan & UK Study Abroad Guidance';
        titleElement.textContent = enTitle;
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
    requestAnimationFrame(() => {
      marqueeTrack.style.animation = 'marqueeMove 25s linear infinite';
    });
  }

  // NEW METHOD: Update current year
  updateCurrentYear() {
    const yearElements = document.querySelectorAll('#currentYear');
    if (yearElements.length > 0) {
      const currentYear = new Date().getFullYear();
      yearElements.forEach(element => {
        element.textContent = currentYear;
      });
    }
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

  goToSlide(index) {
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
    }, 1200);
  }

  nextSlide() {
    this.goToSlide(this.currentSlide + 1);
  }

  prevSlide() {
    this.goToSlide(this.currentSlide - 1);
  }

  updateSlider() {
    // Ensure only current slide is active
    this.slides.forEach((slide, index) => {
      slide.classList.toggle('active', index === this.currentSlide);
    });
    
    this.updateIndicators();
    this.updateCounter();
  }

  updateIndicators() {
    const indicators = document.querySelectorAll('.fullscreen-hero .indicator');
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === this.currentSlide);
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
    const indicators = document.querySelectorAll('.fullscreen-hero .indicator');
    indicators.forEach((indicator, index) => {
      indicator.addEventListener('click', () => {
        this.goToSlide(index);
        this.restartAutoSlide();
      });
    });

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
    this.totalSlides = 0;
    this.autoSlideInterval = null;
    this.autoSlideDelay = 5000; // 5 seconds
    this.isAutoPlaying = true;
  }

  init() {
    this.getSlides();
    if (this.totalSlides === 0) return;
    
    this.setupEventListeners();
    this.updateSliderPosition();
    this.startAutoSlide();
    this.updateCounter();
  }

  getSlides() {
    this.slides = document.querySelectorAll('.overview-slide');
    this.totalSlides = this.slides.length;
    return this.totalSlides;
  }

  goToSlide(index) {
    if (index >= this.totalSlides) {
      this.currentSlide = 0;
    } else if (index < 0) {
      this.currentSlide = this.totalSlides - 1;
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
      dot.classList.toggle('active', index === this.currentSlide);
    });
  }

  updateProgressBar() {
    const progressBar = document.getElementById('progressBar');
    if (progressBar && this.totalSlides > 0) {
      const progress = ((this.currentSlide + 1) / this.totalSlides) * 100;
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
      totalSlidesEl.textContent = this.totalSlides;
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
    const dots = document.querySelectorAll('.slider-dot');
    dots.forEach((dot, index) => {
      dot.addEventListener('click', () => {
        this.goToSlide(index);
        this.restartAutoSlide();
      });
    });

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

    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    const sliderContainer = document.querySelector('.slider-aspect-ratio');
    if (sliderContainer) {
      sliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      
      sliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        this.handleSwipe(touchStartX, touchEndX);
      }, { passive: true });
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
    this.initMobileMenu();
    this.initFAQAccordion();
    this.initSmoothScroll();
    
    // Force update current year on load
    setTimeout(() => {
      this.languageManager.updateCurrentYear();
    }, 100);
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
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 50) {
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

      const stillCounting = Array.from(counters).some(c => {
        const target = Number(c.getAttribute('data-count') || 0);
        const value = Number(c.innerText.replace(/[^0-9]/g, '') || 0);
        return value < target;
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
  }

  initCurrentYear() {
    // Use the LanguageManager's method to update current year
    if (this.languageManager && this.languageManager.updateCurrentYear) {
      this.languageManager.updateCurrentYear();
    } else {
      // Fallback
      const yearEl = document.getElementById('currentYear');
      if (yearEl) yearEl.textContent = String(new Date().getFullYear());
    }
  }

  initMobileMenu() {
    // FIXED VERSION: Don't interfere with dropdown toggles
    // Only close navbar when clicking regular nav links (not dropdown toggles)
    const regularNavLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (regularNavLinks && navbarCollapse) {
      regularNavLinks.forEach(link => {
        link.addEventListener('click', (e) => {
          // Only on mobile
          if (window.innerWidth < 992) {
            // Don't close if clicking a link inside a dropdown
            if (e.target.closest('.dropdown-menu')) {
              return;
            }
            
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
            if (bsCollapse) {
              bsCollapse.hide();
            }
          }
        });
      });
    }
    
    // Fix for dropdown toggles on mobile
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        // On mobile, prevent the navbar from closing when clicking dropdown toggle
        if (window.innerWidth < 992) {
          e.stopPropagation();
          
          // Get the dropdown menu
          const dropdownMenu = this.nextElementSibling;
          if (dropdownMenu && dropdownMenu.classList.contains('dropdown-menu')) {
            // Toggle the dropdown
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-toggle').forEach(otherToggle => {
              if (otherToggle !== this) {
                otherToggle.setAttribute('aria-expanded', 'false');
                const otherMenu = otherToggle.nextElementSibling;
                if (otherMenu && otherMenu.classList.contains('dropdown-menu')) {
                  otherMenu.style.display = 'none';
                }
              }
            });
            
            // Toggle current dropdown
            if (isExpanded) {
              this.setAttribute('aria-expanded', 'false');
              dropdownMenu.style.display = 'none';
            } else {
              this.setAttribute('aria-expanded', 'true');
              dropdownMenu.style.display = 'block';
            }
          }
        }
      });
    });
    
    // Close dropdowns when clicking outside on mobile
    document.addEventListener('click', (e) => {
      if (window.innerWidth < 992) {
        const isDropdownToggle = e.target.closest('.dropdown-toggle');
        const isDropdownMenu = e.target.closest('.dropdown-menu');
        
        if (!isDropdownToggle && !isDropdownMenu) {
          // Close all dropdowns
          document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
            toggle.setAttribute('aria-expanded', 'false');
            const menu = toggle.nextElementSibling;
            if (menu && menu.classList.contains('dropdown-menu')) {
              menu.style.display = 'none';
            }
          });
        }
      }
    });
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

  initSmoothScroll() {
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
  }
}

// ======================
// INITIALIZE APP
// ======================

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  try {
    const app = new App();
    app.init();
    window.app = app; // Make app globally accessible
    
    // Initialize Bootstrap tooltips if any
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (tooltipTriggerList.length > 0 && typeof bootstrap !== 'undefined') {
      tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl);
      });
    }
    
    // Initialize Bootstrap collapse for mobile menu
    const navbarCollapse = document.querySelector('.navbar-collapse');
    if (navbarCollapse && typeof bootstrap !== 'undefined') {
      new bootstrap.Collapse(navbarCollapse, {
        toggle: false
      });
    }
    
    console.log('App initialized successfully');
  } catch (error) {
    console.error('Error initializing app:', error);
  }
});

// ======================
// ADDITIONAL FIX FOR CURRENT YEAR
// ======================

// This ensures the current year is always updated
(function() {
  // Function to update current year
  function updateCurrentYear() {
    const yearElements = document.querySelectorAll('#currentYear');
    if (yearElements.length > 0) {
      const currentYear = new Date().getFullYear();
      yearElements.forEach(element => {
        if (element.textContent !== currentYear.toString()) {
          element.textContent = currentYear;
        }
      });
    }
  }
  
  // Update on page load
  document.addEventListener('DOMContentLoaded', updateCurrentYear);
  
  // Update every second for safety (in case language manager overwrites it)
  setInterval(updateCurrentYear, 1000);
})();