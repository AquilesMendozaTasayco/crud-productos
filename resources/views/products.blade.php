<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
<script src="http://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen py-10">

<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden p-8 space-y-8 border border-gray-100">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Gestión de Productos</h1>
        </div>

        <button id="open-modal"
                class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Producto
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total de productos</p>
                    <p class="text-2xl font-bold text-gray-800"><span id="total-products">0</span></p>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-xl p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Valor total</p>
                    <p class="text-2xl font-bold text-gray-800">S/ <span id="total-value">0.00</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4">
        <div class="w-full md:w-80">
            <div class="relative">
                <span class="absolute left-3 top-3 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-4.35-4.35M11 17a6 6 0 100-12 6 6 0 000 12z" />
                    </svg>
                </span>
                <input id="search"
                       placeholder="Buscar por nombre o descripción..."
                       class="w-full border border-gray-300 rounded-lg px-10 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
            </div>
        </div>
    </div>

    <div class="mt-6 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left font-bold text-gray-700 whitespace-nowrap">ID</th>
                    <th class="px-6 py-4 text-left font-bold text-gray-700 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-4 text-left font-bold text-gray-700 whitespace-nowrap">Precio</th>
                    <th class="px-6 py-4 text-left font-bold text-gray-700 whitespace-nowrap">Descripción</th>
                    <th class="px-6 py-4 text-center font-bold text-gray-700 whitespace-nowrap">Acciones</th>
                </tr>
                </thead>

                <tbody id="products-body" class="divide-y divide-gray-100 bg-white">
                </tbody>
            </table>
        </div>

        <div id="empty-state" class="p-8 text-center text-gray-500 text-sm hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <p class="text-lg font-medium text-gray-500">No hay productos registrados</p>
            <p class="text-gray-400 mt-1">Comienza agregando tu primer producto</p>
        </div>
    </div>

    <div id="pagination" class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mt-6 text-sm text-gray-700 hidden">
        <button id="prev-page"
                class="px-4 py-2 border border-gray-300 rounded-lg disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors duration-200 flex items-center gap-1 justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Anterior
        </button>

        <div class="flex items-center justify-center gap-2">
            <span class="font-medium">Página</span>
            <span id="current-page" class="px-3 py-1 bg-blue-100 text-blue-700 rounded-md font-medium">1</span>
            <span class="font-medium">de</span>
            <span id="last-page" class="font-medium">1</span>
        </div>

        <button id="next-page"
                class="px-4 py-2 border border-gray-300 rounded-lg disabled:opacity-40 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors duration-200 flex items-center gap-1 justify-center">
            Siguiente
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

</div>

<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center backdrop-blur-sm z-50 transition-opacity duration-300">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 transform scale-95 opacity-0 transition-all duration-300"
         id="modal-content">

        <div class="flex items-center justify-between mb-6">
            <h2 id="modal-title" class="text-xl font-semibold text-gray-800">Nuevo Producto</h2>
            <button id="close-modal" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form id="modal-form" class="space-y-5">

            <input type="hidden" id="product_id">

            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Nombre</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.5a2.5 2.5 0 110 5 2.5 2.5 0 010-5zm0 7c-3 0-5.5 1.6-5.5 3.5V18h11v-.5c0-1.9-2.5-3.5-5.5-3.5z"/>
                        </svg>
                    </span>
                    <input id="name" placeholder="Ej. Gaseosa, Laptop, Torta"
                           class="w-full border border-gray-300 rounded-lg px-10 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Precio</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6"/>
                        </svg>
                    </span>
                    <input id="price" type="number" step="0.01" placeholder="Ej. 49.90"
                           class="w-full border border-gray-300 rounded-lg px-10 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" />
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-gray-700 mb-2 block">Descripción</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </span>
                    <textarea id="description"
                              placeholder="Detalles del producto..."
                              class="w-full border border-gray-300 rounded-lg px-10 py-3 min-h-[100px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" id="close-modal-btn"
                        class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                    Guardar
                </button>
            </div>

        </form>
    </div>
</div>

@vite('resources/js/products/main.js')

</body>
</html>
