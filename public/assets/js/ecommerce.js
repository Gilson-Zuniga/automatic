        function app() {
            return {
                categories: [
                    { id: 1, name: 'Smartphones' },
                    { id: 2, name: 'Laptops' },
                    { id: 3, name: 'Tablets' },
                    { id: 4, name: 'Audio' },
                    { id: 5, name: 'Accesorios' },
                    { id: 6, name: 'Smartwatches' },
                    { id: 7, name: 'Cámaras' },
                    { id: 8, name: 'Gaming' },
                    { id: 9, name: 'Smart Home' }
                ],
                selectedCategory: null,
                featuredProducts: [
                    {
                        id: 1,
                        name: 'Smartphone XYZ Pro',
                        description: 'Smartphone de última generación con cámara de 108MP, 12GB RAM y pantalla AMOLED de 6.7".',
                        price: 899.99,
                        oldPrice: 999.99,
                        image: 'https://cdn.pixabay.com/photo/2016/11/29/12/30/phone-1869510_1280.jpg',
                        rating: 4.5,
                        reviews: 128
                    },
                    {
                        id: 2,
                        name: 'Laptop UltraBook',
                        description: 'Laptop ultradelgada con procesador de última generación, 16GB RAM y 512GB SSD.',
                        price: 1299.99,
                        image: 'https://cdn.pixabay.com/photo/2016/03/27/07/12/apple-1282241_1280.jpg',
                        rating: 4.8,
                        reviews: 95
                    },
                    {
                        id: 3,
                        name: 'Auriculares NoiseCancel',
                        description: 'Auriculares con cancelación de ruido, 30 horas de batería y conexión Bluetooth 5.0.',
                        price: 249.99,
                        oldPrice: 299.99,
                        image: 'https://cdn.pixabay.com/photo/2016/09/13/08/44/headphones-1666720_1280.jpg',
                        rating: 4.7,
                        reviews: 204
                    },
                    {
                        id: 4,
                        name: 'Smartwatch FitTrack',
                        description: 'Reloj inteligente con seguimiento de actividad física, monitoreo cardíaco y GPS integrado.',
                        price: 179.99,
                        image: 'https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg',
                        rating: 4.3,
                        reviews: 156
                    }
                ],
                dealProducts: [
                    {
                        id: 5,
                        name: 'Tablet UltraView 10"',
                        description: 'Tablet con pantalla 2K de 10", procesador octa-core y 128GB de almacenamiento.',
                        price: 299.99,
                        oldPrice: 399.99,
                        discount: 25,
                        image: 'https://cdn.pixabay.com/photo/2015/02/05/08/12/ipad-624707_1280.jpg',
                        rating: 4.6,
                        reviews: 87
                    },
                    {
                        id: 6,
                        name: 'Cámara MirrorPro',
                        description: 'Cámara sin espejo con sensor full-frame de 24MP, grabación 4K y estabilización de 5 ejes.',
                        price: 1499.99,
                        oldPrice: 1899.99,
                        discount: 21,
                        image: 'https://cdn.pixabay.com/photo/2014/08/29/14/53/camera-431119_1280.jpg',
                        rating: 4.9,
                        reviews: 64
                    },
                    {
                        id: 7,
                        name: 'Altavoz Bluetooth SoundMax',
                        description: 'Altavoz portátil con sonido 360°, resistencia al agua IPX7 y 20 horas de batería.',
                        price: 129.99,
                        oldPrice: 179.99,
                        discount: 28,
                        image: 'https://cdn.pixabay.com/photo/2019/09/25/08/41/speaker-4502258_1280.jpg',
                        rating: 4.4,
                        reviews: 109
                    }
                ],
                isLoading: false,
                cart: {
                    items: [],
                    isOpen: false
                },
                productModal: {
                    isOpen: false,
                    product: {},
                    quantity: 1
                },
                cartModal: {
                    isOpen: false
                },
                profileModal: {
                    isOpen: false,
                    user: {
                        firstName: 'Juan',
                        lastName: 'Pérez',
                        email: 'juan.perez@example.com',
                        phone: '+123456789',
                        address: 'Calle Principal 123',
                        city: 'Ciudad',
                        state: 'Estado',
                        zipCode: '12345'
                    }
                },
                ordersModal: {
                    isOpen: false,
                    orders: [
                        {
                            id: '10023',
                            date: '15/01/2025',
                            total: 1149.98,
                            status: 'Entregado',
                            items: [
                                {
                                    id: 1,
                                    name: 'Smartphone XYZ Pro',
                                    price: 899.99,
                                    quantity: 1,
                                    image: 'https://cdn.pixabay.com/photo/2016/11/29/12/30/phone-1869510_1280.jpg'
                                },
                                {
                                    id: 3,
                                    name: 'Auriculares NoiseCancel',
                                    price: 249.99,
                                    quantity: 1,
                                    image: 'https://cdn.pixabay.com/photo/2016/09/13/08/44/headphones-1666720_1280.jpg'
                                }
                            ]
                        },
                        {
                            id: '10022',
                            date: '02/01/2025',
                            total: 179.99,
                            status: 'En camino',
                            items: [
                                {
                                    id: 4,
                                    name: 'Smartwatch FitTrack',
                                    price: 179.99,
                                    quantity: 1,
                                    image: 'https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg'
                                }
                            ]
                        }
                    ]
                },
                settingsModal: {
                    isOpen: false,
                    notifications: {
                        promotions: true,
                        orderUpdates: true,
                        newProducts: false
                    },
                    privacy: {
                        shareData: false,
                        thirdPartyCookies: true
                    },
                    password: {
                        current: '',
                        new: '',
                        confirm: ''
                    }
                },
                toast: {
                    show: false,
                    message: '',
                    type: 'success', // success, error, info
                    timeout: null
                },
                countdown: {
                    hours: '08',
                    minutes: '45',
                    seconds: '30'
                },
                
                init() {
                    // Initialize Swiper
                    this.$nextTick(() => {
                        new Swiper('.banner-swiper', {
                            slidesPerView: 1,
                            spaceBetween: 30,
                            loop: true,
                            autoplay: {
                                delay: 5000,
                                disableOnInteraction: false
                            },
                            pagination: {
                                el: '.swiper-pagination',
                                clickable: true
                            },
                            navigation: {
                                nextEl: '.swiper-button-next',
                                prevEl: '.swiper-button-prev'
                            }
                        });
                    });
                    
                    // Load cart from localStorage
                    const savedCart = localStorage.getItem('cart');
                    if (savedCart) {
                        this.cart.items = JSON.parse(savedCart);
                    }
                    
                    // Setup countdown timer
                    this.startCountdown();
                },
                
                startCountdown() {
                    let totalSeconds = parseInt(this.countdown.hours) * 3600 + 
                                       parseInt(this.countdown.minutes) * 60 + 
                                       parseInt(this.countdown.seconds);
                    
                    const countdownInterval = setInterval(() => {
                        totalSeconds--;
                        
                        if (totalSeconds <= 0) {
                            clearInterval(countdownInterval);
                            this.showToast('¡Las ofertas han terminado!', 'info');
                        }
                        
                        const hours = Math.floor(totalSeconds / 3600);
                        const minutes = Math.floor((totalSeconds % 3600) / 60);
                        const seconds = totalSeconds % 60;
                        
                        this.countdown.hours = hours.toString().padStart(2, '0');
                        this.countdown.minutes = minutes.toString().padStart(2, '0');
                        this.countdown.seconds = seconds.toString().padStart(2, '0');
                    }, 1000);
                },
                
                fetchSuggestions() {
                    // Simulación de búsqueda
                    setTimeout(() => {
                        const query = this.searchQuery.toLowerCase();
                        const allProducts = [...this.featuredProducts, ...this.dealProducts];
                        this.suggestions = allProducts.filter(p => 
                            p.name.toLowerCase().includes(query)
                        ).slice(0, 5);
                    }, 300);
                },
                
                selectSuggestion(suggestion) {
                    this.searchQuery = '';
                    this.suggestions = [];
                    this.openProductModal(suggestion);
                },
                
                selectCategory(category) {
                    this.selectedCategory = category;
                    this.showToast(`Categoría seleccionada: ${category.name}`, 'info');
                },
                
                openProductModal(product) {
                    this.productModal.product = product;
                    this.productModal.quantity = 1;
                    this.productModal.isOpen = true;
                },
                
                incrementQuantity() {
                    if (this.productModal.quantity < 99) {
                        this.productModal.quantity++;
                    }
                },
                
                decrementQuantity() {
                    if (this.productModal.quantity > 1) {
                        this.productModal.quantity--;
                    }
                },
                
                addToCart(product, quantity) {
                    this.isLoading = true;
                    
                    // Simulación de API call
                    setTimeout(() => {
                        const existingItemIndex = this.cart.items.findIndex(item => item.id === product.id);
                        
                        if (existingItemIndex !== -1) {
                            // Update quantity if product already in cart
                            this.cart.items[existingItemIndex].quantity += quantity;
                        } else {
                            // Add new item to cart
                            this.cart.items.push({
                                id: product.id,
                                name: product.name,
                                price: product.price,
                                image: product.image,
                                quantity: quantity
                            });
                        }
                        
                        // Save to localStorage
                        localStorage.setItem('cart', JSON.stringify(this.cart.items));
                        
                        this.isLoading = false;
                        this.productModal.isOpen = false;
                        this.showToast('Producto añadido al carrito', 'success');
                    }, 800);
                },
                
                buyNow(product, quantity) {
                    this.isLoading = true;
                    
                    // Simulación de API call
                    setTimeout(() => {
                        this.addToCart(product, quantity);
                        this.toggleCart();
                    }, 800);
                },
                
                toggleCart() {
                    this.cartModal.isOpen = !this.cartModal.isOpen;
                },
                
                toggleProfileModal() {
                    this.profileModal.isOpen = !this.profileModal.isOpen;
                },
                
                toggleOrdersModal() {
                    this.ordersModal.isOpen = !this.ordersModal.isOpen;
                },
                
                toggleSettingsModal() {
                    this.settingsModal.isOpen = !this.settingsModal.isOpen;
                },
                
                updateCartItem(index, quantity) {
                    if (quantity <= 0) {
                        this.removeFromCart(index);
                    } else {
                        this.cart.items[index].quantity = quantity;
                        localStorage.setItem('cart', JSON.stringify(this.cart.items));
                    }
                },
                
                removeFromCart(index) {
                    this.cart.items.splice(index, 1);
                    localStorage.setItem('cart', JSON.stringify(this.cart.items));
                    this.showToast('Producto eliminado del carrito', 'info');
                },
                
                calculateSubtotal() {
                    return this.cart.items.reduce((total, item) => total + (item.price * item.quantity), 0);
                },
                
                checkout() {
                    if (this.cart.items.length === 0) return;
                    
                    this.isLoading = true;
                    
                    // Simulación de API call
                    setTimeout(() => {
                        this.isLoading = false;
                        this.cartModal.isOpen = false;
                        this.cart.items = [];
                        localStorage.removeItem('cart');
                        this.showToast('¡Pedido realizado con éxito!', 'success');
                    }, 1500);
                },
                
                saveProfile() {
                    this.isLoading = true;
                    
                    // Validación simple
                    if (!this.profileModal.user.firstName || !this.profileModal.user.lastName || !this.profileModal.user.email) {
                        this.showToast('Por favor completa los campos obligatorios', 'error');
                        this.isLoading = false;
                        return;
                    }
                    
                    // Simulación de API call
                    setTimeout(() => {
                        this.isLoading = false;
                        this.profileModal.isOpen = false;
                        this.showToast('Perfil actualizado correctamente', 'success');
                    }, 1000);
                },
                
                viewOrderDetails(order) {
                    // Podría abrir un nuevo modal con detalles del pedido
                    this.showToast('Ver detalles del pedido: ' + order.id, 'info');
                },
                
                changePassword() {
                    this.isLoading = true;
                    
                    // Validación simple
                    if (!this.settingsModal.password.current || !this.settingsModal.password.new || !this.settingsModal.password.confirm) {
                        this.showToast('Por favor completa todos los campos', 'error');
                        this.isLoading = false;
                        return;
                    }
                    
                    if (this.settingsModal.password.new !== this.settingsModal.password.confirm) {
                        this.showToast('Las contraseñas no coinciden', 'error');
                        this.isLoading = false;
                        return;
                    }
                    
                    // Simulación de API call
                    setTimeout(() => {
                        this.isLoading = false;
                        this.settingsModal.password = { current: '', new: '', confirm: '' };
                        this.showToast('Contraseña actualizada correctamente', 'success');
                    }, 1000);
                },
                
                logout() {
                    this.isLoading = true;
                    
                    // Simulación de API call
                    setTimeout(() => {
                        this.isLoading = false;
                        this.settingsModal.isOpen = false;
                        this.showToast('Sesión cerrada correctamente', 'success');
                    }, 800);
                },
                
                showToast(message, type = 'success') {
                    // Clear any existing timeout
                    if (this.toast.timeout) {
                        clearTimeout(this.toast.timeout);
                    }
                    
                    this.toast.message = message;
                    this.toast.type = type;
                    this.toast.show = true;
                    
                    // Auto hide after 3 seconds
                    this.toast.timeout = setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                }
            };
        }