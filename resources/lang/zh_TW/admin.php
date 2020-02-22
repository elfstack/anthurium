<?php

return [
    'admin-management' => '管理員',
    'configuration' => '系統設定',
    'admin-user' => [
        'title' => '用戶',

        'actions' => [
            'index' => '用戶列表',
            'create' => '新增用戶',
            'edit' => '編輯 :name',
            'edit_profile' => '更改資料',
            'edit_password' => '修改密碼',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => '名',
            'last_name' => '姓',
            'email' => 'Email',
            'password' => '密碼',
            'password_repeat' => '確認密碼',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'user' => [
        'title' => '義工',

        'actions' => [
            'index' => '義工列表',
            'create' => '新增義工',
            'edit' => '編輯 :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'email_verified_at' => 'Email verified at',
            'password' => 'Password',
            
        ],
    ],

    'volunteer-info' => [
        'title' => '義工信息',

        'actions' => [
            'index' => 'Volunteer Info',
            'create' => 'New Volunteer Info',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'activity' => [
        'title' => '活動',

        'actions' => [
            'index' => 'Activities',
            'create' => 'New Activity',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'starts_at' => 'Starts at',
            'ends_at' => 'Ends at',
            'content' => 'Content',
            'quota' => 'Quota',
            
        ],
    ],

    'volunteer-info' => [
        'title' => 'Volunteer Info',

        'actions' => [
            'index' => 'Volunteer Info',
            'create' => 'New Volunteer Info',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'user_id' => 'User',
            'id_number' => 'Id number',
            'alias' => 'Alias',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'education' => 'Education',
            'organisation' => 'Organisation',
            'mobile_number' => 'Mobile number',
            'address' => 'Address',
            'interests' => 'Interests',
            'emergency_contact' => 'Emergency contact',
            'volunteer_experences' => 'Volunteer experences',
            'references' => 'References',
            
        ],
    ],

    'attendance' => [
        'title' => '出席',

        'actions' => [
            'index' => 'Attendance',
            'create' => 'New Attendance',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'arrived_at' => 'Arrived at',
            'left_at' => 'Left at',
            'activity_id' => 'Activity',
            'user_id' => 'User',
            
        ],
    ],

    'participant' => [
        'title' => '報名',

        'actions' => [
            'index' => 'Participants',
            'create' => 'New Participant',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'enrolled_at' => 'Enrolled at',
            'activity' => 'Activity',
            'user' => 'User',
            'attendance' => 'Attendance',
            
        ],
    ],

    'sidebar' => [
        'volunteer' => '義工管理',
        'manage' => '系統管理'
    ],

    // Do not delete me :) I'm used for auto-generation
];
