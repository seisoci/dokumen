<?php
// Aside menu
return [

    'items' => [
        // Dashboard
        [
            'title' => 'Users',
            'root' => true,
            'icon' => 'media/svg/icons/General/User.svg', // or can be 'flaticon-home' or any flaticon-*
            'page' => '/users',
            'new-tab' => false,
        ],

        // Custom
        // [
        //     'section' => 'Custom',
        // ],
        // [
        //     'title' => 'Applications',
        //     'icon' => 'media/svg/icons/Layout/Layout-4-blocks.svg',
        //     'bullet' => 'line',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Users',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'List - Default',
        //                     'page' => 'test',
        //                 ],
        //                 [
        //                     'title' => 'List - Datatable',
        //                     'page' => 'custom/apps/user/list-datatable'
        //                 ],
        //                 [
        //                     'title' => 'List - Columns 1',
        //                     'page' => 'custom/apps/user/list-columns-1'
        //                 ],
        //                 [
        //                     'title' => 'List - Columns 2',
        //                     'page' => 'custom/apps/user/list-columns-2'
        //                 ],
        //                 [
        //                     'title' => 'Add User',
        //                     'page' => 'custom/apps/user/add-user'
        //                 ],
        //                 [
        //                     'title' => 'Edit User',
        //                     'page' => 'custom/apps/user/edit-user'
        //                 ],
        //             ]
        //         ],
        //         [
        //             'title' => 'Profile',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Profile 1',
        //                     'bullet' => 'line',
        //                     'submenu' => [
        //                         [
        //                             'title' => 'Overview',
        //                             'page' => 'custom/apps/profile/profile-1/overview'
        //                         ],
        //                         [
        //                             'title' => 'Personal Information',
        //                             'page' => 'custom/apps/profile/profile-1/personal-information'
        //                         ],
        //                         [
        //                             'title' => 'Account Information',
        //                             'page' => 'custom/apps/profile/profile-1/account-information'
        //                         ],
        //                         [
        //                             'title' => 'Change Password',
        //                             'page' => 'custom/apps/profile/profile-1/change-password'
        //                         ],
        //                         [
        //                             'title' => 'Email Settings',
        //                             'page' => 'custom/apps/profile/profile-1/email-settings'
        //                         ]
        //                     ]
        //                 ],
        //                 [
        //                     'title' => 'Profile 2',
        //                     'page' => 'custom/apps/profile/profile-2'
        //                 ],
        //                 [
        //                     'title' => 'Profile 3',
        //                     'page' => 'custom/apps/profile/profile-3'
        //                 ],
        //                 [
        //                     'title' => 'Profile 4',
        //                     'page' => 'custom/apps/profile/profile-4'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Contacts',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'List - Columns',
        //                     'page' => 'custom/apps/contacts/list-columns'
        //                 ],
        //                 [
        //                     'title' => 'List - Datatable',
        //                     'page' => 'custom/apps/contacts/list-datatable'
        //                 ],
        //                 [
        //                     'title' => 'View Contact',
        //                     'page' => 'custom/apps/contacts/view-contact'
        //                 ],
        //                 [
        //                     'title' => 'Add Contact',
        //                     'page' => 'custom/apps/contacts/add-contact'
        //                 ],
        //                 [
        //                     'title' => 'Edit Contact',
        //                     'page' => 'custom/apps/contacts/edit-contact'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Projects',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'List - Columns 1',
        //                     'page' => 'custom/apps/projects/list-columns-1'
        //                 ],
        //                 [
        //                     'title' => 'List - Columns 2',
        //                     'page' => 'custom/apps/projects/list-columns-2'
        //                 ],
        //                 [
        //                     'title' => 'List - Columns 3',
        //                     'page' => 'custom/apps/projects/list-columns-3'
        //                 ],
        //                 [
        //                     'title' => 'List - Columns 4',
        //                     'page' => 'custom/apps/projects/list-columns-4'
        //                 ],
        //                 [
        //                     'title' => 'List - Datatable',
        //                     'page' => 'custom/apps/projects/list-datatable'
        //                 ],
        //                 [
        //                     'title' => 'View Project',
        //                     'page' => 'custom/apps/projects/view-project'
        //                 ],
        //                 [
        //                     'title' => 'Add Project',
        //                     'page' => 'custom/apps/projects/add-project'
        //                 ],
        //                 [
        //                     'title' => 'Edit Project',
        //                     'page' => 'custom/apps/projects/edit-project'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Support Center',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Home 1',
        //                     'page' => 'custom/apps/support-center/home-1'
        //                 ],
        //                 [
        //                     'title' => 'Home 2',
        //                     'page' => 'custom/apps/support-center/home-2'
        //                 ],
        //                 [
        //                     'title' => 'FAQ 1',
        //                     'page' => 'custom/apps/support-center/faq-1'
        //                 ],
        //                 [
        //                     'title' => 'FAQ 2',
        //                     'page' => 'custom/apps/support-center/faq-2'
        //                 ],
        //                 [
        //                     'title' => 'FAQ 3',
        //                     'page' => 'custom/apps/support-center/faq-3'
        //                 ],
        //                 [
        //                     'title' => 'Feedback',
        //                     'page' => 'custom/apps/support-center/feedback'
        //                 ],
        //                 [
        //                     'title' => 'License',
        //                     'page' => 'custom/apps/support-center/license'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Chat',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Private',
        //                     'page' => 'custom/apps/chat/private'
        //                 ],
        //                 [
        //                     'title' => 'Group',
        //                     'page' => 'custom/apps/chat/group'
        //                 ],
        //                 [
        //                     'title' => 'Popup',
        //                     'page' => 'custom/apps/chat/popup'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Todo',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Tasks',
        //                     'page' => 'custom/apps/todo/tasks'
        //                 ],
        //                 [
        //                     'title' => 'Docs',
        //                     'page' => 'custom/apps/todo/docs'
        //                 ],
        //                 [
        //                     'title' => 'Files',
        //                     'page' => 'custom/apps/todo/files'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Inbox',
        //             'bullet' => 'dot',
        //             'page' => 'custom/apps/inbox',
        //             'label' => [
        //                 'type' => 'label-danger label-inline',
        //                 'value' => 'new'
        //             ]
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'Pages',
        //     'icon' => 'media/svg/icons/Shopping/Barcode-read.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Wizard',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Wizard 1',
        //                     'page' => 'custom/pages/wizard/wizard-1'
        //                 ],
        //                 [
        //                     'title' => 'Wizard 2',
        //                     'page' => 'custom/pages/wizard/wizard-2'
        //                 ],
        //                 [
        //                     'title' => 'Wizard 3',
        //                     'page' => 'custom/pages/wizard/wizard-3'
        //                 ],
        //                 [
        //                     'title' => 'Wizard 4',
        //                     'page' => 'custom/pages/wizard/wizard-4'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Pricing Tables',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Pricing Tables 1',
        //                     'page' => 'custom/pages/pricing/pricing-1'
        //                 ],
        //                 [
        //                     'title' => 'Pricing Tables 2',
        //                     'page' => 'custom/pages/pricing/pricing-2'
        //                 ],
        //                 [
        //                     'title' => 'Pricing Tables 3',
        //                     'page' => 'custom/pages/pricing/pricing-3'
        //                 ],
        //                 [
        //                     'title' => 'Pricing Tables 4',
        //                     'page' => 'custom/pages/pricing/pricing-4'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Invoices',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Invoice 1',
        //                     'page' => 'custom/pages/invoices/invoice-1'
        //                 ],
        //                 [
        //                     'title' => 'Invoice 2',
        //                     'page' => 'custom/pages/invoices/invoice-2'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'User Pages',
        //             'bullet' => 'dot',
        //             'label' => [
        //                 'type' => 'label-rounded label-primary',
        //                 'value' => '2'
        //             ],
        //             'submenu' => [
        //                 [
        //                     'title' => 'Login 1',
        //                     'page' => 'custom/pages/users/login-1',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Login 2',
        //                     'page' => 'custom/pages/users/login-2',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Login 3',
        //                     'page' => 'custom/pages/users/login-3',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Login 4',
        //                     'page' => 'custom/pages/users/login-4',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Login 5',
        //                     'page' => 'custom/pages/users/login-5',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Login 6',
        //                     'page' => 'custom/pages/users/login-6',
        //                     'new-tab' => true
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Error Pages',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Error 1',
        //                     'page' => 'custom/pages/errors/error-1',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Error 2',
        //                     'page' => 'custom/pages/errors/error-2',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Error 3',
        //                     'page' => 'custom/pages/errors/error-3',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Error 4',
        //                     'page' => 'custom/pages/errors/error-4',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Error 5',
        //                     'page' => 'custom/pages/errors/error-5',
        //                     'new-tab' => true
        //                 ],
        //                 [
        //                     'title' => 'Error 6',
        //                     'page' => 'custom/pages/errors/error-6',
        //                     'new-tab' => true
        //                 ]
        //             ]
        //         ]
        //     ]
        // ],

        // // Layout
        // [
        //     'section' => 'Layout',
        // ],
        // [
        //     'title' => 'Themes',
        //     'desc' => '',
        //     'icon' => 'media/svg/icons/Design/Bucket.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Light Aside',
        //             'page' => 'layout/themes/aside-light'
        //         ],
        //         [
        //             'title' => 'Dark Header',
        //             'page' => 'layout/themes/header-dark'
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'Subheaders',
        //     'desc' => '',
        //     'icon' => 'media/svg/icons/Code/Compiling.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Toolbar Nav',
        //             'page' => 'layout/subheader/toolbar'
        //         ],
        //         [
        //             'title' => 'Actions Buttons',
        //             'page' => 'layout/subheader/actions'
        //         ],
        //         [
        //             'title' => 'Tabbed Nav',
        //             'page' => 'layout/subheader/tabbed'
        //         ],
        //         [
        //             'title' => 'Classic',
        //             'page' => 'layout/subheader/classic'
        //         ],
        //         [
        //             'title' => 'None',
        //             'page' => 'layout/subheader/none'
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'General',
        //     'icon' => 'media/svg/icons/General/Settings-1.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Fixed Content',
        //             'page' => 'layout/general/fixed-content'
        //         ],
        //         [
        //             'title' => 'Minimized Aside',
        //             'page' => 'layout/general/minimized-aside'
        //         ],
        //         [
        //             'title' => 'No Aside',
        //             'page' => 'layout/general/no-aside'
        //         ],
        //         [
        //             'title' => 'Empty Page',
        //             'page' => 'layout/general/empty-page'
        //         ],
        //         [
        //             'title' => 'Fixed Footer',
        //             'page' => 'layout/general/fixed-footer'
        //         ],
        //         [
        //             'title' => 'No Header Menu',
        //             'page' => 'layout/general/no-header-menu'
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'Builder',
        //     'root' => true,
        //     'icon' => 'media/svg/icons/Home/Library.svg',
        //     'page' => 'builder',
        //     'visible' => 'preview',
        // ],

        // // CRUD
        // [
        //     'section' => 'CRUD',
        // ],
        // [
        //     'title' => 'Forms',
        //     'icon' => 'media/svg/icons/Design/PenAndRuller.svg',
        //     'root' => true,
        //     'bullet' => 'dot',
        //     'submenu' => [
        //         [
        //             'title' => 'Form Controls',
        //             'desc' => '',
        //             'icon' => 'flaticon-interface-3',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Base Inputs',
        //                     'page' => 'crud/forms/controls/base'
        //                 ],
        //                 [
        //                     'title' => 'Input Groups',
        //                     'page' => 'crud/forms/controls/input-group'
        //                 ],
        //                 [
        //                     'title' => 'Checkbox',
        //                     'page' => 'crud/forms/controls/checkbox'
        //                 ],
        //                 [
        //                     'title' => 'Radio',
        //                     'page' => 'crud/forms/controls/radio'
        //                 ],
        //                 [
        //                     'title' => 'Switch',
        //                     'page' => 'crud/forms/controls/switch'
        //                 ],
        //                 [
        //                     'title' => 'Mega Options',
        //                     'page' => 'crud/forms/controls/option'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Form Widgets',
        //             'desc' => '',
        //             'icon' => 'flaticon-interface-1',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Datepicker',
        //                     'page' => 'crud/forms/widgets/bootstrap-datepicker'
        //                 ],
        //                 [
        //                     'title' => 'Datetimepicker',
        //                     'page' => 'crud/forms/widgets/bootstrap-datetimepicker'
        //                 ],
        //                 [
        //                     'title' => 'Timepicker',
        //                     'page' => 'crud/forms/widgets/bootstrap-timepicker'
        //                 ],
        //                 [
        //                     'title' => 'Daterangepicker',
        //                     'page' => 'crud/forms/widgets/bootstrap-daterangepicker'
        //                 ],
        //                 [
        //                     'title' => 'Tagify',
        //                     'page' => 'crud/forms/widgets/tagify'
        //                 ],
        //                 [
        //                     'title' => 'Touchspin',
        //                     'page' => 'crud/forms/widgets/bootstrap-touchspin'
        //                 ],
        //                 [
        //                     'title' => 'Maxlength',
        //                     'page' => 'crud/forms/widgets/bootstrap-maxlength'
        //                 ],
        //                 [
        //                     'title' => 'Switch',
        //                     'page' => 'crud/forms/widgets/bootstrap-switch'
        //                 ],
        //                 [
        //                     'title' => 'Multiple Select Splitter',
        //                     'page' => 'crud/forms/widgets/bootstrap-multipleselectsplitter'
        //                 ],
        //                 [
        //                     'title' => 'Bootstrap Select',
        //                     'page' => 'crud/forms/widgets/bootstrap-select'
        //                 ],
        //                 [
        //                     'title' => 'Select2',
        //                     'page' => 'crud/forms/widgets/select2'
        //                 ],
        //                 [
        //                     'title' => 'Typeahead',
        //                     'page' => 'crud/forms/widgets/typeahead'
        //                 ],
        //                 [
        //                     'title' => 'noUiSlider',
        //                     'page' => 'crud/forms/widgets/nouislider'
        //                 ],
        //                 [
        //                     'title' => 'Form Repeater',
        //                     'page' => 'crud/forms/widgets/form-repeater'
        //                 ],

        //                 [
        //                     'title' => 'Ion Range Slider',
        //                     'page' => 'crud/forms/widgets/ion-range-slider'
        //                 ],
        //                 [
        //                     'title' => 'Input Masks',
        //                     'page' => 'crud/forms/widgets/input-mask'
        //                 ],

        //                 [
        //                     'title' => 'Autosize',
        //                     'page' => 'crud/forms/widgets/autosize'
        //                 ],
        //                 [
        //                     'title' => 'Clipboard',
        //                     'page' => 'crud/forms/widgets/clipboard'
        //                 ],
        //                 [
        //                     'title' => 'Google reCaptcha',
        //                     'page' => 'crud/forms/widgets/recaptcha'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Form Text Editors',
        //             'desc' => '',
        //             'icon' => 'flaticon-interface-1',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'TinyMCE',
        //                     'page' => 'crud/forms/editors/tinymce'
        //                 ],
        //                 [
        //                     'title' => 'CKEditor',
        //                     'bullet' => 'line',
        //                     'submenu' => [
        //                         [
        //                             'title' => 'CKEditor Classic',
        //                             'page' => 'crud/forms/editors/ckeditor-classic'
        //                         ],
        //                         [
        //                             'title' => 'CKEditor Inline',
        //                             'page' => 'crud/forms/editors/ckeditor-inline'
        //                         ],
        //                         [
        //                             'title' => 'CKEditor Balloon',
        //                             'page' => 'crud/forms/editors/ckeditor-balloon'
        //                         ],
        //                         [
        //                             'title' => 'CKEditor Balloon Block',
        //                             'page' => 'crud/forms/editors/ckeditor-balloon-block'
        //                         ],
        //                         [
        //                             'title' => 'CKEditor Document',
        //                             'page' => 'crud/forms/editors/ckeditor-document'
        //                         ],
        //                     ]
        //                 ],
        //                 [
        //                     'title' => 'Quill Text Editor',
        //                     'page' => 'crud/forms/editors/quill'
        //                 ],
        //                 [
        //                     'title' => 'Summernote WYSIWYG',
        //                     'page' => 'crud/forms/editors/summernote'
        //                 ],
        //                 [
        //                     'title' => 'Markdown Editor',
        //                     'page' => 'crud/forms/editors/bootstrap-markdown'
        //                 ],
        //             ]
        //         ],
        //         [
        //             'title' => 'Form Layouts',
        //             'desc' => '',
        //             'icon' => 'flaticon-web',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Default Forms',
        //                     'page' => 'crud/forms/layouts/default-forms'
        //                 ],
        //                 [
        //                     'title' => 'Multi Column Forms',
        //                     'page' => 'crud/forms/layouts/multi-column-forms'
        //                 ],
        //                 [
        //                     'title' => 'Basic Action Bars',
        //                     'page' => 'crud/forms/layouts/action-bars'
        //                 ],
        //                 [
        //                     'title' => 'Sticky Action Bar',
        //                     'page' => 'crud/forms/layouts/sticky-action-bar'
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Form Validation',
        //             'desc' => '',
        //             'icon' => 'flaticon-calendar-2',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Validation States',
        //                     'page' => 'crud/forms/validation/states'
        //                 ],
        //                 [
        //                     'title' => 'Form Controls',
        //                     'page' => 'crud/forms/validation/form-controls'
        //                 ],
        //                 [
        //                     'title' => 'Form Widgets',
        //                     'page' => 'crud/forms/validation/form-widgets'
        //                 ]
        //             ]
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'KTDatatable',
        //     'icon' => 'media/svg/icons/Layout/Layout-left-panel-2.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Base',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Local Data',
        //                     'page' => 'crud/ktdatatable/base/data-local',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'JSON Data',
        //                     'page' => 'crud/ktdatatable/base/data-json',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Ajax Data',
        //                     'page' => 'crud/ktdatatable/base/data-ajax',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'HTML Table',
        //                     'page' => 'crud/ktdatatable/base/html-table',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Local Sort',
        //                     'page' => 'crud/ktdatatable/base/local-sort',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Translation',
        //                     'page' => 'crud/ktdatatable/base/translation',
        //                     'icon' => '',
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Advanced',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Record Selection',
        //                     'page' => 'crud/ktdatatable/advanced/record-selection',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Row Details',
        //                     'page' => 'crud/ktdatatable/advanced/row-details',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Modal Examples',
        //                     'page' => 'crud/ktdatatable/advanced/modal',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Column Rendering',
        //                     'page' => 'crud/ktdatatable/advanced/column-rendering',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Column Width',
        //                     'page' => 'crud/ktdatatable/advanced/column-width',
        //                     'icon' => '',
        //                 ],
        //                 [
        //                     'title' => 'Vertical Scrolling',
        //                     'page' => 'crud/ktdatatable/advanced/vertical',
        //                     'icon' => ''
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Child Datatables',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Local Data',
        //                     'page' => 'crud/ktdatatable/child/data-local',
        //                     'icon' => ''
        //                 ],
        //                 [
        //                     'title' => 'Remote Data',
        //                     'page' => 'crud/ktdatatable/child/data-ajax',
        //                     'icon' => ''
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'API',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'API Methods',
        //                     'page' => 'crud/ktdatatable/api/methods',
        //                     'icon' => ''
        //                 ],
        //                 [
        //                     'title' => 'Events',
        //                     'page' => 'crud/ktdatatable/api/events',
        //                     'icon' => ''
        //                 ]
        //             ]
        //         ]
        //     ]
        // ],
        // [
        //     'title' => 'Datatables.net',
        //     'icon' => 'media/svg/icons/Layout/Layout-horizontal.svg',
        //     'bullet' => 'dot',
        //     'root' => true,
        //     'submenu' => [
        //         [
        //             'title' => 'Basic',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Basic Tables',
        //                     'page' => 'crud/datatables/basic/basic',
        //                 ],
        //                 [
        //                     'title' => 'Scrollable Tables',
        //                     'page' => 'crud/datatables/basic/scrollable',
        //                 ],
        //                 [
        //                     'title' => 'Complex Headers',
        //                     'page' => 'crud/datatables/basic/headers',
        //                 ],
        //                 [
        //                     'title' => 'Pagination Options',
        //                     'page' => 'crud/datatables/basic/paginations',
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Advanced',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Column Rendering',
        //                     'page' => 'crud/datatables/advanced/column-rendering',
        //                 ],
        //                 [
        //                     'title' => 'Multiple Controls',
        //                     'page' => 'crud/datatables/advanced/multiple-controls',
        //                 ],
        //                 [
        //                     'title' => 'Column Visibility',
        //                     'page' => 'crud/datatables/advanced/column-visibility',
        //                 ],
        //                 [
        //                     'title' => 'Row Callback',
        //                     'page' => 'crud/datatables/advanced/row-callback',
        //                 ],
        //                 [
        //                     'title' => 'Row Grouping',
        //                     'page' => 'crud/datatables/advanced/row-grouping',
        //                 ],
        //                 [
        //                     'title' => 'Footer Callback',
        //                     'page' => 'crud/datatables/advanced/footer-callback',
        //                 ],
        //             ]
        //         ],
        //         [
        //             'title' => 'Data sources',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'HTML',
        //                     'page' => 'crud/datatables/data-sources/html',
        //                 ],
        //                 [
        //                     'title' => 'Javascript',
        //                     'page' => 'crud/datatables/data-sources/javascript',
        //                 ],
        //                 [
        //                     'title' => 'Ajax Client-side',
        //                     'page' => 'crud/datatables/data-sources/ajax-client-side',
        //                 ],
        //                 [
        //                     'title' => 'Ajax Server-side',
        //                     'page' => 'crud/datatables/data-sources/ajax-server-side',
        //                 ]
        //             ]
        //         ],
        //         [
        //             'title' => 'Search Options',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Column Search',
        //                     'page' => 'crud/datatables/search-options/column-search',
        //                 ],
        //                 [
        //                     'title' => 'Advanced Search',
        //                     'page' => 'crud/datatables/search-options/advanced-search',
        //                 ],
        //             ]
        //         ],
        //         [
        //             'title' => 'Extensions',
        //             'desc' => '',
        //             'bullet' => 'dot',
        //             'submenu' => [
        //                 [
        //                     'title' => 'Buttons',
        //                     'page' => 'crud/datatables/extensions/buttons',
        //                 ],
        //                 [
        //                     'title' => 'ColReorder',
        //                     'page' => 'crud/datatables/extensions/colreorder',
        //                 ],
        //                 /*[
        //                     'title' => 'FixedColumns',
        //                     'page' => 'crud/datatables/extensions/fixedcolumns',
        //                 ],
        //                 [
        //                     'title' => 'FixedHeader',
        //                     'page' => 'crud/datatables/extensions/fixedheader',
        //                 ],*/
        //                 [
        //                     'title' => 'KeyTable',
        //                     'page' => 'crud/datatables/extensions/keytable',
        //                 ],
        //                 [
        //                     'title' => 'Responsive',
        //                     'page' => 'crud/datatables/extensions/responsive',
        //                 ],
        //                 [
        //                     'title' => 'RowGroup',
        //                     'page' => 'crud/datatables/extensions/rowgroup',
        //                 ],
        //                 [
        //                     'title' => 'RowReorder',
        //                     'page' => 'crud/datatables/extensions/rowreorder',
        //                 ],
        //                 [
        //                     'title' => 'Scroller',
        //                     'page' => 'crud/datatables/extensions/scroller',
        //                 ],
        //                 [
        //                     'title' => 'Select',
        //                     'page' => 'crud/datatables/extensions/select'
        //                 ]
        //             ]
        //         ],
        //     ]
        // ],
        // [
        //     'title' => 'File Upload',
        //     'desc' => '',
        //     'icon' => 'media/svg/icons/Files/Upload.svg',
        //     'bullet' => 'dot',
        //     'submenu' => [
        //         [
        //             'title' => 'Image Input',
        //             'page' => 'crud/file-upload/image-input',
        //         ],
        //         [
        //             'title' => 'DropzoneJS',
        //             'page' => 'crud/file-upload/dropzonejs',
        //             'label' => [
        //                 'type' => 'label-danger label-inline',
        //                 'value' => 'new'
        //             ]
        //         ],
        //         [
        //             'title' => 'Uppy',
        //             'page' => 'crud/file-upload/uppy',
        //         ]
        //     ]
        // ],
    ]

];
