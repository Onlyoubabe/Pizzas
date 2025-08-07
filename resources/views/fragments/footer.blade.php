<!-- resources/views/components/footer.blade.php -->
<footer class="bg-white shadow-lg mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo y descripción -->
            <div class="col-span-1 md:col-span-1">
                <a href="#" class="logo flex items-center space-x-2 mb-4">
                    <span class="text-3xl">🍕</span>
                    <span class="text-2xl font-bold bg-gradient-to-r from-red-600 to-red-400 bg-clip-text text-transparent">
                        PizzaPlace
                    </span>
                </a>
                <p class="text-gray-600 text-sm">
                    Disfruta de las mejores pizzas artesanales hechas con ingredientes frescos y mucho amor.
                </p>
            </div>

            <div class="col-span-1">
                <h3 class="text-gray-900 font-semibold mb-4">Enlaces Rápidos</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-red-600 transition-colors duration-300">Inicio</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-red-600 transition-colors duration-300">Menú</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-red-600 transition-colors duration-300">Nosotros</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-red-600 transition-colors duration-300">Contacto</a></li>
                </ul>
            </div>

            <!-- Horario -->
            <div class="col-span-1">
                <h3 class="text-gray-900 font-semibold mb-4">Horario</h3>
                <ul class="space-y-2">
                    <li class="text-gray-600">Lunes - Viernes</li>
                    <li class="text-gray-900 font-medium">11:00 - 22:00</li>
                    <li class="text-gray-600 mt-2">Sábado - Domingo</li>
                    <li class="text-gray-900 font-medium">12:00 - 23:00</li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-span-1">
                <h3 class="text-gray-900 font-semibold mb-4">Contacto</h3>
                <ul class="space-y-2">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Calle Principal #123
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +1 234 567 890
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        info@pizzaplace.com
                    </li>
                </ul>
            </div>
        </div>

        <!-- Línea divisoria -->
        <div class="border-t border-gray-200 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Copyright -->
                <p class="text-gray-600 text-sm">
                    © {{ date('Y') }} PizzaPlace. Todos los derechos reservados.
                </p>
                <!-- Redes sociales -->
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="https://www.facebook.com" class="text-gray-400 hover:text-red-600 transition-colors duration-300">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com" class="text-gray-400 hover:text-red-600 transition-colors duration-300">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                        </svg>
                    </a>
                    <a href="https://www.twitter.com" class="text-gray-400 hover:text-red-600 transition-colors duration-300">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>