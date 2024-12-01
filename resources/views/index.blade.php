<!DOCTYPE html>
<html lang="en">
<!-- Head -->
@include('partials._head')
<body>
<div x-data="setup()" x-init="$refs.loading.classList.add('hidden'); setColors(color);" :class="{ 'dark': isDark}">
    <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
        <!-- Loading screen -->
        <div
            x-ref="loading"
            class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-primary-darker"
        >
            Loading.....
        </div>

        <!-- Sidebar -->
        @include('partials._sidebar')
        <div class="flex-1 h-full overflow-x-hidden overflow-y-auto">
            <!-- Header -->
            @include('partials._header')

            <!-- Main content -->
            @include('partials._maincontent')

        </div>
        <!-- Backdrop -->
        <div
            x-transition:enter="transition duration-300 ease-in-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-300 ease-in-out"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-show="isSettingsPanelOpen"
            @click="isSettingsPanelOpen = false"
            class="fixed inset-0 z-10 bg-primary-darker"
            style="opacity: 0.5"
            aria-hidden="true"
        ></div>
        <!-- Panel -->
        @include('partials._panel')
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="/js/charts.js"></script>
<script src="/js/chartextra.js"></script>
<script src="/js/chart-buttons-functionality.js"></script>
<script src="/js/auto-update-chart.js"></script>
</body>
</html>
