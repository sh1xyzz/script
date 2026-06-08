const body = document.body;
const navToggle = document.querySelector(".nav-toggle");
const navPanel = document.querySelector(".nav-links");
const navLinks = document.querySelectorAll(".nav-links a");
const revealItems = document.querySelectorAll(
  ".hero-copy, .hero-panel, .section-heading, .language-card, .contact-copy, .contact-form, .quiz-card",
);
const form = document.getElementById("contactForm");
const formStatus = document.getElementById("formStatus");
const countdownClock = document.querySelector(".countdown-clock");
const faqItems = document.querySelectorAll(".faq-item");
const quizForm = document.getElementById("trackQuiz");
const quizResult = document.getElementById("quizResult");
const progressFill = document.querySelector(".scroll-progress__fill");

const setMenuState = (isOpen) => {
  body.classList.toggle("menu-open", isOpen);
  navPanel?.classList.toggle("open", isOpen);
  navToggle?.setAttribute("aria-expanded", isOpen ? "true" : "false");
  navToggle?.setAttribute(
    "aria-label",
    isOpen ? "Close navigation" : "Open navigation",
  );
};

const closeMenu = () => setMenuState(false);

if (navToggle && navPanel) {
  setMenuState(false);
  navToggle.addEventListener("click", () => {
    const isOpen = !body.classList.contains("menu-open");
    setMenuState(isOpen);
    if (isOpen) navPanel.querySelector("a")?.focus();
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape" && body.classList.contains("menu-open")) {
      closeMenu();
      navToggle.focus();
    }
  });

  document.addEventListener("click", (event) => {
    if (!body.classList.contains("menu-open")) return;
    if (navPanel.contains(event.target) || navToggle.contains(event.target))
      return;
    closeMenu();
  });
}

navLinks.forEach((link) => link.addEventListener("click", closeMenu));

const splitHeroText = () => {
  const heroTitle = document.querySelector(".hero-copy h1");
  if (!heroTitle) return;
  const text = heroTitle.textContent.trim();
  heroTitle.innerHTML = text
    .split(" ")
    .map((word) => `<span>${word}</span>`)
    .join(" ");
};

const revealHeroWords = () => {
  const spans = document.querySelectorAll(".hero-copy h1 span");
  spans.forEach((span, index) => {
    span.style.transition = `opacity 0.4s ease ${index * 0.08}s, transform 0.4s ease ${index * 0.08}s`;
    span.classList.add("is-visible");
  });
};

splitHeroText();

revealItems.forEach((item) => item.classList.add("reveal"));
const observer = new IntersectionObserver(
  (entries, obs) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("is-visible");
        if (entry.target.classList.contains("hero-copy")) revealHeroWords();
        obs.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.12 },
);
revealItems.forEach((item) => observer.observe(item));

const updateProgress = () => {
  const scroll = window.scrollY;
  const height = document.documentElement.scrollHeight - window.innerHeight;
  const percent = height > 0 ? (scroll / height) * 100 : 0;
  progressFill.style.width = `${Math.min(100, Math.max(0, percent))}%`;
};

const updateCountdown = () => {
  if (!countdownClock) return;
  const target = new Date(countdownClock.dataset.countdown);
  const now = new Date();
  const diff = Math.max(0, target - now);
  const days = Math.floor(diff / (1000 * 60 * 60 * 24));
  const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
  const minutes = Math.floor((diff / (1000 * 60)) % 60);
  const seconds = Math.floor((diff / 1000) % 60);
  countdownClock.innerHTML = [
    { label: "Days", value: days },
    { label: "Hours", value: hours },
    { label: "Min", value: minutes },
    { label: "Sec", value: seconds },
  ]
    .map(
      ({ label, value }) =>
        `<span data-label="${label}">${value.toString().padStart(2, "0")}</span>`,
    )
    .join("");
};

updateCountdown();
setInterval(updateCountdown, 1000);

const initFaq = () => {
  faqItems.forEach((item) => {
    const button = item.querySelector(".faq-question");
    const answer = item.querySelector(".faq-answer");
    button?.addEventListener("click", () => {
      const isOpen = button.getAttribute("aria-expanded") === "true";
      button.setAttribute("aria-expanded", isOpen ? "false" : "true");
      answer?.classList.toggle("open", !isOpen);
      if (!isOpen) answer?.removeAttribute("hidden");
      else answer?.setAttribute("hidden", "");
      faqItems.forEach((other) => {
        if (other !== item) {
          const otherBtn = other.querySelector(".faq-question");
          const otherAnswer = other.querySelector(".faq-answer");
          otherBtn?.setAttribute("aria-expanded", "false");
          otherAnswer?.classList.remove("open");
          otherAnswer?.setAttribute("hidden", "");
        }
      });
    });
  });
};

initFaq();

quizForm?.addEventListener("submit", (event) => {
  event.preventDefault();
  const choices = Array.from(new FormData(quizForm).values());
  if (choices.length < 3) return;
  const score = choices.reduce((sum, value) => sum + value.length, 0);
  let match = "Spanish VivaVoice";
  if (score > 45) match = "English FastTalk";
  else if (score > 30) match = "German StartKraft";
  quizResult.textContent = `Your best match is ${match}. Book a trial session to secure your spot.`;
});

window.addEventListener("scroll", () => {
  updateProgress();
});
updateProgress();

if (form && formStatus) {
  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    formStatus.textContent = "Sending your application...";
    formStatus.className = "form-status";
    const formData = new FormData(form);
    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: formData,
        headers: { "X-Requested-With": "XMLHttpRequest" },
      });
      const result = await response.json();
      if (!response.ok || !result.success) {
        throw new Error(result.message || "We could not send the form.");
      }
      form.reset();
      formStatus.textContent = result.message;
      formStatus.className = "form-status success";
    } catch (error) {
      formStatus.textContent =
        error instanceof Error
          ? error.message
          : "Something went wrong. Please try again.";
      formStatus.className = "form-status error";
    }
  });
}
