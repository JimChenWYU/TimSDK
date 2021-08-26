<?php

namespace TimSDK\Kernel\Contracts;

interface UserSigInterface
{
    /**
     * @return string
     */
    public function getUserSig(string $identifier): array;

    /**
     * @return UserSigInterface
     */
    public function refresh(string $identifier): self;
}
