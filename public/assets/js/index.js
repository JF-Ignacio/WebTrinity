// ==========================================
// WEB-TRINITY Base Interactive Playground JS
// ==========================================

function updatePlayground() {
    const btn = document.getElementById('dynamic-demo-btn');
    const cssEnabled = document.getElementById('toggleCss').checked;
    const jsEnabled = document.getElementById('toggleJs').checked;
    const feedback = document.getElementById('playground-feedback');

    // Reset inline styles
    btn.style.cssText = "";

    if (cssEnabled) {
        btn.style.backgroundColor = '#4f46e5';
        btn.style.color = '#ffffff';
        btn.style.padding = '12px 24px';
        btn.style.borderRadius = '8px';
        btn.style.border = '1px solid #00f2fe';
        btn.style.boxShadow = '0 0 15px rgba(0, 242, 254, 0.4)';
        btn.style.transition = 'all 0.3s ease';
    } else {
        btn.style.backgroundColor = '#e5e7eb';
        btn.style.color = '#1f2937';
        btn.style.padding = '4px 8px';
    }

    if (jsEnabled) {
        btn.onclick = function() {
            alert('WEB-TRINITY Interactive Demo: JavaScript successfully triggered!');
        };
        btn.title = "Click to test JS interaction!";
    } else {
        btn.onclick = null;
        btn.title = "JavaScript disabled";
    }

    // Update feedback description
    if (cssEnabled && jsEnabled) {
        feedback.innerHTML = `<i class="fa-solid fa-circle-check text-success me-1"></i> Full Trinity Active: Button is styled with CSS and responsive to JS clicks!`;
    } else if (cssEnabled) {
        feedback.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> JS disabled: Button looks great, but clicking does nothing.`;
    } else if (jsEnabled) {
        feedback.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-warning me-1"></i> CSS disabled: Button is clickable, but has raw browser styling.`;
    } else {
        feedback.innerHTML = `<i class="fa-solid fa-circle-xmark text-danger me-1"></i> Only HTML active: Raw unstyled element with no behavior.`;
    }
}


document.addEventListener("DOMContentLoaded", () => {
    const textElement = document.querySelector(".type-writer-hero");

    const phrases = [
        'WEB-TRINITY',
        'HTML, CSS, and JAVASCRIPT',
        'ONE ECOSYSTEM'
    ];

    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    const typingSpeed = 200;
    const deletingSpeed = 100;
    const pauseEnd = 1800;

    function typeEffect() {
        const currentPhase = phrases[phraseIndex];

        if(isDeleting) {
            charIndex--;
            textElement.textContent = currentPhase.substring(0, charIndex);
        }
        else {
            charIndex++;
            textElement.textContent = currentPhase.substring(0, charIndex);
        }

        let currentSpeed = isDeleting ? deletingSpeed : typingSpeed;

        if(!isDeleting && charIndex === currentPhase.length) {
            currentSpeed = pauseEnd;
            isDeleting = true;
        }

        else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            phraseIndex = (phraseIndex + 1) % phrases.length;
            currentSpeed = deletingSpeed;
        }

        setTimeout(typeEffect, currentSpeed);
    }

    typeEffect();

});

// Initialize state on load
window.addEventListener('DOMContentLoaded', () => {
    updatePlayground();
});