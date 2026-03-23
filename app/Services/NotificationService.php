<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Create and dispatch a notification to a user
     */
    public static function notify($userId, $type, $title, $message, $data = [], $channel = 'in_app')
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'channel' => $channel,
            'is_read' => false,
        ]);

        // Dispatch to different channels
        if (in_array($channel, ['email', 'all'])) {
            self::sendEmail($userId, $notification);
        }

        if (in_array($channel, ['sms', 'all'])) {
            self::sendSms($userId, $notification);
        }

        if (in_array($channel, ['whatsapp', 'all'])) {
            self::sendWhatsApp($userId, $notification);
        }

        return $notification;
    }

    /**
     * Send email notification (compatible with all drivers: log, mailtrap, mailgun)
     */
    public static function sendEmail($userId, $notification)
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->email) return;

        try {
            // Use dispatch async if queue is configured, otherwise send immediately
            $mailDriver = config('mail.mailer', 'log');
            
            if ($mailDriver === 'log' || config('queue.default') === 'sync') {
                // Send immediately for log/sync drivers (good for testing)
                \Illuminate\Support\Facades\Mail::send(new \App\Mail\NotificationMail($notification));
            } else {
                // Queue for other drivers
                \Illuminate\Support\Facades\Mail::queue(new \App\Mail\NotificationMail($notification));
            }
            
            \Log::info("Email notification sent to {$user->email}", [
                'notification_id' => $notification->id,
                'type' => $notification->type,
                'driver' => $mailDriver
            ]);
        } catch (\Exception $e) {
            \Log::error('Email notification failed: ' . $e->getMessage(), [
                'user_id' => $userId,
                'notification_id' => $notification->id,
                'exception' => (string) $e
            ]);
        }
    }

    /**
     * Send SMS notification via Twilio (or log if not configured for testing)
     */
    public static function sendSms($userId, $notification)
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->phone) {
            \Log::warning('SMS notification skipped: User missing phone', ['user_id' => $userId]);
            return;
        }

        // Check if Twilio is configured
        $sid = config('services.twilio.account_sid');
        $token = config('services.twilio.auth_token');
        $from = config('services.twilio.from_number');

        if (!$sid || !$token || !$from) {
            // Log for testing if Twilio not configured
            \Log::info('SMS notification (not sent - Twilio not configured for testing)', [
                'user_id' => $userId,
                'phone' => $user->phone,
                'notification_id' => $notification->id,
                'title' => $notification->title,
                'message' => substr($notification->message, 0, 100),
                'tip' => 'To enable SMS: Sign up at https://www.twilio.com/try-twilio and configure TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN in .env'
            ]);
            return;
        }

        try {
            $twilio = new \Twilio\Rest\Client($sid, $token);

            $smsBody = "{$notification->title}: " . substr($notification->message, 0, 100);
            
            $twilio->messages->create(
                $user->phone,
                [
                    'from' => $from,
                    'body' => $smsBody
                ]
            );

            \Log::info("SMS notification sent to {$user->phone}", [
                'user_id' => $userId,
                'notification_id' => $notification->id
            ]);
        } catch (\Exception $e) {
            \Log::error('SMS notification failed: ' . $e->getMessage(), [
                'user_id' => $userId,
                'phone' => $user->phone,
                'exception' => (string) $e
            ]);
        }
    }

    /**
     * Send WhatsApp notification via Twilio (or log if not configured for testing)
     */
    public static function sendWhatsApp($userId, $notification)
    {
        $user = \App\Models\User::find($userId);
        if (!$user || !$user->phone) {
            \Log::warning('WhatsApp notification skipped: User missing phone', ['user_id' => $userId]);
            return;
        }

        // Check if Twilio WhatsApp is configured
        $sid = config('services.twilio.account_sid');
        $token = config('services.twilio.auth_token');
        $whatsappFrom = config('services.twilio.whatsapp_from');

        if (!$sid || !$token || !$whatsappFrom) {
            // Log for testing if Twilio WhatsApp not configured
            \Log::info('WhatsApp notification (not sent - Twilio WhatsApp not configured for testing)', [
                'user_id' => $userId,
                'phone' => $user->phone,
                'notification_id' => $notification->id,
                'title' => $notification->title,
                'message' => substr($notification->message, 0, 100),
                'tip' => 'WhatsApp requires business account. Use SMS instead.'
            ]);
            return;
        }

        try {
            $twilio = new \Twilio\Rest\Client($sid, $token);

            $whatsappBody = "{$notification->title}: " . substr($notification->message, 0, 100);
            
            $twilio->messages->create(
                'whatsapp:' . $user->phone,
                [
                    'from' => 'whatsapp:' . $whatsappFrom,
                    'body' => $whatsappBody
                ]
            );

            \Log::info("WhatsApp notification sent to {$user->phone}", [
                'user_id' => $userId,
                'notification_id' => $notification->id
            ]);
        } catch (\Exception $e) {
            \Log::error('WhatsApp notification failed: ' . $e->getMessage(), [
                'user_id' => $userId,
                'phone' => $user->phone,
                'exception' => (string) $e
            ]);
        }
    }

    /**
     * Send bulk notification to multiple users
     */
    public static function notifyMultiple($userIds, $type, $title, $message, $data = [], $channel = 'in_app')
    {
        $notifications = [];

        foreach ($userIds as $userId) {
            $notifications[] = self::notify($userId, $type, $title, $message, $data, $channel);
        }

        return $notifications;
    }

    /**
     * Send booking notification
     */
    public static function notifyBooking($booking, $type, $userType = 'guest')
    {
        $userId = $userType === 'host' ? $booking->property->host_id : $booking->user_id;

        $messageMap = [
            'confirmed' => [
                'title' => 'Booking Confirmed!',
                'message' => $userType === 'host' 
                    ? "New booking from {$booking->user->name} for {$booking->property->title}"
                    : "Your booking at {$booking->property->title} is confirmed for {$booking->check_in}"
            ],
            'cancelled' => [
                'title' => 'Booking Cancelled',
                'message' => $userType === 'host'
                    ? "Booking from {$booking->user->name} has been cancelled"
                    : "Your booking at {$booking->property->title} has been cancelled"
            ],
            'check_in_reminder' => [
                'title' => 'Check-in Tomorrow!',
                'message' => "Don't forget to check in tomorrow at {$booking->check_in}"
            ],
            'check_out_reminder' => [
                'title' => 'Check-out Today',
                'message' => "Please check out by {$booking->check_out}'s time"
            ],
        ];

        $message = $messageMap[$type] ?? ['title' => 'Booking Update', 'message' => ''];

        return self::notify($userId, 'booking', $message['title'], $message['message'], [
            'booking_id' => $booking->id,
            'property_id' => $booking->property_id,
        ]);
    }

    /**
     * Send payment notification
     */
    public static function notifyPayment($payment, $type, $user)
    {
        $messageMap = [
            'pending' => ['title' => 'Payment Processing', 'message' => "Your payment of {$payment->amount} is being processed"],
            'completed' => ['title' => 'Payment Received', 'message' => "Payment of {$payment->amount} has been successfully received"],
            'failed' => ['title' => 'Payment Failed', 'message' => "Your payment of {$payment->amount} failed. Please try again"],
            'refunded' => ['title' => 'Refund Processed', 'message' => "A refund of {$payment->amount} has been issued to your account"],
        ];

        $message = $messageMap[$type] ?? ['title' => 'Payment Update', 'message' => ''];

        return self::notify($user->id, 'payment', $message['title'], $message['message'], [
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
        ]);
    }

    /**
     * Send review notification
     */
    public static function notifyReview($review)
    {
        return self::notify($review->reviewee_id, 'review', 'New Review Received', 
            "{$review->reviewer->name} left a {$review->rating}-star review", [
                'review_id' => $review->id,
                'rating' => $review->rating,
            ]);
    }
}
