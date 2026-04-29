import './bootstrap';
import Alpine from 'alpinejs';
import { Fancybox } from "@fancyapps/ui";

window.Alpine = Alpine;
Alpine.start();

// Initialize Fancybox
Fancybox.bind("[data-fancybox]", {
    // Custom options
    Carousel: {
    transition: "slide", // ini kunci utamanya
  },
});
