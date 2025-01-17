<x-admin-layout>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Order ID</dt>
                    <dd class="text-lg font-semibold text-gray-800">{{ $order->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Customer Name</dt>
                    <dd class="text-lg font-semibold text-gray-800">{{ $order->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                    <dd class="text-lg text-gray-800">{{ $order->contactno }}</dd>
                </div>
                <div class="sm:col-span-2 lg:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="text-lg text-gray-800">{{ $order->address }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                    <dd class="text-lg text-gray-800">{{ $order->payment_method }}</dd>
                </div>
            </dl>
        </div>

        <div class="px-6 py-5 bg-gray-50 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Ordered Products</h3>
            <p class="text-sm text-gray-500">Items in this order</p>
        </div>
        
        <div class="px-6 py-4">
            <ul class="space-y-4">
                @forelse ($order->items as $item)
                    <li class="p-4 bg-white rounded-lg shadow-sm border border-gray-200 flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            @if ($item->product)
                                <img src="{{ asset($item->product->photo) }}" class="h-16 w-16 rounded object-cover" alt="Product Image">
                            @else
                                <div class="h-16 w-16 bg-gray-100 text-gray-400 flex items-center justify-center rounded">
                                    <span>?</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            @if ($item->product)
                                <h4 class="text-md font-semibold text-gray-800">{{ $item->product->product_name }}</h4>
                                <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-500">Price: ₱{{ number_format($item->product->price, 2) }}</p>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="py-4 text-center text-sm text-gray-500">No items found in this order.</li>
                @endforelse
            </ul>
        </div>

        <!-- Status Update Section -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Update Order Status</h3>
            <form action="{{ route('admin.orders.updateStatus') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <div class="mt-4">
                    <label for="status" class="block text-sm font-medium text-gray-500">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="in_queue" {{ $order->status == 'in_queue' ? 'selected' : '' }}>In Queue</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="on-deliver" {{ $order->status == 'on-deliver' ? 'selected' : '' }}>On Delivery</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Update Status
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
