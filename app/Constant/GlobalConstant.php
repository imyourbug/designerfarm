<?php

namespace App\Constant;

class GlobalConstant
{
    public const ROLE_USER = 0;
    public const ROLE_ADMIN = 1;


    public const STATUS_OK = 0;
    public const STATUS_ERROR = 1;

    public const UTC_HOUR = 7;

    public const DOWNLOAD_FILE = 'file';
    public const DOWNLOAD_VIDEO = 'video';
    public const DOWNLOAD_IMAGE = 'image';
    public const DOWNLOAD_LICENSE = 'license';

    public const DOWNLOAD_TYPE = [
        self::DOWNLOAD_FILE,
        self::DOWNLOAD_VIDEO,
        self::DOWNLOAD_LICENSE,
        self::DOWNLOAD_IMAGE,
    ];

    public const WEB_FREEPIK = 'Freepik';
    public const WEB_ENVATO = 'Envato';
    public const WEB_MOTION = 'MotionArray';
    public const WEB_LOVEPIK = 'Lovepik';

    public const WEB_TYPE = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
    ];

    public const WEB_REQUIRED_TYPE_DOWNLOAD = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
    ];
}
