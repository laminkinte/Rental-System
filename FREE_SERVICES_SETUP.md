# Free Services Setup for JubbaStay

This guide helps you set up FREE services for Email, SMS, and Notifications for development and testing.

---

## 📧 EMAIL SETUP (Testing)

### Option 1: Laravel Log Driver (BEST FOR TESTING)
Perfect for local development - emails are logged to a file instead of being sent.

**Update `.env`:**
```env
MAIL_DRIVER=log
MAIL_LOG_CHANNEL=single
```

**How it works:**
- Check emails in: `storage/logs/laravel.log`
- All emails are automatically logged
- **Free, no setup needed, instant testing**

### Option 2: Mailtrap (Sandbox Testing)
Free tier includes 100 emails/month, great for early testing.

1. Sign up at https://mailtrap.io (free account)
2. Create a testing inbox
3. Get your credentials (SMTP user/password)
4. Update `.env`:
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

### Option 3: Mailgun Sandbox (Absolutely FREE)
- 100% free for testing (no credit card needed after signup)
- 5,000 emails/month free
- API key for testing

1. Sign up at https://www.mailgun.com
2. Get sandbox domain and API key
3. Update `.env`:
```env
MAIL_DRIVER=mailgun
MAILGUN_DOMAIN=sandboxxxx.mailgun.org
MAILGUN_SECRET=key-xxxx
```

---

## 📱 SMS SETUP (Testing)

### Option 1: Twilio Free Tier (RECOMMENDED)
- $15 free trial credit (enough for hundreds of tests)
- Works immediately after signup
- Use free test phone number

**Setup:**
1. Sign up at https://www.twilio.com/try-twilio
2. Verify your email (free account)
3. Get Account SID and Auth Token from Dashboard
4. Get your trial number

**Update `.env`:**
```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_FROM_NUMBER=+1234567890
TWILIO_WHATSAPP_FROM=+14155552671
SMS_PROVIDER=twilio
```

**Test it:**
```php
// Send test SMS
\App\Services\NotificationService::notify(
    userId: 1,
    type: 'test',
    title: 'Test SMS',
    message: 'Your test message',
    channel: 'sms'
);
```

### Option 2: Vonage (formerly Nexmo) Free Tier
- 10 free credits (not auto-replenished)
- Good for limited testing

1. Sign up at https://www.vonage.com
2. Get API Key and API Secret
3. Update `.env`:
```env
VONAGE_API_KEY=xxxx
VONAGE_API_SECRET=xxxx
VONAGE_FROM_NUMBER=14155552671
SMS_PROVIDER=vonage
```

### Option 3: African Mobile Providers (Dev Mode)
For testing with local providers, use test credentials:

```env
# M-Pesa (Kenya)
MPESA_CONSUMER_KEY=test_key
MPESA_CONSUMER_SECRET=test_secret
MPESA_TEST_MODE=true

# Wave (Senegal)
WAVE_API_KEY=test_key
WAVE_TEST_MODE=true

# MTN (Multiple countries)
MTN_SUBSCRIPTION_KEY=test_key
MTN_TEST_MODE=true
```

---

## 🔔 NOTIFICATION SERVICE SETUP

### Updated NotificationService.php Configuration

The updated `NotificationService.php` now supports:

1. **In-App Notifications** (Database)
   - No external service needed
   - Stored in notifications table
   - Viewed in notification center

2. **Email Notifications**
   - Uses configured mail driver (log/mailtrap/mailgun)
   - Queued for reliable delivery
   - Automatically sent

3. **SMS Notifications**
   - Uses Twilio (easiest setup)
   - Falls back gracefully if provider unavailable
   - Test mode doesn't send real SMS

4. **WhatsApp Notifications**
   - Uses Twilio WhatsApp API
   - Requires business account (skip for now)
   - Framework ready when you upgrade

---

## 🚀 QUICK START (5 Minutes)

### Step 1: Use Log Driver for Emails
```env
# .env
MAIL_DRIVER=log
```

### Step 2: Setup Free Twilio SMS
1. Go to https://www.twilio.com/try-twilio
2. Sign up (takes 2 minutes)
3. Copy Account SID and Auth Token
4. Add to `.env`:
```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_FROM_NUMBER=+1234567890
SMS_PROVIDER=twilio
```

