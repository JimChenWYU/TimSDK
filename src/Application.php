<?php

namespace TimSDK;

use Closure;
use TimSDK\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \TimSDK\Account\Client $account
 * @property \TimSDK\Openim\Client  $openim
 * @property \TimSDK\MemberPush\Client $member_push
 * @property \TimSDK\Profile\Client $profile
 * @property \TimSDK\Sns\Client     $sns
 * @property \TimSDK\Group\Client   $group
 * @property \TimSDK\Overall\Client $overall
 * @property \TimSDK\Operate\Client $operate
 */
class Application extends ServiceContainer
{
    protected $providers = [
        Account\ServiceProvider::class,
        Openim\ServiceProvider::class,
        MemberPush\ServiceProvider::class,
        Profile\ServiceProvider::class,
        Sns\ServiceProvider::class,
        Group\ServiceProvider::class,
        Overall\ServiceProvider::class,
        Operate\ServiceProvider::class,
    ];

    /**
     * 第三方回调
     * @see https://cloud.tencent.com/document/product/269/1522
     *
     * @param \Closure $closure
     * @return false|mixed
     * @throws \TimSDK\Kernel\Exceptions\Exception
     */
    public function handleNotify(Closure $closure)
    {
        return (new Notify\Message($this))->handle($closure);
    }
}
