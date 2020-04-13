<?php

namespace app\components\validators;

use yii\validators\EmailValidator;

class CustomEmailValidator extends EmailValidator
{
    public $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[А-Яа-яa-zA-Z0-9](?:[А-Яа-яa-zA-Z0-9-]*[А-Яа-яa-zA-Z0-9])?\.)+[А-Яа-яa-zA-Z0-9](?:[А-Яа-яa-zA-Z0-9-]*[А-Яа-яa-zA-Z0-9])?$/';

    protected function validateValue($value)
    {
        if (!is_string($value)) {
            $valid = false;
        } elseif (!preg_match('/^(?P<name>(?:"?([^"]*)"?\s)?)(?:\s+)?(?:(?P<open><?)((?P<local>.+)@(?P<domain>[^>]+))(?P<close>>?))$/i', $value, $matches)) {
            $valid = false;
        } else {
            if ($this->enableIDN) {
                $matches['local'] = idn_to_ascii($matches['local'], IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                $matches['domain'] = idn_to_ascii($matches['domain'],  IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
                $value = $matches['name'] . $matches['open'] . $matches['local'] . '@' . $matches['domain'] . $matches['close'];
            }
            if (strlen($matches['local']) > 64) {
                $valid = false;
            }elseif(strlen($matches['domain']) > 64){
                $valid = false;
            } elseif (strlen($matches['local'] . '@' . $matches['domain']) > 254) {
                $valid = false;
            } else {
                $valid = preg_match($this->pattern .'u', $value) || $this->allowName && preg_match($this->fullPattern . 'u', $value);
                if ($valid && $this->checkDNS) {
                    $valid = checkdnsrr($matches['domain'], 'MX') || checkdnsrr($matches['domain'], 'A');
                }
            }
        }
        return $valid ? null : [$this->message, []];
    }
}