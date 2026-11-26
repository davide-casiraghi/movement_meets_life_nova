<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

/**
 * "Write me on WhatsApp" button in the footer.
 *
 * The number comes from WHATSAPP_NUMBER in the .env file (see config/services.php).
 * Until it is set, the button shows a "service temporarily unavailable" page.
 */
class WhatsAppController extends Controller
{
    /**
     * Open the WhatsApp chat with the prefilled message in the current language.
     *
     * @return RedirectResponse|Response
     */
    public function redirect(): RedirectResponse|Response
    {
        $number = self::normalizeNumber((string) config('services.whatsapp.number'));

        if ($number === '') {
            return response()->view('whatsapp.unavailable', [], 503);
        }

        $message = rawurlencode(__('static_pages.footer.whatsapp_message'));

        return redirect()->away("https://wa.me/{$number}?text={$message}");
    }

    /**
     * wa.me wants the international number with digits only: "+39 333 123 4567" or "0039..." becomes "393331234567".
     *
     * @param string $number
     *
     * @return string
     */
    private static function normalizeNumber(string $number): string
    {
        $digits = preg_replace('/\D/', '', $number);

        return str_starts_with($digits, '00') ? substr($digits, 2) : $digits;
    }
}
