/* * ========================================================= * THE ARCANE EMPORIUM * Global JavaScript * ========================================================= */ document.addEventListener(
  "DOMContentLoaded",
  () => {
    /* * ===================================================== * MOBILE NAVIGATION * ===================================================== */ const menuToggle =
      document.querySelector(".menu-toggle");
    const mainNav = document.querySelector(".main-nav");
    if (menuToggle && mainNav) {
      menuToggle.addEventListener("click", () => {
        mainNav.classList.toggle("is-open");
        const isOpen = mainNav.classList.contains("is-open");
        menuToggle.setAttribute("aria-expanded", isOpen);
      });
    }
    /* * ===================================================== * PRODUCT QUANTITY CONTROLS * ===================================================== */ const quantityControls =
      document.querySelectorAll(".quantity-control");
    quantityControls.forEach((control) => {
      const input = control.querySelector("input");
      const decreaseButton = control.querySelector(".quantity-decrease");
      const increaseButton = control.querySelector(".quantity-increase");
      if (!input) {
        return;
      }
      /* * Decrease quantity */ if (decreaseButton) {
        decreaseButton.addEventListener("click", () => {
          const currentValue = parseInt(input.value) || 1;
          const minimum = parseInt(input.min) || 1;
          if (currentValue > minimum) {
            input.value = currentValue - 1;
          }
          input.dispatchEvent(new Event("change"));
        });
      }
      /* * Increase quantity */ if (increaseButton) {
        increaseButton.addEventListener("click", () => {
          const currentValue = parseInt(input.value) || 1;
          const maximum = parseInt(input.max) || 99;
          if (currentValue < maximum) {
            input.value = currentValue + 1;
          }
          input.dispatchEvent(new Event("change"));
        });
      }
    });
    /* * ===================================================== * PREVENT INVALID QUANTITY VALUES * ===================================================== */ document
      .querySelectorAll('input[type="number"]')
      .forEach((input) => {
        input.addEventListener("input", () => {
          const minimum = parseInt(input.min);
          const maximum = parseInt(input.max);
          let value = parseInt(input.value);
          if (Number.isNaN(value)) {
            return;
          }
          if (!Number.isNaN(minimum) && value < minimum) {
            input.value = minimum;
          }
          if (!Number.isNaN(maximum) && value > maximum) {
            input.value = maximum;
          }
        });
      });
    /* * ===================================================== * IMAGE ERROR HANDLING * ===================================================== * * If a product image is missing, prevent the broken * image icon from ruining the layout. */ document
      .querySelectorAll("img")
      .forEach((image) => {
        image.addEventListener("error", () => {
          image.classList.add("image-not-found");
        });
      });
    /* * ===================================================== * ADD TO SATCHEL FEEDBACK * ===================================================== * * This doesn't add anything to the cart itself. * PHP handles that. * * It simply gives the user visual feedback after * submitting the form. */ document
      .querySelectorAll(".add-to-satchel-large")
      .forEach((button) => {
        const form = button.closest("form");
        if (!form) {
          return;
        }
        form.addEventListener("submit", () => {
          button.classList.add("is-adding");
          const originalContent = button.innerHTML;
          button.innerHTML =
            '<i class="fa-solid fa-check"></i> Added to Satchel';
          /* * Restore the button after a short delay. */ setTimeout(() => {
            button.classList.remove("is-adding");
            button.innerHTML = originalContent;
          }, 1800);
        });
      });
    /* * ===================================================== * CURRENT YEAR * ===================================================== * * Allows us to use: * * <span data-current-year></span> * * instead of manually changing the year. */ document
      .querySelectorAll("[data-current-year]")
      .forEach((element) => {
        element.textContent = new Date().getFullYear();
      });
  },
);
