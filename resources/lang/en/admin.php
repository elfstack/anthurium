<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
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
        'title' => 'Volunteer Info',

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
        'title' => 'Activities',

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
        'title' => 'Attendance',

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
        'title' => 'Participants',

        'actions' => [
            'index' => 'Participants',
            'create' => 'New Participant',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'enrolled_at' => 'Enrolled at',
            'activities_id' => 'Activities',
            'user_id' => 'User',
            'attendance_id' => 'Attendance',
            
        ],
    ],

    'participant' => [
        'title' => 'Participants',

        'actions' => [
            'index' => 'Participants',
            'create' => 'New Participant',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'enrolled_at' => 'Enrolled at',
            'activity_id' => 'Activity',
            'user_id' => 'User',
            'attendance_id' => 'Attendance',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];