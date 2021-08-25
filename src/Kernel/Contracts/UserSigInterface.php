<?php

namespace TimSDK\Kernel\Contracts;

interface UserSigInterface
{
    /**
     * @return string
     */
    public function getUserSig(string $identifier): string;

    /**
     * @return UserSigInterface
     */
    public function refresh(string $identifier): self;
}
