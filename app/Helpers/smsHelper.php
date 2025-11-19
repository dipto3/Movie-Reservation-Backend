<?php

use Illuminate\Support\Facades\Http;

function sendSMS($contact, $msg, $status = null)
{
   $content = nl2br($msg);
   $remove = array("\n", "\r\n", "\r", "<p>", "</p>", "<h1>", "</h1>", "<br>", "<br />", "<br/>");
   $content = str_replace($remove, " ", $content);
   $credentials = config('sms.sms');
   return Http::post(config('sms.url'), [
      ...$credentials,
      'mobileNumbers' => ltrim($contact, "+"),
      'message' => $content,
      'is_Unicode' => isUnicode($msg),
   ]);
}
function isUnicode($massage)
{
   if (preg_match('/[^\x20-\x7E]/u', $massage)) {
      return true;
   }
   return false;
}
