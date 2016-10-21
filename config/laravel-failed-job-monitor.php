<?php

return [

    /*
     * The notification that will be sent when a job fails.
     */
    'notification' => \Spatie\FailedJobMonitor\Notification::class,

    /*
     * The notifiable to which the notification will be sent. The default
     * notifiable will use the mail and slack configuration specified
     * in this config file.
     */
    'notifiable' => \Spatie\FailedJobMonitor\Notifiable::class,

    /*
     * The channels to which the notification will be sent.
     */
    'channels' => ['mail'],

    'mail' => [
        'to' => 'robinsonlegaspi@astigp.com',
    ]
];
