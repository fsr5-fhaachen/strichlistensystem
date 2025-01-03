<?php

namespace App\Utils;

use App\Models\Person;
use Illuminate\Http\Request;

class Telegram
{
    /**
     * send message to info telegram channel
     *
     *
     * @return string|false
     */
    public static function info(string $message, ?Request $request = null, ?Person $person = null)
    {
        if (! env('TELEGRAM_BOT_INFO_CHANNEL_ID')) {
            return;
        }

        return self::sendMessage(env('TELEGRAM_BOT_INFO_CHANNEL_ID'), $message, $request, $person);
    }

    /**
     * send message to warning telegram channel
     *
     *
     * @return string|false
     */
    public static function warning(string $message, ?Request $request = null, ?Person $person = null)
    {
        if (! env('TELEGRAM_BOT_WARNING_CHANNEL_ID')) {
            return;
        }

        return self::sendMessage(env('TELEGRAM_BOT_WARNING_CHANNEL_ID'), $message, $request, $person);
    }

    /**
     * send message to telegram channel
     *
     *
     * @return string|false
     */
    public static function sendMessage(string $channelID, ?string $message = null, ?Request $request = null, ?Person $person = null)
    {
        if (! env('TELEGRAM_BOT_TOKEN')) {
            return;
        }

        // parse output
        $output = '';
        if ($request->ip()) {
            $output .= '*IP:* `'.(env('APP_IS_VPN') ? 'VPN' : $request->ip()).'`'.PHP_EOL;
        }
        if ($person) {
            $output .= '*Person:* '.$person->fullname.' (ID: `'.$person->id.'`)'.PHP_EOL;
        }
        if ($request->session()->has('authToken')) {
            $output .= '*AuthToken:* `'.$request->session()->get('authToken').'`'.PHP_EOL;
        }
        if ($message) {
            $output .= '*Message:* '.$message.PHP_EOL;
        }

        //TODO: make this async
        // send message
        // try {
        //     $url = 'https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage';
        //     $data = array('chat_id' => $channelID, 'text' => $output, 'parse_mode' => 'markdown');
        //     $options = array('http' => array('method' => 'POST', 'header' => "Content-Type:application/x-www-form-urlencoded\r\n", 'content' => http_build_query($data)));
        //     $context = stream_context_create($options);
        //     return file_get_contents($url, false, $context);
        // } catch (\Exception) {
        //     return;
        // }
    }
}
