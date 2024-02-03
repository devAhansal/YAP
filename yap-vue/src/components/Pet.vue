<template>
    <div class="bg-white ">
        <div class="mx-auto grid max-w-7xl gap-x-8 gap-y-20 px-6 lg:px-8 xl:grid-cols-3">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Nos catégories d'animaux</h2>
                <p class="mt-6 text-lg leading-8 text-gray-600">Découvrez notre sélection de catégories d'animaux pour trouver votre compagnon idéal.</p>
            </div>
            <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">
                <li v-for="category in categories" :key="category.id">
                    <div class="flex items-center gap-x-6">
                        <img class="h-16 w-16 rounded-full" :src="category.imageUrl" alt="" />
                        <div>
                            <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">{{ category.name }}</h3>
                            <p class="text-sm font-semibold leading-6 text-indigo-600">{{ category.description }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <br><br>
</template>

<script setup>
const categories = [
    {
        id: 1,
        name: 'Chiens',
        description: 'Découvrez notre sélection de chiens de race et de chiots adorables.',
        imageUrl: 'https://cdn.futura-sciences.com/buildsv6/images/largeoriginal/8/5/8/858743bb35_50169458_chien-min.jpg',
    },
    {
        id: 2,
        name: 'Chats',
        description: 'Explorez notre variété de races de chats et de chatons disponibles.',
        imageUrl: 'https://img.freepik.com/photos-premium/chat-siamois-aux-yeux-bleus-est-assis-devant-fond-blanc_863013-15433.jpg?w=2000',
    },
    {
        id: 3,
        name: 'Oiseaux',
        description: 'Trouvez des oiseaux exotiques et colorés pour animer votre foyer.',
        imageUrl: 'https://assets.gammvert.fr/image/fetch/w_auto,q_auto,f_auto,c_pad/https://images.ctfassets.net/b85ozb2q358o/b270facbc54d205f0ffdbca29159c6a1b44ab450665392e2b4efade90fab496d/960aa94c944c0a9fac3c3507ff1ea973/image.png',
    },
    // Ajoutez d'autres catégories d'animaux au besoin
];
</script>
