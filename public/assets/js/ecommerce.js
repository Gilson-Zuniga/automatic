    // Initialize Alpine.js data and event listeners
    document.addEventListener('alpine:init', () => {
      // Toggle for the switches in configuration
      const switches = document.querySelectorAll('.switch input');
      switches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
          const span = this.nextElementSibling.querySelector('span');
          if (this.checked) {
            span.style.transform = 'translateX(24px)';
            this.nextElementSibling.style.backgroundColor = '#3483FA';
          } else {
            span.style.transform = 'translateX(0)';
            this.nextElementSibling.style.backgroundColor = '#d1d5db';
          }
        });
        
        // Initialize switches
        if (switchEl.checked) {
          const span = switchEl.nextElementSibling.querySelector('span');
          span.style.transform = 'translateX(24px)';
          switchEl.nextElementSibling.style.backgroundColor = '#3483FA';
        }
      });
      
      // Add event listener for cart updates
      document.addEventListener('cart-updated', () => {
        console.log('Cart updated');
        // In a real application, we would update localStorage here
      });
    });