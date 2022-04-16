<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Supports;

interface PaymentMethodInterface
{
    public function isRedirect(): bool;
    
    public function redirectUrl(): string;
    
    public function purchase(array $data): PaymentMethodInterface;
    
    public function getMessage(): string;
}
