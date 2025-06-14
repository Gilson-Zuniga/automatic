<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BazurtoShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel=stylesheet href="{{ asset('assets/css/ecommerce.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style id="app-style">
        [x-cloak] { display: none !important; }
        
        .swiper {
            width: 100%;
            height: 300px;
        }
        
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .modal-backdrop {
            backdrop-filter: blur(3px);
        }
        
        .product-card {
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .loader {
            border-top-color: #3498db;
            animation: spinner 1.5s linear infinite;
        }
        
        @keyframes spinner {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos para el toast unificado */
        #global-toast {
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            z-index: 9999;
        }
    </style>
</head>
@vite('resources/css/app.css')
 
<body class="bg-gray-100">
    <div x-data="app()" class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-indigo-600 text-white shadow-md sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <a href="#" class="text-2xl font-bold"><img src="{{ asset('assets/img/logo.png') }}" alt="Logo" id="logo"></a>
                    </div>

                    <!-- Barra de búsqueda -->
                    <div class="relative w-full max-w-xl mx-4" x-data="{ isOpen: false, searchQuery: '', suggestions: [] }">
                        <div class="relative">
                            <input 
                                type="text" 
                                placeholder="Buscar productos..." 
                                class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                x-model="searchQuery"
                                @focus="isOpen = true"
                                @click.away="isOpen = false"
                                @keyup="if(searchQuery.length > 2) fetchSuggestions()"
                            >
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        
                        <!-- Sugerencias de búsqueda -->
                        <div x-show="isOpen && suggestions.length > 0" x-cloak
                            class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg">
                            <ul class="py-1">
                                <template x-for="suggestion in suggestions" :key="suggestion.id">
                                    <li @click="selectSuggestion(suggestion)" 
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer flex items-center">
                                        <img :src="suggestion.image" class="w-8 h-8 mr-3 object-cover">
                                        <span x-text="suggestion.name"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- Iconos de navegación -->
                    <div class="flex items-center space-x-6">
                        <button @click="toggleCart()" class="relative">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span x-show="cart.items.length > 0" 
                                  x-text="cart.items.length" 
                                  class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            </span>
                        </button>
                        <button @click="toggleProfileModal()">
                            <i class="fas fa-user-circle text-xl"></i>
                        </button>
                        <button @click="toggleOrdersModal()">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </button>
                        <button @click="toggleSettingsModal()">
                            <i class="fas fa-cog text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Menú de categorías -->
                <div class="pt-2 pb-1 overflow-x-auto whitespace-nowrap hide-scrollbar">
                    <template x-for="category in categories" :key="category.id">
                        <a href="javascript:void(0)" 
                           @click="selectCategory(category)"
                           class="px-4 py-1 mr-2 text-sm rounded-full hover:bg-white hover:text-indigo-600 transition-colors"
                           :class="selectedCategory && selectedCategory.id === category.id ? 'bg-white text-indigo-600' : ''">
                            <span x-text="category.name"></span>
                        </a>
                    </template>
                </div>
            </div>
        </nav>
        
        <!-- Main -->
        <main class="flex-grow">
            <!-- Banner carrusel -->
            <div class="swiper banner-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide bg-gradient-to-r from-blue-500 to-indigo-700">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Nuevos Auriculares Bluetooth</h2>
                                <p class="mb-6">Sonido inigualable con 30 horas de batería</p>
                                <button class="bg-white text-indigo-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Ver oferta</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2018/01/16/10/18/headphones-3085681_1280.jpg" alt="Auriculares" class="h-56 object-contain">
                        </div>
                    </div>
                    <div class="swiper-slide bg-gradient-to-r from-pink-500 to-purple-700">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Smartwatches en oferta</h2>
                                <p class="mb-6">Hasta 40% de descuento en modelos seleccionados</p>
                                <button class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Comprar ahora</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2015/06/25/17/21/smart-watch-821557_1280.jpg" alt="Smartwatch" class="h-56 object-contain">
                        </div>
                    </div>
                    <div class="swiper-slide bg-gradient-to-r from-amber-500 to-red-600">
                        <div class="container mx-auto px-6 flex items-center justify-between">
                            <div class="text-white max-w-md">
                                <h2 class="text-4xl font-bold mb-4">Nuevas Laptops Gaming</h2>
                                <p class="mb-6">Potencia y rendimiento a otro nivel</p>
                                <button class="bg-white text-red-600 px-6 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition">Explorar</button>
                            </div>
                            <img src="https://cdn.pixabay.com/photo/2016/03/27/07/12/apple-1282241_1280.jpg" alt="Laptop" class="h-56 object-contain">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>
            
            <!-- Featured Categories -->
            <div class="bg-gray-100 text-gray-900" x-data="ecommerceApp()">
                <section class="max-w-6xl mx-auto p-4">
                    <h1 class="text-3xl font-bold mb-6">Tienda de productos</h1>

                    @if($products->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                @php
                                    $esUrl = Str::startsWith($product->foto, ['http://', 'https://']);
                                    $foto = $esUrl ? $product->foto : asset('storage/' . $product->foto);
                                @endphp
                                <div class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer" 
                                     @click="openProductModal({
                                        id: {{ $product->id }},
                                        name: @js($product->nombre),
                                        description: @js($product->descripcion),
                                        price: {{ $product->precio }},
                                        image: '{{ $foto }}'
                                     })">
                                    <img src="{{ $foto }}" alt="{{ $product->nombre }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h2 class="text-xl font-semibold">{{ $product->nombre }}</h2>
                                        <p class="text-gray-600">{{ $product->descripcion }}</p>
                                        <p class="mt-2 font-bold text-green-600">${{ number_format($product->precio, 0, ',', '.') }}</p>
                                    </div>                       
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500">No hay productos disponibles.</p>
                    @endif
                </section>

                <!-- Modal -->
                <div x-show="productModal.isOpen" x-cloak @keydown.escape.window="productModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen px-4">
                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="productModal.isOpen = false"></div>
                        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto z-10 overflow-hidden relative">
                            <button @click="productModal.isOpen = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-xl"></i>
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <!-- Product Image -->
                                <div class="p-6 bg-gray-100 flex items-center justify-center">
                                    <img :src="productModal.product.image" :alt="productModal.product.name" class="max-h-80 object-contain">
                                </div>

                                <!-- Product Info -->
                                <div class="p-6">
                                    <h2 class="text-2xl font-bold mb-4" x-text="productModal.product.name"></h2>
                                    <p class="text-gray-600 mb-6" x-text="productModal.product.description"></p>

                                    <div class="mb-6">
                                        <span class="text-2xl font-bold text-indigo-600" x-text="'$' + productModal.product.price.toFixed(2)"></span>
                                    </div>

                                    <div class="mb-6">
                                        <h3 class="font-semibold mb-2">Cantidad</h3>
                                        <div class="flex items-center">
                                            <button @click="decrementQuantity()" class="w-10 h-10 bg-gray-200 rounded-l-lg flex items-center justify-center hover:bg-gray-300">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" min="1" max="99" x-model="productModal.quantity" class="w-16 h-10 text-center border-t border-b border-gray-200">
                                            <button @click="incrementQuantity()" class="w-10 h-10 bg-gray-200 rounded-r-lg flex items-center justify-center hover:bg-gray-300">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex space-x-4">
                                        <button @click="addToCart(productModal.product, productModal.quantity)" 
                                                class="flex-1 bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700"
                                                :disabled="isLoading">
                                            <span x-show="!isLoading">Añadir al carrito</span>
                                            <span x-show="isLoading">Cargando...</span>
                                        </button>
                                        <button @click="buyNow(productModal.product, productModal.quantity)" 
                                                class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700"
                                                :disabled="isLoading">
                                            <span x-show="!isLoading">Comprar ahora</span>
                                            <span x-show="isLoading">Cargando...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">BazurtoShop</h3>
                        <p class="text-gray-400">La tienda mas diversa de Internet. Síguenos en:</p>
                        <div class="flex space-x-4 mt-4">
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                            <a href="javascript:void(0)" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Enlaces rápidos</h4>
                        <ul class="space-y-2">
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Inicio</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Productos</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Ofertas</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Contacto</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Ayuda</h4>
                        <ul class="space-y-2">
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">FAQ</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Envíos</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Devoluciones</a></li>
                            <li><a href="javascript:void(0)" class="text-gray-400 hover:text-white">Términos y condiciones</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                                <span>Av. Tecnología 123, Ciudad Digital</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt mr-2"></i>
                                <span>+123 456 7890</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>info@techshop.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                    <p>&copy; 2025 TechShop. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
        
        <!-- Cart Modal -->
        <div x-show="cartModal.isOpen" x-cloak @keydown.escape.window="cartModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="cartModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Carrito de compras</h2>
                        <button @click="cartModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <template x-if="cart.items.length === 0">
                            <div class="text-center py-8">
                                <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Tu carrito está vacío</p>
                                <button @click="cartModal.isOpen = false" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                    Explorar productos
                                </button>
                            </div>
                        </template>
                        
                        <template x-if="cart.items.length > 0">
                            <div>
                                <ul class="divide-y">
                                    <template x-for="(item, index) in cart.items" :key="index">
                                        <li class="py-4 flex">
                                            <img :src="item.image" :alt="item.name" class="h-20 w-20 object-cover rounded">
                                            <div class="ml-4 flex-1">
                                                <h3 class="text-lg font-semibold" x-text="item.name"></h3>
                                                <div class="flex justify-between mt-1">
                                                    <div class="text-gray-600">
                                                        <span x-text="'$' + item.price.toFixed(2)"></span>
                                                        <span class="mx-2">×</span>
                                                        <span x-text="item.quantity"></span>
                                                    </div>
                                                    <div class="font-semibold" x-text="'$' + (item.price * item.quantity).toFixed(2)"></div>
                                                </div>
                                                <div class="flex items-center mt-2">
                                                    <button @click="updateCartItem(index, item.quantity - 1)" class="text-gray-500 hover:text-indigo-600">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <span class="mx-2" x-text="item.quantity"></span>
                                                    <button @click="updateCartItem(index, item.quantity + 1)" class="text-gray-500 hover:text-indigo-600">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                    <button @click="removeFromCart(index)" class="ml-auto text-red-500 hover:text-red-700">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                    
                    <template x-if="cart.items.length > 0">
                        <div class="border-t p-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold" x-text="'$' + calculateSubtotal().toFixed(2)"></span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="text-gray-600">Envío</span>
                                <span class="text-green-600 font-semibold">Gratis</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold mb-6">
                                <span>Total</span>
                                <span x-text="'$' + calculateSubtotal().toFixed(2)"></span>
                            </div>
                            <button @click="checkout()" 
                                    class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 flex items-center justify-center"
                                    :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                    :disabled="isLoading">
                                <template x-if="isLoading">
                                    <div class="w-5 h-5 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                </template>
                                <span>Proceder al pago</span>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- Profile Modal -->
        <div x-show="profileModal.isOpen" x-cloak @keydown.escape.window="profileModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="profileModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Mi perfil</h2>
                        <button @click="profileModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <form @submit.prevent="saveProfile">
                            <div class="mb-6 flex justify-center">
                                <div class="relative">
                                    <div class="h-24 w-24 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <i class="fas fa-user text-indigo-600 text-4xl"></i>
                                    </div>
                                    <button type="button" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full hover:bg-indigo-700">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 mb-2">Nombre</label>
                                    <input type="text" x-model="profileModal.user.firstName" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Apellido</label>
                                    <input type="text" x-model="profileModal.user.lastName" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Email</label>
                                <input type="email" x-model="profileModal.user.email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Teléfono</label>
                                <input type="tel" x-model="profileModal.user.phone" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <h3 class="font-semibold text-lg mb-4 mt-8">Dirección de envío</h3>
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">Dirección</label>
                                <input type="text" x-model="profileModal.user.address" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-gray-700 mb-2">Ciudad</label>
                                    <input type="text" x-model="profileModal.user.city" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Estado</label>
                                    <input type="text" x-model="profileModal.user.state" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div>
                                    <label class="block text-gray-700 mb-2">Código Postal</label>
                                    <input type="text" x-model="profileModal.user.zipCode" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                            </div>
                            
                            <div class="mt-8 flex justify-end">
                                <button type="button" @click="profileModal.isOpen = false" class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100 mr-2">Cancelar</button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center"
                                        :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                        :disabled="isLoading">
                                    <template x-if="isLoading">
                                        <div class="w-4 h-4 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                    </template>
                                    <span>Guardar cambios</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orders Modal -->
        <div x-show="ordersModal.isOpen" x-cloak @keydown.escape.window="ordersModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="ordersModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Mis pedidos</h2>
                        <button @click="ordersModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <template x-if="ordersModal.orders.length === 0">
                            <div class="text-center py-8">
                                <i class="fas fa-box-open text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No tienes pedidos recientes</p>
                                <button @click="ordersModal.isOpen = false" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                    Explorar productos
                                </button>
                            </div>
                        </template>
                        
                        <template x-if="ordersModal.orders.length > 0">
                            <div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <template x-for="order in ordersModal.orders" :key="order.id">
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="font-semibold" x-text="'#' + order.id"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap" x-text="order.date"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap font-semibold" x-text="'$' + order.total.toFixed(2)"></td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" 
                                                              :class="{
                                                                  'bg-green-100 text-green-800': order.status === 'Entregado',
                                                                  'bg-yellow-100 text-yellow-800': order.status === 'En camino',
                                                                  'bg-blue-100 text-blue-800': order.status === 'Procesando',
                                                                  'bg-red-100 text-red-800': order.status === 'Cancelado'
                                                              }"
                                                              x-text="order.status"></span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <button @click="viewOrderDetails(order)" class="text-indigo-600 hover:text-indigo-900">Ver detalles</button>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Settings Modal -->
        <div x-show="settingsModal.isOpen" x-cloak @keydown.escape.window="settingsModal.isOpen = false" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" @click="settingsModal.isOpen = false"></div>
                <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto z-10 overflow-hidden">
                    <div class="flex justify-between items-center p-6 border-b">
                        <h2 class="text-2xl font-bold">Configuración</h2>
                        <button @click="settingsModal.isOpen = false" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Notificaciones</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Emails promocionales</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.promotions" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Actualizaciones de pedidos</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.orderUpdates" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Nuevos productos</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.notifications.newProducts" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Privacidad</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Compartir datos de compra</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.privacy.shareData" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700">Cookies de terceros</span>
                                    <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                                        <input type="checkbox" x-model="settingsModal.privacy.thirdPartyCookies" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer">
                                        <label class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4">Cambiar contraseña</h3>
                            <form @submit.prevent="changePassword">
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Contraseña actual</label>
                                    <input type="password" x-model="settingsModal.password.current" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Nueva contraseña</label>
                                    <input type="password" x-model="settingsModal.password.new" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 mb-2">Confirmar nueva contraseña</label>
                                    <input type="password" x-model="settingsModal.password.confirm" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 flex items-center"
                                            :class="{ 'opacity-75 cursor-not-allowed': isLoading }"
                                            :disabled="isLoading">
                                        <template x-if="isLoading">
                                            <div class="w-4 h-4 border-2 border-white border-solid rounded-full loader mr-2"></div>
                                        </template>
                                        <span>Cambiar contraseña</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <button @click="logout()" class="flex items-center text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>Cerrar sesión</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Toast Notification Único -->
        <div id="global-toast" class="fixed bottom-4 right-4 hidden">
            <div class="bg-gray-800 text-white px-4 py-3 rounded-lg shadow-xl flex items-start max-w-xs border-l-4">
                <span id="toast-icon" class="mr-2 mt-0.5"></span>
                <span id="toast-message" class="flex-1"></span>
            </div>
        </div>
    </div>

    <script>
        // Función global para mostrar toasts
        function showToast(message, isError = false) {
            const toast = document.getElementById('global-toast');
            const icon = document.getElementById('toast-icon');
            const msg = document.getElementById('toast-message');
            const toastInner = toast.firstElementChild;
            
            // Configurar estilo según tipo
            toastInner.className = `px-4 py-3 rounded-lg shadow-xl flex items-start max-w-xs border-l-4 ${
                isError ? 'bg-red-800 text-white border-red-500' 
                        : 'bg-gray-800 text-white border-green-500'
            }`;
            
            // Configurar icono
            icon.innerHTML = isError ? '<i class="fas fa-exclamation-circle"></i>' 
                                    : '<i class="fas fa-check-circle"></i>';
            
            // Configurar mensaje
            msg.textContent = message;
            
            // Mostrar con animación
            toast.classList.remove('hidden');
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);
            
            // Ocultar después de 4 segundos
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.classList.add('hidden'), 300);
            }, 4000);
        }

        // App de ecommerce
        function ecommerceApp() {
            return {
                productModal: {
                    isOpen: false,
                    quantity: 1,
                    product: {}
                },
                isLoading: false,

                openProductModal(product) {
                    this.productModal.product = product;
                    this.productModal.quantity = 1;
                    this.productModal.isOpen = true;
                },

                incrementQuantity() {
                    if (this.productModal.quantity < 99) this.productModal.quantity++;
                },

                decrementQuantity() {
                    if (this.productModal.quantity > 1) this.productModal.quantity--;
                },

                addToCart(product, qty) {
                    this.isLoading = true;
                    setTimeout(() => {
                        showToast(`✅ Añadido ${qty} ${qty === 1 ? 'unidad' : 'unidades'} de "${product.name}" al carrito`);
                        this.isLoading = false;
                        this.productModal.isOpen = false;
                    }, 800);
                },

                buyNow(product, qty) {
                    this.isLoading = true;
                    setTimeout(() => {
                        showToast(`🛒 Compra iniciada: ${qty} ${qty === 1 ? 'unidad' : 'unidades'} de "${product.name}"`);
                        this.isLoading = false;
                        this.productModal.isOpen = false;
                    }, 800);
                },

                async submitToBackend(url, product, quantity) {
                    this.isLoading = true;
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                producto_id: product.id,
                                cantidad: quantity
                            })
                        });

                        if (!response.ok) throw new Error('Error en la respuesta del servidor');
                        
                        showToast('✔️ Acción realizada con éxito');
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('❌ Ocurrió un error al procesar la solicitud', true);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }
        }

        // Inicialización del Swiper
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.banner-swiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
</body>
</html>