<template>
    <div
        class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700"
    >
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
            <li class="py-3 sm:py-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <img
                            class="w-8 h-8 rounded-full"
                            :src="property.thumb || '../images/no-image.png'"
                            @error="handleImageError"
                        />
                    </div>
                    <div class="flex-1 min-w-0 ms-4">
                        <p
                            class="text-sm font-medium text-gray-900 truncate dark:text-white"
                        >
                            Neil Sims
                        </p>
                        <p
                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                        >
                            email@windster.com
                        </p>
                    </div>
                    <div
                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                    >
                        $320
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
<script setup>
const props = defineProps({
    property: Object,
});
const handleImageError = (event) => {
    event.target.src = "/images/noimage.jpg";
};

const formatPrice = (price, locale = "fr-FR") => {
    if (!price) return "";
    // Remove any non-numeric characters (including spaces, FCFA, etc.)
    const numericPrice = parseInt(price.replace(/[^\d]/g, ""), 10);
    const formattedNumber = new Intl.NumberFormat(locale).format(numericPrice);
    return `${formattedNumber} FCFA`;
};
</script>
