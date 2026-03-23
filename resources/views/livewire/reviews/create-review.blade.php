<div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-6">Leave a Review</h2>

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Overall Rating -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating *</label>
            <div class="flex gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('overall_rating', {{ $i }})" class="focus:outline-none">
                        <span class="text-4xl {{ $i <= $overall_rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                    </button>
                @endfor
            </div>
            @error('overall_rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Category Ratings -->
        <div class="grid grid-cols-2 gap-6">
            @foreach(['cleanliness' => 'Cleanliness', 'communication' => 'Communication', 'location' => 'Location', 'value' => 'Value'] as $field => $label)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                    <div class="flex gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" wire:click="$set('{{ $field }}_rating', {{ $i }})" class="focus:outline-none">
                                <span class="text-2xl {{ $i <= $this->{$field . '_rating'} ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                            </button>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Review Text -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Your Review (optional)</label>
            <textarea wire:model="review_text" rows="5" placeholder="Share your experience..." class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            @error('review_text') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Highlights -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">What did you love? (optional)</label>
            <div class="space-y-2">
                @php $highlightOptions = ['Clean', 'Cozy', 'Great Location', 'Responsive Host', 'Beautiful View', 'Comfortable Bed']; @endphp
                @foreach($highlightOptions as $option)
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="highlights" value="{{ $option }}" class="rounded">
                        <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Improvements -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Areas for Improvement (optional)</label>
            <div class="space-y-2">
                @php $improvementOptions = ['Noise', 'Maintenance', 'Communication', 'Photos Accuracy', 'Amenities', 'Check-In']; @endphp
                @foreach($improvementOptions as $option)
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="improvements" value="{{ $option }}" class="rounded">
                        <span class="ml-2 text-sm text-gray-700">{{ $option }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Recommend -->
        <div>
            <label class="flex items-center">
                <input type="checkbox" wire:model="would_recommend" class="rounded">
                <span class="ml-2 text-sm font-medium text-gray-700">I would recommend this property</span>
            </label>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 font-medium">Post Review</button>
    </form>
</div>
