<?php

namespace App\Services\System;

/*
 * Telegram Service
 *
 * */

use GuzzleHttp\Client;

class TelegramService
{
    const _API_URL = 'https://api.telegram.org/bot';
    protected $chatId;
    protected $token;
    protected $params = [];

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
    }

    /*
     * Get Data
     * */
    protected function getData()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $query = @$data['callback_query'];
        if (@$query):
            $this->chatId = $query['from']['id'];
        else:
            $this->chatId = $data['message']['chat']['id'];
        endif;
        return $data;
    }

    /*
     * Set Webhook
     * */
    public function setWebhook($url)
    {
        return $this->request('setWebhook', [
            'url' => $url
        ]);
    }

    /*
     * Request
     * */
    protected function request($method, $post = [])
    {
        $url = self::_API_URL . $this->token . '/' . $method;
        $request = new Client();
        $request = $request->post($url, [
            'form_params' => $post
        ]);
        return $request->getBody();
    }

    /*
     * Token
     * */
    public function token($token = null)
    {
        $this->token = $token;
        return $this;
    }

    /*
     * Chat Id
     * */
    public function chatId($chatId)
    {
        $this->params = array_merge($this->params, ['chat_id' => $chatId]);
        return $this;
    }

    /*
     * Content
     * */
    public function content($text)
    {
        $this->params = array_merge($this->params, ['text' => str_limit($text, 4000)]);
        return $this;
    }

    /*
     * Parse Mode
     * */
    public function parseMode($mode)
    {
        $this->params = array_merge($this->params, ['parse_mode' => $mode]);
        return $this;
    }

    /*
     * Inline Buttons
     * */
    public function inlineButtons($buttons)
    {
        $buttonArr = [[$buttons]];
        if (@is_array($buttons[0])):
            $buttonArr = [$buttons];
        endif;
        $this->replyMarkup([
            'inline_keyboard' => $buttonArr
        ]);
        return $this;
    }

    /*
     * Photo
     * */
    public function photo($url)
    {
        $this->params = array_merge($this->params, ['photo' => $url]);
        return $this;
    }

    /*
     * Caption
     * */
    public function caption($text)
    {
        $this->params = array_merge($this->params, ['caption' => str_limit($text, 1000)]);
        return $this;
    }

    /*
     * Document
     * */
    public function document($url)
    {
        $this->params = array_merge($this->params, ['document' => $url]);
        return $this;
    }

    /*
     * Thumbnail
     * */
    public function thumbnail($url)
    {
        $this->params = array_merge($this->params, ['thumb' => $url]);
        return $this;
    }

    /*
     * Video
     * */
    public function video($url)
    {
        $this->params = array_merge($this->params, ['video' => $url]);
        return $this;
    }

    /*
     * Duration
     * */
    public function duration($duration)
    {
        $this->params = array_merge($this->params, ['duration' => $duration]);
        return $this;
    }

    /*
     * Width
     * */
    public function width($width)
    {
        $this->params = array_merge($this->params, ['width' => $width]);
        return $this;
    }

    /*
     * Height
     * */
    public function height($height)
    {
        $this->params = array_merge($this->params, ['height' => $height]);
        return $this;
    }

    /*
     * Page Preview
     * */
    public function pagePreview($val)
    {
        $this->params = array_merge($this->params, ['disable_web_page_preview' => $val]);
        return $this;
    }

    /*
     * Reply Markup
     * */
    public function replyMarkup($markup)
    {
        $this->params = array_merge($this->params, ['reply_markup' => json_encode($markup)]);
        return $this;
    }

    /*
     * Send Message
     * */
    public function sendMessage()
    {
        return $this->request('sendMessage', $this->params);
    }

    /*
     * Send Photo
     * */
    public function sendPhoto()
    {
        return $this->request('sendPhoto', $this->params);
    }

    /*
     * Send Document
     * */
    public function sendDocument()
    {
        return $this->request('sendDocument', $this->params);
    }

    /*
     * Send Video
     * */
    public function sendVideo()
    {
        return $this->request('sendVideo', $this->params);
    }

}
