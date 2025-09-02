capstonefinal/
│
├── admin/                # Admin dashboard and features
│   ├── dashboard.php
│   ├── hotline.php
│   ├── manage_users.php
│   ├── massnotify.php
│   ├── messages.php
│   ├── audit.php
│   └── system_settings.php
│
├── auth/                 # Authentication (login, register, logout)
│   ├── login.php
│   ├── logout.php
│   ├── register_step1.php
│   ├── register_step2.php
│   └── mail_test.php
│
├── backend/              # Backend logic (APIs, processing)
│   ├── auth/
│   └── citizen/
│       └── audit/
│           ├── create_audit.php
│           ├── delete_audit.php
│           └── update_audit.php
│
├── citizen/              # Citizen-facing pages
│   ├── dashboard.php
│   ├── hotline.php
│   ├── messages.php
│   ├── myalerts.php
│   ├── myprofile.php
│   ├── profile.php
│   ├── sidebar.php
│   └── audit.php
│
├── staff/                # Staff-facing pages
│   ├── attendance.php
│   ├── audit.php
│   ├── dashboard.php
│   ├── hotline.php
│   ├── messages.php
│   ├── send_alert.php
│   └── view_alerts.php
│
├── config/               # Configuration files
│   └── config.php
│
├── uploads/              # Uploaded files
│   └── qc_ids/
│
├── vendor/               # Composer or third-party libraries (if any)
│
├── docs/                 # Documentation, SQL, and info files
│   ├── lgu_emergency_system.sql
│   ├── CONFIG CODE.txt
│   ├── Sample info.txt
│   ├── STEP BY STEP.txt
│   ├── WHOLE SYSTEM BREAK DOWN.txt
│   └── test.md
│
├── index.php             # Main entry point
└── QCIDSAMPLE.jpg        # Sample image (move to uploads/ if used for uploads)