### Step 3: Test
```bash

# Run artisan tinker
php artisan tinker

# Test email (check storage/logs/laravel.log)
>>> Mail::to('test@example.com')->send(new App\Mail\NotificationMail(['title' => 'Test', 'message' => 'Hello']))

# Test SMS (requires Twilio setup)
>>> \App\Services\NotificationService::notify(1, 'test', 'Test', 'Hello', channel: 'sms')

# Test in-app notification
>>> \App\Services\NotificationService::notify(1, 'test', 'Test', 'Hello', channel: 'in_app')
```

Done! ✅

---

## 📊 Free Services Limits

| Service | Email Limit | SMS Limit | Cost |
|---------|----------|----------|------|
| Log Driver | Unlimited | N/A | FREE ✅ |
| Mailtrap | 100/month | N/A | FREE ✅ |
| Mailgun Sandbox | 5,000/month | N/A | FREE ✅ |
| Twilio Trial | Via logging | 100s of texts | $15 credit ✅ |
| Vonage | Via logging | 10 messages | FREE ✅ |

**Recommendation:** Use Log Driver + Twilio Trial for complete free testing.

---

## 🔧 Environment Variables Template

```env
# === MAIL (LOG DRIVER FOR TESTING) ===
MAIL_DRIVER=log
MAIL_FROM_ADDRESS=noreply@jubbastay.com
MAIL_FROM_NAME="JubbaStay"

# === NOTIFICATIONS (IN-APP) ===
# No setup needed - stored in database automatically

# === SMS (TWILIO - FREE TIER) ===
SMS_PROVIDER=twilio
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_FROM_NUMBER=+1234567890

# === WHATSAPP (TWILIO - OPTIONAL) ===
TWILIO_WHATSAPP_FROM=+14155552671

# === QUEUE (FOR ASYNC NOTIFICATIONS) ===
QUEUE_CONNECTION=database
# Alternative: sync (immediate, no queue)
```

---

## 🧪 Testing Notifications

### 1. Test In-App Notification
```bash
php artisan tinker
>>> \App\Services\NotificationService::notify(
    userId: 1,
    type: 'booking',
    title: 'Booking Confirmed',
    message: 'Your booking is confirmed',
    channel: 'in_app'
);
# Check: http://localhost:8000/notifications
```

### 2. Test Email Notification
```bash
php artisan tinker
>>> \App\Services\NotificationService::notify(
    userId: 1,
    type: 'booking',
    title: 'Booking Confirmed',
    message: 'Your booking is confirmed',
    channel: 'email'
);
# Check: tail -f storage/logs/laravel.log
```

### 3. Test SMS (Requires Twilio)
```bash
php artisan tinker
>>> \App\Services\NotificationService::notify(
    userId: 1,
    type: 'booking',
    title: 'Booking Confirmed',
    message: 'Your booking is confirmed',
    phone: '+220xxxxxxxx7',
    channel: 'sms'
);
# Check: Your Twilio console at https://www.twilio.com/console/message-logs
```

---

## 📧 Email Testing Tips

### View Log-Based Emails
```bash
# Real-time log viewer
tail -f storage/logs/laravel.log | grep -i "from:"

# Or check the file directly
cat storage/logs/laravel.log | grep -i "message"
```

### Parse Email from Logs
Emails in log driver show full content including:
- To, From, Subject
- HTML/Plain text body
- Attachments info

---

## 🆘 Troubleshooting

### "SMTP connection refused"
**Fix:** Make sure you're using log driver in `.env`
```env
MAIL_DRIVER=log  # Not 'smtp'
```

### "Twilio API error"
**Fix:** Verify your credentials
```bash
php artisan tinker
>>> env('TWILIO_ACCOUNT_SID')
>>> env('TWILIO_AUTH_TOKEN')
```

### "SMS not sending"
**Fix:** Check in Twilio Dashboard
1. Verify Account SID matches
2. Check trial phone number +1 234567890 is registered
3. Only send to verified numbers in trial mode

### "Notifications not appearing"
**Fix:** Check queue settings
```env
# Use sync for immediate delivery while testing
QUEUE_CONNECTION=sync
```

---

## ✅ Deployment Checklist

Before going to production:

- [ ] Switched from log driver to real email service (Mailgun/SendGrid)
- [ ] Added Twilio production credentials
- [ ] Verified SMS delivery works
- [ ] Tested all notification channels
- [ ] Set QUEUE_CONNECTION to redis/database (not sync)
- [ ] Configured mail encryption (TLS/SSL)
- [ ] Updated MAIL_FROM_ADDRESS
- [ ] Allowed production phone numbers in Twilio

---

**Documentation Version:** 1.0
**Last Updated:** March 18, 2026
**Status:** ✅ Ready for Testing

