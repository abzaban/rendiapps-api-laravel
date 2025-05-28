<?php

namespace App\Models;

use App\Formatters\MongoDBFormatter;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Token as ValidToken;

use App\Repositories\TokenRepository;

use App\Formatters\TokenFormatter;

class TokenModel
{
    private $tokenRepository, $tokenFormatter, $mongoFormatter;

    function __construct()
    {
        $this->tokenRepository = new TokenRepository();
        $this->tokenFormatter = new TokenFormatter();
        $this->mongoFormatter = new MongoDBFormatter();
    }

    public function generateJwtToken($userId, $email)
    {
        $customClaims = [
            'sub' => $userId,
            'correo' => $email
        ];
        $factory = JWTFactory::customClaims($customClaims);
        $payload = $factory->make();
        $token = JWTAuth::encode($payload);
        return $token;
    }

    public function getUserIdByToken($token)
    {
        $objToken = new ValidToken($token);
        return JWTAuth::decode($objToken)['sub'];
    }

    public function registerSessionUser($userId)
    {
        return $this->tokenRepository->registerSessionUser($this->mongoFormatter->stringIdToObjectId($userId), $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function updateAuthToken($userId, $token)
    {
        return $this->tokenRepository->updateAuthToken($this->mongoFormatter->stringIdToObjectId($userId), $token, $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function updatePwdToken($session, $userId, $token)
    {
        return $this->tokenRepository->updatePwdToken($session, $this->mongoFormatter->stringIdToObjectId($userId), $token, $this->mongoFormatter->stringDateToTimestamp(now()));
    }

    public function getByUserId($userId)
    {
        return $this->tokenFormatter->toDomain((object) $this->tokenRepository->getByUserId($this->mongoFormatter->stringIdToObjectId($userId)));
    }

    public function deleteSessionUser($session, $userId)
    {
        return $this->tokenRepository->deleteSessionUser($session, $userId, $this->mongoFormatter->stringDateToTimestamp(now()));
    }
}
