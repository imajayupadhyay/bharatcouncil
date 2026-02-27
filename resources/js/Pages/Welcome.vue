<template>
    <div class="min-h-screen bg-gradient-to-br from-orange-50 to-green-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center">
                        <span class="text-white font-bold text-sm">BG</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">Bharat Governance</span>
                </div>
                <div class="flex gap-4">
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors text-sm font-medium">Home</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors text-sm font-medium">About</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors text-sm font-medium">Services</a>
                    <a href="#" class="text-gray-600 hover:text-orange-500 transition-colors text-sm font-medium">Contact</a>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <div class="inline-block bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full mb-6 tracking-wide uppercase">
                Digital India Initiative
            </div>
            <h1 class="text-5xl sm:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                Welcome to <span class="text-orange-500">Bharat</span><br />
                <span class="text-green-600">Governance</span> Portal
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-10">
                Empowering citizens with transparent, accessible, and efficient government services.
                Your gateway to a digitally connected India.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-3 rounded-lg shadow transition-colors">
                    Get Started
                </a>
                <a href="#" class="border border-gray-300 hover:border-orange-400 text-gray-700 font-semibold px-8 py-3 rounded-lg transition-colors">
                    Learn More
                </a>
            </div>
        </main>

        <!-- Feature Cards -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24 grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div v-for="feature in features" :key="feature.title"
                class="bg-white rounded-2xl shadow-sm p-6 text-center hover:shadow-md transition-shadow">
                <div class="text-4xl mb-4">{{ feature.icon }}</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ feature.title }}</h3>
                <p class="text-gray-500 text-sm">{{ feature.description }}</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-400 text-center text-sm py-6">
            © {{ new Date().getFullYear() }} Bharat Governance. All rights reserved.
        </footer>
    </div>
</template>

<script setup>
const features = [
    {
        icon: '🏛️',
        title: 'Transparent Governance',
        description: 'Real-time access to government policies, decisions, and public records.',
    },
    {
        icon: '⚡',
        title: 'Fast Services',
        description: 'Apply for government services online — no queues, no paperwork.',
    },
    {
        icon: '🔒',
        title: 'Secure & Private',
        description: 'Your data is protected with end-to-end encryption and privacy controls.',
    },
];
</script>
