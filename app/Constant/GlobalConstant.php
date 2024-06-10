<?php

namespace App\Constant;

class GlobalConstant
{
    public const STATUS_PENDING = 0;
    public const STATUS_ACCEPTED = 1;
    public const STATUS_CANCELED = 2;

    public const REQUEST_STATUS = [
        self::STATUS_PENDING,
        self::STATUS_ACCEPTED,
        self::STATUS_CANCELED,
    ];

    public const TYPE_BY_NUMBER_FILE = 0;
    public const TYPE_BY_TIME = 1;

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
    public const WEB_PNGTREE = 'Pngtree';
    public const WEB_FLATICON = 'Flaticon';
    public const WEB_PIKBEST = 'Pikbest';
    public const WEB_STORYBLOCKS = 'Storyblocks';
    public const WEB_VECTEEZY = 'Vecteezy';
    public const WEB_ALL = 'ALL';

    public const WEB_TYPE = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
        self::WEB_PNGTREE,
        self::WEB_FLATICON,
        self::WEB_PIKBEST,
        self::WEB_STORYBLOCKS,
        self::WEB_VECTEEZY,
        self::WEB_ALL,
    ];

    public const WEB_REQUIRED_TYPE_DOWNLOAD = [
        self::WEB_FREEPIK,
        self::WEB_ENVATO,
        self::WEB_MOTION,
        self::WEB_LOVEPIK,
    ];
}
