<aside class="group/sidebar relative w-64 h-screen bg-gray-900 text-white flex flex-col overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-lg">
    
    <div class="p-6 border-b border-gray-700">
        <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-purple-500">Admin Panel</h1>
    </div>

    <nav class="flex-1 space-y-2 px-4 py-4">
        
        <a href="dashboard.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-200 hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out transform hover:scale-105">
            <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span>Dashboard</span>
        </a>

        <?php
        $modules = [
            'Alerts' => [
                'folder' => 'module/module1',
                'icon' => '<svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
                'files' => [
                    'confirmation_tracker.php' => 'Confirmation Tracker',
                    'mass_notification.php' => 'Mass Notification',
                    'system_settings.php' => 'System Settings'
                ]
            ],
            'Categorization' => [
                'folder' => 'module/module2',
                'icon' => '<svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.313.829 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.942 1.543-.829 3.313-2.37-2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.313-.829-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.942-1.543.829-3.313 2.37-2.37.996.608 2.296.262 2.928-.795z"></path></svg>',
                'files' => [
                    'category_mapper.php' => 'Category Mapper',
                    'severity_manager.php' => 'Severity Manager',
                    'source_identifier.php' => 'Source Identifier'
                ]
            ],
            'Communication' => [
                'folder' => 'module/module3',
                'icon' => '<svg class="w-6 h-6 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>',
                'files' => [
                    'channel_returner.php' => 'Channel Returner',
                    'citizen_input.php' => 'Citizen Input',
                    'message_dashboard.php' => 'Message Dashboard',
                    'response_composer.php' => 'Response Composer'
                ]
            ],
            'Integration' => [
                'folder' => 'module/module4',
                'icon' => '<svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>',
                'files' => [
                    'auto_alert_dispatcher.php' => 'Auto Alert Dispatcher',
                    'device_connector.php' => 'Device Connector'
                ]
            ],
            'Localization' => [
                'folder' => 'module/module5',
                // This is a simple and common globe icon
                'icon' => '<svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.551 10H2.885a1.515 1.515 0 00-.731 1.052c-.44 1.761.59 3.597 2.202 4.417a9.497 9.497 0 001.625.599M16 16v-3a2 2 0 00-2-2h-2a2 2 0 00-2 2v3m2 3h2a2 2 0 002-2v-3m0-12V5a2 2 0 00-2-2h-2a2 2 0 00-2 2v3m2 3h2a2 2 0 002-2V5M17 21h4"></path></svg>',
                'files' => [
                    'localized_delivery.php' => 'Localized Delivery',
                    'translation_engine.php' => 'Translation Engine'
                ]
            ],
            'Users' => [
                'folder' => 'module/module6',
                'icon' => '<svg class="w-6 h-6 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>',
                'files' => [
                    'profile_preference_manager.php' => 'Profile Preference Manager',
                    'registration_manager.php' => 'Registration Manager'
                ]
            ],
            'Logs' => [
                'folder' => 'module/module7',
                'icon' => '<svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>',
                'files' => [
                    'activity_logger.php' => 'Activity Logger',
                    'data_security_checker.php' => 'Data Security Checker',
                    'user_tracking_manager.php' => 'User Tracking Manager'
                ]
            ]
        ];

        foreach ($modules as $moduleName => $data) {
            $folder = $data['folder'];
            $files = $data['files'];
            $icon = $data['icon'];
            
            echo '<div x-data="{ open: false }" class="relative">';
            echo '<button @click="open = !open" class="flex items-center justify-between w-full p-3 rounded-lg text-gray-200 hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out transform hover:scale-105 focus:outline-none">';
            echo '<div class="flex items-center space-x-3">';
            echo $icon;
            echo '<span>' . htmlspecialchars($moduleName) . '</span>';
            echo '</div>';
            echo '<svg :class="{\'rotate-90\': open}" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>';
            echo '</button>';
            echo '<div x-show="open" x-collapse.duration.300ms class="mt-2 space-y-2 pl-6 border-l border-gray-700">';
            foreach ($files as $file => $text) {
                echo '<a href="' . htmlspecialchars($folder) . '/' . htmlspecialchars($file) . '" class="flex items-center p-2 text-sm text-gray-400 rounded-lg hover:bg-gray-800 hover:text-white transition duration-200 ease-in-out">';
                echo $text;
                echo '</a>';
            }
            echo '</div>';
            echo '</div>';
        }
        ?>

        <a href="system_settings.php" class="flex items-center space-x-3 p-3 rounded-lg text-gray-200 hover:bg-gray-700 hover:text-white transition duration-200 ease-in-out transform hover:scale-105">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.942 3.313.829 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.942 1.543-.829 3.313-2.37-2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.942-3.313-.829-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.942-1.543.829-3.313 2.37-2.37.996.608 2.296.262 2.928-.795z"></path></svg>
            <span>System Settings</span>
        </a>

        <a href="../auth/logout.php" class="flex items-center space-x-3 p-3 rounded-lg text-red-400 hover:bg-red-700 hover:text-white transition duration-200 ease-in-out transform hover:scale-105">
            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            <span>Logout</span>
        </a>
    </nav>
</aside>