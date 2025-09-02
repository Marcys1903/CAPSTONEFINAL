<?php
$current_page = basename($_SERVER['PHP_SELF']); // get current file name
?>
<aside x-data="{ open: true, profileOpen: false }" 
       class="bg-gray-900 text-white h-screen transition-all duration-300 flex flex-col"
       :class="open ? 'w-64' : 'w-20'">

    <!-- Toggle Button -->
    <div class="flex items-center justify-between p-4 border-b border-gray-700 flex-shrink-0">
        <span x-show="open" x-transition class="text-2xl font-bold">Citizen</span>
        <button @click="open = !open" class="text-gray-300 hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
            </svg>
        </button>
    </div>

    <!-- Nav -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <!-- Dashboard -->
        <a href="dashboard.php" 
           class="flex items-center py-3 px-3 rounded-lg transition-all duration-200 hover:bg-gray-700 group <?= $current_page === 'dashboard.php' ? 'bg-gray-700 border-l-4 border-blue-500' : '' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v14"/>
            </svg>
            <span x-show="open" x-transition class="ml-3">Dashboard</span>
        </a>

        <!-- My Alerts -->
        <a href="myalerts.php" 
           class="flex items-center py-3 px-3 rounded-lg transition-all duration-200 hover:bg-gray-700 group <?= $current_page === 'myalerts.php' ? 'bg-gray-700 border-l-4 border-blue-500' : '' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 17h5l-5 5v-5zM10.5 3.5L12 2l1.5 1.5L15 2l1.5 1.5L18 2v4.5L16.5 8 18 9.5V14h-4.5L12 12.5 10.5 14H6V9.5L7.5 8 6 6.5V2l1.5 1.5L9 2l1.5 1.5z"/>
            </svg>
            <span x-show="open" x-transition class="ml-3">My Alerts</span>
        </a>

        <!-- Messages -->
        <a href="messages.php" 
           class="flex items-center py-3 px-3 rounded-lg transition-all duration-200 hover:bg-gray-700 group <?= $current_page === 'messages.php' ? 'bg-gray-700 border-l-4 border-blue-500' : '' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <span x-show="open" x-transition class="ml-3">Messages</span>
        </a>

        <!-- Hotline -->
        <a href="hotline.php" 
           class="flex items-center py-3 px-3 rounded-lg transition-all duration-200 hover:bg-gray-700 group <?= $current_page === 'hotline.php' ? 'bg-gray-700 border-l-4 border-blue-500' : '' ?>">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <span x-show="open" x-transition class="ml-3">Hotline</span>
        </a>

        <!-- My Profile Dropdown -->
        <div class="space-y-1">
            <button @click="profileOpen = !profileOpen"
                    class="w-full flex items-center justify-between py-3 px-3 rounded-lg transition-all duration-200 hover:bg-gray-700 group
                           <?= in_array($current_page, ['profile.php','audit.php']) ? 'bg-gray-700 border-l-4 border-blue-500' : '' ?>">
                <div class="flex items-center">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span x-show="open" x-transition class="ml-3">My Profile</span>
                </div>
                <svg x-show="open" :class="profileOpen ? 'rotate-180' : ''" 
                     class="w-4 h-4 transition-transform flex-shrink-0" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div x-show="profileOpen && open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="ml-8 space-y-1">
                <a href="profile.php" 
                   class="flex items-center py-2 px-3 rounded-lg text-sm transition-colors hover:bg-gray-700 <?= $current_page === 'profile.php' ? 'bg-gray-700 text-blue-400' : 'text-gray-300' ?>">
                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                   </svg>
                   View Profile
                </a>
                <a href="audit.php" 
                   class="flex items-center py-2 px-3 rounded-lg text-sm transition-colors hover:bg-gray-700 <?= $current_page === 'audit.php' ? 'bg-gray-700 text-blue-400' : 'text-gray-300' ?>">
                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                   </svg>
                   Audit Logs
                </a>
            </div>
        </div>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-700 flex-shrink-0">
        <a href="../auth/logout.php" 
           class="flex items-center justify-center py-3 px-3 rounded-lg bg-red-600 transition-all duration-200 hover:bg-red-700 group">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span x-show="open" x-transition class="ml-3 font-medium">Logout</span>
        </a>
    </div>
</aside>