<x-app-layout>
    <!-- Notification Banner -->
    @if(session('success'))
        <div id="notification-banner" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded-md">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div id="notification-banner" class="fixed top-0 right-0 m-4 p-4 bg-red-500 text-white rounded-md">
            {{ session('error') }}
        </div>
    @endif

     <!-- Blocked User Modal -->
     <div id="blocked-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 {{ session('blocked') ? '' : 'hidden' }}">
        <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
            <h2 class="text-lg font-semibold text-gray-800">Action Restricted</h2>
            <p class="text-gray-600">{{ session('blocked') }}</p>
            <div class="flex justify-end mt-4">
                <button id="close-modal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Close</button>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="container mx-auto py-4 max-w-5xl">
        <!-- Product Display Section -->
        <div id="product-list" class="grid grid-cols-2 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @if($products->isEmpty())
                <div class="text-center text-gray-600">No products to display.</div>
            @else
                @foreach($products as $product)
                    <div class="w-full sm:w-1/2 md:w-auto md:h-86 lg:w-54 mb-4 flex">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden w-full flex flex-col justify-between">
                            <img src="{{ asset($product->photo) }}" alt="Product Image" class="w-full h-32 md:h-28 object-cover sm:h-32">
                            <div class="p-4 flex flex-col justify-between flex-grow">
                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $product->product_name }}</h3>
                                    <p class="text-sm text-gray-600">Price: ₱{{ $product->price }}</p>
                                    <p class="text-sm text-gray-600">Description: {{ $product->description }}</p>
                                </div>
                                <form action="{{ route('add-to-cart', ['productId' => $product->id]) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Pagination Section -->
        <div class="pagination">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
        const notificationBanner = document.getElementById('notification-banner');
        const blockedModal = document.getElementById('blocked-modal');
        const closeModal = document.getElementById('close-modal');

        if (notificationBanner) {
            console.log('Notification banner found');
            setTimeout(() => {
                notificationBanner.style.opacity = '0';
                setTimeout(() => {
                    notificationBanner.style.display = 'none';
                }, 5000);
            }, 3000);
        }

        console.log("Blocked modal:", blockedModal);
        console.log("Close button:", closeModal);

        if (closeModal) {
            closeModal.addEventListener('click', function() {
                console.log('Close button clicked');
                if (blockedModal) {
                    blockedModal.classList.add('hidden');
                }
            });
        }
        });
    </script>
</x-app-layout>
