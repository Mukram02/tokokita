<x-app-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-2">

        @if (session()->has('success'))
        <x-alert message="{{ session('success') }}" />
        @endif

        
        <div class="flex items-center justify-between mt-6">
          <h2 class="font-semibold text-xl">List Product</h2>
          <a href="{{ route('products.create') }}" class="bg-gray-100 px-10 py-2 rounded-md font-semibold">
            Add
          </a>
        </div>

        <div class="grid md:grid-cols-3 grid-cols-1 gap-6 mt-4">
          @foreach ($allProducts as $product) <!-- Perbaiki nama variabel -->
            <div>
            <img 
                src="{{ url('storage/' . $product->foto) }}" 
                class="w-full h-48 object-cover rounded-md"
                alt="{{ $product->nama }}"
            />
              <div class="my-2">
                <p class="text-xl font-light">{{ $product->nama }}</p>
                <p class="font-semibold text-gray-500">Rp.{{ number_format($product->harga) }}</p>
              </div>
              <a href="{{ route('products.edit' , $product) }}" class="bg-gray-100 px-10 py-2 w-full rounded-md font-semibold">Edit>
              </a>
            </div>
          @endforeach
        </div>

        <div class="mt-4">
          {{ $allProducts->links() }} <!-- Pagination -->
        </div>

      </div>
  </div>
</x-app-layout>
